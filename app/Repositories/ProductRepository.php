<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $category;

    /**
     * @var float
     */
    private float $price;

    /**
     * @var int
     */
    private int $stock;

    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getProducts(): LengthAwarePaginator
    {
        return $this->product->newQuery()->paginate(request()->get('per_page'));
    }

    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getProductById(int $id): Model|Collection|Builder|array|null
    {
        return $this->product->newQuery()->findOrFail($id);
    }
}
