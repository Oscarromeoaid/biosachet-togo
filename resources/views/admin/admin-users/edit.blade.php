<x-admin-layout title="Modifier admin" heading="Modifier admin">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.admin-users.update', $admin) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="label" for="name">Nom</label>
                    <input id="name" name="name" value="{{ old('name', $admin->name) }}" class="input" required>
                </div>
                <div>
                    <label class="label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $admin->email) }}" class="input" required>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="label" for="telephone">Telephone</label>
                    <input id="telephone" name="telephone" value="{{ old('telephone', $admin->telephone) }}" class="input">
                </div>
                <div>
                    <label class="label" for="admin_role">Role admin</label>
                    <select id="admin_role" name="admin_role" class="input">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @selected(old('admin_role', $admin->admin_role) === $role)>{{ \Illuminate\Support\Str::headline($role) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="label" for="password">Nouveau mot de passe</label>
                    <input id="password" type="password" name="password" class="input">
                </div>
                <div>
                    <label class="label" for="password_confirmation">Confirmation</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="input">
                </div>
            </div>

            <button type="submit" class="btn-primary">Enregistrer</button>
        </form>
    </div>
</x-admin-layout>
