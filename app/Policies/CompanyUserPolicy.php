<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyUserPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->role_id === Role::ADMINISTRATOR->value) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Company $company): bool
    {
        return ($user->isAdministrator() && $user->company_id === $company->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Company $company): bool
    {
        return ($user->isAdministrator() && $user->company_id === $company->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
        return ($user->isAdministrator() && $user->company_id === $company->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        return ($user->isAdministrator() && $user->company_id === $company->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        //
    }
}
