<?php

namespace console\controller;

class TestController
{
    public function actionIndex(array $params): void
    {
        echo "Це метод index у контролері Test\n";
        print_r($params); // Виведення параметрів
    }

    public function actionJis(array $params): void
    {
        echo "Це actionJis\n";
        print_r($params); // Виведення параметрів
    }
}