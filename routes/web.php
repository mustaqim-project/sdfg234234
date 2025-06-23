<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CustomUserController;
use App\Http\Controllers\Frontend\FollowController;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\LoveLanguageTestController;
use App\Http\Controllers\Auth\GoogleController;
/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Autentikasi)
|--------------------------------------------------------------------------
*/





Route::get('oauth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('oauth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



Route::get('/', function () {
    return view('guest.home');
});

// Static Pages
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('kebijakan', [HomeController::class, 'kebijakan'])->name('kebijakan');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::post('contact', [HomeController::class, 'handleContactFrom'])->name('contact.submit');

// Language Switcher
Route::get('language', LanguageController::class)->name('language');

// News
Route::get('news', [HomeController::class, 'news'])->name('news');
Route::get('news-details/{slug}', [HomeController::class, 'ShowNews'])->name('news-details');

// News Comments
Route::post('news-comment', [HomeController::class, 'handleComment'])->name('news-comment');
Route::post('news-comment-replay', [HomeController::class, 'handleReplay'])->name('news-comment-replay');
Route::delete('news-comment-destroy', [HomeController::class, 'commentDestory'])->name('news-comment-destroy');

// Newsletter
Route::post('subscribe-newsletter', [HomeController::class, 'SubscribeNewsLetter'])->name('subscribe-newsletter');

// Sitemaps
Route::prefix('sitemap')->group(function () {
    Route::get('/sitemap.xml', [SitemapController::class, 'index']);
    Route::get('/sitemap-category-{language}.xml', [SitemapController::class, 'categories']);
    Route::get('/sitemap-tag.xml', [SitemapController::class, 'tags']);
    Route::get('/sitemap-news-{language}.xml', [SitemapController::class, 'newsIndex']);
    Route::get('/sitemap-news-en-{category}', [SitemapController::class, 'newsByCategoryEn']);
    Route::get('/sitemap-news-id-{category}', [SitemapController::class, 'newsByCategoryId']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Dengan Middleware Auth)
|--------------------------------------------------------------------------
*/

// Profile Routes (Auth)
Route::middleware(['auth', 'verified', 'activity'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


     Route::get('/love-language', [LoveLanguageTestController::class, 'index'])
        ->name('love-language.index');

    // Route untuk memproses jawaban test Love Language
    Route::post('/love-language', [LoveLanguageTestController::class, 'store'])
        ->name('love-language.store');

    // Route untuk menampilkan hasil test Love Language
    Route::get('/love-language/result', [LoveLanguageTestController::class, 'result'])
        ->name('love-language.result');

    // Route untuk mendapatkan history test (optional)
    Route::get('/love-language/history', [LoveLanguageTestController::class, 'getTestHistory'])
        ->name('love-language.history');



});

// Notification (Auth + Verified + Activity)
Route::controller(NotificationController::class)
    ->middleware(['auth', 'verified', 'activity'])
    ->group(function () {
        Route::get('/all/notification', 'notifications')->name('notifications');
        Route::get('/accept/friend/request/notification/{id}', 'accept_friend_notification')->name('accept.friend.request.from.notification');
        Route::get('/decline/friend/request/notification/{id}', 'decline_friend_notification')->name('decline.friend.request.from.notification');
    });

// Chat (Auth + Verified + User + Activity + No Back History)
Route::controller(ChatController::class)
    ->middleware(['auth', 'verified', 'activity', 'prevent-back-history'])
    ->group(function () {
        Route::get('/chat/inbox/{reciver}/{product?}/', 'chat')->name('chat');
        Route::post('/chat/save', 'chat_save')->name('chat.save');
        Route::get('chat/own/remove/{id}', 'remove_chat')->name('remove.chat');
        Route::post('/my_message_react', 'react_chat')->name('react.chat');
        Route::get('/chat/profile/search/', 'search_chat')->name('search.chat');
        Route::get('/chat/inbox/load/data/ajax/', 'chat_load')->name('chat.load');
        Route::get('/chat/inbox/read/message/ajax/', 'chat_read_option')->name('chat.read');
        Route::get('/chat/end/{id}', 'endChat')->name('chat.end');
    });

// Follow (Auth + Verified + User + Activity + No Back History)
Route::controller(FollowController::class)
    ->middleware(['auth', 'verified', 'activity', 'prevent-back-history'])
    ->group(function () {
        Route::get('user/account/follow/{id}', 'follow')->name('user.follow');
        Route::get('user/account/unfollow/{id}', 'unfollow')->name('user.unfollow');
    });

// Custom User Actions (Auth + Verified + User + Activity + No Back History)
Route::controller(CustomUserController::class)
    ->middleware(['auth', 'verified', 'activity', 'prevent-back-history'])
    ->group(function () {
        Route::get('user/view/profile/{id}', 'view_profile_data')->name('user.profile.view');
        Route::get('/user/load_post_by_scrolling', 'load_post_by_scrolling')->name('user.load_post_by_scrolling');
        Route::get('user/password/change', 'changepass')->name('user.password.change');
        Route::post('user/password/update', 'updatepass')->name('user.password.update');
        Route::get('user/friend/{id}', 'friend')->name('user.friend');
        Route::get('user/unfriend/{id}', 'unfriend')->name('user.unfriend');
        Route::get('/user/friends/{id}', 'friends')->name('user.friends');
        Route::get('/user/photos/{id}/{identifire}', 'photos')->name('user.photos');
        Route::get('/user/videos/{id}', 'videos')->name('user.videos');
        Route::get('video/delete/{id}', 'delete_mediafile')->name('delete.mediafile');
        Route::get('download/media/file/{id}', 'download_mediafile')->name('download.mediafile');
        Route::get('download/media/file/image/{id}', 'download_mediafile_image')->name('download.mediafile.image');
        Route::get('user/status/{id}', 'account_status')->name('user.status');
    });

// Main (Auth + Verified + User + Activity + No Back History + Check Local DNS)
Route::controller(MainController::class)
    ->middleware(['auth', 'verified', 'activity', 'prevent-back-history'])
    ->group(function () {
        Route::get('/matches', 'matches')->name('matches');
        Route::get('/explore', 'timeline')->name('timeline');
        Route::get('/article', 'blogs')->name('blogs');
        Route::get('/profile', 'profile')->name('profile');

        Route::post('/create_post', 'create_post')->name('create_post');
        Route::get('/edit_post_form/{id}', 'edit_post_form')->name('edit_post_form');
        Route::post('/edit_post/{id}', 'edit_post')->name('edit_post');
        Route::get('/load_post_by_scrolling', 'load_post_by_scrolling')->name('load_post_by_scrolling');
        Route::post('/my_react', 'my_react')->name('my_react');
        Route::get('/my_comment_react', 'my_comment_react')->name('my_comment_react');
        Route::get('/post_comment', 'post_comment')->name('post_comment');
        Route::get('/load_post_comments', 'load_post_comments')->name('load_post_comments');
        Route::get('/search_friends_for_tagging', 'search_friends_for_tagging')->name('search_friends_for_tagging');
        Route::get('/view/single/post/{id?}', 'single_post')->name('single.post');
        Route::get('/preview_post', 'preview_post')->name('preview_post');
        Route::get('/post_comment_count', 'post_comment_count')->name('post_comment_count');
        Route::post('/post/report/save/', 'save_post_report')->name('save.post.report');
        Route::get('/delete/my/post', 'post_delete')->name('post.delete');
        Route::get('comment/delete', 'comment_delete')->name('comment.delete');
        Route::post('share/on/group', 'share_group')->name('share.group.post');
        Route::get('media/file/delete/{id}', 'delete_media_file')->name('media.file.delete');

        // Block user
        Route::get('/block_user/{id}', 'block_user')->name('block_user');
        Route::post('/block_user_post/{id}', 'block_user_post')->name('block_user_post');
        Route::get('/unblock_user/{id}', 'unblock_user')->name('unblock_user');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
