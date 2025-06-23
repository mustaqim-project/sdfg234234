<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\kebijakan;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\HomeSectionSetting;
use App\Models\News;
use App\Models\RecivedMail;
use App\Models\SocialCount;
use App\Models\SocialLink;
use App\Models\Subscriber;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

public function index()
{
    // Cache Breaking News - 10 menit
    $breakingNews = Cache::remember('breaking_news', 10, function () {
        return News::where(['is_breaking_news' => 1])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(10)
            ->get();
    });

    // Cache Hero Slider - 10 menit
    $heroSlider = Cache::remember('hero_slider', 10, function () {
        return News::with(['category', 'auther'])
            ->where('show_at_slider', 1)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(7)
            ->get();
    });

    // Cache Recent News - 10 menit
    $recentNews = Cache::remember('recent_news', 10, function () {
        return News::with(['category', 'auther'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(6)
            ->get();
    });

    // Cache Popular News - 10 menit
    $popularNews = Cache::remember('popular_news', 10, function () {
        return News::with(['category'])
            ->where('show_at_popular', 1)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('updated_at', 'DESC')
            ->take(4)
            ->get();
    });

    // Cache Home Section Settings - 10 menit
    $HomeSectionSetting = Cache::remember('home_section_setting_' . getLangauge(), 10, function () {
        return HomeSectionSetting::where('language', getLangauge())->first();
    });

    if ($HomeSectionSetting) {
        // Cache Category Sections - 10 menit
        $categorySectionOne = Cache::remember('category_section_one_' . $HomeSectionSetting->category_section_one, 10, function () use ($HomeSectionSetting) {
            return News::where('category_id', $HomeSectionSetting->category_section_one)
                ->activeEntries()
                ->withLocalize()
                ->orderBy('id', 'DESC')
                ->take(8)
                ->get();
        });

        $categorySectionTwo = Cache::remember('category_section_two_' . $HomeSectionSetting->category_section_two, 10, function () use ($HomeSectionSetting) {
            return News::where('category_id', $HomeSectionSetting->category_section_two)
                ->activeEntries()
                ->withLocalize()
                ->orderBy('id', 'DESC')
                ->take(8)
                ->get();
        });

        $categorySectionThree = Cache::remember('category_section_three_' . $HomeSectionSetting->category_section_three, 10, function () use ($HomeSectionSetting) {
            return News::where('category_id', $HomeSectionSetting->category_section_three)
                ->activeEntries()
                ->withLocalize()
                ->orderBy('id', 'DESC')
                ->take(6)
                ->get();
        });

        $categorySectionFour = Cache::remember('category_section_four_' . $HomeSectionSetting->category_section_four, 10, function () use ($HomeSectionSetting) {
            return News::where('category_id', $HomeSectionSetting->category_section_four)
                ->activeEntries()
                ->withLocalize()
                ->orderBy('id', 'DESC')
                ->take(4)
                ->get();
        });
    } else {
        $categorySectionOne = collect();
        $categorySectionTwo = collect();
        $categorySectionThree = collect();
        $categorySectionFour = collect();
    }

    // Cache Most Viewed Posts - 10 menit
    $mostViewedPosts = Cache::remember('most_viewed_posts', 10, function () {
        return News::activeEntries()
            ->withLocalize()
            ->orderBy('views', 'DESC')
            ->take(3)
            ->get();
    });

    // Cache Social Counts - 10 menit
    $socialCounts = Cache::remember('social_counts_' . getLangauge(), 10, function () {
        return SocialCount::where(['status' => 1, 'language' => getLangauge()])->get();
    });

    // Cache Most Common Tags - 10 menit
    $mostCommonTags = Cache::remember('most_common_tags', 10, function () {
        return $this->mostCommonTags();
    });

    // Cache Ads - 10 menit
    $ad = Cache::remember('ad', 10, function () {
        return Ad::first();
    });

    return view('frontend.home', compact(
        'breakingNews',
        'heroSlider',
        'recentNews',
        'popularNews',
        'categorySectionOne',
        'categorySectionTwo',
        'categorySectionThree',
        'categorySectionFour',
        'mostViewedPosts',
        'socialCounts',
        'mostCommonTags',
        'ad'
    ));
}


public function ShowNews(string $slug)
{
    // Cache the news based on slug - 10 minutes
    $news = Cache::remember('news_' . $slug, 10, function () use ($slug) {
        return News::with(['auther', 'tags', 'comments'])
            ->where('slug', $slug)
            ->activeEntries()
            ->withLocalize()
            ->first();
    });

    $this->countView($news);

    // Cache recent news - 10 minutes
    $recentNews = Cache::remember('recent_news_' . $news->slug, 10, function () use ($news) {
        return News::with(['category', 'auther'])
            ->where('slug', '!=', $news->slug)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();
    });

    // Cache common tags - 10 minutes
    $mostCommonTags = Cache::remember('most_common_tags', 10, function () {
        return $this->mostCommonTags();
    });

    // Cache next post - 10 minutes
    $nextPost = Cache::remember('next_post_' . $news->id, 10, function () use ($news) {
        return News::where('id', '>', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'asc')
            ->first();
    });

    // Cache previous post - 10 minutes
    $previousPost = Cache::remember('previous_post_' . $news->id, 10, function () use ($news) {
        return News::where('id', '<', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'desc')
            ->first();
    });

    // Cache related posts by category - 10 minutes
    $relatedPosts = Cache::remember('related_posts_' . $news->category_id . '_slug_' . $news->slug, 10, function () use ($news) {
        return News::where('slug', '!=', $news->slug)
            ->where('category_id', $news->category_id)
            ->activeEntries()
            ->withLocalize()
            ->take(5)
            ->get();
    });

    // Cache social counts - 10 minutes
    $socialCounts = Cache::remember('social_counts_' . getLangauge(), 10, function () {
        return SocialCount::where(['status' => 1, 'language' => getLangauge()])->get();
    });

    // Cache advertisement - 10 minutes
    $ad = Cache::remember('ad', 10, function () {
        return Ad::first();
    });

    // Cache related news by tag - 10 minutes
    $relatedNewsByTag = Cache::remember('related_news_by_tag_' . $news->id, 10, function () use ($news) {
        return News::whereHas('tags', function ($query) use ($news) {
            $query->whereIn('name', $news->tags->pluck('name'));
        })
        ->where('id', '!=', $news->id)
        ->activeEntries()
        ->withLocalize()
        ->take(5)
        ->get();
    });

    // Insert internal links if related news by tag exists
    if ($relatedNewsByTag->isNotEmpty()) {
        $news = $this->insertInternalLinks($news, $relatedNewsByTag);
    }

    return view('frontend.news-details', compact(
        'news',
        'recentNews',
        'mostCommonTags',
        'nextPost',
        'previousPost',
        'relatedPosts',
        'socialCounts',
        'ad'
    ));
}

      private function getCategorySection($categoryId, $limit)
    {
        return News::where('category_id', $categoryId)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take($limit)
            ->get();
    }

    private function getRelatedNewsByTag($news)
    {
        return News::whereHas('tags', function ($query) use ($news) {
            $query->whereIn('name', $news->tags->pluck('name'));
        })->where('id', '!=', $news->id)
            ->activeEntries()
            ->withLocalize()
            ->inRandomOrder()
            ->take(5)
            ->get();
    }

    private function insertInternalLinks($news, $relatedNewsByTag)
    {
        $content = $news->content;
        $links = $this->getLinks($news);

        $content = preg_replace_callback(
            '/<p[^>]*>(.*?)<\/p>/is',
            function ($matches) use (&$links) {
                $paragraph = $matches[1];

                foreach ($links as $keyword => $link) {
                    if (strpos($paragraph, $keyword) !== false) {
                        $paragraph = preg_replace(
                            '/\b' . preg_quote($keyword, '/') . '\b(?![^<>]*>)/i',
                            '<a href="' . $link . '">' . $keyword . '</a>',
                            $paragraph,
                            1
                        );
                        unset($links[$keyword]);
                    }
                }

                return '<p>' . $paragraph . '</p>';
            },
            $content
        );

        $news->content = $this->insertRelatedLinks($content, $relatedNewsByTag);
        return $news;
    }

    private function getLinks($news)
    {
        $links = [];
        $tags = $news->tags;
        $category = $news->category;

        foreach ($tags as $tag) {
            $slug = $this->str_slug($tag->name);
            $slugWithEncodedSpace = str_replace('-', '%20', $slug);
            $links[$tag->name] = url('/news?tag=' . $slugWithEncodedSpace);
        }

        if ($category) {
            $slug = $this->str_slug($category->name);
            $links[$category->name] = url('/news?category=' . urlencode($slug));
        }

        return $links;
    }

    private function insertRelatedLinks($content, $relatedNewsByTag)
    {
        $paragraphs = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        $cumulativeWords = 0;
        $counter = 0;
        $relatedLinks = $relatedNewsByTag->map(function ($relatedNews) {
            return $this->formatRelatedLink($relatedNews);
        })->toArray();

        foreach ($paragraphs as $key => $paragraph) {
            if (strip_tags($paragraph) != '') {
                $cumulativeWords += str_word_count(strip_tags($paragraph));

                if ($cumulativeWords >= 500 && isset($relatedLinks[$counter])) {
                    $paragraphs[$key] .= $relatedLinks[$counter];
                    $cumulativeWords = 0;
                    $counter++;
                }
            }
        }

        return implode('', $paragraphs);
    }

    private function formatRelatedLink($relatedNews)
    {
        $link = url('/news-details/' . $relatedNews->slug);
        $title = $relatedNews->title;
        return "
            <div style='display: flex; align-items: center; margin-top: 20px;'>
                <div style='background-color: #0052a3; width: 4px; height: 40px; margin-right: 10px;'></div>
                <div>
                    <p style='font-weight: bold; font-size:16px; margin: 0;'>Baca juga:</p>
                    <p style='margin: 0;'><a href=\"$link\" style='color: #0052a3; text-decoration: none; font-size: 16px; font-weight:bold;'>$title</a></p>
                </div>
            </div>";
    }

    private function str_slug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }


    // public function news(Request $request)
    // {

    //     $news = News::query();

    //     $news->when($request->has('tag'), function ($query) use ($request) {
    //         $query->whereHas('tags', function ($query) use ($request) {
    //             $query->where('name', $request->tag);
    //         });
    //     });

    //     $news->when($request->has('category') && !empty($request->category), function ($query) use ($request) {
    //         $query->whereHas('category', function ($query) use ($request) {
    //             $query->where('slug', $request->category);
    //         });
    //     });

    //     $news->when($request->has('search'), function ($query) use ($request) {
    //         $query->where(function ($query) use ($request) {
    //             $query->where('title', 'like', '%' . $request->search . '%')
    //                 ->orWhere('content', 'like', '%' . $request->search . '%');
    //         })->orWhereHas('category', function ($query) use ($request) {
    //             $query->where('name', 'like', '%' . $request->search . '%');
    //         });
    //     });

    //     $news = $news->activeEntries()->withLocalize()->paginate(20);


    //     $recentNews = News::with(['category', 'auther'])
    //         ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();
    //     $mostCommonTags = $this->mostCommonTags();

    //     $categories = Category::where(['status' => 1, 'language' => getLangauge()])->get();

    //     $ad = Ad::first();

    //     return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories', 'ad'));
    // }

    public function news(Request $request)
    {
        $news = News::query();

        $news->when($request->has('tag'), function ($query) use ($request) {
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', $request->tag);
            });
        });

        $news->when($request->has('category') && !empty($request->category), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });

        $news->when($request->has('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            })->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        });

        $news = $news->activeEntries()->withLocalize()->paginate(20);

        $recentNews = News::with(['category', 'auther'])
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();
        $mostCommonTags = $this->mostCommonTags();

        $categories = Category::where(['status' => 1, 'language' => getLangauge()])->get();

        $ad = Ad::first();

        // Fetch the category if the 'category' parameter exists in the request
        $category = null;
        if ($request->has('category') && !empty($request->category)) {
            $category = Category::where('slug', $request->category)->first();
        }

        return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories', 'ad', 'category'));
    }


    public function countView($news)
    {
        if (session()->has('viewed_posts')) {
            $postIds = session('viewed_posts');

            if (!in_array($news->id, $postIds)) {
                $postIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_posts' => $postIds]);
        } else {
            session(['viewed_posts' => [$news->id]]);

            $news->increment('views');
        }
    }

    public function mostCommonTags()
    {
        return Tag::select('name', \DB::raw('COUNT(*) as count'))
            ->where('language', getLangauge())
            ->groupBy('name')
            ->orderByDesc('count')
            ->take(15)
            ->get();
    }

    public function handleComment(Request $request)
    {

        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();
        toast(__('frontend.Comment added successfully!'), 'success');
        return redirect()->back();
    }

    public function handleReplay(Request $request)
    {

        $request->validate([
            'replay' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->replay;
        $comment->save();
        toast(__('frontend.Comment added successfully!'), 'success');

        return redirect()->back();
    }

    public function commentDestory(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if (Auth::user()->id === $comment->user_id) {
            $comment->delete();
            return response(['status' => 'success', 'message' => __('frontend.Deleted Successfully!')]);
        }

        return response(['status' => 'error', 'message' => __('frontend.Someting went wrong!')]);
    }

    public function SubscribeNewsLetter(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
        ], [
            'email.unique' => __('frontend.Email is already subscribed!')
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => __('frontend.Subscribed successfully!')]);
    }

    public function about()
    {
        $about = About::where('language', getLangauge())->first();
        return view('frontend.about', compact('about'));
    }

    public function kebijakan()
    {
        $kebijakan = kebijakan::where('language', getLangauge())->first();
        return view('frontend.kebijakan', compact('kebijakan'));
    }


    public function contact()
    {
        $contact = Contact::where('language', getLangauge())->first();
        $socials = SocialLink::where('status', 1)->get();
        return view('frontend.contact', compact('contact', 'socials'));
    }

    public function handleContactFrom(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:500']
        ]);

        try {
            $toMail = Contact::where('language', 'en')->first();

            /** Send Mail */
            Mail::to($toMail->email)->send(new ContactMail($request->subject, $request->message, $request->email));

            /** store the mail */

            $mail = new RecivedMail();
            $mail->email = $request->email;
            $mail->subject = $request->subject;
            $mail->message = $request->message;
            $mail->save();
        } catch (\Exception $e) {
            toast(__($e->getMessage()));
        }

        toast(__('frontend.Message sent successfully!'), 'success');

        return redirect()->back();
    }
}
