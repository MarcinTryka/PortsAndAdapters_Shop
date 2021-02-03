<?php


namespace Shop\Domain\Ports\AddProductService;


use Shop\Domain\Model\Money;

interface Request
{
    public function getProductName(): string;

    public function getProductPrice(): Money;
}