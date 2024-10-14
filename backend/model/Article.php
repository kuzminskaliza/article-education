<?php

namespace backend\model;

class Article
{
    public const string FILE_PATH = __DIR__ . '/../../data/article.json';
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
        if (!file_exists(self::FILE_PATH)) {
            return [];
        }
        $jsonData = file_get_contents(self::FILE_PATH);
        $arrayData = json_decode($jsonData, true);
        $collection = [];

        foreach ($arrayData as $data) {
            $article = new self();
            $article->id = (int)$data['id'];
            $article->status = (int)$data['status'];
            $article->title = (string)$data['title'];
            $article->description = (string)$data['description'];

            $collection[] = $article;
        }
        return $collection;
    }

    public function validate(): bool
    {
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

    public function create(array $data): bool
    {
        if (!file_exists(self::FILE_PATH)) {
            file_put_contents(self::FILE_PATH, json_encode([]));
        }

        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        $this->id = $this->generateNewId($dataArray);
        $this->status = (int)$data['status'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];
        if ($this->validate()) {
            $dataArray[] = [
                'id' => $this->id,
                'title' => $this->title,
                'status' => $this->status,
                'description' => $this->description,
            ];

            return boolval(file_put_contents(self::FILE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT)));
        }

        return false;
    }

    public function update(array $data): bool
    {
        $this->status = (int)$data['status'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];

        if ($this->validate()) {
            $jsonData = file_get_contents(self::FILE_PATH);
            $dataArray = json_decode($jsonData, true);

            foreach ($dataArray as &$data) {
                if ($data['id'] === $this->id) {
                    $data['status'] = $this->status;
                    $data['title'] = $this->title;
                    $data['description'] = $this->description;
                    break;
                }
            }

            return boolval(file_put_contents(self::FILE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT)));
        }

        return false;
    }

    private function generateNewId(array $dataArray): int
    {
        if (empty($dataArray)) {
            return 1;
        }

        $maxId = max(array_column($dataArray, 'id'));
        return $maxId + 1;
    }

    public function findId(int $id): ?Article
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        foreach ($dataArray as $data) {
            if ($data['id'] == $id) {
                $article = new self();
                $article->id = $data['id'];
                $article->status = $data['status'];
                $article->title = $data['title'];
                $article->description = $data['description'];
                return $article;
            }
        }
        return null;
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

    public function delete(): bool
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        foreach ($dataArray as $index => $data) {
            if ($data['id'] == $this->id) {
                unset($dataArray[$index]);
                $dataArray = array_values($dataArray);

                return boolval(file_put_contents(self::FILE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT)));
            }
        }
        return false;
    }
}
