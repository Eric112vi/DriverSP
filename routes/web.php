<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\SalesWebController;
use App\Http\Controllers\PermissionController;

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
Route::redirect('/', '/admin/login');
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('dashboard-blog',[
            'title' => 'Dashboard'
        ]);
    })->middleware(['auth', 'verified']);

    Route::get('/dashboard', function () {
        return view('dashboard-blog',[
            'title' => 'Dashboard'
        ]);
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/falken', [ SalesWebController::class, 'falken' ])->name('falken');
        Route::get('/invoice/detail', [ SalesWebController::class, 'invoice_detail' ])->name('invoice.detail');

        Route::get('/mitsu', [ SalesWebController::class, 'mitsuboshi' ])->name('mitsu');
        Route::get('/philips', [ SalesWebController::class, 'philips' ])->name('philips');
        Route::get('/ngk', [ SalesWebController::class, 'ngk' ])->name('ngk');
        Route::get('/universal', [ SalesWebController::class, 'universal' ])->name('universal');
        Route::post('/set-branch', [AuthController::class, 'setBranch'])->name('setBranch');

        Route::get('/editstaff', [UserController::class, 'edit'])->name('editstaff');
        Route::post('/updatestaff', [UserController::class, 'update'])->name('updatestaff');
        Route::post('/addstaff', [UserController::class, 'create'])->name('addstaff');
        Route::post('/resetpassstaff', [UserController::class, 'resetpassstaff'])->name('resetpassstaff');
        Route::resource('users', UserController::class);
        
        Route::resource('permissions', PermissionController::class);
        Route::resource('branches', CabangController::class);

        Route::get('/dashboard-saas', function () {
            return view('dashboard-saas');
        });

        Route::get('/dashboard-crypto', function () {
            return view('dashboard-crypto');
        });

        Route::get('/dashboard-blog', function () {
            return view('dashboard-blog');
        });

        Route::get('/dashboard-job', function () {
            return view('dashboard-job');
        });

        // --- Layout Routes ---
        Route::get('/layouts-light-sidebar', function () {
            return view('layouts-light-sidebar');
        });

        Route::get('/layouts-compact-sidebar', function () {
            return view('layouts-compact-sidebar');
        });

        Route::get('/layouts-icon-sidebar', function () {
            return view('layouts-icon-sidebar');
        });

        Route::get('/layouts-boxed', function () {
            return view('layouts-boxed');
        });

        Route::get('/layouts-preloader', function () {
            return view('layouts-preloader');
        });

        Route::get('/layouts-colored-sidebar', function () {
            return view('layouts-colored-sidebar');
        });

        Route::get('/layouts-scrollable', function () {
            return view('layouts-scrollable');
        });

        Route::get('/layouts-horizontal', function () {
            return view('layouts-horizontal');
        });

        Route::get('/layouts-hori-topbar-light', function () {
            return view('layouts-hori-topbar-light');
        });

        Route::get('/layouts-hori-boxed-width', function () {
            return view('layouts-hori-boxed-width');
        });

        Route::get('/layouts-hori-preloader', function () {
            return view('layouts-hori-preloader');
        });

        Route::get('/layouts-hori-colored-header', function () {
            return view('layouts-hori-colored-header');
        });

        Route::get('/layouts-hori-scrollable', function () {
            return view('layouts-hori-scrollable');
        });

        // --- Backend/Datatable Routes ---
        Route::get('/yajra-datatable', function () {
            return view('yajra-datatable');
        });

        // --- App Routes ---
        Route::get('/calendar', function () {
            return view('calendar');
        });

        Route::get('/calendar-full', function () {
            return view('calendar-full');
        });

        Route::get('/chat', function () {
            return view('chat');
        });

        Route::get('/apps-filemanager', function () {
            return view('apps-filemanager');
        });

        // Ecommerce
        Route::get('/ecommerce-products', function () {
            return view('ecommerce-products');
        });

        Route::get('/ecommerce-product-detail', function () {
            return view('ecommerce-product-detail');
        });

        Route::get('/ecommerce-orders', function () {
            return view('ecommerce-orders');
        });

        Route::get('/ecommerce-customers', function () {
            return view('ecommerce-customers');
        });

        Route::get('/ecommerce-cart', function () {
            return view('ecommerce-cart');
        });

        Route::get('/ecommerce-checkout', function () {
            return view('ecommerce-checkout');
        });

        Route::get('/ecommerce-shops', function () {
            return view('ecommerce-shops');
        });

        Route::get('/ecommerce-add-product', function () {
            return view('ecommerce-add-product');
        });

        // Crypto
        Route::get('/crypto-wallet', function () {
            return view('crypto-wallet');
        });

        Route::get('/crypto-buy-sell', function () {
            return view('crypto-buy-sell');
        });

        Route::get('/crypto-exchange', function () {
            return view('crypto-exchange');
        });

        Route::get('/crypto-lending', function () {
            return view('crypto-lending');
        });

        Route::get('/crypto-orders', function () {
            return view('crypto-orders');
        });

        Route::get('/crypto-kyc-application', function () {
            return view('crypto-kyc-application');
        });

        Route::get('/crypto-ico-landing', function () {
            return view('crypto-ico-landing');
        });

        // Email
        Route::get('/email-inbox', function () {
            return view('email-inbox');
        });

        Route::get('/email-read', function () {
            return view('email-read');
        });

        Route::get('/email-template-basic', function () {
            return view('email-template-basic');
        });

        Route::get('/email-template-alert', function () {
            return view('email-template-alert');
        });

        Route::get('/email-template-billing', function () {
            return view('email-template-billing');
        });

        // Invoices
        Route::get('/invoices-list', function () {
            return view('invoices-list');
        });

        Route::get('/invoices-detail', function () {
            return view('invoices-detail');
        });

        // Projects
        Route::get('/projects-grid', function () {
            return view('projects-grid');
        });

        Route::get('/projects-list', function () {
            return view('projects-list');
        });

        Route::get('/projects-overview', function () {
            return view('projects-overview');
        });

        Route::get('/projects-create', function () {
            return view('projects-create');
        });

        // Tasks
        Route::get('/tasks-list', function () {
            return view('tasks-list');
        });

        Route::get('/tasks-kanban', function () {
            return view('tasks-kanban');
        });

        Route::get('/tasks-create', function () {
            return view('tasks-create');
        });

        // Contacts
        Route::get('/contacts-grid', function () {
            return view('contacts-grid');
        });

        Route::get('/contacts-list', function () {
            return view('contacts-list');
        });

        Route::get('/contacts-profile', function () {
            return view('contacts-profile');
        });

        // Blog
        Route::get('/blog-list', function () {
            return view('blog-list');
        });

        Route::get('/blog-grid', function () {
            return view('blog-grid');
        });

        Route::get('/blog-details', function () {
            return view('blog-details');
        });

        // Jobs
        Route::get('/job-list', function () {
            return view('job-list');
        });

        Route::get('/job-grid', function () {
            return view('job-grid');
        });

        Route::get('/job-apply', function () {
            return view('job-apply');
        });

        Route::get('/job-details', function () {
            return view('job-details');
        });

        Route::get('/job-categories', function () {
            return view('job-categories');
        });

        Route::get('/candidate-list', function () {
            return view('candidate-list');
        });

        Route::get('/candidate-overview', function () {
            return view('candidate-overview');
        });

        // --- Authentication Routes ---
        Route::get('/auth-login', function () {
            return view('auth-login');
        });

        Route::get('/auth-login-2', function () {
            return view('auth-login-2');
        });

        Route::get('/auth-register', function () {
            return view('auth-register');
        });

        Route::get('/auth-register-2', function () {
            return view('auth-register-2');
        });

        Route::get('/auth-recoverpw', function () {
            return view('auth-recoverpw');
        });

        Route::get('/auth-recoverpw-2', function () {
            return view('auth-recoverpw-2');
        });

        Route::get('/auth-lock-screen', function () {
            return view('auth-lock-screen');
        });

        Route::get('/auth-lock-screen-2', function () {
            return view('auth-lock-screen-2');
        });

        Route::get('/auth-confirm-mail', function () {
            return view('auth-confirm-mail');
        });

        Route::get('/auth-confirm-mail-2', function () {
            return view('auth-confirm-mail-2');
        });

        Route::get('/auth-email-verification', function () {
            return view('auth-email-verification');
        });

        Route::get('/auth-email-verification-2', function () {
            return view('auth-email-verification-2');
        });

        Route::get('/auth-two-step-verification', function () {
            return view('auth-two-step-verification');
        });

        Route::get('/auth-two-step-verification-2', function () {
            return view('auth-two-step-verification-2');
        });

        // --- Utility/Pages Routes ---
        Route::get('/pages-starter', function () {
            return view('pages-starter');
        });

        Route::get('/pages-maintenance', function () {
            return view('pages-maintenance');
        });

        Route::get('/pages-comingsoon', function () {
            return view('pages-comingsoon');
        });

        Route::get('/pages-timeline', function () {
            return view('pages-timeline');
        });

        Route::get('/pages-faqs', function () {
            return view('pages-faqs');
        });

        Route::get('/pages-pricing', function () {
            return view('pages-pricing');
        });

        Route::get('/pages-404', function () {
            return view('pages-404');
        });

        Route::get('/pages-500', function () {
            return view('pages-500');
        });

        // --- UI Elements Routes ---
        Route::get('/ui-alerts', function () {
            return view('ui-alerts');
        });

        Route::get('/ui-buttons', function () {
            return view('ui-buttons');
        });

        Route::get('/ui-cards', function () {
            return view('ui-cards');
        });

        Route::get('/ui-carousel', function () {
            return view('ui-carousel');
        });

        Route::get('/ui-dropdowns', function () {
            return view('ui-dropdowns');
        });

        Route::get('/ui-grid', function () {
            return view('ui-grid');
        });

        Route::get('/ui-images', function () {
            return view('ui-images');
        });

        Route::get('/ui-lightbox', function () {
            return view('ui-lightbox');
        });

        Route::get('/ui-modals', function () {
            return view('ui-modals');
        });

        Route::get('/ui-offcanvas', function () {
            return view('ui-offcanvas');
        });

        Route::get('/ui-rangeslider', function () {
            return view('ui-rangeslider');
        });

        Route::get('/ui-session-timeout', function () {
            return view('ui-session-timeout');
        });

        Route::get('/ui-progressbars', function () {
            return view('ui-progressbars');
        });

        Route::get('/ui-placeholders', function () {
            return view('ui-placeholders');
        });

        Route::get('/ui-sweet-alert', function () {
            return view('ui-sweet-alert');
        });

        Route::get('/ui-tabs-accordions', function () {
            return view('ui-tabs-accordions');
        });

        Route::get('/ui-typography', function () {
            return view('ui-typography');
        });

        Route::get('/ui-toasts', function () {
            return view('ui-toasts');
        });

        Route::get('/ui-video', function () {
            return view('ui-video');
        });

        Route::get('/ui-general', function () {
            return view('ui-general');
        });

        Route::get('/ui-colors', function () {
            return view('ui-colors');
        });

        Route::get('/ui-rating', function () {
            return view('ui-rating');
        });

        Route::get('/ui-notifications', function () {
            return view('ui-notifications');
        });

        Route::get('/ui-utilities', function () {
            return view('ui-utilities');
        });

        // --- Form Routes ---
        Route::get('/form-elements', function () {
            return view('form-elements');
        });

        Route::get('/form-layouts', function () {
            return view('form-layouts');
        });

        Route::get('/form-validation', function () {
            return view('form-validation');
        });

        Route::get('/form-advanced', function () {
            return view('form-advanced');
        });

        Route::get('/form-editors', function () {
            return view('form-editors');
        });

        Route::get('/form-uploads', function () {
            return view('form-uploads');
        });

        Route::get('/form-xeditable', function () {
            return view('form-xeditable');
        });

        Route::get('/form-repeater', function () {
            return view('form-repeater');
        });

        Route::get('/form-wizard', function () {
            return view('form-wizard');
        });

        Route::get('/form-mask', function () {
            return view('form-mask');
        });

        // --- Table Routes ---
        Route::get('/tables-basic', function () {
            return view('tables-basic');
        });

        Route::get('/tables-datatable', function () {
            return view('tables-datatable');
        });

        Route::get('/tables-responsive', function () {
            return view('tables-responsive');
        });

        Route::get('/tables-editable', function () {
            return view('tables-editable');
        });

        // --- Chart Routes ---
        Route::get('/charts-apex', function () {
            return view('charts-apex');
        });

        Route::get('/charts-echart', function () {
            return view('charts-echart');
        });

        Route::get('/charts-chartjs', function () {
            return view('charts-chartjs');
        });

        Route::get('/charts-flot', function () {
            return view('charts-flot');
        });

        Route::get('/charts-tui', function () {
            return view('charts-tui');
        });

        Route::get('/charts-knob', function () {
            return view('charts-knob');
        });

        Route::get('/charts-sparkline', function () {
            return view('charts-sparkline');
        });

        // --- Icon Routes ---
        Route::get('/icons-boxicons', function () {
            return view('icons-boxicons');
        });

        Route::get('/icons-materialdesign', function () {
            return view('icons-materialdesign');
        });

        Route::get('/icons-dripicons', function () {
            return view('icons-dripicons');
        });

        Route::get('/icons-fontawesome', function () {
            return view('icons-fontawesome');
        });

        // --- Map Routes ---
        Route::get('/maps-google', function () {
            return view('maps-google');
        });

        Route::get('/maps-vector', function () {
            return view('maps-vector');
        });

        Route::get('/maps-leaflet', function () {
            return view('maps-leaflet');
        });
    });
});

require __DIR__.'/auth.php';