<?php

namespace backend\model;

class Article extends BaseModel
{

    protected int $id;
    protected ?string $title = null;
    protected ?int $status_id = null;
    protected ?int $category_id = null;
    protected ?string $description = null;

    public ?ArticleStatus $articleStatus;
    public ?Category $category;

    public function __construct()
    {
        parent::__construct();

        $this->articleStatus = new ArticleStatus();
        $this->category = new Category();
    }

    public function getTableName(): string
    {
        return 'article';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'title',
            'status_id',
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

        if (empty($this->status_id)) {
            $this->errors['status_id'] = 'Select a status';
        } else {
            $statuses = $this->articleStatus->findAll();
            $statuses = array_map(static fn($status) => $status->getId(), $statuses);

            if (!in_array($this->status_id, $statuses)) {
                $this->errors['status_id'] = 'Incorrect status';
            }
        }

        if (empty($this->category_id)) {
            $this->errors['category_id'] = 'Select a category';
        } else {
            $categories = $this->category->findAll();
            $categories = array_map(static fn($category) => $category->getId(), $categories);

            if (!in_array($this->category_id, $categories)) {
                $this->errors['category_id'] = 'Incorrect category';
            }
        }

        if (empty($this->description)) {
            $this->errors['description'] = 'Description is required';
        }
        return empty($this->errors);
    }

    public function getId(): ?int
    {
        if (!isset($this->id)) {
            return null;
        }

        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getStatusId(): ?int
    {
        return $this->status_id;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getArticleStatus(): ?ArticleStatus
    {
        if ($this->status_id) {
            $articleStatus = $this->articleStatus->findOneById($this->status_id);
            $this->articleStatus = $articleStatus;
        }
        return $this->articleStatus;
    }

    public function getCategory(): ?Category
    {
        if ($this->category_id) {
            $category = $this->category->findOneById($this->category_id);
            $this->category = $category;
        }
        return $this->category;
    }
}
