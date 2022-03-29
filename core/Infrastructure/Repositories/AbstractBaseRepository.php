<?php

namespace Core\Infrastructure\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Core\Domain\Repositories\BaseRepositoryInterface;
use Core\Infrastructure\Helpers\QueryCriteria;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AbstractBaseRepository implements BaseRepositoryInterface
{
    protected Model $eloquent;

    public function __construct(Model $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    public function getAll(string $columns, $condition = null)
    {
        if (!is_null($condition)) {
            return $this->eloquent->all($columns)->where($condition);
        }

        return $this->eloquent->all($columns);
    }

    public function getAllWithPagination(QueryCriteria $criteria)
    {
        return $this->eloquent->orderBy(
            $criteria->getSortColumn(),
            $criteria->getSortType()
        )->paginate(
            $criteria->getLimit(),
            $criteria->getColumns(),
            $criteria->getType(),
            $criteria->getOffset()
        );
    }

    public function getByUUID(string $uuid)
    {
        return $this->eloquent->where('uuid', $uuid)->first();
    }

    public function update(array $data, $condition): bool
    {
        unset($data['id']);
        unset($data['created_at']);
        unset($data['deleted_at']);

        return $this->update($data, $condition);
    }

    public function updateByUUID(array $data, string $uuid): bool
    {
        unset($data['id']);
        unset($data['created_at']);
        unset($data['deleted_at']);

        return $this->update($data, ['uuid' => $uuid]);
    }

    public function updateByID(array $data, int $id): bool
    {
        unset($data['id']);
        unset($data['created_at']);
        unset($data['deleted_at']);

        return $this->update($data, ['id' => $id]);
    }

    public function deleteByID(int $id)
    {
        $row = $this->eloquent->find($id);

        if (empty($row)) {
            throw new ModelNotFoundException('O Registro solicitado na consulta não foi encontrado');
        }

        $row->delete();
        return true;
    }

    public function deleteByIDS(array $ids)
    {
        if ($this->eloquent->destroy($ids)) {
            return true;
        }

        throw new Exception("Não foi possível deletar o registro solicitado");
    }

    public function deleteByUUID(string $uuid)
    {
        return true;
    }
}
