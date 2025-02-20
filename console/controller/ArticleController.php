<?php

namespace console\controller;

class ArticleController
{
    public function actionAutoBlock(array $params): void
    {
        echo "Це метод index у контролері Test\n";
        print_r($params); // Виведення параметрів
    }
}
