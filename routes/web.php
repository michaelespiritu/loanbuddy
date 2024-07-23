<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarrowerController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ];
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect(route('dashboard'));
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin|company owner'])->prefix('admin')->group(function () {
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/create/company', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/create/company', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/company/{company}', [CompanyController::class, 'show'])->name('company.show');
    Route::get('/my-company', [CompanyController::class, 'ownerShow'])->name('company.ownerShow');
    Route::patch('/company/{company}', [CompanyController::class, 'update'])->name('company.update');
});

Route::get('/my-company', [CompanyController::class, 'ownerShow'])->middleware(['role:company owner'])->name('company.ownerShow');

Route::middleware(['auth', 'role:admin|company owner'])->prefix('{company}/employee')->group(function () {
    Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/create', [EmployeeController::class, 'store'])->name('employee.store');
    Route::patch('/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
});

Route::middleware(['auth', 'role:company owner|employee'])->prefix('barrower')->group(function () {
    Route::get('/', [BarrowerController::class, 'index'])->name('barrower.index');
    Route::post('/user', [BarrowerController::class, 'createUser'])->name('barrower.create.user');
    Route::get('/{barrower}', [BarrowerController::class, 'barrowerDetail'])->name('barrower.detail');
    Route::post('/{barrower}/loan', [BarrowerController::class, 'createLoan'])->name('barrower.create.loan');
});

require __DIR__.'/auth.php';
