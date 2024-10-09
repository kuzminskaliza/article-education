<?php

namespace backend\model;

class Article
{
    private mixed $id;
    private mixed $status;
    private mixed $title;
    private mixed $description;
    private const string FILE_PATH = 'data/data.json';


    public function getAllArticle(): array
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $data = json_decode($jsonData, true);
        return $data['articles'] ?? [];
    }

    private function validate(): array
    {
        $errors = [];

        if (empty($_POST['title'])) {
            $errors['title'] = 'Назва статті не має бути порожньою';
        } elseif (strlen($_POST['title']) < 3 || strlen($_POST['title']) > 255) {
            $errors['title'] = 'Назва має має бути від 3 до 255 символів';
        }

        if (empty($_POST['status'])) {
            $errors['status'] = 'Статус не має бути порожнім';
        } elseif ($_POST['status'] != 'published') {
            $errors['status'] = 'Неправильний статус';
        }

        if (empty($_POST['description'])) {
            $errors['description'] = 'Опис не має бути порожнім';
        } elseif (strlen($_POST['description']) < 10) {
            $errors['description'] = 'Опис має містити найменше 10 символів';
        }
        return $errors;
    }

    public function create(): array
    {
        $errors = $this->validate();

        if (empty($errors)) {
            $jsonData = file_get_contents(self::FILE_PATH);
            $dataArray = json_decode($jsonData, true);

            $newID = count($dataArray['articles']) + 1;

            $newArticle = [
                'id' => $newID,
                'title' => $_POST['title'],
                'status' => $_POST['status'],
                'description' => $_POST['description']
            ];

            $dataArray['articles'][] = $newArticle;

            file_put_contents(self::FILE_PATH, json_encode($dataArray));

            return ['success' => true, 'message' => 'Статтю створено'];
        }


        return ['success' => false, 'errors' => $errors];

    }

    public function update($id): array
    {
        $errors = $this->validate();

        if (empty($errors)) {
            $jsonData = file_get_contents(self::FILE_PATH);
            $dataArray = json_decode($jsonData, true);

            foreach ($dataArray['articles'] as $article) {
                if ($article['id'] == $id) {
                    $article['title'] = $_POST['title'];
                    $article['status'] = $_POST['status'];
                    $article['description'] = $_POST['description'];
                    break;
                }
            }

            file_put_contents(self::FILE_PATH, json_encode($dataArray));
            return ['success' => true, 'message' => 'Статтю оновленно'];
        }

        return ['success' => false, 'errors' => $errors];
    }

    public function getArticleId($id)
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        if (!$dataArray['articles']) {
            return null;
        }

        foreach ($dataArray['articles'] as $article) {
            if ($article['id'] === $id) {
                return $article;
            }
        }
        return null;
    }
}


