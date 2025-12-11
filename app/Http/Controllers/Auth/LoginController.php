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
            return redirect('dashboard-admin')->with('success', 'Berhasil login sebagai Admin');
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
            return redirect('dashboard-peneliti')->with('success', 'Berhasil login sebagai Peneliti');
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

    // Simpan input sementara (agar form tidak kosong jika gagal)
    Session::flash('name', $request->name);
    Session::flash('email', $request->email);
    Session::flash('notelp', $request->notelp);

    // VALIDASI
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'notelp'    => 'nullable|string|max:20',

        // Password + Konfirmasi
        'password'              => 'required|min:6',
        'password_confirmation' => 'required|same:password',

        // // Captcha
        // 'g-recaptcha-response' => 'required'
    ],[
        'name.required'             => 'Nama wajib diisi',
        'email.required'            => 'Email wajib diisi',
        'email.email'               => 'Silakan masukkan email valid',
        'email.unique'              => 'Email sudah pernah digunakan',
        'notelp.max'                 => 'Nomor telepon maksimal 20 karakter',

        'password.required'         => 'Password wajib diisi',
        'password.min'              => 'Password minimal 6 karakter',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi',
        'password_confirmation.same'     => 'Konfirmasi password tidak sama',

        // 'g-recaptcha-response.required' => 'Captcha wajib diisi'
    ]);

    // // VALIDASI CAPTCHA (SERVER-SIDE)
    // $captcha = $request->{'g-recaptcha-response'};
    //     $secretKey = env('RECAPTCHA_SECRET_KEY');

    //     $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}");
    //     $captchaSuccess = json_decode($verify);

    //     if (!$captchaSuccess->success || $captchaSuccess->score < 0.5) {
    //         return back()->withErrors(['captcha' => 'Captcha gagal, silakan coba lagi.']);
    // }


    // SIMPAN USER
    $data = [
        'name'     => $request->name,
        'email'    => $request->email,
        'notelp'    => $request->notelp,
        'institution'=> $request->institution,
        'photo'=> $request->photo,
        'password' => Hash::make($request->password),
    ];

    User::create($data);

    // AUTO LOGIN
    $infologin = [
        'email'    => $request->email,
        'password' => $request->password,
    ];

    if(Auth::attempt($infologin)){
        return redirect('dashboard')->with('success', Auth::user()->name . ' berhasil login');
    } else {
        return redirect('admin')->withErrors('Username atau password tidak sesuai');
    }
}

}