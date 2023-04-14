<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HasActionColumn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use HasActionColumn;

    public function index(): Response
    {
        return Inertia::render('Users/List', []);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', compact('user'));
    }

    public function pagedata(Request $request): JsonResponse
    {
        $canEdit = $request->user()->hasPermissionTo('edit user');
        $canDelete = $request->user()->hasPermissionTo('delete user');
        return DataTables::of(User::query())
            ->addColumn('action', function ($row) use ($canEdit, $canDelete) {
                return $this->buildActionColumns($row, 'user', noinsert: !$canEdit, nodelete: !$canDelete);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'email|unique:users'
        ]);

        $payload = $request->only('name', 'password', 'email');
        // se la password non è stata cambiata uso quella del db
        if ($payload['password'] === 'FAKE_PASSWORD') {
            unset($payload['password']);
        }
        $user->update($payload);
        return response()->redirectToRoute('users.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'email|unique:users'
        ]);

        User::create($request->only('email', 'name', 'password'));
        return response()->redirectToRoute('users.index');
    }
}
