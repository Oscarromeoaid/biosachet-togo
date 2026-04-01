@if (session('success'))
    <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
        <p class="font-semibold">Veuillez corriger les erreurs du formulaire.</p>
        <ul class="mt-2 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
