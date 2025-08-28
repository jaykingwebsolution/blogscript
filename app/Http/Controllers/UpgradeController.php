<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpgradeController extends Controller
{
    /**
     * Show the upgrade plans page
     */
    public function index()
    {
        return view('upgrade');
    }
}