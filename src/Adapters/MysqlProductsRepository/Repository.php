<?php


namespace Shop\Adapters\MysqlProductsRepository;

use Shop\Domain\Model\Money;
use Shop\Domain\Ports\ProductsRepository as ProductsRepositoryInterface;

/**
 * Storage layer for products.
 */
class Repository implements ProductsRepositoryInterface
{

    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     * @todo: Lack exception handling.
     */
    public function createProduct(string $name, Money $price): int
    {
        $preparedQuery = $this->pdo->prepare("INSERT INTO `products` (`name`, `price`) VALUES (:name, :price)");
        $preparedQuery->bindValue('name', $name);
        $preparedQuery->bindValue('price', (string)$price);
        $preparedQuery->execute();
        return $this->pdo->lastInsertId();
    }
}