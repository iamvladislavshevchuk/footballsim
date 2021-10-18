<?php

namespace App\Http\Requests;

use App\Models\Simulation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Simulation $simulation
 * @property int $week
 */
class SimulationStatisticsShowRequest extends FormRequest
{
    public function authorize()
    {
        return $this->week <= $this->simulation->week;
    }

    public function rules()
    {
        return [
            'week' => ['integer', 'required', 'min:1']
        ];
    }
}
