<?php

namespace console\model;

class Article extends BaseModel
{
    protected ?int $id;
    protected ?string $title = null;
    protected ?int $status_id = null;
    protected ?string $description = null;

    public ?ArticleStatus $articleStatus;

    public function __construct()
    {
        parent::__construct();

        $this->articleStatus = new ArticleStatus();
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
}
