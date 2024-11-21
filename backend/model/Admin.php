<?php

namespace backend\model;

use backend\BackendApp;
use PDO;

class Admin
{
    private ?string $name;
    private int $id;
    private ?string $email;
    private ?string $password;
    private ?string $confirm_password;
    private array $errors = [];

    public function __construct()
    {
        $this->name = $this->email = $this->password = $this->confirm_password = null;
    }

    public function register(array $data): bool
    {
        $this->name = (string)$data['name'];
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];
        $this->confirm_password = (string)$data['confirm_password'];

        if ($this->validateRegistration()) {
            $stmt = BackendApp::$pdo->prepare('INSERT INTO admin (name, email, password) VALUES (:name, :email, :password) RETURNING id');
            $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => md5($this->password)
            ]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = (int)$admin['id'];
            $_SESSION['id'] = $this->id;
            return true;
        }
        return false;
    }

    public function login(array $data): bool
    {
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];

        $stmt = BackendApp::$pdo->prepare('SELECT id FROM admin WHERE email = :email AND password = :password LIMIT 1');
        $stmt->execute([':email' => $this->email, ':password' => md5($this->password)]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin) {
            $_SESSION['id'] = $admin['id'];
            return true;
        }
        $this->errors['login'] = 'Invalid email or password';
        return false;
    }

    public static function getAuthAdmin(): ?Admin
    {
        if (!isset($_SESSION['id'])) {
            return null;
        }
        $id = $_SESSION['id'];

        $stmt = BackendApp::$pdo->prepare('SELECT * FROM admin WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($adminData) {
            $admin = new self();
            $admin->id = $adminData['id'];
            $admin->name = $adminData['name'];
            $admin->email = $adminData['email'];
            return $admin;
        }
        return null;
    }

    private function emailValidation(string $email): bool
    {
        $stmt = BackendApp::$pdo->prepare('SELECT EXISTS(SELECT 1 FROM admin WHERE email = :email) ');
        $stmt->execute([':email' => $email]);
        return (bool)$stmt->fetchColumn();
    }

    private function emailAndPassword(): void
    {
        if (empty($this->email)) {
            $this->errors['email'] = 'Email is require';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email format';
        } elseif (!$this->emailValidation($this->email)) {
            $this->errors['email'] = 'Try a different email';
        }

        if (empty($this->password)) {
            $this->errors['password'] = 'Password is require';
        } elseif (strlen($this->password) < 3 || strlen($this->password) > 16) {
            $this->errors['password'] = 'Password must be between 3 and 16 characters long';
        }
    }

    public function validateRegistration(): bool
    {
        if (empty($this->name)) {
            $this->errors['name'] = 'Name is require';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $this->name)) {
            $this->errors['name'] = 'Name can only contain letters';
        } elseif (strlen($this->name) > 25) {
            $this->errors['name'] = 'Name must be less than 25 characters';
        }

        $this->emailAndPassword();

        if ($this->password !== $this->confirm_password) {
            $this->errors['confirm_password'] = 'Password do not match';
        }
        return empty($this->errors);
    }

    public function destroySession(): void
    {
        session_unset();
        session_destroy();
    }

    public function getError(string $attribute): ?string
    {
        return $this->errors[$attribute] ?? null;
    }

    public function hasError(string $attribute): bool
    {
        return array_key_exists($attribute, $this->errors);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
