<x-admin-layout title="Nouvelle production" heading="Nouvelle production">
    <form method="POST" action="{{ route('admin.productions.store') }}" class="card p-6 space-y-6">
        @csrf
        @include('admin.productions._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Enregistrer</button>
        </div>
    </form>
</x-admin-layout>
