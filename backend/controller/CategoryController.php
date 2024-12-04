<?php

namespace backend\controller;

use backend\model\Category;
use Exception;

class CategoryController extends BaseController
{
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
            'categories' => $this->category->findAll(),
        ]);
    }

    public function actionCreate(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->category->insert($_POST)) {
                $this->redirect('/category/index');
            }
        }

        return $this->render('create', [
            'category' => $this->category,
        ]);
    }

    public function actionUpdate(): string
    {
        try {
            $category = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($category->update($_POST)) {
                $this->redirect('/category/index');
            }
        }

        return $this->render('update', [
            'category' => $category,
        ]);
    }

    public function actionDelete(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('error/405');
        }

        try {
            $category = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }

        try {
            $category->delete();
        } catch (Exception $exception) {
            return $this->render('error/400', ['message' => 'Cannot delete category in use.']);
        }

        $this->redirect('/category/index');
        return '';
    }

    /**
     * @throws Exception
     */
    private function findModel(): Category
    {
        $id = (int)$_GET['id'];
        if (!$id) {
            throw new Exception('Not found category');
        }

        $category = $this->category->findOneById($id);
        if (!$category) {
            throw new Exception('Not found category');
        }

        return $category;
    }
}
