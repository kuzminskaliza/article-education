<?php

namespace backend\controller;

use backend\view\BaseView;
use Exception;

class BaseController
{
    protected const int NOT_FOUND = 404;
    protected const int METHOD_NOT_ALLOWED = 405;
    protected const int SERVER_ERROR = 500;

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

        throw new Exception('File not found --  ' . $viewFilePath);
    }

    public function error(string $message, int $code): string
    {
        $view = new BaseView();

        $viewFilePath = __DIR__ . '/../' . 'view/template/error/' . $code . '.php';
        if (file_exists($viewFilePath)) {
            return $view->renderTemplate($viewFilePath, ['message' => $message]);
        }

        throw new Exception('File not found --  ' . $viewFilePath);
    }
}
