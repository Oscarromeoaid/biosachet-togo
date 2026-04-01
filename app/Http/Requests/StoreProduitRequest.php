<?php

namespace App\Http\Requests;

use App\Models\Produit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->input('slug') ?: Str::slug((string) $this->input('nom')),
            'recette' => $this->parseRecette($this->input('recette_text')),
            'proprietes' => $this->parseProprietes($this->input('proprietes_text')),
        ]);
    }

    public function rules(): array
    {
        $produitId = $this->route('produit')?->id;

        return [
            'nom' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::in(Produit::CATALOG_SLUGS),
                Rule::unique('produits', 'slug')->ignore($produitId),
            ],
            'format' => ['required', 'string', 'max:50'],
            'usage_ideal' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix_unitaire' => ['required', 'numeric', 'min:1'],
            'cout_revient' => ['required', 'numeric', 'min:0'],
            'stock_disponible' => ['required', 'integer', 'min:0'],
            'recette' => ['required', 'array', 'min:1'],
            'notes_production' => ['nullable', 'string'],
            'sechage_heures_min' => ['required', 'integer', 'min:1'],
            'sechage_heures_max' => ['required', 'integer', 'gte:sechage_heures_min'],
            'proprietes' => ['required', 'array', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.in' => 'Le catalogue est verrouille aux 4 types officiels de sachets biodegradables.',
        ];
    }

    private function parseRecette(?string $text): array
    {
        return collect(preg_split('/\r\n|\r|\n/', trim((string) $text)))
            ->filter()
            ->mapWithKeys(function (string $line) {
                [$ingredient, $quantity] = array_pad(explode(':', $line, 2), 2, '');

                return [trim($ingredient) => trim($quantity)];
            })
            ->filter(fn (string $quantity, string $ingredient) => filled($ingredient) && filled($quantity))
            ->all();
    }

    private function parseProprietes(?string $text): array
    {
        return collect(preg_split('/,|\r\n|\r|\n/', trim((string) $text)))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
