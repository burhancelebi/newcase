<?php

namespace App\Services;

use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductService extends BaseService
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getProducts(): LengthAwarePaginator
    {
        return $this->productRepository->getProducts();
    }

    /**
     * @param int $id
     * @return array|Builder|Collection|Product|Model|null
     */
    public function getProductById(int $id): array|Builder|Collection|Product|Model|null
    {
        return $this->productRepository->getProductById($id);
    }
}
