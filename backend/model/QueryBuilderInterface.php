<?php

namespace backend\model;

interface QueryBuilderInterface
{
    public function insert(array $data): bool;

    public function update(array $data): bool;

    public function delete(): bool;
}
