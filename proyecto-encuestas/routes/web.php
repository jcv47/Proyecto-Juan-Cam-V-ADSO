<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\Admin\SurveyController as AdminSurveyController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

Route::view('/', 'index')->name('home');



/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/comentarios', [ComentariosController::class, 'index'])->name('ui.comentarios');

    // Cliente: ver encuesta y responderla
    Route::get('/comentarios/encuesta/{survey}', [ComentariosController::class, 'showSurvey'])
        ->name('ui.surveys.show');

    Route::post('/comentarios/encuesta/{survey}', [ComentariosController::class, 'submitSurvey'])
        ->name('ui.surveys.submit');

    // Admin: ver detalle de una respuesta (solo admin)
    Route::get('/comentarios/respuesta/{submission}', [ComentariosController::class, 'showSubmission'])
        ->middleware('admin')
        ->name('admin.submissions.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('ui')->group(function () {
    Route::view('/servicios', 'servicios')->name('ui.servicios');
    Route::view('/productos', 'productos')->name('ui.productos');
    Route::get('/surveys/{survey}', [ComentariosController::class, 'showSurvey'])->name('ui.surveys.show');
    Route::post('/surveys/{survey}/submit', [ComentariosController::class, 'submitSurvey'])->name('ui.surveys.submit');

    // OJO: comentarios y contacto luego los protegemos con auth (te lo dejo ya listo)
    Route::middleware('auth')->group(function () {
        Route::view('/comentarios', 'comentarios')->name('ui.comentarios');
        Route::view('/contacto', 'contacto')->name('ui.contacto');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // admin/encuestas/crear
    Route::get('/encuestas/crear', [AdminSurveyController::class, 'create'])
        ->name('surveys.create');

    Route::post('/encuestas', [AdminSurveyController::class, 'store'])
        ->name('surveys.store');

    // admin/informes
    Route::get('/informes', [AdminReportController::class, 'index'])
        ->name('reports.index');

    Route::post('/submissions/{submission}/ai-mock', [ComentariosController::class, 'generateMockAi'])
        ->name('submissions.ai.mock');
});



require __DIR__.'/auth.php';
