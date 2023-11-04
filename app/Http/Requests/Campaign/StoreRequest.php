<?php

namespace App\Http\Requests\Campaign;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $min_start_hours = '06:00';
        $max_start_hours = '22:00';

        return [
            'pitch_id' => [
                'required',
            ],
            'sub_pitch_id' => [
              'required',
            ],
            'date' => [
                'required',
              'date',
              'after_or_equal:' . date('Y-m-d'),
            ],
            'start_time' => [
                'required',
               'date_format:H:i',
                'before_or_equal:' . $max_start_hours,
                'after_or_equal:' . $min_start_hours,
                'before:end_time',
            ],
            'end_time' => [
                'required',
              'date_format:H:i',
                'after:start_time',
            ],
            'price_per_hour' => [
                'required',
            ],
            'campaign_title' => [
                'string',
                'filled'
            ],
            'slug' => [
                'string',
                'filled',
                Rule::unique(Campaign::class),
            ],
        ];
    }

    public function messages() : array {
        return [
            'start_time.date_format' => 'Invalid time format',
            'end_time.date_format' => 'The end time field must be after start time',
        ];
    }
}
