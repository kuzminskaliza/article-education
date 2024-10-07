<?php

namespace backend\controller;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}