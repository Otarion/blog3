<?php

namespace App\Controllers;

use App\Models\Post;
use MVC\HttpException;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        return $this->view('index.html', [
            'posts' => Post::latest()->get(),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (! $post) {
            throw new HttpException();
        }

        return $this->view('post.html', [
            'post' => $post,
        ]);
    }
}
