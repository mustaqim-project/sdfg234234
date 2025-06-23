<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Validator;

class MbtiTestController extends Controller
{
    const TOTAL_QUESTIONS = 32;

    /**
     * Display MBTI test form
     */
    public function index()
    {
        try {
            $questions = $this->getMBTIQuestions();
            return view('mbti.test', compact('questions'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat pertanyaan MBTI: ' . $e->getMessage());
        }
    }

    /**
     * Get MBTI questions from database
     */
    private function getMBTIQuestions()
    {
        $questions = DB::select("
            SELECT
                ac.id AS category_id,
                ac.name AS category_name,
                aq.id AS question_id,
                aq.question,
                aq.options
            FROM
                assessment_categories ac
            JOIN
                assessment_questions aq ON ac.id = aq.assessment_category_id
            WHERE
                ac.assessment_type_id = 2
            ORDER BY aq.id ASC
        ");

        if (empty($questions)) {
            throw new \Exception('Tidak ada pertanyaan MBTI yang ditemukan');
        }

        foreach ($questions as $question) {
            $options = json_decode($question->options, true);
            if (json_last_error() !== JSON_ERROR_NONE || empty($options)) {
                throw new \Exception('Format opsi pertanyaan tidak valid');
            }
            $question->randomized_options = $this->randomizeOptions($options);
        }

        return $questions;
    }

    /**
     * Process MBTI test answers and calculate result
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answers' => ['required', 'array', 'size:' . self::TOTAL_QUESTIONS],
            'answers.*' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $answers = $request->input('answers');
            $mbtiResult = $this->calculateMBTI($answers);

            $this->saveUserProfile($mbtiResult);
            $this->storeAnswers($answers);

            return redirect()->route('mbti.result')
                ->with('mbti_result', $mbtiResult)
                ->with('success', 'Tes MBTI berhasil diselesaikan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Save MBTI result to user profile
     */
    private function saveUserProfile($mbtiResult)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->username) {
            throw new \Exception('Username pengguna tidak ditemukan');
        }

        $userProfile = UserProfile::firstOrNew(['username' => $currentUser->username]);
        $userProfile->mbti = $mbtiResult;
        $userProfile->save();
    }

    /**
     * Randomize answer options to prevent bias
     */
    private function randomizeOptions($options)
    {
        $optionKeys = array_keys($options);
        $optionValues = array_values($options);

        // Shuffle values while maintaining keys
        shuffle($optionValues);

        return array_combine($optionKeys, $optionValues);
    }

    /**
     * Display MBTI test result
     */
    public function result()
    {
        try {
            $mbtiResult = session('mbti_result');

            if (!$mbtiResult) {
                $currentUser = Auth::user();
                if (!$currentUser || !$currentUser->username) {
                    return redirect()->route('mbti.index')
                        ->with('error', 'Sesi pengguna tidak valid.');
                }

                $userProfile = UserProfile::where('username', $currentUser->username)->first();
                $mbtiResult = $userProfile ? $userProfile->mbti : null;
            }

            if (!$mbtiResult || strlen($mbtiResult) !== 4) {
                return redirect()->route('mbti.index')
                    ->with('error', 'Silakan ambil tes MBTI terlebih dahulu.');
            }

            $mbtiDescription = $this->getMBTIDescription($mbtiResult);

            return view('mbti.result', compact('mbtiResult', 'mbtiDescription'));
        } catch (\Exception $e) {
            return redirect()->route('mbti.index')
                ->with('error', 'Gagal memuat hasil: ' . $e->getMessage());
        }
    }

    /**
     * Calculate MBTI type based on answers
     */
    private function calculateMBTI($answers)
    {
        $scores = [
            'E' => 0,
            'I' => 0,
            'S' => 0,
            'N' => 0,
            'T' => 0,
            'F' => 0,
            'J' => 0,
            'P' => 0
        ];

        // Question mappings with weights
        $dimensions = [
            'EI' => [
                'range' => [1, 9],
                'E' => [1, 3, 5, 7, 9], // Questions where E is positive
                'I' => [2, 4, 6, 8]     // Questions where I is positive
            ],
            'SN' => [
                'range' => [10, 18],
                'S' => [10, 12, 14, 16, 18],
                'N' => [11, 13, 15, 17]
            ],
            'TF' => [
                'range' => [19, 27],
                'T' => [19, 21, 23, 25, 27],
                'F' => [20, 22, 24, 26]
            ],
            'JP' => [
                'range' => [28, 35],
                'J' => [28, 30, 32, 34],
                'P' => [29, 31, 33, 35]
            ]
        ];

        foreach ($answers as $questionId => $answerValue) {
            $answerValue = (int)$answerValue; // Ensure integer

            foreach ($dimensions as $dimension => $config) {
                list($start, $end) = $config['range'];

                if ($questionId >= $start && $questionId <= $end) {
                    // For each dimension, check which trait this question measures
                    foreach (['E', 'I', 'S', 'N', 'T', 'F', 'J', 'P'] as $trait) {
                        if (isset($config[$trait])) {
                            if (in_array($questionId, $config[$trait])) {
                                $scores[$trait] += $this->getQuestionScore($trait, $answerValue);
                            }
                        }
                    }
                    break;
                }
            }
        }

        return $this->determineMBTIType($scores);
    }

    /**
     * Calculate score for a single question based on trait and answer
     */
    private function getQuestionScore($trait, $answerValue)
    {
        // Some questions may need reverse scoring
        $reverseTraits = ['I', 'N', 'F', 'P'];

        if (in_array($trait, $reverseTraits)) {
            return 6 - $answerValue; // Reverse score (1=5, 2=4, etc.)
        }

        return $answerValue;
    }

    /**
     * Determine MBTI type from scores
     */
    private function determineMBTIType($scores)
    {
        $mbti = '';

        $mbti .= ($scores['E'] >= $scores['I']) ? 'E' : 'I';
        $mbti .= ($scores['S'] >= $scores['N']) ? 'S' : 'N';
        $mbti .= ($scores['T'] >= $scores['F']) ? 'T' : 'F';
        $mbti .= ($scores['J'] >= $scores['P']) ? 'J' : 'P';

        return $mbti;
    }

    /**
     * Store detailed answers (optional)
     */
    private function storeAnswers($answers)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->username) {
            return; // Skip storing if username not available
        }

        // Implement this if you want to store individual answers
        // Example:
        /*
        foreach ($answers as $questionId => $answer) {
            MBTIAnswer::create([
                'username' => $currentUser->username,
                'question_id' => $questionId,
                'answer' => $answer,
                'answered_at' => now()
            ]);
        }
        */
    }

    /**
     * Get MBTI type description
     */
    private function getMBTIDescription($mbtiType)
    {
        $descriptions = [
            'INTJ' => [
                'title' => 'Si Arsitek',
                'description' => 'Pemikir strategis dan imajinatif dengan rencana untuk segalanya.',
                'strengths' => ['Analitis', 'Strategis', 'Mandiri', 'Visioner', 'Inovatif'],
                'weaknesses' => ['Terlalu kritis', 'Perfeksionis', 'Canggung secara sosial', 'Kadang tidak peka'],
                'suitable_jobs' => [
                    'Arsitek sistem dan perangkat lunak',
                    'Konsultan strategis bisnis',
                    'Peneliti dan ilmuwan',
                    'Analis keuangan dan investasi',
                    'Arsitek dan insinyur',
                    'Penulis dan editor',
                    'Dokter spesialis',
                    'Pengacara perusahaan'
                ],
                'compatibility' => [
                    'very_compatible' => ['ENFP', 'ENTP'],
                    'compatible' => ['INFP', 'INTP'],
                    'needs_effort' => ['ESFJ', 'ISFJ'],
                    'challenging' => ['ESFP', 'ISFP']
                ]
            ],
            'INTP' => [
                'title' => 'Si Pemikir',
                'description' => 'Penemu inovatif dengan dahaga tak terpuaskan akan pengetahuan.',
                'strengths' => ['Orisinal', 'Berpikiran terbuka', 'Jujur', 'Logis', 'Objektif'],
                'weaknesses' => ['Pelupa', 'Tidak peka', 'Terlalu tertutup', 'Menunda-nunda'],
                'suitable_jobs' => [
                    'Programmer dan developer software',
                    'Peneliti dan akademisi',
                    'Analis sistem dan data',
                    'Insinyur dan teknisi',
                    'Ahli matematika dan statistik',
                    'Penulis teknis',
                    'Konsultan IT',
                    'Filsuf dan teoretikus'
                ],
                'compatibility' => [
                    'very_compatible' => ['ENTJ', 'ENFJ'],
                    'compatible' => ['INTJ', 'INFJ'],
                    'needs_effort' => ['ESTJ', 'ESFJ'],
                    'challenging' => ['ESFP', 'ESTP']
                ]
            ],
            'ENTJ' => [
                'title' => 'Si Komandan',
                'description' => 'Pemimpin yang berani, imajinatif, dan berkemauan kuat.',
                'strengths' => ['Efisien', 'Percaya diri', 'Berkemauan kuat', 'Karismatik', 'Tegas'],
                'weaknesses' => ['Tidak sabar', 'Keras kepala', 'Tidak toleran', 'Dominan'],
                'suitable_jobs' => [
                    'CEO dan eksekutif perusahaan',
                    'Pengusaha dan pemilik bisnis',
                    'Manajer senior dan direktur',
                    'Konsultan manajemen',
                    'Pengacara perusahaan',
                    'Perencana keuangan',
                    'Politisi dan diplomat',
                    'Banker investasi'
                ],
                'compatibility' => [
                    'very_compatible' => ['INTP', 'INFP'],
                    'compatible' => ['INTJ', 'ENFP'],
                    'needs_effort' => ['ISFJ', 'ESFJ'],
                    'challenging' => ['ISFP', 'ISTP']
                ]
            ],
            'ENTP' => [
                'title' => 'Si Pendebat',
                'description' => 'Pemikir cerdas dan penasaran yang tidak bisa menolak tantangan intelektual.',
                'strengths' => ['Cerdas', 'Kreatif', 'Brainstormer hebat', 'Energik', 'Adaptif'],
                'weaknesses' => ['Suka berdebat', 'Tidak peka', 'Tidak tahan rutinitas', 'Mudah bosan'],
                'suitable_jobs' => [
                    'Marketing dan periklanan',
                    'Jurnalis dan penyiar',
                    'Konsultan bisnis',
                    'Pengacara',
                    'Sales manager',
                    'Entrepreneur',
                    'Psikolog',
                    'Trainer dan motivator'
                ],
                'compatibility' => [
                    'very_compatible' => ['INTJ', 'INFJ'],
                    'compatible' => ['ENFJ', 'INTP'],
                    'needs_effort' => ['ISTJ', 'ISFJ'],
                    'challenging' => ['ESTJ', 'ESFJ']
                ]
            ],
            'INFJ' => [
                'title' => 'Si Advokat',
                'description' => 'Tenang dan mistis, namun sangat menginspirasi dan idealis yang tak kenal lelah.',
                'strengths' => ['Kreatif', 'Insightful', 'Bertekad', 'Empati tinggi', 'Visioner'],
                'weaknesses' => ['Sensitif', 'Perfeksionis', 'Tertutup', 'Mudah terluka'],
                'suitable_jobs' => [
                    'Psikolog dan konselor',
                    'Penulis dan editor',
                    'Guru dan dosen',
                    'Pekerja sosial',
                    'HR specialist',
                    'Desainer grafis',
                    'Dokter dan perawat',
                    'Peneliti sosial'
                ],
                'compatibility' => [
                    'very_compatible' => ['ENTP', 'ENFP'],
                    'compatible' => ['INTJ', 'INTP'],
                    'needs_effort' => ['ESTP', 'ESFP'],
                    'challenging' => ['ESTJ', 'ISTJ']
                ]
            ],
            'INFP' => [
                'title' => 'Si Mediator',
                'description' => 'Orang yang puitis, baik hati dan altruistik, selalu ingin membantu tujuan yang baik.',
                'strengths' => ['Empati', 'Kreatif', 'Passionate', 'Fleksibel', 'Setia'],
                'weaknesses' => ['Tidak realistis', 'Self-critical', 'Terlalu idealis', 'Mudah stress'],
                'suitable_jobs' => [
                    'Penulis dan jurnalis',
                    'Konselor dan terapis',
                    'Seniman dan musisi',
                    'Guru dan instruktur',
                    'Fotografer dan videographer',
                    'Pekerja kemanusiaan',
                    'Pustakawan',
                    'Desainer interior'
                ],
                'compatibility' => [
                    'very_compatible' => ['ENTJ', 'ENFJ'],
                    'compatible' => ['INTJ', 'ENFP'],
                    'needs_effort' => ['ESTJ', 'ISTJ'],
                    'challenging' => ['ESTP', 'ESFP']
                ]
            ],
            'ENFJ' => [
                'title' => 'Si Protagonis',
                'description' => 'Pemimpin yang karismatik dan menginspirasi, mampu memukau pendengarnya.',
                'strengths' => ['Persuasif', 'Dapat diandalkan', 'Passionate', 'Empati', 'Komunikatif'],
                'weaknesses' => ['Terlalu idealis', 'Terlalu selfless', 'Fluktuasi harga diri'],
                'suitable_jobs' => [
                    'Guru dan pendidik',
                    'Konselor dan terapis',
                    'HR manager',
                    'Public relations',
                    'Event organizer',
                    'Pelatih dan coach',
                    'Politisi',
                    'Direktur LSM'
                ],
                'compatibility' => [
                    'very_compatible' => ['INTP', 'INFP'],
                    'compatible' => ['INTJ', 'ENTP'],
                    'needs_effort' => ['ISTP', 'ESTP'],
                    'challenging' => ['ISTJ', 'ESTJ']
                ]
            ],
            'ENFP' => [
                'title' => 'Si Campaigner',
                'description' => 'Jiwa bebas yang antusias, kreatif dan sosial.',
                'strengths' => ['Penasaran', 'Perceptif', 'Energik', 'Antusias', 'Inspiratif'],
                'weaknesses' => ['Terlalu optimis', 'Gelisah', 'Mencari persetujuan', 'Mudah teralihkan'],
                'suitable_jobs' => [
                    'Marketing dan advertising',
                    'Jurnalis dan broadcaster',
                    'Konsultan dan coach',
                    'Event planner',
                    'Seniman dan performer',
                    'Sales representative',
                    'Psikolog',
                    'Entrepreneur'
                ],
                'compatibility' => [
                    'very_compatible' => ['INTJ', 'INFJ'],
                    'compatible' => ['ENTJ', 'INFP'],
                    'needs_effort' => ['ISTJ', 'ISFJ'],
                    'challenging' => ['ESTJ', 'ESTP']
                ]
            ],
            'ISTJ' => [
                'title' => 'Si Logistician',
                'description' => 'Praktis dan mengutamakan fakta, dapat diandalkan dan bertanggung jawab.',
                'strengths' => ['Jujur', 'Dapat diandalkan', 'Bertanggung jawab', 'Sistematis', 'Teliti'],
                'weaknesses' => ['Keras kepala', 'Tidak peka', 'Judgmental', 'Kaku'],
                'suitable_jobs' => [
                    'Akuntan dan auditor',
                    'Administrator dan manajer',
                    'Polisi dan detektif',
                    'Hakim dan pengacara',
                    'Dokter dan dokter gigi',
                    'Programmer komputer',
                    'Analis keuangan',
                    'Engineer'
                ],
                'compatibility' => [
                    'very_compatible' => ['ESFP', 'ESTP'],
                    'compatible' => ['ENFP', 'ISFP'],
                    'needs_effort' => ['INFJ', 'ENFJ'],
                    'challenging' => ['ENTP', 'ENFP']
                ],
                'notes' => 'Berdasarkan penelitian dari Korea, pasangan dengan tipe ISTJ memiliki risiko lebih tinggi untuk masalah hubungan jika tidak ada komunikasi yang baik.'
            ],
            'ISFJ' => [
                'title' => 'Si Protector',
                'description' => 'Pelindung yang sangat berdedikasi dan hangat, selalu siap membela orang yang dicintai.',
                'strengths' => ['Supportif', 'Dapat diandalkan', 'Sabar', 'Perhatian', 'Loyal'],
                'weaknesses' => ['Terlalu rendah hati', 'Kelebihan beban', 'Enggan berubah'],
                'suitable_jobs' => [
                    'Perawat dan bidan',
                    'Guru sekolah dasar',
                    'Konselor dan terapis',
                    'Administrator kesehatan',
                    'Pustakawan',
                    'Interior designer',
                    'HR specialist',
                    'Pekerja sosial'
                ],
                'compatibility' => [
                    'very_compatible' => ['ESTP', 'ESFP'],
                    'compatible' => ['ENFP', 'ISFP'],
                    'needs_effort' => ['INTJ', 'ENTJ'],
                    'challenging' => ['ENTP', 'INTP']
                ]
            ],
            'ESTJ' => [
                'title' => 'Si Executive',
                'description' => 'Administrator yang sangat baik, tak tertandingi dalam mengelola hal atau orang.',
                'strengths' => ['Berdedikasi', 'Berkemauan kuat', 'Langsung', 'Organized', 'Efisien'],
                'weaknesses' => ['Tidak sabar', 'Keras kepala', 'Tidak peka', 'Dominan'],
                'suitable_jobs' => [
                    'Manager dan eksekutif',
                    'Administrator bisnis',
                    'Perwira militer',
                    'Hakim dan pengacara',
                    'Akuntan senior',
                    'Sales manager',
                    'Project manager',
                    'Banker'
                ],
                'compatibility' => [
                    'very_compatible' => ['ISFP', 'ISTP'],
                    'compatible' => ['ESFP', 'ESTP'],
                    'needs_effort' => ['INFP', 'ENFP'],
                    'challenging' => ['INFJ', 'ENFJ']
                ],
                'notes' => 'Seperti ISTJ, penelitian menunjukkan bahwa pasangan dengan tipe ESTJ juga memerlukan perhatian khusus dalam komunikasi emosional.'
            ],
            'ESFJ' => [
                'title' => 'Si Consul',
                'description' => 'Orang yang luar biasa peduli, sosial dan populer, selalu ingin membantu.',
                'strengths' => ['Praktis', 'Loyal', 'Organizer yang baik', 'Hangat', 'Supportif'],
                'weaknesses' => ['Butuh perhatian', 'Sensitif', 'Terlalu selfless', 'Mudah terpengaruh'],
                'suitable_jobs' => [
                    'Customer service manager',
                    'Event coordinator',
                    'Guru dan pendidik',
                    'Perawat dan terapis',
                    'HR specialist',
                    'Office manager',
                    'Social worker',
                    'Receptionist'
                ],
                'compatibility' => [
                    'very_compatible' => ['ISFP', 'ISTP'],
                    'compatible' => ['ESFP', 'ESTP'],
                    'needs_effort' => ['INTJ', 'INTP'],
                    'challenging' => ['ENTP', 'ENTJ']
                ]
            ],
            'ISTP' => [
                'title' => 'Si Virtuoso',
                'description' => 'Eksperimen yang berani dan praktis, master dari semua jenis alat.',
                'strengths' => ['Optimis', 'Kreatif', 'Praktis', 'Fleksibel', 'Adaptif'],
                'weaknesses' => ['Tertutup', 'Tidak peka', 'Risk-taking', 'Mudah bosan'],
                'suitable_jobs' => [
                    'Mekanik dan teknisi',
                    'Pilot dan masinis',
                    'Insinyur mesin',
                    'Fotografer',
                    'Atlet profesional',
                    'Forensic scientist',
                    'Carpenter dan welder',
                    'IT support'
                ],
                'compatibility' => [
                    'very_compatible' => ['ESTJ', 'ESFJ'],
                    'compatible' => ['ENFJ', 'ENTJ'],
                    'needs_effort' => ['INFJ', 'INFP'],
                    'challenging' => ['ENFP', 'ENTP']
                ]
            ],
            'ISFP' => [
                'title' => 'Si Adventurer',
                'description' => 'Seniman yang fleksibel dan menawan, selalu siap menjelajahi kemungkinan baru.',
                'strengths' => ['Menawan', 'Sensitif', 'Artistik', 'Fleksibel', 'Setia'],
                'weaknesses' => ['Terlalu kompetitif', 'Tak terduga', 'Mudah stress', 'Pemalu'],
                'suitable_jobs' => [
                    'Seniman dan desainer',
                    'Musisi dan komposer',
                    'Fotografer dan videographer',
                    'Konselor dan terapis',
                    'Guru seni',
                    'Fashion designer',
                    'Florist',
                    'Massage therapist'
                ],
                'compatibility' => [
                    'very_compatible' => ['ESTJ', 'ESFJ'],
                    'compatible' => ['ENTJ', 'ENFJ'],
                    'needs_effort' => ['ISTJ', 'ISFJ'],
                    'challenging' => ['INTJ', 'ENTJ']
                ]
            ],
            'ESTP' => [
                'title' => 'Si Entrepreneur',
                'description' => 'Orang cerdas, energik dan perceptif, benar-benar menikmati hidup di tepi jurang.',
                'strengths' => ['Berani', 'Praktis', 'Orisinal', 'Energik', 'Spontan'],
                'weaknesses' => ['Tidak sabar', 'Tidak peka', 'Risk-taking', 'Mudah bosan'],
                'suitable_jobs' => [
                    'Sales representative',
                    'Entrepreneur dan pemilik bisnis',
                    'Marketing specialist',
                    'Event coordinator',
                    'Polisi dan petugas keamanan',
                    'Paramedis',
                    'Real estate agent',
                    'Personal trainer'
                ],
                'compatibility' => [
                    'very_compatible' => ['ISTJ', 'ISFJ'],
                    'compatible' => ['ESTJ', 'ESFJ'],
                    'needs_effort' => ['INFJ', 'INFP'],
                    'challenging' => ['INTP', 'INTJ']
                ]
            ],
            'ESFP' => [
                'title' => 'Si Entertainer',
                'description' => 'Orang yang spontan, energik dan antusias - hidup tidak pernah membosankan.',
                'strengths' => ['Observan', 'Praktis', 'Komunikator hebat', 'Ramah', 'Optimis'],
                'weaknesses' => ['Sensitif', 'Menghindari konflik', 'Mudah bosan', 'Impulsif'],
                'suitable_jobs' => [
                    'Entertainer dan performer',
                    'Tour guide',
                    'Sales representative',
                    'Event coordinator',
                    'Social media manager',
                    'Receptionist',
                    'Childcare worker',
                    'Flight attendant'
                ],
                'compatibility' => [
                    'very_compatible' => ['ISTJ', 'ISFJ'],
                    'compatible' => ['ESTJ', 'ESFJ'],
                    'needs_effort' => ['INFJ', 'INFP'],
                    'challenging' => ['INTJ', 'INTP']
                ]
            ]
        ];

        return $descriptions[$mbtiType] ?? [
            'title' => 'Unknown Type',
            'description' => 'Type description not available.',
            'strengths' => [],
            'weaknesses' => [],
            'suitable_jobs' => [],
            'compatibility' => [
                'very_compatible' => [],
                'compatible' => [],
                'needs_effort' => [],
                'challenging' => []
            ]
        ];
    }
}
