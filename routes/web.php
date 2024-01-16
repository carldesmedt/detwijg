<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Shift;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', ['events'=> Event::all()->map(function(Event $event){
            return [
                'data' => [
                    'slug' => $event->slug,
                    'online' =>$event->date_online,
                    'offline' =>$event->date_offline,
                    'name'=> $event->name,
                    'description' =>$event->description,
                    'startdate'=> $event->date_start, 
                    'enddate'=> $event->date_end,
                ],
                'subscription_required' => (bool)$event->shifts[0]->subscription_required,
                'shifts' => $event->shifts->map(function (Shift $shift){
                    return [
                        'start' =>$shift->start,
                        'end' =>$shift->end,
                        'max_subscriptions' => $shift->subscription_max,
                        'count_subscriptions' =>$shift->subscriptions->count(),
                        'free_space' => $shift->subscription_max - $shift->subscriptions->count(),
                        'fee' => $shift->subscription_fee,
                    ];
                }),
            ];
        })]);
    })->name('dashboard');
    Route::get('mgm/{event:slug}',[ EventController::class, 'detail'])->name('mgmdetail');
    Route::resource('event', EventController::class);
    Route::get('/axios', function (Request $request) {
        return ['test' => 'tester'];
    });
    Route::post('/paid', [SubscriptionController::class, 'paid'])->name('subscription.paid');
});
Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('{event:slug}', [EventController::class, 'show']);
Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
Route::get('/confirmed/{subscription:id}/{event:slug}/{free:free}', [SubscriptionController::class, 'show'])->name('confirmed');
Route::get('/onhold/{subscription:id}/{event:slug}/{free:free}', [SubscriptionController::class, 'onhold'])->name('onhold');

