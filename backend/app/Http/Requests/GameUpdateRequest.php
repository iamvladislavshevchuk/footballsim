<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $home_score
 * @property int $aawy_score
 */
class GameUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'home_score' => ['integer', 'min:0'],
            'away_score' => ['integer', 'min:0']
        ];
    }
}
