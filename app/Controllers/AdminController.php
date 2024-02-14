<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index(): Response
    {
        return $this->view('admin.html');
    }
}
