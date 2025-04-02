<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $filter = User::query();

        if ($request->has('filter')) {
            $filter->where('name', 'LIKE', "%{$request->query('filter')}%")
                ->orWhere('email', 'LIKE', "%{$request->query('filter')}%");
        }

        return view('auth.users.list', ['users' => $filter->simplePaginate(10)]);
    }

    public function create(Request $request): View {
        return view('auth.users.create');
    }

    public function edit(Request $request, string $uuid): View {
        return view('auth.users.edit', ['user' => User::whereUuid($uuid)->first()]);
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate($this->rules());

        try {
            User::create($validated);

            session()->flash('success', 'User created successfully!');
            return redirect()->back();
        } catch (\Exception) {
            session()->flash('error', 'Cannot create the user. Try again.');
            return redirect()->back();
        }
    }
    
    public function update(Request $request, string $uuid): RedirectResponse{
        $validated = $request->validate($this->rules($uuid));

        try {
            $user = User::whereUuid($uuid)->firstOrFail();
            $user->update($validated);

            session()->flash('success', 'User updated successfully!');
            return redirect()->back()->with('success', 'User updated successfully!');
        } catch (\Exception) {
            session()->flash('success', 'Cannot update the user. Try again.');
            return redirect()->back()->with('error', 'Cannot update the user. Try again.');
        }
    }
    
    public function destroy(Request $request, string $uuid): RedirectResponse {
        try {
            $user = User::whereUuid($uuid)->firstOrFail();
            $user->delete();

            session()->flash('success', 'User deleted successfully!');
            return redirect()->back()->with('sucesss', 'Cannot update the user. Try again.');
        } catch (\Exception) {
            session()->flash('error', 'Cannot delete the user. Try again.');
            return redirect()->back()->with('error', 'Cannot delete the user. Try again.');
        }
    }

    private function rules(?string $uuid = null) {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ];
    
        if (!empty($uuid)) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }
}
