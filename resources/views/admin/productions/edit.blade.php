<x-admin-layout title="Modifier production" heading="Modifier production">
    <form method="POST" action="{{ route('admin.productions.update', $production) }}" class="card p-6 space-y-6">
        @csrf
        @method('PUT')
        @include('admin.productions._form')
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">Mettre a jour</button>
        </div>
    </form>
</x-admin-layout>
