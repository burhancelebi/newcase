<?php

namespace App\Http\Requests;

use App\Rules\ProductStockControlRule;
use App\Services\ProductService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateOrderRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(ProductService $productService): array
    {
        return [
            'customer_id' => 'bail|required',
            'products.*.quantity' => 'required|integer|min:1|max:100|bail',
            'products.*.id' => ['required', new ProductStockControlRule($productService)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors(),
        ]));
    }
}
