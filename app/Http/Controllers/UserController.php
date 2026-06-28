<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
    ) {}

    public function index()
    {
        return view('admin.user.index', [
            'users' => $this->service->getAll()
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        return view('admin.user.edit', [
            'user' => $this->service->findById($id)
        ]);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $this->service->update($id, $request->validated());

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(int $id)
    {
        if ($id == auth()->id()) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $this->service->delete($id);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function resetPassword(int $id)
    {
        $user = $this->service->findById($id);

        $user->password = Hash::make('12345678');
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'Password berhasil direset ke 12345678');
    }
}
