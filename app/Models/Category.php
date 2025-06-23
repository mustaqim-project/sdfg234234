<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'language', 'name', 'slug', 'show_at_nav', 'status', 'meta_keyword', 'meta_description'
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
