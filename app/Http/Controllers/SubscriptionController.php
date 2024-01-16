<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionReceived;
use App\Mail\SubscriptionOnHold;
use App\Mail\SubscriptionPaid;
use Inertia\Inertia;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sub = Subscription::create([
           'shift_id' => $request->shift_id,
           'name' => $request->name,
           'email' => $request->email,
           'address' => $request->address,
           'phone' => $request->phone,
           'referenced_contact' => $request->contact,
           'class' => $request->class,
           'team' => $request->team,
           'status' => 'reserved',
           'fee' => $request->fee 
        ]);
        $t=$sub->created_at->timestamp;
        $modulo = $t % 97;
        if($modulo == 0){$modulo = 97;};
        if($modulo < 10){$modulo = '0'.$modulo;};
        $sub->reference = $t.$modulo;
        $sub->save();
        
        $event = Shift::find($sub->shift_id)->event;
     
        $max_inschr = Shift::find($sub->shift_id)->subscription_max;
        $free = $max_inschr - Subscription::where('shift_id', $sub->shift_id)->count();
        
        if($free<0){
           $sub->status = 'on hold';
           $sub->save();
            Mail::to($sub->email)->send(new SubscriptionOnHold($sub, $event, $free));
            return redirect()->route('onhold', ['subscription' => $sub->id, 'event' => $event->id, 'free' => $free]);
        }
        else{
            Mail::to($sub->email)->send(new SubscriptionReceived($sub, $event, $free));
            return redirect()->route('confirmed', ['subscription' => $sub->id, 'event' => $event->id, 'free' => $free]);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription, string $event, int $free)
    {
        $event = Event::find($event);

        //heavenly tested

        return Inertia::render('Subscription/Confirmed', [
            'event' => $event, 
            'subscription' => $subscription,
            'free' =>$free
         ]);
         //this is an update
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function onhold(Subscription $subscription, string $event, int $free)
    {
        $event = Event::find($event);
        return Inertia::render('Subscription/Onhold', [
            'event' => $event, 
            'subscription' => $subscription,
            'free' =>$free
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function paid(Request $request)
    {   
        if($request->paidsubs== []){
            return redirect()->route('mgmdetail', 'quiz-2024');
        }
        foreach($request->paidsubs as $payed){
            
            $subscription = Subscription::find($payed);
            $event = $subscription->shift->event;
            $subscription->status = "paid";
            $subscription->save();
            Mail::to($subscription->email)->send(new SubscriptionPaid($subscription, $event));
            
        }
        return redirect()->route('mgmdetail', 'quiz-2024');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
