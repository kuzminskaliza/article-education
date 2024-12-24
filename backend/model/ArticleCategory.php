<?php

namespace backend\model;

class ArticleCategory extends BaseModel
{
    protected ?int $article_id = null;
    protected ?int $category_id = null;
    private ?Category $category;

    public function __construct()
    {
        parent::__construct();

        $this->category = new Category();
    }

    public function getTableName(): string
    {
        return 'article_category';
    }

    public function getAttributes(): array
    {
        return [
            'article_id',
            'category_id',
        ];
    }

    public function primaryKey(): array
    {
        return [
            'article_id',
            'category_id',
        ];
    }

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];

        if (!is_numeric($this->article_id)) {
            $this->errors['article_id'] = 'article_id must be numeric';
        }

        if (!is_numeric($this->category_id)) {
            $this->errors['category_id'] = 'category_id must be numeric';
        }

        return empty($this->errors);
    }

    public function getCategory(): ?Category
    {
        return $this->category->findOne(['id' => $this->category_id]);
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getArticleId(): ?int
    {
        return $this->article_id;
    }
}
