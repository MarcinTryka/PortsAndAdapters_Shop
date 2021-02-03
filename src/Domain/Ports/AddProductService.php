<?php


namespace Shop\Domain\Ports;


use Shop\Domain\Model\Product\Factory;
use Shop\Domain\Ports\AddProductService\Request;
use Shop\Domain\Ports\AddProductService\Response;


class AddProductService
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    /**
     * @throws \Shop\Domain\Model\Product\CreateException
     */
    public function addProduct(Request $request, Response $response): void
    {
        /**
         * Create a new Product entity based on request
         */
        $productFactory = new Factory($this->productsRepository);
        $product = $productFactory->createFromRequest($request);

        /**
         * Attach the Product entity to the domain response.
         */
        $response->setProduct($product);
    }
}