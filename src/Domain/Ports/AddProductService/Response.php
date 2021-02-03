<?php


namespace Shop\Domain\Ports\AddProductService;


use Shop\Domain\Model\Product;

interface Response
{
    public function setProduct(Product $product);
}