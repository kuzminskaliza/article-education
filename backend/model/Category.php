<?php

namespace backend\model;

class Category extends BaseModel
{
    protected int $id;
    protected ?string $name = null;

    public function getTableName(): string
    {
        return 'category';
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
        if (empty($this->name)) {
            $this->errors['name'] = 'Title is required';
        } elseif (strlen($this->name) < 3 || strlen($this->name) > 255) {
            $this->errors['name'] = 'Title must be between 3-255 symbols';
        }
        return empty($this->errors);
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
