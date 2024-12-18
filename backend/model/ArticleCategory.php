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

    public function getCategory(): ?Category
    {
        return $this->category->findOne(['id' => $this->category_id]);
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }
}
