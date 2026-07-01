<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $role = '';

    public ?int $editId = null;

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $this->editId ? Rule::unique('users')->ignore($this->editId) : 'unique:users,email',
            ],
            'role' => 'required|exists:roles,name',
        ];

        if (! $this->editId) {
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['password'] = 'nullable|string|min:8';
        }

        $this->validate($rules);

        if ($this->editId) {
            $user = User::findOrFail($this->editId);
            $user->name = $this->name;
            $user->email = $this->email;
            if ($this->password) {
                $user->password = bcrypt($this->password);
            }
            $user->save();
            $user->syncRoles($this->role);
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->assignRole($this->role);
        }

        $this->resetForm();
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        $this->editId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? '';
        $this->password = '';
    }

    public function delete(int $id)
    {
        if ($id === auth()->id()) {
            $this->addError('deleteSelf', 'Anda tidak bisa menghapus akun Anda sendiri');

            return;
        }

        User::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->resetValidation();
    }

    public function getRolesProperty()
    {
        return Role::all();
    }

    public function getUsersProperty()
    {
        return User::with('roles')->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.user-management')
            ->layout('layouts.app');
    }
}
