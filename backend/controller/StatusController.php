<?php

namespace backend\controller;

use backend\model\ArticleStatus;
use Exception;

class StatusController extends BaseController
{
    private ArticleStatus $status;

    public function __construct()
    {
        $this->status = new ArticleStatus();
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
            'statuses' => $this->status->findAll(),
        ]);
    }

    public function actionCreate(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->status->insert($_POST)) {
                $this->redirect('/status/index');
            }
        }

        return $this->render('create', [
            'status' => $this->status,
        ]);
    }

    public function actionUpdate(): string
    {
        try {
            $status = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($status->update($_POST)) {
                $this->redirect('/status/index');
            }
        }


        return $this->render('update', [
            'status' => $status,
        ]);
    }

    public function actionDelete(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('error/405');
        }

        try {
            $status = $this->findModel();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => $exception->getMessage()]);
        }

        try {
            $status->delete();
        } catch (Exception $exception) {
            return $this->render('error/404', ['message' => 'Cannot delete status in use.']);
        }

        $this->redirect('/status/index');
        return '';
    }

    /**
     * @throws Exception
     */
    private function findModel(): ArticleStatus
    {
        $id = (int)$_GET['id'];
        if (!$id) {
            throw new Exception('Not found status');
        }

        $status = $this->status->findOneById($id);
        if (!$status) {
            throw new Exception('Not found status');
        }

        return $status;
    }
}
