<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiscTestController extends Controller
{
    const TOTAL_QUESTIONS = 28;
    const ASSESSMENT_TYPE_ID = 4;

    /**
     * Display DISC test form
     */
    public function index()
    {
        try {
            $questions = $this->getDiscQuestions();
            return view('disc.test', compact('questions'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat pertanyaan DISC: ' . $e->getMessage());
        }
    }

    /**
     * Process DISC test answers and calculate result
     */
    public function store(Request $request)
    {
        $validator = $this->validateAnswers($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $answers = $request->input('answers');
            $discResult = $this->calculateDisc($answers);

            $this->saveUserProfile($discResult, $answers);

            return redirect()->route('disc.result')
                ->with('disc_result', $discResult)
                ->with('success', 'Tes DISC berhasil diselesaikan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display DISC test result
     */
    public function result()
    {
        try {
            $discResult = $this->getDiscResult();

            if (!$discResult) {
                return redirect()->route('disc.index')
                    ->with('error', 'Silakan ambil tes DISC terlebih dahulu.');
            }

            $discDescription = $this->getDiscDescription($discResult['primary_type']);

            return view('disc.result', compact('discResult', 'discDescription'));
        } catch (\Exception $e) {
            return redirect()->route('disc.index')
                ->with('error', 'Gagal memuat hasil: ' . $e->getMessage());
        }
    }

    /**
     * Show user's DISC test history
     */
    public function history()
    {
        try {
            $userProfile = UserProfile::where('username', Auth::user()->username)->first();

            if (!$userProfile || !$userProfile->disc_test) {
                return redirect()->route('disc.index')
                    ->with('error', 'Belum ada riwayat tes DISC.');
            }

            $discTestData = json_decode($userProfile->disc_test, true);
            $discDescription = $this->getDiscDescription($discTestData['primary_type']);

            return view('disc.history', compact('discTestData', 'discDescription'));
        } catch (\Exception $e) {
            return redirect()->route('disc.index')
                ->with('error', 'Gagal memuat riwayat: ' . $e->getMessage());
        }
    }

    /**
     * Get detailed DISC analysis via API
     */
    public function getDetailedAnalysis()
    {
        try {
            $userProfile = UserProfile::where('username', Auth::user()->username)->first();

            if (!$userProfile || !$userProfile->disc_test) {
                return response()->json(['error' => 'Data tes DISC tidak ditemukan'], 404);
            }

            $discTestData = json_decode($userProfile->disc_test, true);

            $analysis = [
                'basic_info' => [
                    'primary_type' => $discTestData['primary_type'],
                    'secondary_type' => $discTestData['secondary_type'] ?? null,
                    'combined_type' => $discTestData['combined_type'],
                    'completed_at' => $discTestData['completed_at']
                ],
                'scores' => $discTestData['scores'],
                'percentages' => $discTestData['percentages'],
                'total_score' => $discTestData['total_score'],
                'interpretation' => $this->getScoreInterpretation($discTestData['scores']),
                'recommendations' => $this->getRecommendations($discTestData['primary_type'])
            ];

            return response()->json($analysis);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get DISC questions from database
     */
    private function getDiscQuestions()
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
                ac.assessment_type_id = ?
            ORDER BY aq.id ASC
        ", [self::ASSESSMENT_TYPE_ID]);

        if (empty($questions)) {
            throw new \Exception('Tidak ada pertanyaan DISC yang ditemukan');
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
     * Validate user answers
     */
    private function validateAnswers(Request $request)
    {
        return Validator::make($request->all(), [
            'answers' => ['required', 'array', 'size:' . self::TOTAL_QUESTIONS],
            'answers.*' => ['required', 'integer', 'min:1', 'max:5']
        ]);
    }

    /**
     * Get DISC result from session or database
     */
    private function getDiscResult()
    {
        $discResult = session('disc_result');

        if (!$discResult) {
            $userProfile = UserProfile::where('username', Auth::user()->username)->first();
            if ($userProfile && $userProfile->disc_test) {
                $discTestData = json_decode($userProfile->disc_test, true);
                if ($discTestData && isset($discTestData['primary_type'])) {
                    $discResult = [
                        'primary_type' => $discTestData['primary_type'],
                        'secondary_type' => $discTestData['secondary_type'] ?? null,
                        'combined_type' => $discTestData['combined_type'] ?? $discTestData['primary_type'],
                        'scores' => $discTestData['scores'] ?? [],
                        'percentages' => $discTestData['percentages'] ?? [],
                        'total_score' => $discTestData['total_score'] ?? 0,
                        'completed_at' => $discTestData['completed_at'] ?? null
                    ];
                }
            }
        }

        return $discResult && isset($discResult['primary_type']) ? $discResult : null;
    }

    /**
     * Calculate DISC type based on answers
     */
    private function calculateDisc($answers)
    {
        $scores = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
        $dimensions = $this->getDimensionMapping();

        foreach ($answers as $questionId => $answerValue) {
            $answerValue = (int)$answerValue;

            foreach ($dimensions as $dimension => $questionIds) {
                if (in_array($questionId, $questionIds)) {
                    $scores[$dimension] += $answerValue;
                    break;
                }
            }
        }

        $percentages = $this->calculatePercentages($scores);
        [$primaryType, $secondaryType] = $this->determinePrimaryAndSecondaryTypes($scores);
        $combinedType = $this->determineCombinedType($primaryType, $secondaryType, $scores);

        return [
            'primary_type' => $primaryType,
            'secondary_type' => $secondaryType,
            'combined_type' => $combinedType,
            'scores' => $scores,
            'percentages' => $percentages
        ];
    }

    /**
     * Get DISC dimension mapping
     */
    private function getDimensionMapping()
    {
        return [
            'D' => [1, 5, 9, 13, 17, 21, 25],   // Dominance
            'I' => [2, 6, 10, 14, 18, 22, 26],  // Influence
            'S' => [3, 7, 11, 15, 19, 23, 27],  // Steadiness
            'C' => [4, 8, 12, 16, 20, 24, 28]   // Conscientiousness
        ];
    }

    /**
     * Calculate percentages from scores
     */
    private function calculatePercentages($scores)
    {
        $totalScore = array_sum($scores);
        $percentages = [];

        foreach ($scores as $dimension => $score) {
            $percentages[$dimension] = $totalScore > 0 ? round(($score / $totalScore) * 100, 1) : 0;
        }

        return $percentages;
    }

    /**
     * Determine primary and secondary types
     */
    private function determinePrimaryAndSecondaryTypes($scores)
    {
        arsort($scores);
        $sortedTypes = array_keys($scores);

        return [$sortedTypes[0], $sortedTypes[1]];
    }

    /**
     * Determine combined type
     */
    private function determineCombinedType($primaryType, $secondaryType, $scores)
    {
        // Create combined type if secondary is close (within 20% of primary)
        if ($scores[$secondaryType] >= ($scores[$primaryType] * 0.8)) {
            return $primaryType . $secondaryType;
        }

        return $primaryType;
    }

    /**
     * Save DISC result to user profile
     */
    private function saveUserProfile($discResult, $answers)
    {
        $userProfile = UserProfile::firstOrNew(['username' => Auth::user()->username]);

        $formattedAnswers = [];
        foreach ($answers as $questionId => $answer) {
            $formattedAnswers[] = [
                'question_id' => (int)$questionId,
                'answer' => (string)$answer
            ];
        }

        $totalScore = array_sum($discResult['scores']);

        $discTestData = [
            'primary_type' => $discResult['primary_type'],
            'secondary_type' => $discResult['secondary_type'],
            'combined_type' => $discResult['combined_type'],
            'scores' => $discResult['scores'],
            'percentages' => $discResult['percentages'],
            'total_score' => $totalScore,
            'answers' => $formattedAnswers,
            'completed_at' => now()->toISOString()
        ];

        $userProfile->disc_test = json_encode($discTestData);
        $userProfile->save();
    }

    /**
     * Randomize answer options to prevent bias
     */
    private function randomizeOptions($options)
    {
        $optionKeys = array_keys($options);
        $optionValues = array_values($options);

        shuffle($optionValues);

        return array_combine($optionKeys, $optionValues);
    }

    /**
     * Get DISC type description
     */
    private function getDiscDescription($discType)
    {
        $descriptions = $this->getDiscDescriptions();

        // Handle combined types
        if (strlen($discType) > 1) {
            return $this->getCombinedTypeDescription($discType, $descriptions);
        }

        return $descriptions[$discType] ?? null;
    }

    /**
     * Get all DISC type descriptions
     */
    private function getDiscDescriptions()
    {
        return [
            'D' => [
                'title' => 'Dominance',
                'subtitle' => 'Si Penggerak',
                'description' => 'Berorientasi pada hasil, tegas, dan kompetitif. Anda lebih suka memimpin dan mendorong untuk mencapai hasil.',
                'characteristics' => [
                    'Langsung dan terus terang',
                    'Fokus pada hasil',
                    'Kompetitif dan ambisius',
                    'Pengambil keputusan yang cepat',
                    'Suka mengendalikan situasi'
                ],
                'strengths' => [
                    'Mencapai hasil',
                    'Membuat keputusan dengan cepat',
                    'Mengambil inisiatif',
                    'Menerima tantangan',
                    'Memecahkan masalah'
                ],
                'weaknesses' => [
                    'Bisa tidak sabar',
                    'Mungkin mengabaikan detail',
                    'Bisa tidak peka',
                    'Mungkin terlihat agresif',
                    'Tidak menyukai tugas rutin'
                ],
                'motivation' => 'Pencapaian, kontrol, dan hasil',
                'fears' => 'Dimanfaatkan atau kehilangan kendali'
            ],
            'I' => [
                'title' => 'Influence',
                'subtitle' => 'Si Inspiratif',
                'description' => 'Antusias, optimis, dan berorientasi pada orang. Anda menikmati interaksi sosial dan menginspirasi orang lain.',
                'characteristics' => [
                    'Antusias dan energik',
                    'Banyak bicara dan ekspresif',
                    'Pandangan optimis',
                    'Berorientasi pada orang',
                    'Komunikator yang persuasif'
                ],
                'strengths' => [
                    'Memotivasi orang lain',
                    'Menciptakan antusiasme',
                    'Membangun hubungan',
                    'Berkomunikasi dengan efektif',
                    'Menghasilkan ide-ide'
                ],
                'weaknesses' => [
                    'Bisa tidak terorganisir',
                    'Mungkin terlalu berlebihan dalam menjual',
                    'Lebih banyak bicara daripada mendengar',
                    'Bisa impulsif',
                    'Mungkin kurang dalam tindak lanjut'
                ],
                'motivation' => 'Pengakuan, persetujuan sosial, dan popularitas',
                'fears' => 'Kehilangan persetujuan sosial atau malu di depan umum'
            ],
            'S' => [
                'title' => 'Steadiness',
                'subtitle' => 'Si Pendukung',
                'description' => 'Sabar, dapat diandalkan, dan berorientasi pada tim. Anda menghargai stabilitas dan lebih suka lingkungan yang stabil dan dapat diprediksi.',
                'characteristics' => [
                    'Sabar dan tenang',
                    'Dapat diandalkan dan konsisten',
                    'Pendengar yang baik',
                    'Pemain tim',
                    'Setia dan mendukung'
                ],
                'strengths' => [
                    'Memberikan stabilitas',
                    'Pendengar yang luar biasa',
                    'Anggota tim yang setia',
                    'Tenang di bawah tekanan',
                    'Membangun hubungan yang langgeng'
                ],
                'weaknesses' => [
                    'Menolak perubahan',
                    'Bisa ragu-ragu',
                    'Mungkin menghindari konflik',
                    'Lambat bertindak',
                    'Bisa terlalu rendah hati'
                ],
                'motivation' => 'Keamanan, stabilitas, dan apresiasi',
                'fears' => 'Kehilangan keamanan atau perubahan mendadak'
            ],
            'C' => [
                'title' => 'Conscientiousness',
                'subtitle' => 'Si Hati-hati',
                'description' => 'Analitis, sistematis, dan fokus pada kualitas. Anda menghargai akurasi dan lebih suka bekerja dengan data dan sistem.',
                'characteristics' => [
                    'Berorientasi pada detail',
                    'Pemikir analitis',
                    'Fokus pada kualitas',
                    'Pendekatan sistematis',
                    'Diplomatik dan bijaksana'
                ],
                'strengths' => [
                    'Mempertahankan standar tinggi',
                    'Menganalisis secara menyeluruh',
                    'Mengikuti prosedur',
                    'Menghasilkan pekerjaan berkualitas',
                    'Berpikir sistematis'
                ],
                'weaknesses' => [
                    'Bisa terlalu kritis',
                    'Mungkin terlalu banyak berpikir dalam mengambil keputusan',
                    'Menghindari mengambil risiko',
                    'Bisa perfeksionis',
                    'Mungkin terlihat acuh tak acuh'
                ],
                'motivation' => 'Pekerjaan berkualitas, akurasi, dan keahlian',
                'fears' => 'Kritik terhadap pekerjaan mereka atau membuat kesalahan'
            ]
        ];
    }

    /**
     * Get combined type description
     */
    private function getCombinedTypeDescription($discType, $descriptions)
    {
        $primary = substr($discType, 0, 1);
        $secondary = substr($discType, 1, 1);

        $primaryDesc = $descriptions[$primary];
        $secondaryDesc = $descriptions[$secondary];

        return [
            'title' => $primaryDesc['title'] . ' + ' . $secondaryDesc['title'],
            'subtitle' => $primaryDesc['subtitle'] . ' / ' . $secondaryDesc['subtitle'],
            'description' => "You have a blend of {$primaryDesc['title']} and {$secondaryDesc['title']} traits. " . $primaryDesc['description'],
            'characteristics' => array_merge(
                array_slice($primaryDesc['characteristics'], 0, 3),
                array_slice($secondaryDesc['characteristics'], 0, 2)
            ),
            'strengths' => array_merge(
                array_slice($primaryDesc['strengths'], 0, 3),
                array_slice($secondaryDesc['strengths'], 0, 2)
            ),
            'weaknesses' => array_merge(
                array_slice($primaryDesc['weaknesses'], 0, 3),
                array_slice($secondaryDesc['weaknesses'], 0, 2)
            ),
            'motivation' => $primaryDesc['motivation'] . ' and ' . strtolower($secondaryDesc['motivation']),
            'fears' => $primaryDesc['fears'] . ' or ' . strtolower($secondaryDesc['fears'])
        ];
    }

    /**
     * Get score interpretation
     */
    private function getScoreInterpretation($scores)
    {
        $total = array_sum($scores);
        $interpretations = [];

        foreach ($scores as $dimension => $score) {
            $percentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;

            $level = match (true) {
                $percentage >= 35 => 'Very High',
                $percentage >= 25 => 'High',
                $percentage >= 15 => 'Moderate',
                default => 'Low'
            };

            $interpretations[$dimension] = [
                'score' => $score,
                'percentage' => $percentage,
                'level' => $level
            ];
        }

        return $interpretations;
    }

    /**
     * Get recommendations based on DISC type
     */
    private function getRecommendations($primaryType)
    {
        $recommendations = [
            'D' => [
                'communication' => 'Berkomunikasi secara langsung dan fokus pada hasil',
                'work_style' => 'Berikan proyek yang menantang dan otoritas dalam pengambilan keputusan',
                'development' => 'Bekerja pada kesabaran dan mempertimbangkan sudut pandang orang lain',
                'leadership' => 'Pemimpin alami, tetapi harus berlatih kepemimpinan kolaboratif'
            ],
            'I' => [
                'communication' => 'Gunakan komunikasi yang antusias dan berfokus pada orang',
                'work_style' => 'Berikan kesempatan interaksi sosial dan pengakuan',
                'development' => 'Fokus pada tindak lanjut dan perhatian terhadap detail',
                'leadership' => 'Hebat dalam menginspirasi orang lain, harus mengembangkan keterampilan organisasi'
            ],
            'S' => [
                'communication' => 'Gunakan gaya komunikasi yang sabar dan mendukung',
                'work_style' => 'Berikan lingkungan yang stabil dan ekspektasi yang jelas',
                'development' => 'Berlatih beradaptasi dengan perubahan dan ketegasan',
                'leadership' => 'Pemain tim yang luar biasa, harus bekerja pada kecepatan pengambilan keputusan'
            ],
            'C' => [
                'communication' => 'Berikan informasi detail dan penalaran yang logis',
                'work_style' => 'Berikan waktu untuk analisis dan pekerjaan yang fokus pada kualitas',
                'development' => 'Berlatih pengambilan keputusan cepat dan pengambilan risiko',
                'leadership' => 'Keterampilan analitis yang kuat, harus bekerja pada keterampilan interpersonal'
            ]
        ];

        return $recommendations[$primaryType] ?? [];
    }
}
