<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class CatalogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('catalogs')->insert([
            'id' => 1,
            'code' => '01-00-00-00-000',
            'name' => 'ACTIVOS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 1,
            'level' => '1',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('activos'),
            'catalog_id' => NULL
       ]);
        \DB::table('catalogs')->insert([
            'id' => 2,
            'code' => '02-00-00-00-000',
            'name' => 'PASIVOS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 2,
            'level' => '1',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('pasivos'),
            'catalog_id' => NULL
        ]);
        \DB::table('catalogs')->insert([
            'id' => 3,
            'code' => '03-00-00-00-000',
            'name' => 'CAPITAL O PATRIMONIO',
            'style' => 'Grupo',
            'note' => false,
            'type' => 3,
            'level' => '1',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('capital'),
            'catalog_id' => NULL
        ]);
        \DB::table('catalogs')->insert([
            'id' => 4,
            'code' => '04-00-00-00-000',
            'name' => 'INGRESOS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 4,
            'level' => '1',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('ingresos'),
            'catalog_id' => NULL
        ]);
        \DB::table('catalogs')->insert([
            'id' => 5,
            'code' => '02-00-00-00-000',
            'name' => 'COMPRAS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 5,
            'level' => '1',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('compras'),
            'catalog_id' => NULL
        ]);
        \DB::table('catalogs')->insert([
            'id' => 6,
            'code' => '06-00-00-00-000',
            'name' => 'GASTOS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 6,
            'level' => '1',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('gastos'),
            'catalog_id' => NULL
        ]);

        \DB::table('catalogs')->insert([
            'id' => 7,
            'code' => '01-01-00-00-000',
            'name' => 'ACTIVOS CORRIENTES',
            'style' => 'Grupo',
            'note' => false,
            'type' => 1,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('CORRIENTE'),
            'catalog_id' => 1
        ]);
        \DB::table('catalogs')->insert([
            'id' => 8,
            'code' => '01-02-00-00-000',
            'name' => 'PROPIEDADES PLANTA Y EQUIPO',
            'style' => 'Grupo',
            'note' => false,
            'type' => 1,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('PLANTA'),
            'catalog_id' => 1
        ]);
        \DB::table('catalogs')->insert([
            'id' => 9,
            'code' => '01-03-00-00-000',
            'name' => 'DIFERIDOS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 1,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('DIFERIDO'),
            'catalog_id' => 1
        ]);
        \DB::table('catalogs')->insert([
            'id' => 10,
            'code' => '01-04-00-00-000',
            'name' => 'OTROS ACTIVOS',
            'style' => 'Grupo',
            'note' => false,
            'type' => 1,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('OTROS'),
            'catalog_id' => 1
        ]);
        \DB::table('catalogs')->insert([
            'id' => 11,
            'code' => '02-01-00-00-000',
            'name' => 'PASIVOS A CORTO PLAZO',
            'style' => 'Grupo',
            'note' => false,
            'type' => 2,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('CORTO'),
            'catalog_id' => 2
        ]);
        \DB::table('catalogs')->insert([
            'id' => 12,
            'code' => '02-02-00-00-000',
            'name' => 'PASIVOS A LARGO PLAZO',
            'style' => 'Grupo',
            'note' => false,
            'type' => 2,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('OTROS'),
            'catalog_id' => 2
        ]);
        \DB::table('catalogs')->insert([
            'id' => 13,
            'code' => '03-01-00-00-000',
            'name' => 'FONDOS DISPONIBLES',
            'style' => 'Grupo',
            'note' => false,
            'type' => 3,
            'level' => '2',
            'school_id' => 1,
            'user_created' => 2,
            'token' => Crypt::encrypt('OTROS'),
            'catalog_id' => 3
        ]);
    }
}
