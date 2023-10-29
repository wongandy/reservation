<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\View\View as View;
use Illuminate\Http\RedirectResponse;

class CompanyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company): View
    {
        $this->authorize('viewAny', $company);

        $users = $company->users()->where('role_id', Role::COMPANY_OWNER->value)->get();

        return view('companies.users.index', compact('company', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Company $company): View
    {
        $this->authorize('create', $company);

        return view('companies.users.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('create', $company);

        $company->users()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => Role::COMPANY_OWNER->value,
        ]);

        return to_route('companies.users.index', $company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company, User $user): View
    {
        $this->authorize('update', $company);

        return view('companies.users.edit', compact('company', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, Company $company, User $user): RedirectResponse
    {
        $this->authorize('update', $company);

        $user->update($request->validated());

        return to_route('companies.users.index', $company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, User $user): RedirectResponse
    {
        $this->authorize('delete', $company);
        
        $user->delete();

        return to_route('companies.users.index', $company);
    }
}
