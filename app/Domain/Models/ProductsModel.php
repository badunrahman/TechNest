<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use Nyholm\Psr7\Response;

class ProductsModel extends BaseModel
{
    private $products_table = "products";

    public function __construct(PDOService $db_service)
    {
        parent::__construct($db_service);
    }

    /**
     * Fetches the list of products from the DB.
     * @return mixed
     */
    public function getProducts(): mixed
    {
        $sql = "SELECT * FROM products";
        $products = $this->selectAll($sql);
        return $products;
    }

    public function getProductById(int $product_id): mixed
    {
        $sql = "SELECT * FROM products WHERE id = :product_id";
        $product = $this->selectOne($sql, ["product_id" => $product_id]);

        return $product;
    }

    public function updateProduct(array $product_info)
    {

        return $this->execute(
            'UPDATE products
         SET category_id = :category_id ,name = :name,description = :description,price = :price, stock_quantity = :stock
         WHERE id = :id',
            [
                'id' => $product_info['product_id'],
                'category_id' => $product_info['category'],
                'name' => $product_info['product_name'],
                'description' => $product_info['description'],
                'price' => $product_info['price'],
                'stock' => $product_info['quantity']
            ]
        );
    }
}
