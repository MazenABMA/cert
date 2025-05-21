<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\UsersController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/add/{user?}', [UsersController::class, 'register'])->name('users_add');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('users/charge_credit/{user}', [UsersController::class, 'chargeCreditForm'])->name('charge_credit_form')->middleware('auth');
Route::post('users/charge_credit/{user}', [UsersController::class, 'chargeCredit'])->name('charge_credit')->middleware('auth');

Route::get('verify', [UsersController::class, 'verify'])->name('verify');
Route::get('/auth/google',[UsersController::class, 'redirectToGoogle'])->name('login_with_google');
Route::get('/auth/google/callback',[UsersController::class, 'handleGoogleCallback']);


Route::get('/forgot-password', [UsersController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot-password', [UsersController::class, 'sendTemporaryPassword'])->name('send_temp_password');


Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
Route::post('/buy/{product}', [ProductsController::class, 'buy'])->name('buy_product')->middleware('auth');

// Review Routes
Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/products/{product}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number??5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/cryptography', function (Request $request) {
    $data = $request->data ?? "Welcome to Cryptography";
    $action = $request->action ?? "Encrypt";
    $result = $request->result ?? "";
    $status = "Failed";

    if($request->action == "Encrypt") {
        $temp = openssl_encrypt($request->data, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($temp) {
            $status = 'Encrypted Successfully';
            $result = base64_encode($temp);
        }
    }
    else if($request->action == "Decrypt") {
        $temp = base64_decode($request->data);
        $result = openssl_decrypt($temp, 'aes-128-ecb', 'thisisasecretkey', OPENSSL_RAW_DATA, '');
        if($result) $status = 'Decrypted Successfully';
    }
    else if($request->action == "Hash") {
        $temp = hash('sha256', $request->data);
        $result = base64_encode($temp);
        $status = 'Hashed Successfully';
    }
    else if($request->action == "Sign") {
        $path = storage_path('app/private/malak@localhost.com.pfx');
        $password = '12345678';
        $certificates = [];
        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];
        $signature = '';
        if(openssl_sign($request->data, $signature, $privateKey, 'sha256')) {
            $result = base64_encode($signature);
            $status = 'Signed Successfully';
        }
    }
    else if($request->action=="Verify") {
        $signature = base64_decode($request->result);
        $path = storage_path('app/public/malak@localhost.com.crt');
        $publicKey = file_get_contents($path);
        if(openssl_verify($request->data, $signature, $publicKey, 'sha256')) {
            $status = 'Verified Successfully';
        }
    }
    else if($request->action == "KeySend") {
        $path = storage_path('app/public/malak@localhost.com.crt');
        $publicKey = file_get_contents($path);
        $temp = '';
        if(openssl_public_encrypt($request->data, $temp, $publicKey)) {
            $result = base64_encode($temp);
            $status = 'Key is Encrypted Successfully';
        }
    }
    else if($request->action == "KeyRecive") {
        $path = storage_path('app/private/malak@localhost.com.pfx');
        $password = '12345678';
        $certificates = [];
        $pfx = file_get_contents($path);
        openssl_pkcs12_read($pfx, $certificates, $password);
        $privateKey = $certificates['pkey'];
        $encryptedKey = base64_decode($request->data);
        $result = '';
        if(openssl_private_decrypt($encryptedKey, $result, $privateKey)) {
            $status = 'Key is Decrypted Successfully';
        }
    }

    return view('cryptography', compact('data', 'result', 'action', 'status'));})->name('cryptography');
   

// Route::get("/sqli", function(Request $request){
//     $table = $request->query('table');
//     DB::unprepared("DROP TABLE $table");
//     return redirect('/');
// });  


// route::get('/collect', function (request $REQUEST){
//     $name=$REQUEST->query('name');
//     $credit=$REQUEST->query('credit');

//     return response('data colleected', 200)
//         ->header('access-control-allow-origin', '*')
//         ->header('access-control-allow-methods', 'get, post, option')
//         ->header('access-control-allow-headers', 'content-type, x-requested-with');
// });
