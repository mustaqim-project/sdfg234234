<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminNewsCreateRequest;
use App\Http\Requests\AdminNewsUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NewsController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:news index,admin'])->only(['index', 'copyNews']);
        $this->middleware(['permission:news create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:news update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:news delete,admin'])->only(['destroy']);
        $this->middleware(['permission:news all-access,admin'])->only(['toggleNewsStatus']);
    }


    public function index()
    {
        $languages = Language::all();
        return view('admin.news.index', compact('languages'));
    }

    public function pendingNews(): View
    {
        $languages = Language::all();
        return view('admin.pending-news.index', compact('languages'));
    }



    public function fetchCategory(Request $request)
    {
        $categories = Category::where('language', $request->lang)
                              ->where('status', 1)
                              ->get();
        return $categories;
    }


    function approveNews(Request $request): Response
    {
        $news = News::findOrFail($request->id);
        $news->is_approved = $request->is_approve;
        $news->save();

        return response(['status' => 'success', 'message' => __('admin.Updated Successfully')]);
    }


    public function create()
    {
        $languages = Language::all();
        return view('admin.news.create', compact('languages'));
    }


    // public function store(AdminNewsCreateRequest $request)
    // {
    //     $relativeImagePath = $this->handleFileUpload($request, 'image');

    //     // Remove the 'uploads/' prefix from the relative image path if it exists
    //     $relativeImagePath = str_replace('uploads/', '', $relativeImagePath);
    //     // Define the base URL
    //     $baseUrl = 'https://image.miluv.app/';

    //     // Concatenate the base URL with the relative image path
    //     $imagePath = $baseUrl . $relativeImagePath;


    //     $news = new News();
    //     $news->language = $request->language;
    //     $news->category_id = $request->category;
    //     $news->auther_id = Auth::guard('admin')->user()->id;
    //     $news->image = $imagePath;  // Use the updated image path
    //     $news->title = $request->title;
    //     $news->slug = \Str::slug($request->title);
    //     $news->content = $request->content;
    //     $news->meta_title = $request->meta_title;
    //     $news->meta_description = $request->meta_description;
    //     $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
    //     $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
    //     $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
    //     $news->status = $request->status == 1 ? 1 : 0;
    //     $news->is_approved = getRole() == 'Super Admin' || checkPermission('news all-access') ? 1 : 0;
    //     $news->meta_keyword = $request->meta_keyword;
    //     $news->scheduled_at = $request->scheduled_at ? $request->scheduled_at : Carbon::now();
    //     $news->created_at = $request->scheduled_at ? $request->scheduled_at : Carbon::now();
    //     $news->save();

    //     $tags = explode(',', $request->tags);
    //     $tagIds = [];

    //     foreach ($tags as $tag) {
    //         $item = Tag::firstOrCreate(['name' => $tag, 'language' => $news->language]);
    //         $tagIds[] = $item->id;
    //     }

    //     $news->tags()->attach($tagIds);

    //     toast(__('admin.Created Successfully!'), 'success')->width('330');

    //     return redirect()->route('admin.news.index');
    // }



    public function store(AdminNewsCreateRequest $request)
    {
        $imagePath = $this->handleFileUpload($request, 'image');

        $news = new News();
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->auther_id = Auth::guard('admin')->user()->id;
        $news->image = $imagePath;
        $news->title = $request->title;
        $news->slug = \Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->is_approved = getRole() == 'Super Admin' || checkPermission('news all-access') ? 1 : 0;
        $news->meta_keyword = $request->meta_keyword;
        $news->scheduled_at = $request->scheduled_at ? $request->scheduled_at : Carbon::now();
        $news->created_at = $request->scheduled_at ? $request->scheduled_at : Carbon::now();
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        foreach ($tags as $tag) {
            $item = Tag::firstOrCreate(['name' => $tag, 'language' => $news->language]);
            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);

        toast(__('admin.Created Successfully!'), 'success')->width('330');

        return redirect()->route('admin.news.index');
    }



    public function toggleNewsStatus(Request $request)
    {
        try {
            $news = News::findOrFail($request->id);
            $news->{$request->name} = $request->status;
            $news->save();

            return response(['status' => 'success', 'message' => __('admin.Updated successfully!')]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function edit(string $id)
    {
        $languages = Language::all();
        $news = News::findOrFail($id);

        if(!canAccess(['news all-access'])){
            if($news->auther_id != auth()->guard('admin')->user()->id){
                return abort(404);
            }
        }

        $categories = Category::where('language', $news->language)->get();

        return view('admin.news.edit', compact('languages', 'news', 'categories'));
    }


    // public function update(AdminNewsUpdateRequest $request, string $id)
    // {

    //     $news = News::findOrFail($id);

    //     if($news->auther_id != auth()->guard('admin')->user()->id || getRole() != 'Super Admin'){
    //         return abort(404);
    //     }

    //     $relativeImagePath = $this->handleFileUpload($request, 'image');

    //     // Remove the 'uploads/' prefix from the relative image path if it exists
    //     $relativeImagePath = str_replace('uploads/', '', $relativeImagePath);
    //     // Define the base URL
    //     $baseUrl = 'https://image.miluv.app/';

    //     // Concatenate the base URL with the relative image path
    //     $imagePath = $baseUrl . $relativeImagePath;


    //     $news->language = $request->language;
    //     $news->category_id = $request->category;
    //     $news->image = !empty($imagePath) ? $imagePath : $news->image;
    //     $news->title = $request->title;
    //     $news->slug = \Str::slug($request->title);
    //     $news->content = $request->content;
    //     $news->meta_title = $request->meta_title;
    //     $news->meta_description = $request->meta_description;
    //     $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
    //     $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
    //     $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
    //     $news->status = $request->status == 1 ? 1 : 0;
    //     $news->meta_keyword = $request->meta_keyword;
    //     $news->scheduled_at = $request->scheduled_at;
    //     $news->save();

    //     $tags = explode(',', $request->tags);
    //     $tagIds = [];

    //     /** Delete previos tags */
    //     $news->tags()->delete();

    //     /** detach tags form pivot table */
    //     $news->tags()->detach($news->tags);

    //     foreach ($tags as $tag) {
    //         $item = new Tag();
    //         $item->name = $tag;
    //         $item->language = $news->language;
    //         $item->save();

    //         $tagIds[] = $item->id;
    //     }

    //     $news->tags()->attach($tagIds);


    //     toast(__('admin.Update Successfully!'), 'success')->width('330');

    //     return redirect()->route('admin.news.index');
    // }

  public function update(AdminNewsUpdateRequest $request, string $id)
    {

        $news = News::findOrFail($id);

        if($news->auther_id != auth()->guard('admin')->user()->id || getRole() != 'Super Admin'){
            return abort(404);
        }

        $imagePath = $this->handleFileUpload($request, 'image');

        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->image = !empty($imagePath) ? $imagePath : $news->image;
        $news->title = $request->title;
        $news->slug = \Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->meta_keyword = $request->meta_keyword;
        $news->scheduled_at = $request->scheduled_at;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagIds = [];

        /** Delete previos tags */
        $news->tags()->delete();

        /** detach tags form pivot table */
        $news->tags()->detach($news->tags);

        foreach ($tags as $tag) {
            $item = new Tag();
            $item->name = $tag;
            $item->language = $news->language;
            $item->save();

            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);


        toast(__('admin.Update Successfully!'), 'success')->width('330');

        return redirect()->route('admin.news.index');
    }


    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $this->deleteFile($news->image);
        $news->tags()->delete();
        $news->delete();

        return response(['status' => 'success', 'message' => __('admin.Deleted Successfully!')]);
    }


    public function copyNews(string $id)
    {
        $news = News::findOrFail($id);
        $copyNews = $news->replicate();
        $copyNews->save();

        toast(__('admin.Copied Successfully!'), 'success');

        return redirect()->back();
    }
}
