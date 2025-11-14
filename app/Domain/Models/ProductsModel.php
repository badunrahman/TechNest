<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductsModel extends BaseModel
{
    private const TABLE = 'products';

    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    /**
     * Retrieve all products ordered by the most recent creation date.
     */
    public function getAllProducts(): array
    {
        $sql = 'SELECT p.*, c.name AS category_name '
            . 'FROM ' . self::TABLE . ' p '
            . 'LEFT JOIN categories c ON c.id = p.category_id '
            . 'ORDER BY p.created_at DESC';

        return $this->selectAll($sql);
    }

    /**
     * Find a product by its primary key.
     */
    public function findById(int $id): array|false
    {
        $sql = 'SELECT p.*, c.name AS category_name '
            . 'FROM ' . self::TABLE . ' p '
            . 'LEFT JOIN categories c ON c.id = p.category_id '
            . 'WHERE p.id = :id '
            . 'LIMIT 1';

        return $this->selectOne($sql, ['id' => $id]);
    }

    /**
     * Persist a new product record.
     */
    public function create(array $data): int|string
    {
        $sql = 'INSERT INTO ' . self::TABLE
            . ' (category_id, name, description, price, stock_quantity) '
            . 'VALUES (:category_id, :name, :description, :price, :stock_quantity)';

        $this->execute($sql, [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,
        ]);

        return $this->lastInsertId();
    }

    /**
     * Update an existing product record.
     */
    public function update(int $id, array $data): int
    {
        $sql = 'UPDATE ' . self::TABLE
            . ' SET category_id = :category_id, name = :name, description = :description, '
            . 'price = :price, stock_quantity = :stock_quantity '
            . 'WHERE id = :id';

        return $this->execute($sql, [
            'id' => $id,
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'] ?? 0,
        ]);
    }

    /**
     * Delete a product by its primary key.
     */
    public function delete(int $id): int
    {
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';

        return $this->execute($sql, ['id' => $id]);
    }
}
