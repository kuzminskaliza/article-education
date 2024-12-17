<?php

namespace backend\model;

/**
 * @example Класс для роботи з білдером, не дуже правильний!!!
 * Class QueryBuilder
 */
class QueryBuilder
{
    protected string $table;
    protected string $alias = '';
    protected array $select = ['*'];
    protected array $joins = [];
    protected array $where = [];
    protected array $groupBy = [];
    protected array $orderBy = [];
    protected ?int $limit = null;
    protected array $params = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function alias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    public function select(array $columns): self
    {
        $this->select = $columns;
        return $this;
    }

    public function join(string $table, array $on, string $type = 'INNER'): self
    {
        $conditions = [];
        foreach ($on as $column1 => $column2) {
            $conditions[] = "$column1 = $column2";
        }
        $this->joins[] = strtoupper($type) . " JOIN $table ON " . implode(' AND ', $conditions);
        return $this;
    }

    public function where(array|string $condition): self
    {
        $this->where[] = ['', $condition];
        return $this;
    }

    public function andWhere(array|string $condition): self
    {
        $this->where[] = ['AND', $condition];
        return $this;
    }

    public function orWhere(array|string $condition): self
    {
        $this->where[] = ['OR', $condition];
        return $this;
    }

    public function andFilterWhere(array $condition): self
    {
        foreach ($condition as $column => $value) {
            if (is_string($column)) {
                if ($value !== null && $value !== '') {
                    $this->andWhere([$column => $value]);
                }
            }
        }
        return $this;
    }

    public function filterWhere(array $condition): self
    {
        foreach ($condition as $column => $value) {
            if (is_string($column)) {
                if ($value !== null && $value !== '') {
                    $this->where([$column => $value]);
                }
            }
        }
        return $this;
    }

    public function groupBy(array $columns): self
    {
        $this->groupBy = $columns;
        return $this;
    }

    public function orderBy(array $columns): self
    {
        $this->orderBy = $columns;
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function build(): string
    {
        $query = 'SELECT ' . implode(', ', $this->select)
            . ' FROM ' . $this->table;

        if ($this->alias) {
            $query .= ' AS ' . $this->alias;
        }

        if (!empty($this->joins)) {
            $query .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->where)) {
            $whereConditions = $this->buildWhere();
            if (!empty($whereConditions)) {
                $query .= ' WHERE ' . $whereConditions;
            }
        }

        if (!empty($this->groupBy)) {
            $query .= ' GROUP BY ' . implode(', ', $this->groupBy);
        }

        if (!empty($this->orderBy)) {
            $orderClauses = [];
            foreach ($this->orderBy as $column => $direction) {
                $orderClauses[] = "$column " . ($direction === SORT_DESC ? 'DESC' : 'ASC');
            }
            $query .= ' ORDER BY ' . implode(', ', $orderClauses);
        }

        if ($this->limit !== null) {
            $query .= ' LIMIT ' . $this->limit;
        }

        return $query;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    protected function buildWhere(): string
    {
        $conditions = [];
        foreach ($this->where as [$type, $condition]) {
            if (is_array($condition)) {
                foreach ($condition as $column => $value) {
                    $placeholder = ":param" . count($this->params);
                    $conditions[] = "$column = $placeholder";
                    $this->params[$placeholder] = $value;
                }
            } else {
                $conditions[] = $condition;
            }
        }

        $items = array_map(static function ($item) {
            return is_array($item) ? implode(' ', $item) : $item;
        }, $conditions);

        return implode(' ', $items);
    }
}
