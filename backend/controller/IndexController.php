<?php

namespace backend\controller;

class IndexController extends BaseController
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
