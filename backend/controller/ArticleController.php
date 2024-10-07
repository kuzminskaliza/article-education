<?php

namespace backend\controller;

use backend\model\Article;

class ArticleController extends BaseController
{
    private Article $article;

    public function __construct()
    {
        $this->article = new Article();
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'articles' => $this->article->getAllArticle()
        ]);
    }
}