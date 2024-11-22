<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $products = $this->productService->getProducts();

        return ProductResource::collection($products);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return ProductResource
     */
    public function show(int $id): ProductResource
    {
        $product = $this->productService->getProductById($id);

        return ProductResource::make($product);
    }
}
