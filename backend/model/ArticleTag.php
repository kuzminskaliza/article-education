<?php

namespace backend\model;

class ArticleTag extends BaseModel
{
    protected int $id;
    protected ?string $tag = null;

    public function getTableName(): string
    {
        return 'article_tag';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'article_id',
            'tag',
            'created_at',
            'updated_at'
        ];
    }

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (empty($this->tag)) {
            $this->errors['tag'] = 'Tag is required';
        }
        return empty($this->errors);
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
