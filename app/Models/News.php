<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'language',
        'category_id',
        'auther_id',
        'image',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_breaking_news',
        'show_at_slider',
        'show_at_popular',
        'status',
        'is_approved',
        'views',
        'meta_keyword',
        'scheduled_at',
    ];

    protected $dates = [
        'scheduled_at',
    ];

    public function scopeActiveEntries($query)
    {
        return $query->where([
            'status' => 1,
            'is_approved' => 1
        ]);
    }

    public function scopeWithLocalize($query)
    {
        return $query->where('language', getLangauge());
    }

    public function scopeScheduled($query)
    {
        return $query->where('scheduled_at', '<=', Carbon::now())
                     ->where('status', 0);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags');
    }

    public function auther()
    {
        return $this->belongsTo(Admin::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
