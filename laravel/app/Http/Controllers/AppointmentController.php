<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Models\Barber;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments=Appointment::all();
        return response()->json($appointments,200,['Access-Control-Allow-Origin'=>"*"],JSON_UNESCAPED_UNICODE);
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
        try 
        {
            $request->validate([
                'name'=>'required|string|max: 255',
                'barber_id'=>'required|max: 255',
                'appointment'=>'required|date',
            ],
            [
                'name.required'=>'Nev nincs megadva',
                'barber_id.required'=>'Nincs megadva fodrasz',
                'appointment.required'=>'Nincs megadva datum',
                'name.string'=>'Nev nem szoveg',
                'barber_id.integer'=>'Nem szam',
                'appointment.date'=>'Nem datum',
                'name.max'=>'Tul hosszu'
            ]    
            );
        } 
        catch (ValidationException $e) 
        {
            return response()->json([
                'message'=>$e->getMessage(),
            ],400);
        }
        try
        {
            $barber = Barber::findOrFail($request->input('barber_id'));
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json([
                'message'=>'Nincs ilyen ID-vel fodrasz'
            ]);
        }
        $appointment=Appointment::create([
            'name'=>$request->input('name'),
            'barber_id'=>$request->input('barber_id'),
            'appointment'=>$request->input('appointment')
        ]);
        return response()->json(['success'=>true,'uzenet'=>$appointment->name.' rögzítve'],200, ['Access-Control-Allow-Origin'=>'*'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $appointment = appointment::find($request->id);
        $appointment->delete();
        return response()->json(["success" => true, "uzenet" => $appointment->appointment . "->" .$appointment->name . " törölve!"], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }
}
