<?php

namespace backend\controller;

class ArticleController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}