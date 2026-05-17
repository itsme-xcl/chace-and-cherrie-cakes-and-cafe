<?php

use Illuminate\Support\Facades\Route;

/* =========================
| Controllers
========================= */
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminMasterController;
use App\Http\Controllers\Admin\AdminOrderController;

use App\Http\Controllers\Cashier\CashierAuthController;
use App\Http\Controllers\Cashier\CashierController;

use App\Http\Controllers\Baker\BakerAuthController;
use App\Http\Controllers\Baker\BakerController;

use App\Http\Controllers\DeliveryController;

use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| DEFAULT PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
});


/*
|--------------------------------------------------------------------------
| LOGIN REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| CUSTOMER AUTH
|--------------------------------------------------------------------------
*/
Route::get('/customer/login', fn() => view('auth.customer'))
    ->name('customer.login');

Route::get('/customer/register', fn() => view('auth.customer-register'))
    ->name('customer.register');

Route::post('/customer/register', [CustomerAuthController::class, 'register'])
    ->name('customer.register.submit');

Route::post('/customer/login', [CustomerAuthController::class, 'login'])
    ->name('customer.login.submit');

Route::get('/customer/forgot-password', function () {
    return view('auth.customer-forgot');
})->name('customer.forgot');

Route::post('/customer/send-code', [CustomerAuthController::class, 'sendCode'])
    ->name('customer.send.code');

Route::get('/customer/verify-code', function () {
    return view('auth.customer-verify');
})->name('customer.verify');

Route::post('/customer/verify-code', [CustomerAuthController::class, 'verifyCode'])
    ->name('customer.verify.code');

Route::get('/customer/reset-password', function () {
    return view('auth.customer-reset');
})->name('customer.reset');

Route::post('/customer/reset-password', [CustomerAuthController::class, 'resetPassword'])
    ->name('customer.reset.password');


/*
|--------------------------------------------------------------------------
| CUSTOMER DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/customer/account', [CustomerController::class, 'account'])
    ->name('customer.account');


/*
|--------------------------------------------------------------------------
| CUSTOMER FEATURES
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('orders.create');

Route::post('/orders/confirm', [OrderController::class, 'confirm'])
    ->name('orders.confirm');

Route::get('/orders/confirm', function () {
    return redirect('/customer/account');
});

Route::post('/orders/store', [OrderController::class, 'store'])
    ->name('orders.store');

Route::get('/customer/orders', [OrderController::class, 'index'])
    ->name('customer.orders');




/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', fn() => view('auth.adminlogin'))
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::get('/admin/forgot-password', function () {
    return view('auth.admin-forgot');
})->name('admin.forgot');

Route::post('/admin/forgot-password', [AdminAuthController::class, 'resetPassword'])
    ->name('admin.reset.password');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/account', [AdminController::class, 'index'])
        ->name('admin.account');

    // Maintenance
    Route::post('{section}/store', [AdminMasterController::class, 'store'])
        ->name('admin.section.store');

    Route::post('{section}/{id}/update', [AdminMasterController::class, 'update'])
        ->name('admin.section.update');

    Route::post('{section}/{id}/toggle', [AdminMasterController::class, 'toggle'])
        ->name('admin.section.toggle');

    Route::delete('{section}/{id}', [AdminMasterController::class, 'destroy'])
        ->name('admin.section.delete');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders');

    // SEND FOR DELIVERY
    Route::post('/orders/{id}/delivery', function ($id) {

        $order = \App\Models\Order::findOrFail($id);

        $order->status = 'delivery';

        $order->save();

        return back();

    })->name('admin.orders.delivery');

    // MARK DELIVERED
    Route::post('/orders/{id}/complete', function ($id) {

        $order = \App\Models\Order::findOrFail($id);

        $order->status = 'completed';

        $order->save();

        return back();

    })->name('admin.orders.complete');

});


/*
|--------------------------------------------------------------------------
| CASHIER
|--------------------------------------------------------------------------
*/
Route::prefix('cashier')->group(function () {

    Route::get('/login', [CashierAuthController::class, 'showLogin'])
        ->name('cashier.login');

    Route::post('/login', [CashierAuthController::class, 'login'])
        ->name('cashier.login.submit');

    Route::post('/logout', [CashierAuthController::class, 'logout'])
        ->name('cashier.logout');

    Route::get('/dashboard', [CashierController::class, 'index'])
        ->name('cashier.dashboard');

    Route::post('/orders/{id}/approve', [CashierController::class, 'approve'])
        ->name('cashier.orders.approve');

    Route::post('/orders/{id}/reject', [CashierController::class, 'reject'])
        ->name('cashier.orders.reject');
});


/*
|--------------------------------------------------------------------------
| CASHIER SALES
|--------------------------------------------------------------------------
*/
Route::get('/sales', [CashierController::class, 'sales'])
    ->name('cashier.sales');


/*
|--------------------------------------------------------------------------
| BAKER
|--------------------------------------------------------------------------
*/
Route::prefix('baker')->group(function () {

    // AUTH
    Route::get('/login', [BakerAuthController::class, 'showLogin'])
        ->name('baker.login');

    Route::post('/login', [BakerAuthController::class, 'login'])
        ->name('baker.login.submit');

    Route::post('/logout', [BakerAuthController::class, 'logout'])
        ->name('baker.logout');

    // DASHBOARD
    Route::get('/dashboard', [BakerController::class, 'dashboard'])
        ->name('baker.dashboard');

    // ORDER ACTIONS
    Route::post('/orders/{id}/start', [BakerController::class, 'start'])
        ->name('baker.orders.start');

    Route::post('/orders/{id}/ready', [BakerController::class, 'ready'])
        ->name('baker.orders.ready');

    Route::post('/orders/{id}/complete', [BakerController::class, 'complete'])
        ->name('baker.orders.complete');
});


/*
|--------------------------------------------------------------------------
| DELIVERY
|--------------------------------------------------------------------------
*/
Route::prefix('delivery')->group(function () {

    // LOGIN PAGE
    Route::get('/login', function () {

        return view('auth.delivery_login');

    })->name('delivery.login');


    // REGISTER PAGE
    Route::get('/register', function () {

        return view('auth.delivery_register');

    })->name('delivery.register');


    // REGISTER SUBMIT
    Route::post('/register', [DeliveryController::class, 'register'])
        ->name('delivery.register.submit');


    // LOGIN SUBMIT
    Route::post('/login', [DeliveryController::class, 'login'])
        ->name('delivery.login.submit');


    // LOGOUT
    Route::post('/logout', function () {

        session()->forget('delivery_id');

        return redirect()->route('delivery.login');

    })->name('delivery.logout');


    // DELIVERY DASHBOARD
    Route::get('/dashboard', function () {

        if (!session()->has('delivery_id')) {

            return redirect()->route('delivery.login');
        }

        $orders = \App\Models\Order::with(['flavor', 'size'])
            ->whereIn('status', ['ready', 'delivery'])
            ->where('delivery_method', 'Delivery')
            ->latest()
            ->get();

        return view('delivery.delivery_account', compact('orders'));

    })->name('delivery.dashboard');


    // START DELIVERY
    Route::post('/start/{id}', function ($id) {

        $order = \App\Models\Order::findOrFail($id);

        $order->status = 'delivery';

        $order->save();

        return back();

    })->name('delivery.start');


    // COMPLETE DELIVERY
    Route::post('/complete/{id}', function ($id) {

        $order = \App\Models\Order::findOrFail($id);

        $order->status = 'completed';

        $order->save();

        return back();

    })->name('delivery.complete');

});


/*
|--------------------------------------------------------------------------
| DEFAULT LARAVEL
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/admin/forgot-password', function () {
    return view('auth.admin-forgot');
})->name('admin.forgot');

Route::post('/admin/send-code', [AdminAuthController::class, 'sendCode'])
    ->name('admin.send.code');

Route::get('/admin/verify-code', function () {
    return view('auth.admin-verify');
})->name('admin.verify');

Route::post('/admin/verify-code', [AdminAuthController::class, 'verifyCode'])
    ->name('admin.verify.code');

Route::get('/admin/reset-password', function () {
    return view('auth.admin-reset');
})->name('admin.reset');

Route::post('/admin/reset-password', [AdminAuthController::class, 'resetPassword'])
    ->name('admin.reset.password');

use App\Http\Controllers\AdminReportController;

Route::get('/admin/reports', [AdminReportController::class, 'index']);
Route::post('/admin/reports/pdf', [AdminReportController::class, 'exportPDF'])
    ->name('admin.reports.pdf');
Route::get('/admin/reports/excel', [AdminReportController::class, 'exportExcel']);
Route::get('/admin/reports/print', [AdminReportController::class, 'print']);

Route::get('/admin/inventory', [AdminController::class, 'inventory'])
    ->name('admin.inventory');

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/products/{id}/checkout', [ProductController::class, 'checkout'])
    ->name('products.checkout');

    Route::get('/dashboard', function () {
    return redirect('/');
});
Route::get('/role-selection', function () {
    return view('auth.login');
})->name('role.selection');
    require __DIR__.'/auth.php';