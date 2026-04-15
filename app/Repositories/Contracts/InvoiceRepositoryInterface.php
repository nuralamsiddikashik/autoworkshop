<?php

namespace App\Repositories\Contracts;

interface InvoiceRepositoryInterface
{
    public function query(array $relations = []);

    public function findById(int $id, array $relations = [], array $columns = ['*']);

    public function getAll(array $relations = [], int $paginate = 10);

    public function getHidden(array $relations = [], int $paginate = 10);

    public function create(array $data);

    public function update(int $id, array $data);

    public function setHiddenStatus(int $id, bool $isHidden);

    public function delete(int $id);
}
