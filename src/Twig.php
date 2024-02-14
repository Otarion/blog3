<?php

namespace MVC;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Twig extends Environment
{
    public function __construct()
    {
        // On indique que nos templates seront resources/views
        $loader = new FilesystemLoader(__DIR__ . '/../resources/views');

        // On fait appel au constructeur parent
        parent::__construct($loader);

        // On ajoute des variables qui seront accessibles dans tous les templates
        $this->addGlobal('errors', errors());
        $this->addGlobal('status', status());
        $this->addGlobal('guest', isGuest());
        $this->addGlobal('auth', isAuth());
        $this->addGlobal('admin', isAdmin());
        $this->addGlobal('old', old());

        // Une fonction pour générer facilement des champs cachés de méthodes HTTP
        $this->addFunction(new TwigFunction('method', 'method'));
        // Une fonction pour ajouter le token CSRF à nos formulaires
        $this->addFunction(new TwigFunction('csrf_field', 'csrf_field'));
    }
}
