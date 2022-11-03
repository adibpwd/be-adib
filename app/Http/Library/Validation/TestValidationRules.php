<?php

namespace App\Http\Library\Validation;

use Illuminate\Validation\Rule;

trait TestValidationRules
{
    protected function getCustomerRules()
    {
        return [
            'city' => ['required', 'string', 'max:255'],
        ];
    }

    protected function getOrderRules()
    {
        return [
            'city' => ['string', 'max:255'],
            'status' => ['array'],
            'min_date' => ['date_format:Y-m-d', 'required_with:max_date'],
            'max_date' => ['date_format:Y-m-d', 'after_or_equal:min_date', 'required_with:min_date'],
        ];
    }

    protected function getDetailBlokRules()
    {
        return [
            'name' => ['required', 'string', 'max:10'],
        ];
    }
  
    protected function fillBlokRules()
    {
        return [
            'blok_id' => ['required', 'numeric'],
            'name' => [
                'required', 
                'string', 
                'max:10',
                'unique:parking_vehicles,name' 
                // Rule::unique('parking_vehicles')
            ],
        ];
    }
    
    protected function outBlokRules()
    {
        return [
            'id' => ['required', 'numeric']
        ];
    }
}