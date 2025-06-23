<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Validator;

class TempramentTestController extends Controller
{
    const TOTAL_QUESTIONS = 28;

    /**
     * Display DISC test form
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
                ac.assessment_type_id = 5
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
        $userProfile = UserProfile::firstOrNew(['user_id' => Auth::id()]);
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
                $userProfile = UserProfile::where('user_id', Auth::id())->first();
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
                        if (isset($config[$trait])) { // <-- FIXED HERE
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
        // Implement this if you want to store individual answers
        // Example:
        /*
        foreach ($answers as $questionId => $answer) {
            MBTIAnswer::create([
                'user_id' => Auth::id(),
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
                'title' => 'The Architect',
                'description' => 'Imaginative and strategic thinkers, with a plan for everything.',
                'strengths' => ['Analytical', 'Strategic', 'Independent'],
                'weaknesses' => ['Overly critical', 'Perfectionist', 'Socially awkward']
            ],
            'INTP' => [
                'title' => 'The Thinker',
                'description' => 'Innovative inventors with an unquenchable thirst for knowledge.',
                'strengths' => ['Original', 'Open-minded', 'Honest'],
                'weaknesses' => ['Absent-minded', 'Insensitive', 'Overly private']
            ],
            'ENTJ' => [
                'title' => 'The Commander',
                'description' => 'Bold, imaginative and strong-willed leaders.',
                'strengths' => ['Efficient', 'Confident', 'Strong-willed'],
                'weaknesses' => ['Impatient', 'Stubborn', 'Intolerant']
            ],
            'ENTP' => [
                'title' => 'The Debater',
                'description' => 'Smart and curious thinkers who cannot resist an intellectual challenge.',
                'strengths' => ['Quick-witted', 'Creative', 'Excellent brainstormers'],
                'weaknesses' => ['Argumentative', 'Insensitive', 'Intolerant of routine']
            ],
            'INFJ' => [
                'title' => 'The Advocate',
                'description' => 'Quiet and mystical, yet very inspiring and tireless idealists.',
                'strengths' => ['Creative', 'Insightful', 'Determined'],
                'weaknesses' => ['Sensitive', 'Perfectionist', 'Private']
            ],
            'INFP' => [
                'title' => 'The Mediator',
                'description' => 'Poetic, kind and altruistic people, always eager to help a good cause.',
                'strengths' => ['Empathetic', 'Creative', 'Passionate'],
                'weaknesses' => ['Unrealistic', 'Self-critical', 'Overly idealistic']
            ],
            'ENFJ' => [
                'title' => 'The Protagonist',
                'description' => 'Charismatic and inspiring leaders, able to mesmerize their listeners.',
                'strengths' => ['Persuasive', 'Reliable', 'Passionate'],
                'weaknesses' => ['Overly idealistic', 'Too selfless', 'Fluctuating self-esteem']
            ],
            'ENFP' => [
                'title' => 'The Campaigner',
                'description' => 'Enthusiastic, creative and sociable free spirits.',
                'strengths' => ['Curious', 'Perceptive', 'Energetic'],
                'weaknesses' => ['Overly optimistic', 'Restless', 'Seeking approval']
            ],
            'ISTJ' => [
                'title' => 'The Logistician',
                'description' => 'Practical and fact-minded, reliable and responsible.',
                'strengths' => ['Honest', 'Dependable', 'Responsible'],
                'weaknesses' => ['Stubborn', 'Insensitive', 'Judgmental']
            ],
            'ISFJ' => [
                'title' => 'The Protector',
                'description' => 'Very dedicated and warm protectors, always ready to defend their loved ones.',
                'strengths' => ['Supportive', 'Reliable', 'Patient'],
                'weaknesses' => ['Overly humble', 'Overloaded', 'Reluctant to change']
            ],
            'ESTJ' => [
                'title' => 'The Executive',
                'description' => 'Excellent administrators, unsurpassed at managing things or people.',
                'strengths' => ['Dedicated', 'Strong-willed', 'Direct'],
                'weaknesses' => ['Impatient', 'Stubborn', 'Insensitive']
            ],
            'ESFJ' => [
                'title' => 'The Consul',
                'description' => 'Extraordinarily caring, social and popular people, always eager to help.',
                'strengths' => ['Practical', 'Loyal', 'Good organizers'],
                'weaknesses' => ['Needy', 'Sensitive', 'Overly selfless']
            ],
            'ISTP' => [
                'title' => 'The Virtuoso',
                'description' => 'Bold and practical experimenters, masters of all kinds of tools.',
                'strengths' => ['Optimistic', 'Creative', 'Practical'],
                'weaknesses' => ['Private', 'Insensitive', 'Risk-taking']
            ],
            'ISFP' => [
                'title' => 'The Adventurer',
                'description' => 'Flexible and charming artists, always ready to explore new possibilities.',
                'strengths' => ['Charming', 'Sensitive', 'Artistic'],
                'weaknesses' => ['Overly competitive', 'Unpredictable', 'Easily stressed']
            ],
            'ESTP' => [
                'title' => 'The Entrepreneur',
                'description' => 'Smart, energetic and perceptive people, truly enjoy living on the edge.',
                'strengths' => ['Bold', 'Practical', 'Original'],
                'weaknesses' => ['Impatient', 'Insensitive', 'Risk-taking']
            ],
            'ESFP' => [
                'title' => 'The Entertainer',
                'description' => 'Spontaneous, energetic and enthusiastic people - life is never boring.',
                'strengths' => ['Observant', 'Practical', 'Excellent communicators'],
                'weaknesses' => ['Sensitive', 'Conflict-averse', 'Easily bored']
            ]
        ];

        return $descriptions[$mbtiType] ?? [
            'title' => 'Unknown Type',
            'description' => 'Type description not available.',
            'strengths' => [],
            'weaknesses' => []
        ];
    }
}
