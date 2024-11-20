<?php

namespace backend\model;

use backend\BackendApp;
use PDO;

class Article
{
    public const int STATUS_NEW = 1;
    public const int STATUS_PUBLISHED = 2;
    public const int STATUS_UNPUBLISHED = 3;

    public const array STATUSES = [
        self::STATUS_NEW => 'New',
        self::STATUS_PUBLISHED => 'Published',
        self::STATUS_UNPUBLISHED => 'Unpublished',
    ];

    private int $id;
    private ?string $title;
    private ?int $status;
    private ?string $description;
    private array $errors = [];

    public function __construct()
    {
        $this->title = $this->status = $this->description = null;
    }

    public function getAll(): array
    {
        $stmt = BackendApp::getDb()->query('SELECT * FROM articles');
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $collection = [];
        foreach ($articles as $data) {
            $article = new self();
            $article->id = (int)$data['id'];
            $article->status = (int)$data['status'];
            $article->title = (string)$data['title'];
            $article->description = (string)$data['description'];

            $collection[] = $article;
        }
        return $collection;
    }

    public function create(array $data): bool
    {
        $this->status = (int)$data['status'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];

        if ($this->validate()) {
            $stmt = BackendApp::getDb()->prepare('INSERT INTO articles (title, status, description) VALUES (:title, :status, :description)');
            return $stmt->execute([
                ':title' => $this->title,
                ':status' => $this->status,
                ':description' => $this->description,]);
        }
        return false;
    }

    public function update(array $data): bool
    {
        $this->status = (int)$data['status'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];

        if ($this->validate()) {
            $stmt = BackendApp::getDb()->prepare('UPDATE articles SET title = :title, status = :status, description = :description WHERE id = :id');
            return $stmt->execute([
                ':id' => $this->id,
                ':title' => $this->title,
                ':status' => $this->status,
                ':description' => $this->description
            ]);
        }
        return false;
    }

    public function delete(): bool
    {
        $stmt = BackendApp::getDb()->prepare('DELETE FROM articles WHERE id = :id');
        return $stmt->execute([':id' => $this->id]);
    }

    public function findId(int $id): ?Article
    {
        $stmt = BackendApp::getDb()->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $article = new self();
            $article->id = $data['id'];
            $article->status = $data['status'];
            $article->title = $data['title'];
            $article->description = $data['description'];
            return $article;
        }
        return null;
    }

    public function validate(): bool
    {
        $this->errors = [];
        if (strlen($this->title) < 3 || strlen($this->title) > 255) {
            $this->errors['title'] = 'Title is required';
        }

        if (empty($this->status)) {
            $this->errors['status'] = 'Select a status';
        } else {
            if (!array_key_exists($this->status, self::STATUSES)) {
                $this->errors['status'] = 'Incorrect status';
            }
        }
        if (empty($this->description)) {
            $this->errors['description'] = 'Description is required';
        }
        return empty($this->errors);
    }

    public function getError(string $attribute): ?string
    {
        return $this->errors[$attribute] ?? null;
    }

    public function hasError(string $attribute): bool
    {
        return array_key_exists($attribute, $this->errors);
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

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
