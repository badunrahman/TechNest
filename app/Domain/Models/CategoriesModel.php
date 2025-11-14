<?php

declare(strict_types=1);

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class CategoriesModel extends BaseModel
{
    private const TABLE = 'categories';

    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    /**
     * Retrieve all categories ordered by the most recent creation date.
     */
    public function getAllCategories(): array
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' ORDER BY created_at DESC';

        return $this->selectAll($sql);
    }

    /**
     * Locate a category by its primary key.
     */
    public function findById(int $id): array|false
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE id = :id LIMIT 1';

        return $this->selectOne($sql, ['id' => $id]);
    }

    /**
     * Persist a new category record.
     */
    public function create(array $data): int|string
    {
        $sql = 'INSERT INTO ' . self::TABLE . ' (name, description) VALUES (:name, :description)';

        $this->execute($sql, [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return $this->lastInsertId();
    }

    /**
     * Update an existing category record.
     */
    public function update(int $id, array $data): int
    {
        $sql = 'UPDATE ' . self::TABLE . ' SET name = :name, description = :description WHERE id = :id';

        return $this->execute($sql, [
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    /**
     * Delete a category by its primary key.
     */
    public function delete(int $id): int
    {
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';

        return $this->execute($sql, ['id' => $id]);
    }
}
