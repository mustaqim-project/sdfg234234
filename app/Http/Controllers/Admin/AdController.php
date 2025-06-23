<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAdUpdateRequest;
use App\Models\Ad;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:advertisement index,admin'])->only(['index']);
        $this->middleware(['permission:advertisement update,admin'])->only(['update']);
    }

    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ad = Ad::first();
        return view('admin.ad.index', compact('ad'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AdminAdUpdateRequest $request, string $id)
    {
        // Handle file uploads
        $home_top_bar_ad = $this->handleFileUpload($request, 'home_top_bar_ad');
        $home_middle_ad = $this->handleFileUpload($request, 'home_middle_ad');
        $view_page_ad = $this->handleFileUpload($request, 'view_page_ad');
        $news_page_ad = $this->handleFileUpload($request, 'news_page_ad');
        $side_bar_ad = $this->handleFileUpload($request, 'side_bar_ad');
        $ads_banner_left = $this->handleFileUpload($request, 'ads_banner_left');
        $ads_banner_right = $this->handleFileUpload($request, 'ads_banner_right');

        $ad = Ad::first();

        // Update or create ad record
        $ad->update([
            'home_top_bar_ad' => !empty($home_top_bar_ad) ? $home_top_bar_ad : $ad->home_top_bar_ad,
            'home_middle_ad' => !empty($home_middle_ad) ? $home_middle_ad : $ad->home_middle_ad,
            'view_page_ad' => !empty($view_page_ad) ? $view_page_ad : $ad->view_page_ad,
            'news_page_ad' => !empty($news_page_ad) ? $news_page_ad : $ad->news_page_ad,
            'side_bar_ad' => !empty($side_bar_ad) ? $side_bar_ad : $ad->side_bar_ad,
            'ads_banner_left' => !empty($ads_banner_left) ? $ads_banner_left : $ad->ads_banner_left,
            'ads_banner_right' => !empty($ads_banner_right) ? $ads_banner_right : $ad->ads_banner_right,

            'home_top_bar_ad_status' => $request->home_top_bar_ad_status == 1 ? 1 : 0,
            'home_middle_ad_status' => $request->home_middle_ad_status == 1 ? 1 : 0,
            'view_page_ad_status' => $request->view_page_ad_status == 1 ? 1 : 0,
            'news_page_ad_status' => $request->news_page_ad_status == 1 ? 1 : 0,
            'side_bar_ad_status' => $request->side_bar_ad_status == 1 ? 1 : 0,
            'ads_banner_left_status' => $request->ads_banner_left_status == 1 ? 1 : 0,
            'ads_banner_right_status' => $request->ads_banner_right_status == 1 ? 1 : 0,

            'home_top_bar_ad_url' => $request->home_top_bar_ad_url,
            'home_middle_ad_url' => $request->home_middle_ad_url,
            'view_page_ad_url' => $request->view_page_ad_url,
            'news_page_ad_url' => $request->news_page_ad_url,
            'side_bar_ad_url' => $request->side_bar_ad_url,
            'ads_banner_left_url' => $request->ads_banner_left_url,
            'ads_banner_right_url' => $request->ads_banner_right_url,
        ]);

        toast(__('admin.Updated Successfully'), 'success');

        return redirect()->back();
    }


}
