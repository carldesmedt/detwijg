<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use App\Models\Event;
use App\Models\Shift;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function trindex() {

    }
    public function index()
    {
        //dd(date("Y-m-d"));
        $events = Event::all()->where('date_online','<=', date("Y-m-d"))->where('date_offline', '>', date("Y-m-d"))->map(function (Event $event){
            $shift = $event->shifts->first();
            $subscription_required = $shift->subscription_required;
            $location = $shift->location;
            return [
                'name' => $event->name, 
                'slug' => $event->slug,
                'description' => $event->description,
                'start_date' => $event->date_start,
                'end_date' => $event->date_end,
                'subscription_required' => $subscription_required,
                'location' => $location,
            ];
            
        });
       //dd($events);
        return Inertia::render('Welcome', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //each event must have a unique name, slug.
        //check for all event names and slugs and retun in view
        $ruled_out_names = Event::all()->map(function (Event $event){
            return $event->name;
        });

        //return view
        return Inertia::render('Event/Create' ,[
            'ro_names' => $ruled_out_names,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'date_online' => $request->date_online,
            'date_offline' => $request->date_offline,
        ]);

        foreach($request->shifts as $shift){
            $s = Shift::create([
                'event_id' => $event->id,
                'date' => $shift['date'],
                'start' => $shift['shift_start'],//nullable
                'end' => $shift['shift_end'],//nullable
                'subscription_required' => $shift['subscription_required'],
                'subscription_max' => $shift['subscription_max'],//nullable
                'subscription_fee' => $shift['subscription_fee'],//nullable
                'subscription_start' => $shift['subscription_start'],//nullable
                'subscription_end' => $shift['subscription_end'],//nullable
                'subscription_param' => json_encode($shift['subscription_param']),//nullable
                'location' => $shift['location'] //nullable
            ]);
        }
        return redirect()->route('dashboard');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {   
        $subscription = [
            'required' => (bool)$event->shifts->first()->subscription_required,
            'fee' => $event->shifts->first()->subscription_fee,
            'param' => json_decode($event->shifts->first()->subscription_param),
            'start' => $event->shifts->first()->subscription_start,
            'end' => $event->shifts->first()->subscription_end,
        ];
        $shifts = $event->shifts->map(function(Shift $shift){
            $free_space = $shift->subscription_max - $shift->subscriptions->count();
            if ($free_space < 0){$free_space = 0;};
            return [
                'id' => $shift->id,
                'date' => $shift->date,
                'start' => $shift->start,
                'end' =>$shift->end,
                'free_space' => $free_space,
            ];
        });
        
        return Inertia::render('Event/Show', [
            'event' => $event, 
            'subscription' => $subscription,
            'shifts' =>$shifts,
            'location' => $event->shifts->first()->location,
            /*'shifts' => $shifts, 
            'freeSpaces' => $freeSpaces, 
            'subscriptionFee' => $subscriptionFee, 
            'products' => $products*/
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Event $event){
        //$subscriptions = array();
        $shiftsubs = $event->shifts->map(function(Shift $shift){
            return $shift->subscriptions;
        });
       // dd($shiftsubs[0]);
        $subscriptions = $shiftsubs[0]->map(function(Subscription $subscription){
            return $subscription;
        });
        //dd($subscriptions);
        //dd('test detail'.$event);



        return Inertia::render('Event/Detail', [
            'event' => $event,
            'shifts' => $event->shifts,
            'subscriptions' => $subscriptions,
            'subscription_param' => json_decode($event->shifts->first()->subscription_param)/*$event->shifts->map(function(Shift $shift){
                return $shift->subscriptions
            }),*/
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
