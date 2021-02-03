<?php


namespace Shop\Domain\Model\Product;


use Shop\Domain\Logger;
use Shop\Domain\Model\Product;
use Shop\Domain\Ports\AddProductService\Request;
use Shop\Domain\Ports\ProductsRepository;

class Factory
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    /**
     * Creates a new Product entity from create product domain request.
     * @throws CreateException
     */
    public function createFromRequest(Request $request): Product
    {
        try {
            $productId = $this->productsRepository->createProduct(
                $request->getProductName(),
                $request->getProductPrice()
            );
        } catch (\Exception $e) {
            /**
             * Using a static access to the class can make unit testing more difficult. We have to be able to replace
             * the logger with a mock (Logger::getInstance()->registerLogger($mock)) or handle it in any different way:
             * - dependency injection
             * - attaching error message to the CreateException and log it above
             */
            Logger::getInstance()->error(sprintf("Creating product error: %s", $e));
            throw new CreateException("Creating product error");
        }
        return new Product($productId, $request->getProductName(), $request->getProductPrice());
    }
}