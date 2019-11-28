<?php

namespace App\Services\Meal;

use Illuminate\Contracts\Validation\Validator;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class PickMealValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        $categories = implode(',', config('here.categories'));;

        return [
            'useLocation' => ['required', 'string', 'in:custom,current'],
            'currentLocation' => ['required_if:useLocation,current', 'string', 'nullable', 'regex:/^\-?\d+(\.\d+)?,\s*+\-?\d+(\.\d+)?(;\-?\d+(\.\d+)?,\s*+\-?\d+(\.\d+)?)*$/'],
            'searchRadius' => ['required','int', 'in:2,5,10,15,20,25'],
            'level' => ['required', 'string', "in:{$categories}"],
            'maxResults' => ['required', 'int', 'in:1,2,3,4,5'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'customLocationId' => ['trim', 'strip_tags'],
            'customLocationAddress' => ['trim', 'strip_tags'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'customLocationId.required_if' => 'Custom location not given or not found. You must provide a valid address.',
            'customLocationId.required' => 'Custom location not given or not found. You must provide a valid address.',
            'currentLocation.required_if' => 'Current location not found. If your browser prompts you for permission, be sure to click "Allow".',
            'currentLocation.required' => 'Current location not found. If your browser prompts you for permission, be sure to click "Allow".',
            'currentLocation.regex' => 'Current location coordinates are not in the correct format.',
        ];
    }

    /**
     * Additional operations for the validator.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    protected function withValidator(Validator $validator)
    {
        $validator->sometimes('customLocationAddress', 'required|string', function ($input) {
            return $input->customLocationId === null && $input->useLocation === 'custom';
        });

        $validator->sometimes('customLocationId', 'required|string', function ($input) {
            return $input->customLocationAddress === null && $input->useLocation === 'custom';
        });
    }
}
