<?php

namespace backend\model;

interface ORMInterface
{
    public function insert(array $data): bool;

    public function update(array $data): bool;

    public function delete(): bool;

    public function validate(array $attributes = []): bool;
}
