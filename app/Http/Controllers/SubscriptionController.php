<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionReceived;
use App\Mail\SubscriptionOnHold;
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
     
        $max_subscr = Shift::find($sub->shift_id)->subscription_max;
        $sub_count = Subscription::where('shift_id', $sub->shift_id);
        if(($max_subscr-$sub_count)>0){
            Mail::to($sub->email)->send(new SubscriptionReceived($sub, $event));
        }
        else{
            $sub->status = 'On hold';
            Mail::to($sub->email)->send(new SubscriptionOnHold($sub, $event));
        }
        
        return redirect()->route('confirmed', ['subscription' => $sub->id, 'event' => $event->id]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription, string $event)
    {
        $event = Event::find($event);

        //heavenly tested

        return Inertia::render('Subscription/Confirmed', [
            'event' => $event, 
            'subscription' => $subscription,
         ]);
         //this is an update
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
