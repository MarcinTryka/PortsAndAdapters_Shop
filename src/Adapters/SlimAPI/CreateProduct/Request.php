<?php


namespace Shop\Adapters\SlimAPI\CreateProduct;


use Shop\Domain\Model\Money;

/**
 * Add a new product domain request.
 */
class Request implements \Shop\Domain\Ports\AddProductService\Request
{
    const FIELD_NAME = 'name';
    const FIELD_PRICE = 'price';

    private string $name;
    private Money $price;

    /**
     * @throws InvalidNameException
     * @throws InvalidPriceException
     */
    public function __construct(array $requestBody)
    {
        if (!isset($requestBody[self::FIELD_NAME])) {
            throw new InvalidNameException('Field is required');
        }
        $this->name = $requestBody['name'];

        if (!isset($requestBody[self::FIELD_PRICE])) {
            throw new InvalidPriceException('Field is required');
        }
        if (!is_numeric($requestBody[self::FIELD_PRICE])) {
            throw new InvalidPriceException('Numeric value required');
        }

        try {
            $this->price = new Money($requestBody[self::FIELD_PRICE]);
        } catch (Money\InvalidMoneyFormatException $e) {
            throw new InvalidPriceException('Invalid price format');
        }
    }

    public function getProductName(): string
    {
        return $this->name;
    }

    public function getProductPrice(): Money
    {
        return $this->price;
    }
}