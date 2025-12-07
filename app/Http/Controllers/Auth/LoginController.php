<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    // Tampilkan form login admin
    public function showAdminLogin()
    {
        return view('admin.login');
    }
    

    // Tampilkan form login researcher
    public function showResearcherLogin()
    {
        return view('researcher.login');
    }

    // Proses login admin
    public function loginAdmin(Request $request){
    Session::flash('email', $request->email);

    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ], [
        'email.required' => 'Email wajib diisi',
        'password.required' => 'Password wajib diisi'
    ]);

    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

    // Coba login
    if (Auth::attempt($credentials)) {

        // Cek apakah user adalah admin
        if (Auth::user()->user_group === 'admin') {
            return redirect('dashboard')->with('success', 'Berhasil login sebagai Admin');
        }

        // Jika bukan admin → logout dan tolak
        Auth::logout();
        return redirect('admin')->withErrors('Anda tidak memiliki akses sebagai Admin.');
    }

    return redirect('admin')->withErrors('Email atau password salah.');
    }
    public function logout(){
        Auth::logout();
        return redirect('admin')->with('success','Berhasil Logout') ;
    }

    // Proses login researcher
    public function loginResearcher(Request $request)
    {
         Session::flash('email', $request->email);

    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ], [
        'email.required' => 'Email wajib diisi',
        'password.required' => 'Password wajib diisi'
    ]);

    $credentials = [
        'email' => $request->email,
        'password' => $request->password
    ];

    // Coba login
    if (Auth::attempt($credentials)) {

        // Cek apakah user adalah peneliti
        if (Auth::user()->user_group === 'peneliti') {
            return redirect('researcher/dashboard')->with('success', 'Berhasil login sebagai Peneliti');
        }

        // Jika bukan peneliti → logout dan tolak
        Auth::logout();
        return redirect('researcher')->withErrors('Anda tidak memiliki akses sebagai Peneliti.');
    }

    return redirect('researcher')->withErrors('Email atau password salah.');
    }
    public function register(){
        return view('researcher/register');
    }
    public function create(Request $request){
        Session::flash('name', $request->name);
        Session::flash('email', $request->email);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ], [
            'name.required'=> 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email'=> 'Silakan Masukkan Email Valid',
            'email.unique'=> 'Email sudah pernah digunakan, silakan gunakan email lain',
            'password.required' => 'Password wajib diisi',
            'password.min'=>'Password Minimal 6 Karakter'
        ]);

        $data=[
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ];
        User::create($data);

        $infologin = [
            'email'=> $request->email,
            'password'=> $request->password,
        ];

        if(Auth::attempt($infologin)){
            return redirect('dashboard')-> with('success',Auth::user()->name .'berhasil login');
        }
        else{
            return redirect('admin')->withErrors('Username dan password tidak sesuai');
        }
    }
}