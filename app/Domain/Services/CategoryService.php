<?php

declare(strict_types=1);

namespace App\Domain\Services;

class CategoryService extends BaseService
{
    /**
     * Validate and sanitize category data.
     *
     * @param array $data Raw category input data.
     *
     * @return array Result payload using the Result pattern contract.
     */
    public function validateCategory(array $data): array
    {
        $errors = [];
        $sanitized = [];
        $old = [];

        $name = trim((string) ($data['name'] ?? ''));
        $old['name'] = $name;
        if ($name === '') {
            $errors['name'] = 'Category name is required.';
        } else {
            $sanitized['name'] = $name;
        }

        $description = trim((string) ($data['description'] ?? ''));
        $old['description'] = $description;
        $sanitized['description'] = $description;

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
