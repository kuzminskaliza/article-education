<?php

namespace backend\model;

use backend\BackendApp;

class Category extends BaseModel
{
    protected int $id;
    protected ?string $name = null;

    public function getTableName(): string
    {
        return 'categories';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'name',
            'created_at',
            'updated_at'
        ];
    }

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (strlen($this->name) < 3 || strlen($this->name) > 255) {
            $this->errors['name'] = 'Title is required';
        }
        return empty($this->errors);
    }

    public function getAllCategory(): array
    {
        $category = [];
        $query = "SELECT * FROM " . $this->getTableName();
        $stmt = BackendApp::$pdo->query($query);
        $results = $stmt->fetchAll();

        foreach ($results as $row) {
            $category[$row['id']] = $row['name'];
        }
        return $category;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
