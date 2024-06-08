<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserActivityLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->can('viewAny user_activity_logs')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserActivityLog  $userActivityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserActivityLog $userActivityLog)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserActivityLog  $userActivityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserActivityLog $userActivityLog)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserActivityLog  $userActivityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserActivityLog $userActivityLog)
    {
        if ($user->can('delete user_activity_logs')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserActivityLog  $userActivityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserActivityLog $userActivityLog)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserActivityLog  $userActivityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserActivityLog $userActivityLog)
    {
        //
    }
}
