<?php

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function showRegisterForm(): Response
    {
        return $this->view('register.html');
    }

    public function register(): Response
    {
        $validated = $this->request->validate($this->request->request->all(), [
            'name' => ['required', ['lengthMin', 5]],
            'email' => ['required', 'email'],
            'password' => ['required', ['lengthMin', 8], ['equals', 'password_confirmation']],
        ], $this->session);

        // Si mon formulaire a des erreur, on redirige l'utilisateur vers celui-ci
        if (! $validated) {
            $this->response->setStatusCode(Response::HTTP_FOUND);
            $this->response->headers->set('Location', '/inscription');
            return $this->response;
        }

        // On créé l'utilisateur avec Eloquent
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = password_hash($validated['password'], PASSWORD_DEFAULT);
        $user->save();

        // Et on en profite pour connecter notre utilisateur ...
        $this->session->set('user_id', $user->id);

        // ... et le rediriger vers son compte
        $this->response->setStatusCode(Response::HTTP_FOUND);
        $this->response->headers->set('Location', '/compte');
        return $this->response;
    }
}
