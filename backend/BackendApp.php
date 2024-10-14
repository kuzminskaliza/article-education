<?php

namespace backend;

use backend\view\BaseView;
use Exception;

class BackendApp
{
    private const string DEFAULT_CONTROLLER = 'index';
    private const string DEFAULT_ACTION = 'index';
    private const string CONTROLLER_NAMESPACE = 'backend\\controller\\';

    private array $config;
    private BaseView $view;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->view = new BaseView();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        try {
            // Отримання URI без GET параметрів
            $uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
            $uri = trim($uri, '/');

            // Розбиваємо URI на частини для контролера та методу
            $parts = explode('/', $uri);

            // Якщо контролер не вказано, використовуємо дефолтний
            $controllerName = self::CONTROLLER_NAMESPACE . ucfirst(!empty($parts[0]) ? $parts[0] : self::DEFAULT_CONTROLLER) . 'Controller';
            $actionName = 'action' . ucfirst($parts[1] ?? self::DEFAULT_ACTION);

            // Перевіряємо чи існує клас контролера
            if (!class_exists($controllerName)) {
                throw new Exception("Контролер $controllerName не знайдено");
            }

            $controller = new $controllerName();

            // Перевіряємо чи існує метод у контролері
            if (!method_exists($controller, $actionName)) {
                throw new Exception("Метод $actionName не знайдено у контролері $controllerName");
            }

            echo $this->view->renderTemplate($this->config['params']['template_file'], [
                'content' => $controller->$actionName(),
                'vendor_url' => $this->config['params']['vendor_url'] ?? '',
                'title' => null,
                'header' => null,
            ]);
        } catch (Exception $exception) {
            // Обробка помилки
            echo 'Помилка сервера: ' . $exception->getMessage();
        }
    }
}
