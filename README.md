<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<pre>
    └── routes
    ├── api.php
    ├── console.php
    └── web.php


/routes/api.php:
--------------------------------------------------------------------------------
 1 | <?php
 2 | 
 3 | use App\Http\Controllers\API\AuthenticationController;
 4 | use App\Http\Controllers\API\ProductController;
 5 | use Illuminate\Http\Request;
 6 | use Illuminate\Support\Facades\Route;
 7 | 
 8 | 
 9 | // Authentication routes
10 | Route::post('register',
11 |         [AuthenticationController::class, 'register'])->name('register');
12 | 
13 | Route::post('/login',
14 |         [AuthenticationController::class, 'login'])->name('login');
15 | 
16 | // Product routes
17 | Route::middleware('auth:sanctum')->group(function () {
18 |     Route::resource('products', ProductController::class)
19 |         ->only(['index', 'store', 'show', 'update', 'destroy'])
20 |         ->names([
21 |             'index' => 'products.index',
22 |             'store' => 'products.store',
23 |             'show' => 'products.show',
24 |             'update' => 'products.update',
25 |             'destroy' => 'products.destroy'
26 |         ]);
27 | });
28 | 
29 | 
30 | 
31 | 
</pre>
