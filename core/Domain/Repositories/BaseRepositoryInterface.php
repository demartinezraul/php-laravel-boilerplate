<?php

namespace Core\Domain\Repositories;

use Core\Infrastructure\Helpers\QueryCriteria;

interface BaseRepositoryInterface
{
    public function getAll(string $columns, $condition = null);

    public function getAllWithPagination(QueryCriteria $criteria);

    public function getByUUID(string $uuid);

    public function update(array $data, $condition): bool;

    public function updateByUUID(array $data, string $uuid): bool;

    public function updateByID(array $data, int $id): bool;

    public function deleteByID(int $id);

    public function deleteByIDS(array $ids);

    public function deleteByUUID(string $uuid);
}
