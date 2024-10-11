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
            'articles' => $this->article->getAll()
        ]);
    }


    public function actionCreate(): string
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($this->article->create($_POST)) {
                $this->redirect('/article/index');
            }

        }

        return $this->render('create', [
            'article' => $this->article,

        ]);

    }

    public function actionUpdate(): string
    {
        $id = $_GET['id'];
        $article = $this->article->findId($id);


        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($article->update($id, $_POST)) {
                $this->redirect('/article/index');
            }
        }

        return $this->render('update', [
            'article' => $article,
        ]);
    }

    public function actionView(): string
    {
        $id = $_GET['id'];
        $article = $this->article->findId($id);

        return $this->render('view', [
            'article' => $article,
        ]);
    }

    public function actionDelete(): void
    {
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            if ($id && $this->article->deleteId($id)) {
                $this->redirect('/article/index');
            }
        }
    }

}