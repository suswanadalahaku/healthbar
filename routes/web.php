<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChatSessionController;
use App\Livewire\Chat;
use App\Livewire\ChatHistory;
use App\Livewire\EditArtikel;
use App\Livewire\TambahArtikel;
use App\Livewire\TampilArtikel;
use App\Livewire\TinjauArtikel;
use App\Models\Articles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




// Route::get('dashboard', function() {
    //     return view ('dashboard', [
        //         'users'=> User::where('id', '!=', Auth::id(),)->get(),
        //         ]);
        //     })
        //     ->middleware(['auth', 'verified'])
        //     ->name('dashboard');

// return redirect()->route('dashboard-dokter');
        
// Route::view('/', 'welcome');

Route::get('/', function () {
    return view('dashboard', [
        'users' => User::where('id', '!=', Auth::id())->get(),
    ]);
});


Route::get('/', function () {
    $articles = Articles::where('is_approved', 1)->latest()->get();
    $users = Auth::check() ? User::where('id', '!=', Auth::id())->get() : [];
    return view('dashboard', compact('articles', 'users'));
})->name('dashboard');

// Route::get('/', function () {
//     $articles = Articles::where('status', 'approved')->latest()->get();
//     return view('dashboard', compact('articles'));
// })->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/chat/{receiverId}', Chat::class)->name('chat');

Route::get('/start-chat/{receiverId}', [ChatSessionController::class, 'startChat'])
    ->middleware('auth')
    ->name('start-chat');

// Route::get('/tampil-artikel', [ArticleController::class, 'index'])
//     ->name('tampil-artikel');

Route::get('/detail-artikel/{id}', [ArticleController::class, 'show'])
    ->middleware('auth')
    ->name('detail-artikel');

Route::middleware(['auth'])->get('/chat-history', ChatHistory::class)->name('chat-history');
Route::middleware(['auth'])->get('/tambah-artikel', TambahArtikel::class)->name('tambah-artikel');
Route::middleware(['auth'])->get('/edit-artikel/{id}', EditArtikel::class)->name('edit-artikel');
Route::middleware(['auth'])->get('/tinjau-artikel', TinjauArtikel::class)->name('tinjau-artikel');
Route::middleware(['auth'])->delete('/artikel/{id}', [ArticleController::class, 'destroy'])->name('delete-artikel');


Route::get('/tampil-artikel', TampilArtikel::class)->name('tampil-artikel');

Route::middleware(['role:2'])->group(function () {
    Route::post('/artikel/{id}/approve', [ArticleController::class, 'approve'])->name('approve-artikel');
    Route::post('/artikel/{id}/reject', [ArticleController::class, 'reject'])->name('reject-artikel');
});

route::post('/tambah-artikel', [TambahArtikel::class, 'saveContent'])->name('storeArticle');
Route::put('/edit-artikel/{id}', [EditArtikel::class, 'updateContent'])->name('update-article');




require __DIR__.'/auth.php';













// Route::get('/dashboard-admin', function () {
//     return view('dashboard-admin', [
//         'users' => User::where('id', '!=', Auth::id())->get(),
//     ]);
// })->middleware(['auth', 'verified', 'role:1'])->name('dashboard-admin');

// Route::get('/dashboard-dokter', function() {
//     return view ('dashboard-dokter');
// })->middleware(['auth', 'verified', 'role:2'])->name('dashboard-dokter');

// Route::get('/dashboard-masyarakat', function() {
//     return view ('dashboard-masyarakat', [
//         'users'=> User::where('id', '!=', Auth::id(),)->get(),
//     ]);
// })->middleware(['auth', 'verified', 'role:3'])->name('dashboard-masyarakat');

// Route::middleware(['auth', 'role:masyarakat'])->group(function () {
//     Route::get('/masyarakat/dashboard')->name('dashboard-masyarakat');
// });