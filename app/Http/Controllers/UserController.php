<?php

namespace App\Http\Controllers;

use App\Enums\ReturnMessage;
use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $filter = $this->executeFilter($request);
        
        $users = $filter->paginate(10);
        $users->get()
            ->transform(function ($user) {
                $user->role = UserRoles::tryFrom($user->role) ?? UserRoles::USER;
                return $user;
            });
        
        return view('auth.users.list', ['users' => $users]);
    }

    public function create(Request $request): View {
        return view('auth.users.create');
    }

    public function edit(Request $request, string $uuid): View {
        return view('auth.users.edit', ['user' => User::whereUuid($uuid)->first()]);
    }

    public function store(Request $request): RedirectResponse {
        if ($request->user()->cannot('create', User::class)) {
            session()->flash('error', ReturnMessage::USER_DONT_HAVE_PERMISSION->value);
            return redirect('/users');
        }

        $validated = $request->validate($this->rules());
        $validated = $this->verifyUserRole($request, $validated);

        try {
            User::create($validated);

            session()->flash('success', ReturnMessage::USER_CREATED_SUCCESS->value);
            return redirect('/users');
        } catch (\Exception) {
            session()->flash('error', ReturnMessage::USER_CREATED_FAIL->value);
            return redirect('/users');
        }
    }
    
    public function update(Request $request, string $uuid): RedirectResponse{
        if ($request->user()->cannot('update', User::class)) {
            session()->flash('error', ReturnMessage::USER_DONT_HAVE_PERMISSION->value);
            return redirect('/users');
        }

        $validated = $request->validate($this->rules($uuid));
        $validated = $this->verifyUserRole($request, $validated);

        try {
            $user = User::whereUuid($uuid)->firstOrFail();
            $user->update($validated);

            session()->flash('success', ReturnMessage::USER_UPDATED_SUCCESS->value);
            return redirect('/users');
        } catch (\Exception) {
            session()->flash('error', ReturnMessage::USER_UPDATED_FAIL->value);
            return redirect('/users');
        }
    }
    
    public function destroy(Request $request, string $uuid): RedirectResponse { 
        try {
            $user = User::whereUuid($uuid)->firstOrFail();

            if ($request->user()->cannot('delete', $user)) {
                session()->flash('error', ReturnMessage::USER_DONT_HAVE_PERMISSION->value);
                return redirect('/users');
            }

            $user->delete();

            session()->flash('success', ReturnMessage::USER_DELETED_SUCCESS->value);
            return redirect('/users');
        } catch (\Exception) {
            session()->flash('error', ReturnMessage::USER_DELETED_FAIL->value);
            return redirect('/users');
        }
    }

    private function rules(?string $uuid = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'unique:users'],
        ];
    
        if (empty($uuid)) {
            $rules['password'] = 'required|min:8|confirmed';
        } else {
            $rules['email'] = array_slice($rules['email'], 0, 2); // Remove a regra `unique` da validação
        }
        
        return $rules;
    }

    private function executeFilter(Request $request): User|Builder {
        $filter = User::query();

        if ($request->has('filter') AND !empty($request->query('filter'))) {
            $filter->where('name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('email', 'LIKE', "%{$request->query('filter')}%");
        }

        return $filter;
    }

    private function verifyUserRole(Request $request, array $data): array {
        $data['role'] = UserRoles::USER->value;
        if (isset($request->role) AND $request->role == 'on') {
            $data['role'] = UserRoles::ADMIN->value;
        }

        return $data;
    }
}
