<?php

namespace App\Http\Controllers;

use App\Models\Dropdown\Dropdown;
use App\Models\News\News;
use App\Settings\Site;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::active()
            ->paginate(app(Site::class)->news_page_size)
            ->withQueryString();
        return $this->view('News.index', compact('news',));
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, News $news)
    {
        $recent_news = News::active()
            ->limit(2)
            ->where('id', '!=' , $news->id)
            ->get();

        $next_post = News::active()->where('id', '>', $news->id)->first();
        $prev_post = News::active()->where('id', '<', $news->id)->first();

        return $this->view('News.show', compact('news', 'recent_news', 'next_post', 'prev_post'));
    }
}
