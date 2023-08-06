<?php


namespace App\Repositories;


use App\Models\Admin;
use App\Traits\UploadAble;
use App\Contracts\AdminContract;

class AdminRepository extends BaseRepositories implements AdminContract
{
    use UploadAble;

    /**
     * @param Admin $model
     * @param array $filters
     */
    public function __construct(Admin $model,array $filters = [
        \App\QueryFilter\Search::class,
        \App\QueryFilter\Role::class

    ])
    {
        parent::__construct($model, $filters);
    }

    public function new(array $data)
    {
        if (array_key_exists('image', $data))
        {
            $data['image'] = $this->uploadOne($data['image'],'admin/image');
        }
        $data['password'] = bcrypt($data['password']);
        $admin = $this->model::create($data);
        $admin->assignRole($data['roles']);
        return $admin;
    }

    public function update($id, array $data)
    {
        $admin = $this->findOneById($id);
        if (array_key_exists('image', $data))
        {
            if ($admin->image)
            {
                $this->deleteOne($admin->image);
            }
            $data['image'] = $this->uploadOne($data['image'],'admin/image');
        }

        if (array_key_exists('password',$data))
        {
            $data['password'] = bcrypt($data['password']);
        }

        $admin->update($data);

        if (array_key_exists('roles',$data))
        {
            $admin->syncRoles($data['roles']);
        }

        return $admin;
    }

    public function destroy($id)
    {
        $admin = $this->findOneById($id);
        if ($admin->image)
        {
            $this->deleteOne($admin->image);
        }
        return $admin->delete();
    }
}
