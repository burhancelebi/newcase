<?php

namespace App\Rules;

use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductStockControlRule implements ValidationRule
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $quantity = $this->searchForId($value, request()->get('products'));

        $product = $this->productService->getProductById($value);

        if ($product->stock < $quantity)
        {
            $fail('There are only ' . $product->stock .' of this product in stock');
        }
    }

    private function searchForId($id, $array) {
        foreach ($array as $val) {
            if ($val['id'] === $id) {
                return $val['quantity'];
            }
        }
        return null;
    }
}
