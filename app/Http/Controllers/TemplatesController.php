<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    public function index($workspace)
    {
        return redirect()->away('https://www.google.com');
    }
}
