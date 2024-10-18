<?php

namespace backend\controller;

use backend\model\Admin;

class AdminController extends BaseController
{
    private Admin $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }

    public function actionLogin(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->admin->login($_POST)) {
                $this->redirect('/article/index');
            }
        }
        return $this->render('login', [
            'admin' => $this->admin
        ]);
    }

    public function actionRegister(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->admin->register($_POST)) {
                $this->redirect('/article/index');
            }
        }
        return $this->render('register', [
            'admin' => $this->admin
        ]);
    }

    public function actionLogout(): void
    {
        $this->admin->destroySession();
        $this->redirect('/admin/login');
    }
}
