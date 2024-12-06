<?php

namespace console;

use Exception;
use PDO;

class ConsoleApp
{
    private array $config;
    public static PDO $pdo;

    /**
     * Конструктор для налаштування підключення до бази даних та ініціалізації додатку.
     *
     * @param array $config Конфігурація додатку.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $dsn = $this->config['db']['dsn'] ?? null;
        $user = $this->config['db']['username'] ?? null;
        $password = $this->config['db']['password'] ?? null;
        self::$pdo = new PDO($dsn, $user, $password);
    }

    /**
     * Виконує команду, передану через аргументи командного рядка.
     *
     * @param array $arguments Масив аргументів командного рядка.
     * @throws Exception
     */
    public function runCommand(array $arguments): void
    {
        // Перша частина аргументу - це команда або контролер/метод
        $command = $arguments[0];
        $params = array_slice($arguments, 1);

        // Обробка команди у форматі "контролер/метод"
        if (strpos($command, '/') !== false) {
            // Формат контролер/метод
            [$controllerName, $actionName] = explode('/', $command);
            $controllerClass = "console\\controller\\" . ucfirst($controllerName) . 'Controller';
            $actionMethod = 'action' . ucfirst($actionName);

            if (!class_exists($controllerClass)) {
                throw new Exception("Консольний контролер $controllerClass не знайдено");
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $actionMethod)) {
                throw new Exception("Метод $actionMethod не знайдено у контролері $controllerClass");
            }

            // Виклик методу контролера з передачею параметрів
            $controller->$actionMethod($params);
        } else {
            // Виконання звичайних команд, таких як "migrate"
            $this->executeCommand($command, $params);
        }
    }

    /**
     * Виконує специфічні команди, такі як "migrate".
     *
     * @param string $command Назва команди.
     * @param array $params Параметри для команди.
     * @throws Exception
     */
    private function executeCommand(string $command, array $params): void
    {
        switch ($command) {
            case 'migrate-up':
                $this->migrateUp();
                break;
            case 'migrate-down':
                $this->migrateDown($params[0] ?? '');
                break;
            case 'migrate-create':
                $this->migrateCreate($params[0] ?? '');
                break;
            default:
                throw new Exception("Команда $command не знайдена");
        }
    }

    /**
     * Метод для запуску міграцій.
     */
    private function migrateUp(): void
    {
        echo "Запуск міграцій... \n";

        // Пошук всіх файлів міграцій
        $migrationFiles = glob(__DIR__ . '/migration/*.php');
        $executedMigrations = $this->getExecutedMigrations();

        foreach ($migrationFiles as $file) {
            $migrationClass = basename($file, '.php');

            if (in_array($migrationClass, $executedMigrations)) {
                continue; // Пропускаємо вже виконані міграції
            }

            require_once $file;
            if (!class_exists($migrationClass)) {
                echo "Клас $migrationClass не знайдено у файлі $file\n";
                continue;
            }

            $migration = new $migrationClass();
            if (method_exists($migration, 'up')) {
                $migration->up();
                $this->saveMigration($migrationClass);
                echo "Міграція $migrationClass виконана.\n";
            }
        }
    }

    /**
     * Метод для скасування міграцій.
     */
    private function migrateDown(string $migrationName): void
    {
        echo "Реверт міграцій... \n";

        if (is_numeric($migrationName)) {
            $count = (int)$migrationName;
            $executedMigrations = $this->getExecutedMigrations(['count' => $count]);
        } elseif (empty($migrationName)) {
            $executedMigrations = $this->getExecutedMigrations(['count' => 1]);
        } else {
            $executedMigrations = $this->getExecutedMigrations(['version' => $migrationName]);
        }

        if (empty($executedMigrations)) {
            echo "Немає міграцій для реверту.\n";
            return;
        }

        foreach ($executedMigrations as $migrationClass) {
            $migrationFile = __DIR__ . "/migration/{$migrationClass}.php";

            if (!file_exists($migrationFile)) {
                echo "Файл для міграції $migrationClass не знайдено.\n";
                continue;
            }

            require_once $migrationFile;
            if (!class_exists($migrationClass)) {
                echo "Клас $migrationClass не знайдено у файлі $migrationFile\n";
                continue;
            }

            $migration = new $migrationClass();
            if (method_exists($migration, 'down')) {
                $migration->down();
                $this->removeMigration($migrationClass);
            } else {
                echo "Метод 'down' відсутній у міграції $migrationClass.\n";
            }
        }
    }

    /**
     * Метод для створення нової міграції.
     */
    private function migrateCreate(string $migrationName): void
    {
        echo "Створення нової міграції... \n";

        // Генерація імені файлу міграції
        $timestamp = date('YmdHis');
        $className = 'm' . $timestamp . '_' . strtolower($migrationName);
        $fileName = __DIR__ . "/migration/{$className}.php";

        // Шаблон коду для нової міграції
        $template = <<<PHP
<?php

use console\ConsoleApp;

class {$className}
{
    public function up(): void
    {
        // Код для застосування міграції
    }

    public function down(): void
    {
        // Код для скасування міграції
    }
}
PHP;

        // Створення файлу міграції
        if (file_put_contents($fileName, $template) !== false) {
            echo "Міграція {$className} створена у файлі {$fileName}.\n";
        } else {
            echo "Помилка при створенні файлу міграції.\n";
        }
    }


    /**
     * Отримує список виконаних міграцій з бази даних.
     *
     * @return array Список виконаних міграцій.
     */
    private function getExecutedMigrations(array $options = []): array
    {
        $migrations = [];
        $stmt = self::$pdo->prepare("
            SELECT EXISTS (
                SELECT 1
                FROM information_schema.tables
                WHERE table_schema = 'public'
                AND table_name = :table_name
            );
        ");

        $stmt->execute(['table_name' => 'migration']);

        if ($stmt->fetchColumn()) {
            // Базовий SQL-запит
            $query = "SELECT version FROM migration";

            // Динамічне додавання умов WHERE
            $conditions = [];
            $params = [];
            if (isset($options['version'])) {
                $conditions[] = "version = :version";
                $params['version'] = $options['version'];
            }
            if (isset($options['count']) && is_int($options['count'])) {
                $params['count'] = $options['count'];
            }

            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            if (!empty($options)) {
                // Додаємо сортування
                $query .= " ORDER BY created_at DESC";
            }

            // Додаємо обмеження кількості
            if (isset($options['count']) && is_int($options['count'])) {
                $query .= " LIMIT :count";
            }

            $stmt = self::$pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }

            $stmt->execute();
            $migrations = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        return $migrations;
    }

    /**
     * Зберігає інформацію про виконану міграцію в базі даних.
     *
     * @param string $migration Назва міграції.
     */
    private function saveMigration(string $migration): void
    {
        $query = "INSERT INTO migration (version) VALUES (:version)";
        $statement = self::$pdo->prepare($query);
        $statement->execute(['version' => $migration]);
    }


    /**
     * Видаляє запис про виконану міграцію з таблиці `migration`.
     *
     * @param string $migrationClass Назва міграції.
     * @return void
     */
    private function removeMigration(string $migrationClass): void
    {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM migration WHERE version = :version");
            $stmt->execute(['version' => $migrationClass]);

            if ($stmt->rowCount() > 0) {
                echo "Міграція {$migrationClass} успішно видалена з таблиці `migration`.\n";
            } else {
                echo "Міграція {$migrationClass} не знайдена у таблиці `migration`.\n";
            }
        } catch (\PDOException $e) {
            echo "Помилка при видаленні міграції {$migrationClass}: " . $e->getMessage() . "\n";
        }
    }
}