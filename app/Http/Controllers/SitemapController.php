<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function categories($language)
    {
        $categories = Category::where('language', $language)->orderBy('created_at', 'desc')->get();
        return response()->view('sitemap.categories', compact('categories', 'language'))->header('Content-Type', 'text/xml');
    }

    public function tags()
    {
        $tags = Tag::orderBy('created_at', 'desc')->get();
        return response()->view('sitemap.tags', compact('tags'))->header('Content-Type', 'text/xml');
    }

    public function newsIndex($language)
    {
        $categories = Category::where('language', $language)
            ->where('status', 1) // Menambahkan kondisi status = 1
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->view('sitemap.news-index', compact('categories', 'language'))->header('Content-Type', 'text/xml');
    }


    public function newsByCategoryEn($category)
    {
        $news = News::select('news.*')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->where('categories.slug', $category)
            ->where('categories.language', 'en')
            ->orderBy('news.created_at', 'desc')
            ->get();
        return response()->view('sitemap.news', compact('news'))->header('Content-Type', 'text/xml');
    }

    public function newsByCategoryId($category)
    {
        $news = News::select('news.*')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->where('categories.slug', $category)
            ->where('categories.language', 'id')
            ->where('categories.status', 1) 
            ->orderBy('news.created_at', 'desc')
            ->get();
        return response()->view('sitemap.news', compact('news'))->header('Content-Type', 'text/xml');
    }

}
