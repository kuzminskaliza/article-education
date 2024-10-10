<?php

namespace backend\model;

class Article
{
    const  FILE_PATH = __DIR__ . '/../../data/article.json';
    private $id;
    private $title;
    private $status;
    private $description;
    private $errors = [];

    public function getAll(): array
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $arrayData = json_decode($jsonData, true);
        $collection = [];

        foreach ($arrayData as $data) {
            $article = new self();
            $article->id = $data['id'];
            $article->status = $data['status'];
            $article->title = $data['title'];
            $article->description = $data['description'];

            $collection[] = $article;
        }

        return $collection;

    }

    public function validate(): bool
    {
        if (strlen($this->title) < 3 || strlen($this->title) > 255) {
            $this->errors['title'] = 'Назва має бути від 3 до 255 символів';
        }
        if (empty($this->status)) {
            $this->errors['status'] = 'Оберіть статус';
        }
        if (empty($this->description)) {
            $this->errors['description'] = 'Опис не може бути порожнім';
        }

        return empty($this->errors);
    }

    public function create(array $data): bool
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        $this->id = $this->generateNewId($dataArray);
        $this->status = $data['status'];
        $this->title = $data['title'];
        $this->description = $data['description'];

        if ($this->validate()) {

            $dataArray[] = [
                'id' => $this->id,
                'title' => $this->title,
                'status' => $this->status,
                'description' => $this->description,
            ];

            file_put_contents(self::FILE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT));
            return true;
        }

        return false;
    }

    public function update($id, $data): bool
    {

        $this->status = $data['status'];
        $this->title = $data['title'];
        $this->description = $data['description'];


        return $this->validate() && $this->save();
    }

    private function generateNewId(array $dataArray): int
    {
        if (empty($dataArray)) {
            return 1;
        }

        $maxId = max(array_column($dataArray, 'id'));
        return $maxId + 1;
    }


    public function save(): bool
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        foreach ($dataArray as &$data) {
            if ($data['id'] == $this->id) {
                $data['status'] = $this->status;
                $data['title'] = $this->title;
                $data['description'] = $this->description;
                break;
            }
        }

        file_put_contents(self::FILE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT));

        return true;
    }

    public function findId($id): ?Article
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

    public function getId()
    {
        return $this->id;
    }

    public function getError($attribute)
    {
        return $this->errors[$attribute];
    }

    public function hasError($attribute): bool
    {
        return array_key_exists($attribute, $this->errors);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getStatus()
    {
        return $this->status;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function deleteId($id): bool
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);


        foreach ($dataArray as $index => $data) {
            if ($data['id'] == $id) {
                unset($dataArray[$index]);
                $dataArray = array_values($dataArray);

                file_put_contents(self::FILE_PATH, json_encode($dataArray, JSON_PRETTY_PRINT));
                return true;
            }
        }

        return false;
    }

}