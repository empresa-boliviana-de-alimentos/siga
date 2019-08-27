<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TipoInsumoSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(TipoIngresoSeeder::class);
        $this->call(PartidaSeeder::class);
        $this->call(SaborSeeder::class);
        $this->call(UnidadMedidaSeeder::class);
        $this->call(InsumoSeeder::class);
        $this->call(LineaProduccion::class);
        $this->call(TipoOrdenProduccion::class);
        $this->call(TipoDevolucion::class);
        $this->call(ColorSeeder::class);
        $this->call(SublineaSeeder::class);
    }
}
