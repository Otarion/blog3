<?php declare(strict_types=1);

namespace App\Middlewares;

use MVC\HttpException;
use MVC\Middleware;
use MVC\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Auth extends Middleware
{
    public function handle(Request $request, Response $response, Session $session): void
    {
        // On récupère la méthode HTTP ('POST' par exemple)
        $httpMethod = $request->getMethod();

        // On compare le token transmis depuis le formulaire avec le token de la session (celui qu'on a transmis lors de la précédente réponse)
        $badToken = $request->request->get('_token') !== $session->get('_token');

        // Si la méthode n'est pas GET ET que le token est erroné
        if ($httpMethod !== 'GET' && $badToken) {
            throw new HttpException('Token CSRF manquant', 403);
        }

        //Vérifier si l'utilisateur est authentifié
        if (!$this->isAuth()) {
            //Rediriger l'utilisateur vers la page de login
           $response->setStatusCode(Response::HTTP_FOUND);
            $response->headers->set('Location', '/connexion');
            return;
        }

        // A chaque requête, on génère un nouveau token
        $session->set('_token', bin2hex(random_bytes(35)));
    }

    //Fonction pour vérifier l'authentificateur de l'utilisateur
    private function isAuth(): void {

    }
}