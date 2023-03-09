<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('edit product');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required',
            'price'  => 'required|numeric|decimal:0,2|min:0'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'price' => floatval(trim($this->price, '€'))
        ]);
    }
}
