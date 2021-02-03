<?php


namespace Shop\Adapters\SlimAPI\CreateProduct;


use Shop\Domain\Model\Product;
use Shop\Domain\Ports\AddProductService\Response as ResponseInterface;

class Response implements ResponseInterface
{

    private Product $product;

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function toArray()
    {
        return [
            'id' => $this->product->getId(),
            'name' => $this->product->getName(),
            'price' => (string)$this->product->getPrice(),
        ];
    }
}