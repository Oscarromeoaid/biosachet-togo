<x-admin-layout title="Modifier client" heading="Modifier client">
    <form method="POST" action="{{ route('admin.clients.update', $client) }}" class="card p-6 space-y-6">
        @csrf
        @method('PUT')
        @include('admin.clients._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Mettre a jour</button>
        </div>
    </form>
</x-admin-layout>
