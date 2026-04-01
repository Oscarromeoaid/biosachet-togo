<x-admin-layout title="Nouvel achat matière" heading="Nouvel achat matière">
    <form method="POST" action="{{ route('admin.stocks-matieres.store') }}" class="card p-6 space-y-6">
        @csrf
        @include('admin.stocks-matieres._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</x-admin-layout>
