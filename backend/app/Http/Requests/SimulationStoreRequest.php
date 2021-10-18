<?php

namespace App\Http\Requests;

use App\Models\Simulation;
use Illuminate\Foundation\Http\FormRequest;

class SimulationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Simulation::count() === 0;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
