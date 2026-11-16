
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamMemberController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Language selection
Route::get('/language/{locale}', function ($locale) {
    abort_unless(in_array($locale, ['en', 'pl'], true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
});

// Registration
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Authenticated pages
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {

        $user = auth()->user();

        $managedProjects = $user->managedProjects()
            ->with('teamMembers')
            ->latest()
            ->get();

        $memberProjects = $user->memberProjects()
            ->with('user')
            ->latest()
            ->get();

        $allProjects = $managedProjects
            ->concat($memberProjects)
            ->unique('id');

        $totalProjects = $allProjects->count();

        $completedProjects = $allProjects
            ->where('status', 'completed')
            ->count();

        $teamMembers = $managedProjects
            ->flatMap(fn ($project) => $project->teamMembers)
            ->unique('id')
            ->count();

        return view('dashboard', compact(
            'managedProjects',
            'memberProjects',
            'totalProjects',
            'completedProjects',
            'teamMembers'
        ));

    })->name('dashboard');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Existing Team Members CRUD
    Route::resource('team-members', TeamMemberController::class)
        ->except(['show']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});