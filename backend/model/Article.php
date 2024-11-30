<?php

namespace backend\model;

class Article extends BaseModel
{

    protected int $id;
    protected ?string $title = null;
    protected ?int $status = null;
    protected ?int $category_id = null;
    protected ?string $description = null;

    public function getTableName(): string
    {
        return 'article';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'title',
            'status',
            'category_id',
            'description',
            'updated_at',
            'created_at',
        ];
    }

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (strlen($this->title) < 3 || strlen($this->title) > 255) {
            $this->errors['title'] = 'Title is required';
        }

        if (empty($this->status)) {
            $this->errors['status'] = 'Select a status';
        } else {
            $statuses = (new ArticleStatus())->getAllStatuses();
            if (!array_key_exists($this->status, $statuses)) {
                $this->errors['status'] = 'Incorrect status';
            }
        }

        if (empty($this->category_id)) {
            $this->errors['category_id'] = 'Select a category';
        } else {
            $categories = (new Category())->getAllCategory();
            if (!array_key_exists($this->category_id, $categories)) {
                $this->errors['category_id'] = 'Incorrect category';
            }
        }

        if (empty($this->description)) {
            $this->errors['description'] = 'Description is required';
        }
        return empty($this->errors);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }
    public function getCategory(): ?int
    {
        return $this->category_id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
