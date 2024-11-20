<?php

namespace console\controller;

class TestController
{
    public function actionIndex(array $params): void
    {
        echo "Це метод index у контролері Test\n";
        print_r($params); // Виведення параметрів
    }
}