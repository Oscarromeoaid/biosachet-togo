<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="label" for="nom">Nom</label>
        <input id="nom" name="nom" value="{{ old('nom', $client->nom) }}" class="input" required>
    </div>
    <div>
        <label class="label" for="telephone">Telephone</label>
        <input id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}" class="input">
    </div>
    <div>
        <label class="label" for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $client->email) }}" class="input">
    </div>
    <div>
        <label class="label" for="type">Type</label>
        <select id="type" name="type" class="input" required>
            @foreach (\App\Models\Client::TYPES as $type)
                <option value="{{ $type }}" @selected(old('type', $client->type) === $type)>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label" for="ville">Ville</label>
        <input id="ville" name="ville" value="{{ old('ville', $client->ville) }}" class="input" required>
    </div>
</div>
