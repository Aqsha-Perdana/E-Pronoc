<?php

use App\Http\Controllers\DepanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalSelectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;  
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\FundRealizationController;
use App\Livewire\ProposalWizard;
use App\Livewire\FundRealizationReport;
use App\Livewire\FundRealizationReportEdit;


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
Route::get('/dashboard-admin', function () {
     $user = Auth::user();
    return view('dashboard-admin', compact('user'));
})->name('dashboard-admin')
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

    Route::get('/done', function () {
        return view('proposalsel.done', ['page' => 'done']);
    })->name('done');

    Route::get('/final', function () {
        return view('proposalsel.final', ['page' => 'final']);
    })->name('final');
});

Route::post('/proposalsel/{page?}', [ProposalController::class, 'accept'])->name('proposal.done');

// Route Dashboard (Pastikan name-nya 'dashboard' karena dipakai di redirect Livewire)
Route::get('/proposal-submission', [ProposalController::class, 'index'])->name('mainproposalutama');
// Pastikan sudah dibungkus middleware auth jika perlu
Route::get('/proposals/create', ProposalWizard::class)->name('proposals.create');
// Route Download PDF
Route::get('/proposal/{id}/download', [ProposalController::class, 'download'])->name('proposal.download');

Route::get('/proposals/{id}', [App\Http\Controllers\ProposalController::class, 'show'])->name('proposals.show');




Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('switch.language');

Route::get('/fund-realization-report', FundRealizationReport::class)->name('report.fund');

// ... di dalam middleware auth group
Route::get('/fund-realization/{id}/edit', FundRealizationReportEdit::class)->name('report.fund.edit');

// Pastikan ID disesuaikan dengan parameter di Component
Route::get('/fund-realization-report/{id}/view', \App\Livewire\FundRealizationReportShow::class)->name('report.fund.show');



Route::get('/fund-realization/{id}/download-pdf', [FundRealizationController::class, 'downloadPdf'])
    ->name('report.fund.download');





Route::get('/dashboard-peneliti', function () {
     $user = Auth::user();
    return view('dashboard-peneliti', compact('user'));
})->name('dashboard-peneliti')
->middleware('peneliti');


Route::get('/progress', [App\Http\Controllers\DashboardController::class, 'progress']);
Route::get('/final', [App\Http\Controllers\DashboardController::class, 'final'])->name('final');
Route::get('/final/new', [App\Http\Controllers\DashboardController::class, 'createFinal']);
Route::post('/final', [App\Http\Controllers\DashboardController::class, 'storeFinal']);
Route::get('/final/download/{id}', [App\Http\Controllers\DashboardController::class, 'downloadFinal'])->name('final.download');
Route::get('/final/view/{id}', [App\Http\Controllers\DashboardController::class, 'showFinal'])->name('final.view');
Route::delete('/final/{id}', [App\Http\Controllers\DashboardController::class, 'destroyFinal'])->name('final.destroy');
Route::get('/progress/new', [App\Http\Controllers\DashboardController::class, 'createProgress']);
Route::post('/progress', [App\Http\Controllers\DashboardController::class, 'storeProgress']);
Route::get('/progress/download/{id}', [App\Http\Controllers\DashboardController::class, 'downloadPdf'])->name('progress.download');
Route::delete('/progress/{id}', [App\Http\Controllers\DashboardController::class, 'destroy'])->name('progress.destroy');
Route::get('/progress/view/{id}', [App\Http\Controllers\DashboardController::class, 'showPdf'])->name('progress.view');
