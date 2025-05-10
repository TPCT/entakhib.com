<?php

use App\Models\Translation\Translation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('{locale?}')
    ->middleware([
        \App\Http\Middleware\SetLocale::class,
        \App\Http\Middleware\StatusChecker::class,
        \App\Http\Middleware\ComingSoonMiddleware::class
    ])
    ->group(function(){
        Route::get('/coming-soon', function(){
            return view('coming-soon');
        })->name('site.coming-soon');

        Route::controller(\App\Http\Controllers\ProfileController::class)->group(function(){
            Route::prefix('auth')->middleware([
                \App\Http\Middleware\ProfileAuthBypass::class,
            ])->group(function(){
                Route::get('/login', 'login')->name('profile.login');
                Route::post('/login', 'login')->name('profile.login.post')->middleware('throttle:login');
                Route::get('/register', 'register')->name('profile.register');
                Route::post('/register', 'register')->name('profile.register.post')->middleware('throttle:login');
                Route::get('/otp', 'otp')->name('profile.otp');
                Route::post('/otp', 'otp')->name('profile.otp.post')->middleware('throttle:login');
            });

            Route::middleware(\App\Http\Middleware\ProfileGuard::class)->group(function(){
                Route::get('/vote/{type}', 'vote')
                    ->whereIn('type', [\App\Models\Profile::CLUSTER, \App\Models\Profile::PARTY])
                    ->name('profile.vote');
                Route::get('/profile/view', 'show')->name('profile.view');
                Route::any('/profile/edit', 'edit')->name('profile.edit');
                Route::any('/logout', 'logout')->name('profile.logout');
            });
        });

        Route::controller(\App\Http\Controllers\ElectionResultsController::class)
            ->prefix('/election-results')
            ->group(function(){
                Route::get('', 'index')->name('election-results.index');
                Route::get('/parties-winners/{party}', 'partyWinners')->name('election-results.winners');
            });

        Route::get('/city/{city?}', [\App\Http\Controllers\ApiController::class, 'districts'])->name('api.districts');
        Route::get('/district/{district?}', [\App\Http\Controllers\ApiController::class, 'clusters'])->name('api.clusters');

        Route::controller(\App\Http\Controllers\PartiesController::class)->prefix('parties')->group(function(){
            Route::get('', 'index')->name('parties.index');
            Route::get('show/{party}', 'show')->name('parties.show');
            Route::get('votes', 'votes')->name('parties.votes');
        });

        Route::controller(\App\Http\Controllers\ClustersController::class)->prefix('clusters')->group(function(){
            Route::get('', 'index')->name('clusters.index');
            Route::get('show/{cluster}', 'show')->name('clusters.show');
            Route::get('votes', 'votes')->name('clusters.votes');
            Route::get('votes/{cluster}', 'votesShow')->name('clusters.votes.show');
        });

        Route::resource('candidates', \App\Http\Controllers\CandidatesController::class)->only([
            'index', 'show'
        ]);

        Route::resource('news', \App\Http\Controllers\NewsController::class)->only([
            'show', 'index'
        ]);

        Route::controller(\App\Http\Controllers\SiteController::class)
            ->group(function(){
                Route::get('/', 'index')->name('site.index');
                Route::get('/about-us', 'aboutUs')->name('site.about-us');
                Route::get('/faqs', 'faqs')->name('site.faqs');
                Route::any('/contact-us', 'contactUs')->name('site.contact-us')
                    ->middleware('throttle:5,1');
            });

        Route::get('/{page}', [\App\Http\Controllers\SiteController::class, 'show'])->name('page.show');

        Route::fallback([\App\Http\Controllers\SiteController::class, 'show']);
    });

