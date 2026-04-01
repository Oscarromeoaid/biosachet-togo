<?php

namespace Database\Seeders;

use App\Models\Production;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        Production::query()->delete();

        foreach (range(29, 0) as $offset) {
            $date = CarbonImmutable::now()->subDays($offset);
            $isMarketPeak = in_array($date->dayOfWeekIso, [5, 6], true);
            $isSlowDay = $date->dayOfWeekIso === 7;

            $petitTransparent = $isSlowDay
                ? fake()->numberBetween(90, 130)
                : fake()->numberBetween($isMarketPeak ? 180 : 130, $isMarketPeak ? 260 : 190);

            $moyenSouple = $isSlowDay
                ? fake()->numberBetween(70, 110)
                : fake()->numberBetween($isMarketPeak ? 130 : 95, $isMarketPeak ? 190 : 155);

            $grandSolide = $isSlowDay
                ? fake()->numberBetween(18, 35)
                : fake()->numberBetween($isMarketPeak ? 40 : 25, $isMarketPeak ? 75 : 55);

            $filmBiodegradable = $isSlowDay
                ? fake()->randomFloat(2, 4, 10)
                : fake()->randomFloat(2, $isMarketPeak ? 10 : 6, $isMarketPeak ? 24 : 16);

            Production::query()->create([
                'date' => $date->toDateString(),
                'kg_manioc_utilise' => fake()->randomFloat(2, $isSlowDay ? 10 : 14, $isMarketPeak ? 34 : 28),
                'sachets_petit_transparent' => $petitTransparent,
                'sachets_moyen_souple' => $moyenSouple,
                'sachets_grand_solide' => $grandSolide,
                'film_biodegradable_m2' => $filmBiodegradable,
                'notes' => match (true) {
                    $offset % 10 === 0 => 'Serie film prioritaire pour emballage alimentaire et essais de scellage a chaud.',
                    $isMarketPeak => 'Production renforcee pour les besoins commerces et boulangerie de fin de semaine.',
                    $isSlowDay => 'Cadence reduite, focus sur sechage long des grands sachets solides.',
                    default => fake()->optional()->sentence(),
                },
            ]);
        }
    }
}
