<?php

namespace backend\model;

class ArticleTag extends BaseModel
{
    protected int $id;
    protected ?string $title = null;

    public function getTableName(): string
    {
        return 'article_tag';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'article_id',
            'title',
            'created_at',
            'updated_at'
        ];
    }

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (empty($this->title)) {
            $this->errors['tag'] = 'Tag is required';
        }
        return empty($this->errors);
    }

    public function getTagName(): ?string
    {
        return $this->title;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
