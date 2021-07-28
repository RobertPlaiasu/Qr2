<?php

namespace App\Policies;

use App\Models\County;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountyPolicy extends Policy
{
    use HandlesAuthorization;

    protected $name = 'judet';

    public function before(User $user)
    {
        if($this->searchNameValueInPermissions($user, $this->all))
            return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user) :bool
    {
        return false;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user) :bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\County  $county
     * @return mixed
     */
    public function update(User $user, County $county) :bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\County  $county
     * @return bool
     */
    public function delete(User $user, County $county) :bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\County  $county
     * @return bool
     */
    public function restore(User $user, County $county) :bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\County  $county
     * @return bool
     */
    public function forceDelete(User $user, County $county) :bool
    {
        return false;
    }
}
