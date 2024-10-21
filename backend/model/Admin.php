<?php

namespace backend\model;

class Admin
{
    public const string FILE_PATH = __DIR__ . '/../../data/admin.json';

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
        if (!file_exists(self::FILE_PATH)) {
            file_put_contents(self::FILE_PATH, json_encode([]));
        }

        $jsonData = file_get_contents(self::FILE_PATH);
        $admins = json_decode($jsonData, true);

        $this->id = $this->generateNewId($admins);
        $this->name = (string)$data['name'];
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];
        $this->confirm_password = (string)$data['confirm_password'];

        if ($this->validateRegistration()) {
            $admins[] = [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'password' => md5($this->password)
            ];
            file_put_contents(self::FILE_PATH, json_encode($admins, JSON_PRETTY_PRINT));
            $_SESSION['id'] = $this->id;
            return true;
        }
        return false;
    }

    public function login(array $data): bool
    {
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];

        if (!file_exists(self::FILE_PATH)) {
            return false;
        }

        $jsonData = file_get_contents(self::FILE_PATH);
        $admins = json_decode($jsonData, true);

        if ($this->validateLogin()) {
            return false;
        }

        foreach ($admins as $admin) {
            if ($admin['email'] === $this->email && $admin['password'] === md5($this->password)) {
                $_SESSION['id'] = $admin['id'];
                return true;
            }
        }
        return false;
    }

    public static function getAuthAdmin(): ?Admin
    {
        if (!isset($_SESSION['id'])) {
            return null;
        }
        $id = $_SESSION['id'];

        $jsonData = file_get_contents(self::FILE_PATH);
        $dataArray = json_decode($jsonData, true);

        foreach ($dataArray as $data) {
            if ($data['id'] == $id) {
                $admin = new self();
                $admin->id = $data['id'];
                $admin->name = $data['name'] ?? '';
                $admin->email = $data['email'] ?? '';
                $admin->password = $data['password'] ?? '';
                return $admin;
            }
        }

        return null;
    }

    private function emailValidation(string $email): bool
    {
        $jsonData = file_get_contents(self::FILE_PATH);
        $admins = json_decode($jsonData, true);

        foreach ($admins as $admin) {
            if ($admin['email'] === $email) {
                return false;
            }
        }
        return true;
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

    public function validateLogin(): bool
    {
        $this->emailAndPassword();
        return empty($this->errors);
    }

    public function destroySession(): void
    {
        session_unset();
        session_destroy();
    }

    private function generateNewId(array $admins): int
    {
        if (empty($admins)) {
            return 1;
        }

        $maxId = max(array_column($admins, 'id'));
        return $maxId + 1;
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
