<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\UserAccountChangedNotification;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the users.
     *
     * @param  IndexUserRequest  $request The index user request instance.
     * @return View The users index view.
     */
    public function index(IndexUserRequest $request): View
    {
        $queryParams = $request->validated();

        $users = User::getByParams($queryParams)
            ->paginate(5)
            ->withQueryString();
        $roles = UserRole::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the user.
     *
     * @param  User  $user The user instance.
     * @return View The edit user form view.
     */
    public function show(User $user): View
    {
        $user->load('role', 'department');

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the user.
     *
     * @param  User  $user The user instance.
     * @return View The edit user form view.
     */
    public function edit(User $user): View
    {
        $user->load('department');
        $roles = UserRole::allRolesExcept(UserRoleEnum::SuperAdmin)->get();
        if (Auth::user()->hasRole(UserRoleEnum::Admin)) {
            $adminRoleName = UserRoleEnum::Admin->value;
            $roles = $roles->reject(function ($role) use ($adminRoleName) {
                return $role->name === $adminRoleName;
            });
        }

        return view('users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the user in storage.
     *
     * @param  UpdateUserRequest  $request The update user request instance.
     * @param  User  $user    The user instance.
     * @param  UserService  $userService The user service instance.
     * @return RedirectResponse A redirect response to the users index.
     */
    public function update(
        UpdateUserRequest $request,
        User $user,
        UserService $userService
    ): RedirectResponse {
        $validatedData = $request->validated();

        $this->authorize('update', [$user, $validatedData['role_id']]);

        $userService->update($user, $validatedData);

        $user->load('role');

        $user->notify(new UserAccountChangedNotification());

        return redirect()->route('users.show', $user->id)->with(
            'status',
            'user-updated'
        );
    }

    /**
     * Remove the user from storage.
     *
     * @param  User  $user The user instance.
     * @return RedirectResponse A redirect response to the users index.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('status', 'user-deleted');
    }
}
