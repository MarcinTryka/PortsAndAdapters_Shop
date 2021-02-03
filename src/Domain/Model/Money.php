<?php


namespace Shop\Domain\Model;


use Shop\Domain\Model\Money\InvalidMoneyFormatException;

class Money
{
    const DECIMAL_SEPARATOR = '.';

    private string $value;
    private string $decimal;

    /**
     * Money constructor.
     * @param string $amount Money representation in format x.yy
     * @throws InvalidMoneyFormatException
     */
    public function __construct(string $amount)
    {
        $moneyParts = explode(self::DECIMAL_SEPARATOR, $amount);
        if (count($moneyParts) != 2) {
            throw new InvalidMoneyFormatException();
        }
        if (!is_numeric($moneyParts[0]) || !is_numeric($moneyParts[1]) || strlen($moneyParts[1]) > 2) {
            throw new InvalidMoneyFormatException();
        }

        $this->value = (int)$moneyParts[0];
        $this->decimal = (int)$moneyParts[1];
    }

    public function __toString(): string
    {
        return $this->value . self::DECIMAL_SEPARATOR . $this->decimal;
    }

}