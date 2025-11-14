<?php

declare(strict_types=1);

namespace App\Domain\Services;

class ProductService extends BaseService
{
    /**
     * Validate and sanitize product data.
     *
     * @param array $data Raw product input data.
     *
     * @return array Result payload using the Result pattern contract.
     */
    public function validateProduct(array $data): array
    {
        $errors = [];
        $sanitized = [];
        $old = [];

        $name = trim((string) ($data['name'] ?? ''));
        $old['name'] = $name;
        if ($name === '') {
            $errors['name'] = 'Product name is required.';
        } else {
            $sanitized['name'] = $name;
        }

        $priceValue = trim((string) ($data['price'] ?? ''));
        $old['price'] = $priceValue;
        if ($priceValue === '') {
            $errors['price'] = 'Price is required.';
        } elseif (!is_numeric($priceValue)) {
            $errors['price'] = 'Price must be a valid number.';
        } else {
            $price = (float) $priceValue;
            if ($price < 0) {
                $errors['price'] = 'Price must be zero or greater.';
            } else {
                $sanitized['price'] = $price;
            }
        }

        $description = trim((string) ($data['description'] ?? ''));
        $old['description'] = $description;
        $sanitized['description'] = $description;

        $categoryId = isset($data['category_id']) ? (int) $data['category_id'] : 0;
        $old['category_id'] = $categoryId;
        $sanitized['category_id'] = $categoryId;

        $stockValue = trim((string) ($data['stock_quantity'] ?? ''));
        $old['stock_quantity'] = $stockValue;
        if ($stockValue === '') {
            $sanitized['stock_quantity'] = 0;
        } elseif (!is_numeric($stockValue)) {
            $errors['stock_quantity'] = 'Stock quantity must be a whole number.';
        } else {
            $stockQuantity = (int) $stockValue;
            if ($stockQuantity < 0) {
                $errors['stock_quantity'] = 'Stock quantity must be zero or greater.';
            } else {
                $sanitized['stock_quantity'] = $stockQuantity;
            }
        }

        if (!isset($sanitized['stock_quantity'])) {
            $sanitized['stock_quantity'] = 0;
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
                'data' => $old,
            ];
        }

        return [
            'success' => true,
            'data' => $sanitized,
        ];
    }
}
