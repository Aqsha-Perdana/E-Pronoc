<?php

use App\Http\Controllers\DepanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalSelectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;   


/*s
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

////// NAVIGASI HEADERRRRRRRRR ///////////////////
// Route::get('/', function () {
//     return view('landingpage');
// })->name('home');

//PERLOGIN REGISTERAN
Route::get('/admin', [LoginController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/admin/login', [LoginController::class, 'loginAdmin'])->name('login.admin.submit');
Route::get('/admin/logout', [LoginController::class, 'logout']);
Route::get('/researcher', [LoginController::class, 'showResearcherLogin'])->name('login.researcher');
Route::post('/researcher/login', [LoginController::class, 'loginResearcher'])->name('login.researcher.submit');
Route::get('/researcher/register', [LoginController::class, 'register']);
Route::post('/researcher/create', [LoginController::class, 'create']);
Route::get("/logout", function(){
    return view("logout");
});

//NAVIGASI DI LANDING PAGE//
Route::get('/', [DepanController::class,'index']);
Route::get('/pusatinformasi', [DepanController::class,'pusatinformasi']);
Route::get('/proyek', [DepanController::class,'proyek']);
Route::get('/tentang', [DepanController::class,'tentang']);



///////// NAVIGASI DI HALAMAN ADMIN //////////////
Route::get('/dashboard', function () {
     $user = Auth::user();
    return view('dashboard', compact('user'));
})->name('dashboard')
->middleware('admin');

Route::post('/skills/update', [SkillController::class, 'updateSkills'])->name('skills.updateSkills');
Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');



Route::get('/proposal-selection', function () {
    return view('proposal');
})->name('proposal')
->middleware('admin');

Route::get('/information-center', function () {
    return view('information');
})->name('information')
->middleware('admin');


Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('admin');

Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('admin');

Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('admin');



Route::get('/logout', function () {
    return view('logout');
})->name('logout');
Route::get('/editprofile', function () {
    return view('editprofile');
})->name('editprofile')->middleware('admin');


///////// NAVIGASI PROPOSAL SELECTION //////////////

Route::get('proposalsel/{page?}', [ProposalSelectionController::class, 'show'])
     ->name('proposal')
     ->middleware('admin');

Route::prefix('proposalsel')->name('proposalsel.')->group(function () {

    Route::get('/list', function () {
        return view('proposalsel.list', ['page' => 'list']);
    })->name('list');

    Route::get('/review', function () {
        return view('proposalsel.review', ['page' => 'review']);
    })->name('review');

    Route::get('/progress', function () {
        return view('proposalsel.progress', ['page' => 'progress']);
    })->name('progress');

    Route::get('/final', function () {
        return view('proposalsel.final', ['page' => 'final']);
    })->name('final');
});
