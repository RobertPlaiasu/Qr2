<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Permission;

class PermissionPolicy extends Policy
{
    use HandlesAuthorization;

    protected $name = 'permission';

    public function before(User $user)
    {
        if($this->searchNameValueInPermissions($user, $this->all))
            return true;
    }


    public function viewAny(User $user) :bool
    {
        return false;
    }


    public function create(User $user) :bool
    {
        return false;
    }

    
    public function update(User $user, Permission $permission) :bool
    {
        return false;
    }

    
    public function delete(User $user, Permission $permission) :bool
    {
        return false;
    }


    public function restore(User $user, Permission $permission) :bool
    {
        return false;
    }

    
    public function forceDelete(User $user, Permission $permission) :bool
    {
        return false;
    }
}
