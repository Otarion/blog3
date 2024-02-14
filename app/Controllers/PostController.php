<?php

namespace App\Controllers;

use App\Models\Post;
use MVC\HttpException;
use App\Models\Comment;
use MVC\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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

        public function comment(string $slug)
{
    // Vérifier si le slug dans l'URI correspond bien à un article existant
    $post = Post::where('slug', $slug)->first();

    if (!$post) {
        throw new HttpException('Article non trouvé', 404);
    }

    // Vérifier si le champ de commentaire est rempli
    $commentContent = $this->request->request->get('comment');

    if (empty($commentContent)) {
        $this -> session->getFlashBag()->add('error', 'Le champ de commentaire ne peut pas être vide');
        $this ->response->setStatusCode(Response::HTTP_FOUND);
        $this ->response->headers->set('Location', '/articles/'.$slug);
        return  $this ->response;
    }

    // Enregistrer le commentaire
    $comment = new Comment();
    $comment->content = $commentContent;
    $comment->user_id = $this -> session->get('user_id'); // Assumer que vous stockez l'ID de l'utilisateur dans la session
    $comment->post_id = $post->id;
    $comment->save();

    // Créer une variable de session flash
    $this -> session->getFlashBag()->add('status', 'Commentaire publié');

    // Rediriger l'utilisateur vers l'article qu'il vient de commenter
    $this ->response->setStatusCode(Response::HTTP_FOUND);
    $this ->response->headers->set('Location', '/articles/'.$slug);
    return  $this ->response;
    }

// Fonction pour vérifier l'authentification de l'utilisateur
private function isAuth(): void {
    // Implémentez votre logique de vérification d'authentification ici,
    // Retourne true si authentifié, false sinon.
    }
}