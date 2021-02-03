<?php

namespace Shop\Tests\Domain\Model\Product;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Shop\Domain\Logger as LogManager;
use Shop\Domain\Model\Money;
use Shop\Domain\Model\Product;
use Shop\Domain\Model\Product\Factory;
use Shop\Domain\Ports\AddProductService\Request;
use Shop\Domain\Ports\ProductsRepository;

class FactoryTest extends TestCase
{

    public function testCreateFromRequest()
    {
        $price = new Money(123.45);
        $productsRepository = $this->getMockBuilder(ProductsRepository::class)->getMock();
        $productsRepository->expects($this->once())
            ->method('createProduct')
            ->with('Test name', $price)
            ->willReturn(321);

        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->atLeastOnce())
            ->method('getProductName')
            ->with()
            ->willReturn('Test name');

        $request->expects($this->atLeastOnce())
            ->method('getProductPrice')
            ->with()
            ->willReturn($price);

        $factory = new Factory($productsRepository);
        $productEntity = $factory->createFromRequest($request);

        $this->assertInstanceOf(Product::class, $productEntity);
        $this->assertEquals(321, $productEntity->getId());
        $this->assertEquals('Test name', $productEntity->getName());
        $this->assertEquals($price, $productEntity->getPrice());
    }

    public function testCreateFromRequestCreatingException()
    {
        $price = new Money(123.45);
        $exception = new \Exception("Test error to log.");
        $productsRepository = $this->getMockBuilder(ProductsRepository::class)->getMock();
        $productsRepository->expects($this->once())
            ->method('createProduct')
            ->with('Test name', $price)
            ->willThrowException($exception);

        $logger = $this->getMockBuilder(LoggerInterface::class)->getMock();
        $logger->expects($this->once())
            ->method('error')
            ->with("Creating product error: " . $exception);
        LogManager::getInstance()->registerLogger($logger);

        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->atLeastOnce())
            ->method('getProductName')
            ->with()
            ->willReturn('Test name');

        $request->expects($this->atLeastOnce())
            ->method('getProductPrice')
            ->with()
            ->willReturn($price);

        $factory = new Factory($productsRepository);

        $this->expectException(Product\CreateException::class);
        $this->expectErrorMessage("Creating product error");
        $factory->createFromRequest($request);
    }


}
