<?php

namespace backend\model\search;

use backend\model\Article;
use backend\model\QueryBuilder;

class ArticleSearch extends Article
{
    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (strlen($this->title) < 3 || strlen($this->title) > 255) {
            $this->errors['title'] = 'Title is required';
        }
        return true;
    }

    public function castAttributes(array $data): array
    {
        $data = array_map('trim', $data);
        if (array_key_exists('id', $data)) {
            if (empty($data['id'])) {
                unset($data['id']);
            } else {
                $data['id'] = (int)$data['id'];
            }
        }
        if (array_key_exists('status_id', $data)) {
            if (empty($data['status_id'])) {
                unset($data['status_id']);
            } else {
                $data['status_id'] = (int)$data['status_id'];
            }
        }
        return $data;
    }

    public function search(array $get): array
    {
        if (empty($get['ArticleSearch'])) {
            return $this->findAll();
        }
        $this->setAttributes($this->castAttributes($get['ArticleSearch']));
        if ($this->validate()) {
            $query = (new QueryBuilder($this->getTableName()))
                ->filterWhere([
                    'status_id' => $this->getStatusId(),
                    'id' => $this->getId(),
                ])
                ->andFilterWhere(['LIKE', ['title' => '%' . $this->getTitle() . '%']]);

            return $this->findByQueryBuilder($query);
        }

        return [];
    }
}
