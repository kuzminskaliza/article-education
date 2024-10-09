<?php

namespace backend\controller;

use backend\model\Market;

class MarketController extends BaseController
{

    private $market;
    public function __construct()
    {
        $this->market = new Market();
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'markets' => $this->market->getAll()
        ]);
    }

    public function actionCreate()
    {

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($this->market->create($_POST)) {
                $this->redirect('/market/index');
            }
        }

        return $this->render('create', [
            'market' => $this->market,
        ]);
    }

    public function actionUpdate()
    {

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            if ($this->market->update($_GET['id'], $_POST)) {
                $this->redirect('/market/index');
            }
        }

        return $this->render('update', [

        ]);
    }

    public function actionDelete()
    {
        return $this->render('delete', [

        ]);
    }

    public function actionView()
    {
        return $this->render('view', [

        ]);
    }
}