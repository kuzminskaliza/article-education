<?php

namespace backend\model;

class Admin extends BaseModel
{
    protected ?string $name = null;
    protected int $id;
    protected ?string $email = null;
    protected ?string $password = null;
    protected ?string $confirm_password = null;
    protected ?string $old_password = null;
    protected ?string $photo = null;
    private bool $validateOnlyPhoto = false;
    private bool $validateOnlyEmailAndName = false;
    private bool $validateOnlyPassword = false;

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
            'photo'
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
        if ($this->validateOnlyPhoto) {
            return true;
        }


        if ($this->validateOnlyPassword) {
            $admin = self::getAuthAdmin();
            if ($admin->password !== $this->old_password) {
                $this->errors['old_password'] = 'The current password is incorrect.';
            }

            if (empty($this->password)) {
                $this->errors['new_password'] = 'Password is require';
            } elseif (strlen($this->password) < 3 || strlen($this->password) > 16) {
                $this->errors['new_password'] = 'Password must be between 3 and 16 characters long';
            }

            if ($this->password !== $this->confirm_password) {
                $this->errors['confirm_password'] = 'Password do not match';
            }
            return empty($this->errors);
        }

        if ($this->validateOnlyEmailAndName) {
            if (empty($this->name)) {
                $this->errors['name'] = 'Name is require';
            } elseif (strlen($this->name) > 25) {
                $this->errors['name'] = 'Name must be less than 25 characters';
            }

            if (empty($this->email)) {
                $this->errors['email'] = 'Email is require';
            } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Invalid email format';
            }
            return empty($this->errors);
        }

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
                $_SESSION['id'] = $admin->id;
                return true;
            }

            $this->errors['email'] = 'Email incorrect';
            $this->errors['password'] = 'Password incorrect';
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

    protected function setHashFieldsData(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }
        return $data;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function updateNameAndEmail(array $data): bool
    {
        $this->name = (string)$data['name'];
        $this->email = (string)$data['email'];

        $this->validateOnlyEmailAndName = true;
        if (!$this->validate()) {
            return false;
        }

        return $this->update(['name' => $this->name, 'email' => $this->email]);
    }

    public function uploadPhoto(array $file): bool
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $this->errors['file'] = 'File is not uploaded';
            return false;
        }

        $maxFileSize = 1024 * 1024 * 2;
        if ($file['size'] > $maxFileSize) {
            $this->errors['file'] = 'File is too large';
            return false;
        }

        $uploadDir = __DIR__ . '/../data/images';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $originalName = $file['name'];
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        $fileName = md5(uniqid('', true)) . '.' . $fileExtension;
        $uploadFile = $uploadDir . '/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $this->validateOnlyPhoto = true;
            if ($this->update(['photo' => $fileName])) {
                return true;
            }
        }
        $this->errors['file'] = 'Failed to upload file';
        return false;
    }

    public function getPhoto(): ?string
    {
        return '/data/images/'  . $this->photo;
    }

    public function updatePassword(array $data): bool
    {
        $this->password = (string)$data['new_password'];
        $this->confirm_password = (string)$data['confirm_password'];
        $this->old_password = md5((string)$data['old_password']);

        $this->validateOnlyPassword = true;

        return $this->update(['password' => $this->password]);
    }
}
