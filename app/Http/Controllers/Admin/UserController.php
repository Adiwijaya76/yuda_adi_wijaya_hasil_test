<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\RespondsWithDataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    use RespondsWithDataTables;

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('admin.users.index');
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => User::ROLES,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('admin.users.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pengguna berhasil ditambahkan.',
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => User::ROLES,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pengguna berhasil diperbarui.',
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => 'Anda tidak dapat menghapus akun sendiri.',
            ]);
        }

        $user->delete();

        return back()->with('toast', [
            'type' => 'success',
            'message' => "Akun \"{$user->name}\" berhasil dihapus.",
        ]);
    }

    private function data(Request $request): JsonResponse
    {
        $baseQuery = User::query()->with('merchantProfile')->latest();

        return $this->dataTablesResponse(
            $baseQuery,
            $request,
            fn (User $user) => [
                'name' => $user->name,
                'email' => $user->email,
                'role_badge' => view('components.role-badge', ['role' => $user->role])->render(),
                'merchant' => $user->merchantProfile?->company_name ?? '-',
                'action' => view('admin.users.partials.actions', ['user' => $user])->render(),
            ],
            function ($query) use ($request) {
                $query->search($request->query('keyword'))->ofRole($request->query('role'));
            },
        );
    }
}
