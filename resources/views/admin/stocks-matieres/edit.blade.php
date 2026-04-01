<x-admin-layout title="Modifier achat" heading="Modifier achat">
    <form method="POST" action="{{ route('admin.stocks-matieres.update', $stock) }}" class="card p-6 space-y-6">
        @csrf
        @method('PUT')
        @include('admin.stocks-matieres._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Mettre a jour</button>
        </div>
    </form>
</x-admin-layout>
