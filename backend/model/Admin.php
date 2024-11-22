<?php

namespace backend\model;

class Admin extends BaseModel
{
    protected ?string $name = null;
    protected int $id;
    protected ?string $email = null;
    protected ?string $password = null;
    protected ?string $confirm_password = null;

    public function getTableName(): string
    {
        return 'admin';
    }

    public function getAttributes(): array
    {
        return [
            'id',
            'email',
            'password',
            'name',
            'updated_at',
            'created_at',
        ];
    }

    public function register(array $data): bool
    {
        $result = $this->insert($data);
        if ($result) {
            $_SESSION['id'] = $this->id;
        }

        return $result;
    }

    public function validate(array $attributes = []): bool
    {
        if (!empty($attributes)) {
            if (in_array('password', $attributes)) {
                if (empty($this->password)) {
                    $this->errors['password'] = 'Password is require';
                } elseif (strlen($this->password) < 3 || strlen($this->password) > 16) {
                    $this->errors['password'] = 'Password must be between 3 and 16 characters long';
                }
            }

            if (in_array('email', $attributes)) {
                if (empty($this->email)) {
                    $this->errors['email'] = 'Email is require';
                } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $this->errors['email'] = 'Invalid email format';
                } elseif ($this->exist(['email' => $this->email])) {
                    $this->errors['email'] = 'Try a different email';
                }
            }

            return empty($this->errors);
        }

        if (empty($this->name)) {
            $this->errors['name'] = 'Name is require';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $this->name)) {
            $this->errors['name'] = 'Name can only contain letters';
        } elseif (strlen($this->name) > 25) {
            $this->errors['name'] = 'Name must be less than 25 characters';
        }

        if (empty($this->email)) {
            $this->errors['email'] = 'Email is require';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email format';
        } elseif ($this->exist(['email' => $this->email])) {
            $this->errors['email'] = 'Try a different email';
        }

        if (empty($this->password)) {
            $this->errors['password'] = 'Password is require';
        } elseif (strlen($this->password) < 3 || strlen($this->password) > 16) {
            $this->errors['password'] = 'Password must be between 3 and 16 characters long';
        }

        if ($this->password !== $this->confirm_password) {
            $this->errors['confirm_password'] = 'Password do not match';
        }
        return empty($this->errors);
    }

    public function login(array $data): bool
    {
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];

        if ($this->validate(['email', 'password'])) {
            $admin = $this->findOne([
                'email' => $this->email,
                'password' => md5($this->password),
            ]);

            if ($admin) {
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
        return (new self())->findOneById((int)$_SESSION['id']);
    }

    public function destroySession(): void
    {
        session_unset();
        session_destroy();
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
