<?php

namespace console\model;

class ArticleStatus extends BaseModel
{
    protected int $id;
    protected ?string $title = null;

    public function getTableName(): string
    {
        return 'article_status';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'title',
            'created_at',
            'updated_at'
        ];
    }

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (empty($this->title)) {
            $this->errors['title'] = 'Title is require';
        } elseif (strlen($this->title) < 3 || strlen($this->title) > 255) {
            $this->errors['title'] = 'Title must be between 3-255 symbols';
        }
        return empty($this->errors);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
