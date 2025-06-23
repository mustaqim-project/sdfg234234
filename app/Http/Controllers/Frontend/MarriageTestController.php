<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;

class MarriageTestController extends Controller
{

        const TOTAL_QUESTIONS = 30;
    const ASSESSMENT_TYPE_ID = 1;


    public function index()
    {
        // Ambil data pertanyaan dari database
        $questions = DB::select("
            SELECT aq.id AS question_id,
                   ac.name AS category_name,
                   aq.question,
                   aq.options
            FROM assessment_categories ac
            JOIN assessment_questions aq ON ac.id = aq.assessment_category_id
            WHERE ac.assessment_type_id = 1
            ORDER BY aq.id
        ");

        // Decode JSON options dan randomize urutan pilihan
        foreach ($questions as $question) {
            $options = json_decode($question->options, true);
            $question->randomized_options = $this->randomizeOptions($options);
        }

        return view('marriage-test.index', compact('questions'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'answers' => 'required|array|size:30',
            'answers.*' => 'required|string|in:A,B,C,D,E'
        ]);

        // Ambil data pertanyaan untuk perhitungan skor
        $questions = DB::select("
            SELECT aq.id AS question_id,
                   aq.options
            FROM assessment_categories ac
            JOIN assessment_questions aq ON ac.id = aq.assessment_category_id
            WHERE ac.assessment_type_id = 1
            ORDER BY aq.id
        ");

        $rawScore = 0;
        $answers = [];
        $weightMapping = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5];

        // Hitung skor mentah dan format jawaban
        foreach ($questions as $index => $question) {
            $questionId = $question->question_id;
            $userAnswer = $request->answers[$index];

            // Tambahkan ke array jawaban
            $answers[] = [
                'question_id' => $questionId,
                'answer' => $userAnswer
            ];

            // Hitung skor berdasarkan bobot
            $rawScore += $weightMapping[$userAnswer];
        }

        // Konversi ke range 1-100
        $finalScore = $this->convertToRange100($rawScore);

        // Format data untuk disimpan
        $testResult = [
            'raw_score' => $rawScore,      // Skor asli (30-150)
            'final_score' => $finalScore,   // Skor final (1-100)
            'answers' => $answers,
            'completed_at' => now()->toISOString()
        ];

        // Simpan hasil ke user_profile berdasarkan username
        $userProfile = UserProfile::where('username', Auth::user()->username)->first();

        if (!$userProfile) {
            // Buat user profile baru jika belum ada
            $userProfile = new UserProfile();
            $userProfile->username = Auth::user()->username;
        }

        $userProfile->marriage_test = json_encode($testResult);
        $userProfile->save();

        // Redirect dengan pesan sukses dan skor
        return redirect()->route('marriage-test.result')
                        ->with('success', 'Tes berhasil diselesaikan!')
                        ->with('score', $finalScore);
    }

    public function result()
    {
        $userProfile = UserProfile::where('username', Auth::user()->username)->first();

        if (!$userProfile || !$userProfile->marriage_test) {
            return redirect()->route('marriage-test.index')
                           ->with('error', 'Silakan selesaikan tes terlebih dahulu.');
        }

        $testResult = json_decode($userProfile->marriage_test, true);

        // Ambil skor final (1-100) atau konversi dari raw score jika belum ada
        $finalScore = isset($testResult['final_score'])
            ? $testResult['final_score']
            : $this->convertToRange100($testResult['score'] ?? $testResult['raw_score']);

        $rawScore = $testResult['raw_score'] ?? $testResult['score'];

        // Tentukan kategori kesiapan berdasarkan skor final
        $readinessLevel = $this->getReadinessLevel($finalScore);

        return view('marriage-test.result', compact('finalScore', 'rawScore', 'readinessLevel'));
    }

    /**
     * Konversi skor dari range 30-150 ke range 1-100
     */
    private function convertToRange100($rawScore)
    {
        $minRawScore = 30;  // Skor minimum yang mungkin (30 × 1)
        $maxRawScore = 150; // Skor maksimum yang mungkin (30 × 5)

        $minFinalScore = 1;
        $maxFinalScore = 100;

        // Formula konversi linear
        $finalScore = (($rawScore - $minRawScore) / ($maxRawScore - $minRawScore))
                     * ($maxFinalScore - $minFinalScore) + $minFinalScore;

        // Pastikan hasil dalam range 1-100 dan dibulatkan
        return max(1, min(100, round($finalScore)));
    }

    private function randomizeOptions($options)
    {
        $optionKeys = ['A', 'B', 'C', 'D', 'E'];
        $optionValues = array_values($options);

        // Shuffle nilai-nilai opsi
        shuffle($optionValues);

        // Buat mapping baru dengan key tetap A-E tapi nilai teracak
        $randomizedOptions = [];
        foreach ($optionKeys as $index => $key) {
            if (isset($optionValues[$index])) {
                $randomizedOptions[$key] = $optionValues[$index];
            }
        }

        return $randomizedOptions;
    }

    private function getReadinessLevel($score)
    {
        if ($score >= 80) {
            return [
                'level' => 'Sangat Siap',
                'description' => 'Anda menunjukkan kesiapan yang sangat baik untuk menikah. Terus pertahankan dan kembangkan aspek-aspek positif ini.',
                'color' => 'success'
            ];
        } elseif ($score >= 60) {
            return [
                'level' => 'Cukup Siap',
                'description' => 'Anda memiliki kesiapan yang cukup baik, namun masih ada beberapa area yang perlu diperbaiki sebelum menikah.',
                'color' => 'info'
            ];
        } elseif ($score >= 40) {
            return [
                'level' => 'Kurang Siap',
                'description' => 'Masih ada banyak aspek yang perlu dipersiapkan. Sebaiknya fokus pada pengembangan diri terlebih dahulu.',
                'color' => 'warning'
            ];
        } else {
            return [
                'level' => 'Belum Siap',
                'description' => 'Anda belum siap untuk menikah. Penting untuk fokus pada pertumbuhan personal dan kesiapan dalam berbagai aspek kehidupan.',
                'color' => 'danger'
            ];
        }
    }
}
