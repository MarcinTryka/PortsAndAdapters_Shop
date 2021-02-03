<?php


namespace Shop\Adapters\FakeProductsRepository;


use Shop\Domain\Model\Money;

/**
 * Class pretends to be a storage layer for products. It doesn't store anything, instead of that it returns id of
 * the stored product generated from the length of product's name. It allows to generate exception when specific
 * product name is given.
 */
class Repository implements \Shop\Domain\Ports\ProductsRepository
{

    /**
     * @inheritDoc
     */
    public function createProduct(string $name, Money $price): int
    {
        if ($name == 'Throw fake exception') {
            throw new \Exception("Dumb error");
        }
        //Instead of id of new created element:
        return strlen($name);
    }
}