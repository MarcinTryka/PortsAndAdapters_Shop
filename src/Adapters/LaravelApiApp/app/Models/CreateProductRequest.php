<?php


namespace App\Models;


use Illuminate\Http\Request;
use Shop\Domain\Model\Money;
use Shop\Domain\Ports\AddProductService\Request as RequestInterface;

class CreateProductRequest implements RequestInterface
{
    private string $name;
    private Money $price;

    /**
     * @throws Money\InvalidMoneyFormatException
     */
    public function __construct(Request $request)
    {
        $this->name = $request->get('name');
        $this->price = new Money($request->get('price'));
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
