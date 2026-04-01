<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $this->cleanupOrphans();
        $this->convertTablesToInnoDb();
        $this->ensureForeignKeys();
    }

    public function down(): void
    {
        //
    }

    private function cleanupOrphans(): void
    {
        DB::table('clients')
            ->whereNotNull('user_id')
            ->whereNotIn('user_id', DB::table('users')->select('id'))
            ->update(['user_id' => null]);

        DB::table('activity_logs')
            ->whereNotNull('user_id')
            ->whereNotIn('user_id', DB::table('users')->select('id'))
            ->update(['user_id' => null]);

        DB::table('commandes')
            ->whereNotIn('client_id', DB::table('clients')->select('id'))
            ->delete();

        DB::table('commande_paiements')
            ->whereNotNull('created_by')
            ->whereNotIn('created_by', DB::table('users')->select('id'))
            ->update(['created_by' => null]);

        DB::table('commande_paiements')
            ->whereNotIn('commande_id', DB::table('commandes')->select('id'))
            ->delete();

        DB::table('commande_produit')
            ->whereNotIn('commande_id', DB::table('commandes')->select('id'))
            ->delete();

        DB::table('commande_produit')
            ->whereNotIn('produit_id', DB::table('produits')->select('id'))
            ->delete();

        DB::table('stock_mouvements')
            ->whereNotNull('commande_id')
            ->whereNotIn('commande_id', DB::table('commandes')->select('id'))
            ->update(['commande_id' => null]);

        DB::table('stock_mouvements')
            ->whereNotIn('produit_id', DB::table('produits')->select('id'))
            ->delete();
    }

    private function convertTablesToInnoDb(): void
    {
        $tables = [
            'users',
            'clients',
            'produits',
            'commandes',
            'commande_produit',
            'commande_paiements',
            'productions',
            'stock_matieres',
            'stock_mouvements',
            'activity_logs',
            'message_contacts',
            'personal_access_tokens',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("ALTER TABLE `{$table}` ENGINE = InnoDB");
            }
        }
    }

    private function ensureForeignKeys(): void
    {
        $constraints = [
            [
                'table' => 'clients',
                'name' => 'clients_user_id_foreign',
                'columns' => ['user_id'],
                'references' => ['id'],
                'on' => 'users',
                'delete' => 'null',
            ],
            [
                'table' => 'commandes',
                'name' => 'commandes_client_id_foreign',
                'columns' => ['client_id'],
                'references' => ['id'],
                'on' => 'clients',
                'delete' => 'cascade',
            ],
            [
                'table' => 'commande_produit',
                'name' => 'commande_produit_commande_id_foreign',
                'columns' => ['commande_id'],
                'references' => ['id'],
                'on' => 'commandes',
                'delete' => 'cascade',
            ],
            [
                'table' => 'commande_produit',
                'name' => 'commande_produit_produit_id_foreign',
                'columns' => ['produit_id'],
                'references' => ['id'],
                'on' => 'produits',
                'delete' => 'cascade',
            ],
            [
                'table' => 'stock_mouvements',
                'name' => 'stock_mouvements_produit_id_foreign',
                'columns' => ['produit_id'],
                'references' => ['id'],
                'on' => 'produits',
                'delete' => 'cascade',
            ],
            [
                'table' => 'stock_mouvements',
                'name' => 'stock_mouvements_commande_id_foreign',
                'columns' => ['commande_id'],
                'references' => ['id'],
                'on' => 'commandes',
                'delete' => 'null',
            ],
            [
                'table' => 'commande_paiements',
                'name' => 'commande_paiements_commande_id_foreign',
                'columns' => ['commande_id'],
                'references' => ['id'],
                'on' => 'commandes',
                'delete' => 'cascade',
            ],
            [
                'table' => 'commande_paiements',
                'name' => 'commande_paiements_created_by_foreign',
                'columns' => ['created_by'],
                'references' => ['id'],
                'on' => 'users',
                'delete' => 'null',
            ],
            [
                'table' => 'activity_logs',
                'name' => 'activity_logs_user_id_foreign',
                'columns' => ['user_id'],
                'references' => ['id'],
                'on' => 'users',
                'delete' => 'null',
            ],
        ];

        foreach ($constraints as $constraint) {
            if ($this->hasForeignKey($constraint['table'], $constraint['name'])) {
                continue;
            }

            Schema::table($constraint['table'], function (Blueprint $table) use ($constraint) {
                $foreign = $table->foreign($constraint['columns'], $constraint['name'])
                    ->references($constraint['references'])
                    ->on($constraint['on']);

                match ($constraint['delete']) {
                    'cascade' => $foreign->cascadeOnDelete(),
                    'null' => $foreign->nullOnDelete(),
                    default => $foreign,
                };
            });
        }
    }

    private function hasForeignKey(string $table, string $name): bool
    {
        return collect(Schema::getForeignKeys($table))
            ->contains(fn (array $foreignKey) => ($foreignKey['name'] ?? null) === $name);
    }
};
