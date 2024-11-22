<?php

namespace backend\model;

class Article extends BaseModel
{
    public const int STATUS_NEW = 1;
    public const int STATUS_PUBLISHED = 2;
    public const int STATUS_UNPUBLISHED = 3;

    public const array STATUSES = [
        self::STATUS_NEW => 'New',
        self::STATUS_PUBLISHED => 'Published',
        self::STATUS_UNPUBLISHED => 'Unpublished',
    ];

    protected int $id;
    protected ?string $title = null;
    protected ?int $status = null;
    protected ?string $description = null;

    public function getTableName(): string
    {
        return 'article';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'title',
            'status',
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
