<?php


namespace App\Models;


use Shop\Domain\Model\Money;
use Shop\Domain\Ports\ProductsRepository as ProductsRepositoryInterface;

class ProductsRepository implements ProductsRepositoryInterface
{

    public function createProduct(string $name, Money $price): int
    {
        $productData = [
            'name' => $name,
            'price_main' => $price->getValue(),
            'price_decimal' => $price->getDecimal(),
        ];
        $product = Product::create($productData);
        return $product->id;
    }
}
