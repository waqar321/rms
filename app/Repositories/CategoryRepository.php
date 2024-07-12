<?php

namespace App\Repositories;

use App\Models\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

/**
 * Class CategorynRepository
 *
 * @author WAQAR MUGHAL <waqar.mughal@leopardscourier.com>
 * @date   21/04/24
 */

class CategoryRepository implements CategoryRepositoryInterface
{
    private $model;

    public function __construct(CategoryInterface $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        // $data['parent_id'] = 0;
        // $data['password'] = bcrypt($data['password']);
        return $this->model::create($data);
    }

    public function find($id)
    {
        return $this->model::where('id', $id)->first();
    }

    public function update($id, array $data)
    {
        // base admin's status cannot be set
        if ($id == 1 and array_key_exists('is_active', $data)) {
            unset($data['is_active']);
        }

        $this->model::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        // base admin cannot be deleted
        if ($id != 1) {
            $this->model::where('id', $id)->delete();
        }
    }
}
