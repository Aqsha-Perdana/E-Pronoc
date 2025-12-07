<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $skills = $user->skills()->get(); // pastikan relasi user->skills ada di model User

    return view('dashboard', compact('user', 'skills'));
}


}
