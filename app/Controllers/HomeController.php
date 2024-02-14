<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return $this->view('home.html');
    }
}
