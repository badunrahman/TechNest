<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use Nyholm\Psr7\Response;


class CategoriesModel extends BaseModel
{
    private $categories_table = "categories";

    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    public function getCategories(): array
    {
        $sql = "SELECT * FROM {$this->categories_table}";
        return $this->selectAll($sql);
    }
}
