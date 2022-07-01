<?php
namespace App\Web\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('web::home.index');
    }
}
