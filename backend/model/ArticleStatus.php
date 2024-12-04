<?php
namespace backend\model;

use backend\BackendApp;

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

    public function getAllStatuses(): array
    {
        $statuses = [];
        $query = "SELECT * FROM " . $this->getTableName();
        $stmt = BackendApp::$pdo->query($query);
        $results = $stmt->fetchAll();

        foreach ($results as $row) {
            $statuses[$row['id']] = $row['title'];
        }
        return $statuses;
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
