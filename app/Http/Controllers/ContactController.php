<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\MessageContact;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        MessageContact::query()->create($request->validated());

        return redirect()->route('site.contact')->with('success', 'Votre message a bien ete envoye.');
    }
}
