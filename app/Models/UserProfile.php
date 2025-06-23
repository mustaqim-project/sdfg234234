<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender_id',
        'height',
        'weight',
        'province_id',
        'city_id',
        'education_level_id',
        'occupation',
        'company',
        'religion_id',
        'income_range_id',
        'wants_children',
        'zodiac_id',
        'smoking_habit_id',
        'drinking_habit_id',
        'marriage_test_result',
        'mbti_test_result',
        'disc_test_result',
        'temperament_test_result',
        'love_language_test_result',
        'bio',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'wants_children' => 'boolean',
        'marriage_test_result' => 'array',
        'mbti_test_result' => 'array',
        'disc_test_result' => 'array',
        'temperament_test_result' => 'array',
        'love_language_test_result' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function zodiac()
    {
        return $this->belongsTo(Zodiac::class, 'zodiac_id');
    }

    public function smokingHabit()
    {
        return $this->belongsTo(SmokingHabit::class, 'smoking_habit_id');
    }

    public function drinkingHabit()
    {
        return $this->belongsTo(DrinkingHabit::class, 'drinking_habit_id');
    }

    public function incomeRange()
    {
        return $this->belongsTo(IncomeRange::class, 'income_range_id');
    }
}
