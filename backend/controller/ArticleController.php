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

    public function actionIndex(): string
    {
        return $this->render('index', [
            'articles' => $this->article->getAllArticle()
        ]);
    }

    public function actionCreate(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->article->create();

            if ($result['success']) {
                return $this->render('success', ['message' => $result['message']]);
            } else {
                return $this->render('create', ['errors' => $result['errors']]);
            }
        }

        return $this->render('create');
    }

    public function actionUpdate($id): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->article->update($id);

            if ($result['success']) {
                return $this->render('success', ['message' => $result['message']]);
            } else {
                return $this->render('create', ['errors' => $result['errors']]);
            }
        }

        return $this->render('create');
    }

}

