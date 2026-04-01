<x-admin-layout title="Nouveau client" heading="Nouveau client">
    <form method="POST" action="{{ route('admin.clients.store') }}" class="card p-6 space-y-6">
        @csrf
        @include('admin.clients._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</x-admin-layout>
