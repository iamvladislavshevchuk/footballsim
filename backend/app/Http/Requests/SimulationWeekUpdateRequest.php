<?php

namespace App\Http\Requests;

use App\Models\Simulation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Simulation $simulation
 * @property integer $week
 */
class SimulationWeekUpdateRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->week === 1) 
            return true;

        return $this->simulation->games()->week($this->week - 1)->empty()->doesntExist()
            && $this->simulation->games()->week($this->week)->exists();
    }

    public function rules()
    {
        return [
            'week' => ['integer', 'required', 'min:1']
        ];
    }
}
