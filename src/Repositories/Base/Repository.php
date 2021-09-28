<?php

namespace Samchentw\Common\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @return string
     */
    abstract public function model(): string;


    public function getModel()
    {
        return $this->model;
    }

    /**
     * Instantiate a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = app($this->model());
    }


    /**
     * @param  int  $id
     * @return Model
     */
    public function getById($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * 取得全部
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * 新增
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * 更新
     */
    public function update($input, $id)
    {
        $data = $this->getById($id);
        return tap($data, function ($model) use ($input) {
            $model->update($input);
        });
    }

    /**
     * 刪除
     */
    public function destroy(string $id)
    {
        return $this->model->destroy($id);
    }

    /**
     * 分頁功能
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \InvalidArgumentException
     */
    public function page($count = 10)
    {
        return $this->model()::paginate($count);
    }

    /**
     * 取得 model 的 $fillable參數
     * @return array
     */
    public function getFillable()
    {
        return $this->model->getFillable();
    }

    /**
     * 取得 model 實例化查詢
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        return $this->model()::query();
    }


    public function getAllForFrontQuery()
    {
        $query = $this->getModel()->query();

        if (method_exists($this->model, 'scopeEnableQuery')) {
            $query->enableTrueQuery();
        }

        if (method_exists($this->model, 'scopeSortByConfig')) {
            $query->sortByConfig();
        }

        return $query;
    }

    public function getAllForFront()
    {
        $query = $this->getModel()->query();

        if (method_exists($this->model, 'scopeEnableQuery')) {
            $query->enableTrueQuery();
        }

        if (method_exists($this->model, 'scopeSortByConfig')) {
            $query->sortByConfig();
        }

        return $query->get();
    }

    public function getAllForAdminQuery()
    {
        $query = $this->getModel()->query();

        if (method_exists($this->model, 'scopeSortByConfig')) {
            $query->sortByConfig();
        }

        return $query;
    }

    public function getAllForAdmin()
    {
        $query = $this->getModel()->query();

        if (method_exists($this->model, 'scopeSortByConfig')) {
            $query->sortByConfig();
        }

        return $query->get();
    }
}
