<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function logout(): Response
    {
        // On supprime la variable de session pour déconnecter l'utilisateur
        $this->session->remove('user_id');

        // On le redirige ensuite vers le formulaire de connexion
        $this->response->setStatusCode(Response::HTTP_FOUND);
        $this->response->headers->set('Location', '/connexion');
        return $this->response;
    }
}
