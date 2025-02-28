<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dotenv\Exception\ValidationException;
use App\Models\Appointment;

class Barber extends Model
{
    /** @use HasFactory<\Database\Factories\BarberFactory> */
    use HasFactory;

    function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function store(Request $request)
    {
        try 
        {
            
        } 
        catch (ValidationException $e) 
        {
            
        }
    }
}
