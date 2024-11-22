<?php

namespace backend\controller;

use backend\model\Article;
use Exception;

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
            'articles' => $this->article->findAll()
        ]);
    }

    public function actionCreate(): string
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($this->article->insert($_POST)) {
                $this->redirect('/article/index');
            }
        }

        return $this->render('create', [
            'article' => $this->article,

        ]);
    }

    public function actionUpdate(): string
    {
        try {
            $article = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($article->update($_POST)) {
                $this->redirect('/article/index');
            }
        }

        return $this->render('update', [
            'article' => $article,
        ]);
    }

    public function actionView(): string
    {
        try {
            $article = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }

        return $this->render('view', [
            'article' => $article,
        ]);
    }

    public function actionDelete(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('error/405');
        }
        try {
            $article = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }

        $article->delete();
        $this->redirect('/article/index');
        return '';
    }

    /**
     * @throws Exception
     */
    private function findModel(): Article
    {
        $id = (int)$_GET['id'];
        if (!$id) {
            throw new Exception('Not found Article');
        }
        $article = $this->article->findOneById($id);
        if (!$article) {
            throw new Exception('Not found Article');
        }
        return $article;
    }
}
