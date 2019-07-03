<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\RssFeed;
use App\Services\SiteMap;

class BlogController extends Controller
{
    public function index(Request $request)
    {
    	/*$articles = Article::where('published_at', '<=', Carbon::now())->orderBy('published_at', 'desc')->paginate(config('blog.articles_per_page'));
    	return view('blog.index', compact('articles'));*/

        $tag = $request->get('tag');
        $postService = new PostService($tag);
        $data = $postService->lists();
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        return view($layout, $data);
    }

    /*public function detail($slug)
    {
    	$article = Article::where('slug', $slug)->firstOrFail();
    	return view('blog.article', ['article' => $article]);
    }*/

    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::where('tag', $tag)->firstOrFail();
        }
        return view($post->layout, compact('post', 'tag'));
    }

    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();
        return response($rss)->header('Content-type', 'application/rss+xml');
    }

    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();
        return response($map)->header('Content-type', 'text/xml');
    }
}
