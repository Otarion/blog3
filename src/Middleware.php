<?php

namespace MVC;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class Middleware
{
    // On obligera toutes les classe Middleware enfant à implémenter la méthode handle()
    abstract public function handle(Request $request, Response $response, Session $session): void;
}
