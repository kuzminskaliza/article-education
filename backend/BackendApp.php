<?php

namespace backend;

use backend\controller\AdminController;
use backend\model\Admin;
use backend\view\BaseView;
use Exception;
use PDO;
use PDOException;

class BackendApp
{
    private const string DEFAULT_CONTROLLER = 'index';
    private const string DEFAULT_ACTION = 'index';
    private const string CONTROLLER_NAMESPACE = 'backend\\controller\\';

    private array $config;
    private BaseView $view;
    public static PDO $pdo;

    /**
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        session_start();
        $this->config = $config;
        $this->view = new BaseView();
        $this->initDb();
    }

    /**
     * @throws Exception
     */
    private function initDb(): void
    {
        try {
            self::$pdo = new PDO($this->config['db']['dsn'], $this->config['db']['username'], $this->config['db']['password']);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $exception) {
            throw new Exception('Не вдалось підключитись до бази даних' . $exception->getMessage());
        }
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

            $admin = Admin::getAuthAdmin();
            if (!$admin && $controllerName !== AdminController::class) {
                $controller = new AdminController();
                $controller->redirect('/admin/login');
                return;
            }

            if ($admin && $controllerName === AdminController::class && $actionName !== 'actionLogout') {
                $controller = new AdminController();
                $controller->redirect('/index/index');
                return;
            }

            // Перевіряємо чи існує клас контролера
            if (!class_exists($controllerName)) {
                throw new Exception("Контролер $controllerName не знайдено");
            }

            $controller = new $controllerName();

            // Перевіряємо чи існує метод у контролері
            if (!method_exists($controller, $actionName)) {
                throw new Exception("Метод $actionName не знайдено у контролері $controllerName");
            }
            if ($admin) {
                echo $this->view->renderTemplate($this->config['params']['template_file'], [
                    'content' => $controller->$actionName(),
                    'vendor_url' => $this->config['params']['vendor_url'] ?? '',
                    'title' => null,
                    'header' => null,
                ]);
            } else {
                echo $this->view->renderTemplate($this->config['params']['template_form_register'], [
                    'content' => $controller->$actionName(),
                    'vendor_url' => $this->config['params']['vendor_url'] ?? '',
                ]);
            }
        } catch (Exception $exception) {
            $errorHtml = $this->view->renderTemplate($this->config['params']['template_error'], [
                'message' => 'Помилка сервера: ' . $exception->getMessage()
            ]);
            echo $this->view->renderTemplate($this->config['params']['template_file'], [
                'content' => $errorHtml,
                'vendor_url' => $this->config['params']['vendor_url'] ?? '',
                'title' => null,
                'header' => null,
            ]);
        }
    }
}
