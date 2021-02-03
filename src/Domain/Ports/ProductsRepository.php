<?php


namespace Shop\Domain\Ports;


use Shop\Domain\Model\Money;

interface ProductsRepository
{
    /**
     * @return int Returns integer identity of created object
     */
    public function createProduct(string $name, Money $price): int;
}