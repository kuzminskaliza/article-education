<?php

namespace backend\controller;

use backend\view\BaseView;

class BaseController
{
    public function redirect(string $url, $code = 302): void
    {
        header('Location: ' . $url, true, $code);
    }

    public function render(string $viewName, array $params = []): string
    {
        $view = new BaseView();
        $controllerName = $this::class;
        $controllerName = explode('\\', $controllerName);
        $controllerName = str_replace('controller', '', strtolower(end($controllerName)));

        $viewFilePath = __DIR__ . '/../' . 'view/' . $controllerName . DIRECTORY_SEPARATOR . $viewName . '.php';

        if (file_exists($viewFilePath)) {
            return $view->renderTemplate($viewFilePath, $params);
        }

        return 'File not found --  ' . __DIR__;
    }
}
