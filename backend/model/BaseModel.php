<?php

namespace backend\model;

use backend\BackendApp;
use PDO;

abstract class BaseModel implements ORMInterface, QueryBuilderInterface
{
    protected PDO $pdo;
    protected array $errors = [];

    abstract public function getTableName(): string;

    abstract public function getAttributes(): array;

    protected function primaryKey(): string|array
    {
        return 'id';
    }

    public function __construct()
    {
        $this->pdo = BackendApp::$pdo;
    }

    public function insert(array $data): bool
    {
        $result = true;
        $this->setAttributes($data);
        if ($this->validate()) {
            $data = $this->setHashFieldsData($data);
            $dbColumns = array_intersect(array_keys($data), $this->getAttributes());
            $columns = implode(', ', $dbColumns);
            $placeholders = implode(', ', array_map(static fn($col) => ":$col", $dbColumns)); // використовуємо плейсхолдери
            $query = "INSERT INTO {$this->getTableName()} ( $columns ) VALUES ( $placeholders )";
            if (is_string($this->primaryKey())) {
                $query .= "RETURNING {$this->primaryKey()}";
            }
            $stmt = $this->pdo->prepare($query);
            // Підставляємо значення за допомогою асоціативного масиву
            $params = array_combine(array_map(static fn($col) => ":$col", $dbColumns), array_map(static fn($col) => $data[$col], $dbColumns));
            $stmt->execute($params);
            $entity = $stmt->fetch(PDO::FETCH_ASSOC);

            if (
                is_string($this->primaryKey())
                && property_exists($this, $this->primaryKey())
                && !empty($entity[$this->primaryKey()])
            ) {
                $this->{$this->primaryKey()} = $entity[$this->primaryKey()];
            }
        } else {
            $result = false;
        }

        return $result;
    }

    protected function setAttributes(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function validate(array $attributes = []): bool
    {
        return true;
    }

    public function update(array $data): bool
    {
        $result = true;
        $this->setAttributes($data);

        if ($this->validate()) {
            $data = $this->setHashFieldsData($data);
            // Фільтруємо атрибути, які можна оновити в базі даних
            $dbColumns = array_intersect(array_keys($data), $this->getAttributes());

            // Формуємо частини запиту: "name = :name, email = :email, ..."
            $setClauses = implode(', ', array_map(static fn($col) => "$col = :$col", $dbColumns));

            // Створюємо SQL-запит з плейсхолдерами
            $query = "UPDATE {$this->getTableName()} SET $setClauses WHERE {$this->primaryKey()} = :primaryKey";
            $stmt = $this->pdo->prepare($query);

            // Підставляємо значення за допомогою асоціативного масиву
            $params = array_combine(array_map(static fn($col) => ":$col", $dbColumns), array_map(static fn($col) => $data[$col], $dbColumns));

            // Додаємо значення для первинного ключа
            $params[':primaryKey'] = $this->{$this->primaryKey()};

            // Виконуємо запит
            $stmt->execute($params);

            // Перевіряємо, чи був успішним запит
            if ($stmt->rowCount() === 0) {
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    public function delete(): bool
    {
        $primaryKey = $this->primaryKey();
        $stmt = BackendApp::$pdo->prepare("DELETE FROM {$this->getTableName()} WHERE $primaryKey = :$primaryKey");
        return $stmt->execute([":$primaryKey" => $this->$primaryKey]);
    }

    public function deleteAll(array $attributes = []): bool
    {
        if (empty($attributes)) {
            $primaryKey = $this->primaryKey();
            if (is_array($primaryKey)) {
                $conditions = [];
                $params = [];
                foreach ($primaryKey as $key) {
                    $conditions[] = "$key = :$key";
                    $params[":$key"] = $this->$key;
                }
                $whereClause = implode(' AND ', $conditions);
            } else {
                $whereClause = "$primaryKey = :$primaryKey";
                $params = [":$primaryKey" => $this->$primaryKey];
            }
        } else {
            $conditions = [];
            $params = [];
            foreach ($attributes as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $whereClause = implode(' AND ', $conditions);
        }
        $stmt = BackendApp::$pdo->prepare("DELETE FROM {$this->getTableName()} WHERE $whereClause");
        return $stmt->execute($params);
    }

    public function getError(string $attribute): ?string
    {
        return $this->errors[$attribute] ?? null;
    }

    public function hasError(string $attribute): bool
    {
        return array_key_exists($attribute, $this->errors);
    }

    public function findOneById(int $id): ?object
    {
        $query = "SELECT * FROM {$this->getTableName()} WHERE {$this->primaryKey()} = :id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $filteredResult = array_intersect_key($result, array_combine($this->getAttributes(), $this->getAttributes()));
            $this->setAttributes($filteredResult);
            return $this;
        }

        return null;
    }

    /**
     * @param array $conditions
     * @return object|$this
     */
    public function findOne(array $conditions): ?object
    {
        $validConditions = array_intersect_key($conditions, array_combine($this->getAttributes(), $this->getAttributes()));
        $whereClause = implode(' AND ', array_map(static fn($col) => "$col = :$col", array_keys($validConditions)));

        $query = "SELECT * FROM {$this->getTableName()} WHERE $whereClause LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_combine(array_map(static fn($col) => ":$col", array_keys($validConditions)), array_values($validConditions)));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $filteredResult = array_intersect_key($result, array_combine($this->getAttributes(), $this->getAttributes()));
            $this->setAttributes($filteredResult);
            return $this;
        }

        return null;
    }

    /**
     * @param array $conditions
     * @return array|object[]|static[]
     */
    public function findAll(array $conditions = []): array
    {
        $validConditions = array_intersect_key($conditions, array_combine($this->getAttributes(), $this->getAttributes()));
        $whereClause = implode(' AND ', array_map(static fn($col) => "$col = :$col", array_keys($validConditions)));

        $query = "SELECT * FROM {$this->getTableName()}";
        if (!empty($whereClause)) {
            $query .= " WHERE $whereClause";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_combine(array_map(static fn($col) => ":$col", array_keys($validConditions)), array_values($validConditions)));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $objects = [];
        foreach ($results as $result) {
            $filteredResult = array_intersect_key($result, array_combine($this->getAttributes(), $this->getAttributes()));
            $object = new static();
            $object->setAttributes($filteredResult);
            $objects[] = $object;
        }

        return $objects;
    }

    public function exist(array $conditions): bool
    {
        $where = array_map(static fn($key) => "$key = :$key", array_keys($conditions));
        $whereSql = implode(' AND ', $where);
        $query = "SELECT EXISTS(SELECT 1 FROM {$this->getTableName()} WHERE $whereSql LIMIT 1)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($conditions);

        return (bool)$stmt->fetchColumn();
    }

    protected function setHashFieldsData(array $data): array
    {
        return $data;
    }

    public function findByQueryBuilder(QueryBuilder $builder): array
    {
        $query = $builder->build();
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($builder->getParams());
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $objects = [];
        foreach ($results as $result) {
            $filteredResult = array_intersect_key($result, array_combine($this->getAttributes(), $this->getAttributes()));
            $object = new static();
            $object->setAttributes($filteredResult);
            $objects[] = $object;
        }

        return $objects;
    }
}
