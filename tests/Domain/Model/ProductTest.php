<?php

namespace Shop\Tests\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shop\Domain\Model\Money;
use Shop\Domain\Model\Product;

class ProductTest extends TestCase
{

    /**
     * @group unit
     */
    public function testGetName()
    {
        $product = new Product(1, 'abc test name', new Money(123.45));
        $this->assertEquals('abc test name', $product->getName());
    }

    /**
     * @group unit
     */
    public function testGetId()
    {
        $product = new Product(1, 'abc test name', new Money(123.45));
        $this->assertEquals(1, $product->getId());
    }

    /**
     * @group unit
     */
    public function testGetPrice()
    {
        $price = new Money(123.45);
        $product = new Product(1, 'abc test name', $price);
        $this->assertEquals($price, $product->getPrice());
    }
}
