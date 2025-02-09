<?php

namespace common\model;

interface QueryBuilderInterface
{
    public function findOneById(int $id): ?object;

    public function findOne(array $conditions): ?object;

    /**
     * @param array $conditions
     * @return object[]
     */
    public function findAll(array $conditions = []): array;

    public function exist(array $conditions): bool;
}
