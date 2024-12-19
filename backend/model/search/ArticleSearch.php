<?php

namespace backend\model\search;

use backend\model\Article;
use backend\model\QueryBuilder;

class ArticleSearch extends Article
{
    protected ?array $status_ids = [];
    protected ?string $category_name = null;

    public function validate(array $attributes = []): bool
    {
        $this->errors = [];
        if (!empty($this->getId()) && !is_numeric($this->getId())) {
            $this->errors['id'] = 'The ID must be a numeric value';
        }
        if (!empty($this->title) && strlen($this->title) < 3 || strlen($this->title) > 255) {
            $this->errors['title'] = 'The title must be between 3 and 255 characters';
        }
        if (!empty($this->category_name) && strlen($this->category_name) < 3) {
            $this->errors['category_name'] = 'The categories must be at leans 3 characters';
        }
        return true;
    }

    public function castAttributes(array $data): array
    {
        $data = array_map(static function ($item) {
            return is_string($item) ? trim($item) : $item;
        }, $data);

        if (array_key_exists('id', $data)) {
            if (empty($data['id'])) {
                unset($data['id']);
            } else {
                $data['id'] = (int)$data['id'];
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
            $builder = (new QueryBuilder($this->getTableName()))
                ->select(['distinct a.*'])
                ->alias('a')
                ->join('article_category ac', ['ac.article_id' => 'a.id'])
                ->join('category c', ['c.id' => 'ac.category_id'])
                ->filterWhere([
                    'a.id' => $this->getId(),
                    'a.status_id' => $this->getStatusIds(),
                    'ac.category_id' => $this->getCategoryIds(),
                    ['ILIKE', 'c.name', '%' . $this->getCategoryName() . '%'],
                ])
                ->orFilterWhere([
                    ['ILIKE', 'a.title', '%' . $this->getTitle() . '%'],
                    ['ILIKE', 'a.description', '%' . $this->getTitle() . '%']
               ]);
            return $this->findByQueryBuilder($builder);
        }

        return [];
    }

    public function getStatusIds(): ?array
    {
        return  $this->status_ids;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }
}
