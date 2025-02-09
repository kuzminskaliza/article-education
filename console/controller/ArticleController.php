<?php

namespace console\controller;

use console\model\Article;
use Exception;

class ArticleController
{
    private Article $article;

    public function __construct()
    {
        $this->article = new Article();
    }

    public function actionAutoBlock(array $params): void
    {
        try {
            $articles = $this->article->findAll(['status_id' => 1]);
            foreach ($articles as $article) {
                if ($article->update(['status_id' => 3])) {
                    echo 'update success ' . $article->getId() . PHP_EOL;
                } else {
                    echo 'update fail ' . $article->getId() . PHP_EOL;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
