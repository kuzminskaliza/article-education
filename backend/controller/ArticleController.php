<?php

namespace backend\controller;

use backend\model\Article;
use backend\model\Category;
use backend\model\search\ArticleSearch;
use Exception;

class ArticleController extends BaseController
{
    private Article $article;
    private Category $category;

    public function __construct()
    {
        $this->article = new Article();
        $this->category = new Category();
    }

    public function actionIndex(): string
    {
        $searchModel = new ArticleSearch();

        return $this->render('index', [
            'articles' => $searchModel->search($_GET),
            'searchModel' => $searchModel,
            'category' => $this->category
        ]);
    }

    public function actionCreate(): string
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($this->article->safeCreate($_POST)) {
                $this->redirect('/article/index');
            }
        }

        return $this->render('create', [
            'article' => $this->article,
            'category' => $this->category,
        ]);
    }

    public function actionUpdate(): string
    {
        try {
            $article = $this->findModel();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), self::NOT_FOUND);
        }
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($article->safeUpdate($_POST)) {
                $this->redirect('/article/index');
            }
        }

        return $this->render('update', [
            'article' => $article,
            'category' => $this->category,
        ]);
    }

    public function actionView(): string
    {
        try {
            $article = $this->findModel();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), self::NOT_FOUND);
        }

        return $this->render('view', [
            'article' => $article,
        ]);
    }

    public function actionDelete(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->error('Page not found', self::METHOD_NOT_ALLOWED);
        }
        try {
            $article = $this->findModel();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), self::NOT_FOUND);
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
