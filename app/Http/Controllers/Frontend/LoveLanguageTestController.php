<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Validator;

class LoveLanguageTestController extends Controller
{
    const TOTAL_QUESTIONS = 30; // Love Language biasanya 30 pertanyaan

    /**
     * Display LOVE LANGUAGE test form
     */
    public function index()
    {
        try {
            $questions = $this->getLoveLanguageQuestions();
            return view('love-language.test', compact('questions'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat pertanyaan Love Language: ' . $e->getMessage());
        }
    }

    /**
     * Get Love Language questions from database
     */
    private function getLoveLanguageQuestions()
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
            throw new \Exception('Tidak ada pertanyaan Love Language yang ditemukan');
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
     * Process Love Language test answers and calculate result
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
            $loveLanguageResult = $this->calculateLoveLanguage($answers);

            // Format answers for JSON storage
            $formattedAnswers = [];
            foreach ($answers as $questionId => $answer) {
                $formattedAnswers[] = [
                    'question_id' => (int)$questionId,
                    'answer' => (int)$answer
                ];
            }

            // Calculate overall score (you can adjust this calculation as needed)
            $totalScore = array_sum($loveLanguageResult['scores']);
            $maxPossibleScore = self::TOTAL_QUESTIONS * 5; // 30 questions * max 5 points each
            $overallScore = round(($totalScore / $maxPossibleScore) * 100);

            // Create JSON result similar to marriage test format
            $jsonResult = [
                'score' => $overallScore,
                'primary_love_language' => $loveLanguageResult['primary'],
                'secondary_love_language' => $loveLanguageResult['secondary'],
                'love_language_scores' => $loveLanguageResult['scores'],
                'answers' => $formattedAnswers,
                'completed_at' => now()->toISOString()
            ];

            $this->saveUserProfile($jsonResult, $loveLanguageResult);

            return redirect()->route('love-language.result')
                ->with('love_language_result', $loveLanguageResult)
                ->with('success', 'Tes Love Language berhasil diselesaikan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Save Love Language result to user profile
     */
    private function saveUserProfile($jsonResult, $loveLanguageResult)
    {
        $userProfile = UserProfile::firstOrNew(['username' => Auth::user()->username]);

        // Save in JSON format to love_language_test_result column
        $userProfile->love_language_test_result = json_encode($jsonResult);

        // Keep the old format for backward compatibility (optional)
        $userProfile->love_language = $loveLanguageResult;

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
     * Display Love Language test result
     */
    public function result()
    {
        try {
            $loveLanguageResult = session('love_language_result');

            if (!$loveLanguageResult) {
                $userProfile = UserProfile::where('username', Auth::user()->username)->first();

                if ($userProfile && $userProfile->love_language_test_result) {
                    // Try to get result from JSON format first
                    $jsonResult = json_decode($userProfile->love_language_test_result, true);
                    if ($jsonResult && isset($jsonResult['primary_love_language'])) {
                        $loveLanguageResult = [
                            'primary' => $jsonResult['primary_love_language'],
                            'secondary' => $jsonResult['secondary_love_language'],
                            'scores' => $jsonResult['love_language_scores'],
                            'primary_score' => $jsonResult['love_language_scores'][$jsonResult['primary_love_language']],
                            'secondary_score' => $jsonResult['love_language_scores'][$jsonResult['secondary_love_language']]
                        ];
                    }
                } elseif ($userProfile && $userProfile->love_language) {
                    // Fallback to old format
                    $loveLanguageResult = $userProfile->love_language;
                }
            }

            if (!$loveLanguageResult) {
                return redirect()->route('love-language.index')
                    ->with('error', 'Silakan ambil tes Love Language terlebih dahulu.');
            }

            $loveLanguageDescription = $this->getLoveLanguageDescription($loveLanguageResult);

            return view('love-language.result', compact('loveLanguageResult', 'loveLanguageDescription'));
        } catch (\Exception $e) {
            return redirect()->route('love-language.index')
                ->with('error', 'Gagal memuat hasil: ' . $e->getMessage());
        }
    }

    /**
     * Calculate Love Language type based on answers
     */
    private function calculateLoveLanguage($answers)
    {
        $scores = [
            'words_of_affirmation' => 0,
            'acts_of_service' => 0,
            'receiving_gifts' => 0,
            'quality_time' => 0,
            'physical_touch' => 0
        ];

        // Love Language biasanya 6 pertanyaan per kategori (30 total)
        $questionMapping = [
            'words_of_affirmation' => [1, 6, 11, 16, 21, 26],
            'acts_of_service' => [2, 7, 12, 17, 22, 27],
            'receiving_gifts' => [3, 8, 13, 18, 23, 28],
            'quality_time' => [4, 9, 14, 19, 24, 29],
            'physical_touch' => [5, 10, 15, 20, 25, 30]
        ];

        foreach ($answers as $questionId => $answerValue) {
            $answerValue = (int)$answerValue;

            foreach ($questionMapping as $loveLanguage => $questions) {
                if (in_array($questionId, $questions)) {
                    $scores[$loveLanguage] += $answerValue;
                    break;
                }
            }
        }

        return $this->determinePrimaryLoveLanguage($scores);
    }

    /**
     * Determine primary Love Language from scores
     */
    private function determinePrimaryLoveLanguage($scores)
    {
        // Urutkan berdasarkan skor tertinggi
        arsort($scores);

        $primaryLanguage = array_key_first($scores);
        $secondaryLanguage = array_keys($scores)[1];

        return [
            'primary' => $primaryLanguage,
            'secondary' => $secondaryLanguage,
            'scores' => $scores,
            'primary_score' => $scores[$primaryLanguage],
            'secondary_score' => $scores[$secondaryLanguage]
        ];
    }

    /**
     * Get Love Language description
     */
    private function getLoveLanguageDescription($result)
    {
        $descriptions = [
            'words_of_affirmation' => [
                'title' => 'Words of Affirmation',
                'description' => 'Anda merasa dicintai ketika pasangan mengekspresikan kasih sayang melalui kata-kata. Pujian, dorongan, dan ungkapan cinta yang tulus sangat berarti bagi Anda.',
                'how_to_show' => [
                    'Berikan pujian yang tulus dan spesifik',
                    'Ucapkan "Aku cinta kamu" secara teratur',
                    'Tulis catatan atau pesan cinta',
                    'Berikan dorongan dan dukungan verbal',
                    'Akui pencapaian dan usaha mereka'
                ],
                'what_hurts' => [
                    'Kritik yang tidak membangun',
                    'Kata-kata kasar atau menghina',
                    'Diabaikan atau tidak diakui',
                    'Kurangnya komunikasi verbal',
                    'Sarkasme yang menyakitkan'
                ]
            ],
            'acts_of_service' => [
                'title' => 'Acts of Service',
                'description' => 'Anda merasa dicintai ketika pasangan menunjukkan kasih sayang melalui tindakan. Bantuan praktis dan dukungan nyata lebih bermakna daripada kata-kata.',
                'how_to_show' => [
                    'Bantu dengan pekerjaan rumah tangga',
                    'Lakukan tugas-tugas yang tidak mereka sukai',
                    'Siapkan makanan atau minuman kesukaan',
                    'Bantu menyelesaikan proyek atau masalah',
                    'Ambil alih tanggung jawab mereka saat mereka sibuk'
                ],
                'what_hurts' => [
                    'Tidak menepati janji untuk membantu',
                    'Membuat lebih banyak pekerjaan untuk mereka',
                    'Bersikap malas atau tidak membantu',
                    'Mengabaikan permintaan bantuan',
                    'Tidak menghargai usaha mereka'
                ]
            ],
            'receiving_gifts' => [
                'title' => 'Receiving Gifts',
                'description' => 'Anda merasa dicintai ketika menerima hadiah yang bermakna. Bukan tentang nilai materi, tetapi tentang perhatian dan usaha di balik pemberian tersebut.',
                'how_to_show' => [
                    'Berikan hadiah kecil secara spontan',
                    'Ingat dan rayakan hari-hari spesial',
                    'Pilih hadiah yang menunjukkan Anda mendengarkan',
                    'Buat atau beli sesuatu yang mereka butuhkan',
                    'Berikan bunga atau cokelat tanpa alasan khusus'
                ],
                'what_hurts' => [
                    'Lupa hari ulang tahun atau anniversary',
                    'Memberikan hadiah yang tidak bermakna',
                    'Tidak pernah memberikan kejutan',
                    'Mengatakan hadiah tidak penting',
                    'Tidak menghargai hadiah yang diterima'
                ]
            ],
            'quality_time' => [
                'title' => 'Quality Time',
                'description' => 'Anda merasa dicintai ketika mendapat perhatian penuh dari pasangan. Waktu berkualitas bersama tanpa gangguan adalah yang paling berharga bagi Anda.',
                'how_to_show' => [
                    'Berikan perhatian penuh saat berbicara',
                    'Rencanakan aktivitas bersama secara teratur',
                    'Matikan gadget saat menghabiskan waktu bersama',
                    'Dengarkan dengan aktif tanpa menghakimi',
                    'Lakukan hobi atau kegiatan yang mereka sukai'
                ],
                'what_hurts' => [
                    'Terus-menerus terganggu oleh gadget',
                    'Membatalkan rencana bersama',
                    'Tidak memberikan perhatian penuh',
                    'Terlalu sibuk untuk menghabiskan waktu',
                    'Multitasking saat sedang bersama'
                ]
            ],
            'physical_touch' => [
                'title' => 'Physical Touch',
                'description' => 'Anda merasa dicintai melalui sentuhan fisik yang penuh kasih. Pelukan, ciuman, dan kontak fisik lainnya membuat Anda merasa terhubung dan dicintai.',
                'how_to_show' => [
                    'Berikan pelukan dan ciuman secara teratur',
                    'Pegang tangan saat berjalan bersama',
                    'Berikan pijatan atau sentuhan lembut',
                    'Duduk berdekatan saat menonton TV',
                    'Berikan sentuhan spontan sepanjang hari'
                ],
                'what_hurts' => [
                    'Menghindari kontak fisik',
                    'Menolak pelukan atau ciuman',
                    'Jarang menyentuh atau berpelukan',
                    'Menunjukkan kasih sayang hanya di private',
                    'Tidak nyaman dengan intimacy fisik'
                ]
            ]
        ];

        $primaryLanguage = $result['primary'];
        $secondaryLanguage = $result['secondary'];

        return [
            'primary' => $descriptions[$primaryLanguage],
            'secondary' => $descriptions[$secondaryLanguage],
            'scores' => $result['scores'],
            'primary_percentage' => round(($result['primary_score'] / array_sum($result['scores'])) * 100),
            'secondary_percentage' => round(($result['secondary_score'] / array_sum($result['scores'])) * 100)
        ];
    }

    /**
     * Get user's Love Language test history (optional method)
     */
    public function getTestHistory()
    {
        $userProfile = UserProfile::where('username', Auth::user()->username)->first();

        if ($userProfile && $userProfile->love_language_test_result) {
            return json_decode($userProfile->love_language_test_result, true);
        }

        return null;
    }
}
