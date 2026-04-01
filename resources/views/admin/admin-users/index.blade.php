<x-admin-layout title="Admins" heading="Comptes admin">
    <div class="card overflow-hidden">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-6 py-4 text-left font-semibold">Nom</th>
                    <th class="px-6 py-4 text-left font-semibold">Email</th>
                    <th class="px-6 py-4 text-left font-semibold">Telephone</th>
                    <th class="px-6 py-4 text-left font-semibold">Role admin</th>
                    <th class="px-6 py-4 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100 bg-white">
                @foreach ($admins as $admin)
                    <tr>
                        <td class="px-6 py-4 font-semibold">{{ $admin->name }}</td>
                        <td class="px-6 py-4">{{ $admin->email }}</td>
                        <td class="px-6 py-4">{{ $admin->telephone }}</td>
                        <td class="px-6 py-4">{{ $admin->admin_role_label }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.admin-users.edit', $admin) }}" class="text-[var(--bio-green)]">Modifier</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $admins->links() }}</div>
</x-admin-layout>
