<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    private $appData;

    public function __construct()
    {
        // load appData.php
        $this->appData = require(app_path('appData.php'));
    }

    public function index()
    {
        return response()->json($this->appData);
    }
}
