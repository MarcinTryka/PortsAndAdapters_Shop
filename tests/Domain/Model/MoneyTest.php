<?php

namespace Shop\Tests\Domain\Model;

use PHPUnit\Framework\TestCase;
use Shop\Domain\Model\Money;

class MoneyTest extends TestCase
{
    public function testToString(){
        $price = new Money('123.45');
        $this->assertEquals('123.45', (string)$price);
    }

    public function testNoDecimalPart(){
        $this->expectException(Money\InvalidMoneyFormatException::class);
        new Money('12345');
    }

    public function testInvalidNumberPart(){
        $this->expectException(Money\InvalidMoneyFormatException::class);
        new Money('123a.45');
    }

    public function testInvalidDecimalPart(){
        $this->expectException(Money\InvalidMoneyFormatException::class);
        new Money('123.45a');
    }

    public function testTooLongDecimalPart(){
        $this->expectException(Money\InvalidMoneyFormatException::class);
        new Money('123.455');
    }

}
