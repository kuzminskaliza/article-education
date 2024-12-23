<?php

namespace backend\model;

use Exception;

class Article extends BaseModel
{
    protected ?int $id;
    protected ?string $title = null;
    protected ?int $status_id = null;
    protected array $category_ids = [];
    protected ?string $description = null;

    public ?ArticleStatus $articleStatus;
    public ?Category $category;
    protected ?ArticleCategory $articleCategory;

    public function __construct()
    {
        parent::__construct();

        $this->articleStatus = new ArticleStatus();
        $this->category = new Category();
        $this->articleCategory = new ArticleCategory();
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

        if (empty($this->category_ids)) {
            $this->errors['category_ids'] = 'At least one category must be selected';
        } else {
            $categories = $this->category->findAll();
            $categoryIds = array_map(static fn($category) => $category->getId(), $categories);

            foreach ($this->category_ids as $categoryId) {
                if (!in_array($categoryId, $categoryIds)) {
                    $this->errors['category_ids'][] = 'Invalid category selected';
                }
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

    /**
     * @return array|ArticleCategory[]
     */

    public function getCategories(): array
    {
        return $this->articleCategory->findAll(['article_id' => $this->getId()]);
    }

    public function safeCreate(array $post): bool
    {
        $this->setAttributes($post);
        if ($this->validate()) {
            try {
                $this->pdo->beginTransaction();
                $this->insert($post);
                foreach ($this->getCategoryIds() as $categoryId) {
                    $articleCategory = new ArticleCategory();
                    $articleCategory->insert(['article_id' => $this->getId(), 'category_id' => $categoryId]);
                }
                $this->pdo->commit();
            } catch (Exception $exception) {
                $this->pdo->rollBack();
                $this->errors['category_ids'] = $exception->getMessage();
                return false;
            }
            return true;
        }
        return false;
    }

    public function safeUpdate(array $post): bool
    {
        $this->setAttributes($post);

        if ($this->validate()) {
            try {
                $this->pdo->beginTransaction();
                $this->update($post);
                $articleCategory = new ArticleCategory();
                $currentCategories = $articleCategory->findAll(['article_id' => $this->getId()]);

                $currentCategoryIds = array_map(static fn($categoryItem) => $categoryItem->getCategoryId(), $currentCategories);
                $newCategoryIds = $this->getCategoryIds();

                $categoriesToDelete = array_diff($currentCategoryIds, $newCategoryIds);
                foreach ($categoriesToDelete as $categoryId) {
                    $articleCategory->deleteAll(['article_id' => $this->getId(), 'category_id' => $categoryId]);
                }
                $categoriesToAdd = array_diff($newCategoryIds, $currentCategoryIds);
                foreach ($categoriesToAdd as $categoryId) {
                    $articleCategory->insert(['article_id' => $this->getId(), 'category_id' => $categoryId]);
                }

                $this->pdo->commit();
            } catch (Exception $exception) {
                $this->pdo->rollBack();
                $this->errors['category_ids'] = $exception->getMessage();
                return false;
            }
            return true;
        }
        return false;
    }

    public function getCategoryIds(): array
    {
        return $this->category_ids;
    }
}
