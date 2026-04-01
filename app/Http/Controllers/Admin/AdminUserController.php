<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Models\User;
use App\Services\ActivityLogService;

class AdminUserController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index()
    {
        return view('admin.admin-users.index', [
            'admins' => User::query()->where('role', User::ROLE_ADMIN)->orderBy('name')->paginate(15),
        ]);
    }

    public function edit(User $user)
    {
        abort_unless($user->isAdmin(), 404);

        return view('admin.admin-users.edit', [
            'admin' => $user,
            'roles' => User::ADMIN_ROLES,
        ]);
    }

    public function update(UpdateAdminUserRequest $request, User $user)
    {
        abort_unless($user->isAdmin(), 404);

        $data = $request->safe()->except('password', 'password_confirmation');

        if ($request->filled('password')) {
            $data['password'] = $request->string('password')->toString();
        }

        $user->update($data + ['role' => User::ROLE_ADMIN]);

        $this->activityLog->log(
            'admins',
            'update',
            'Compte admin mis a jour: '.$user->email,
            $user,
            ['admin_role' => $user->admin_role]
        );

        return redirect()->route('admin.admin-users.index')->with('success', 'Compte admin mis a jour.');
    }
}
