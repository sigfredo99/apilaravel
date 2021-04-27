<?php

use Illuminate\Database\Seeder;

class DataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            [
                'payment_method_id' => 1,
                'name' => 'Contra Entrega',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'payment_method_id' => 2,
                'name' => 'Transferencia Bancaria',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'payment_method_id' => 3,
                'name' => 'Billetera Eletrónica',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'payment_method_id' => 4,
                'name' => 'Sin Método de Pago',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('ubigeo')->insert([
            [
                'ubigeo_id' => 1,
                'ubigeo_code' => '230101',
                'departament' => 'Tacna',
                'province' => 'Tacna',
                'district' => 'Tacna',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'ubigeo_id' => 2,
                'ubigeo_code' => '230102',
                'departament' => 'Tacna',
                'province' => 'Tacna',
                'district' => 'Alto de la Alianza',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'ubigeo_id' => 3,
                'ubigeo_code' => '230104',
                'departament' => 'Tacna',
                'province' => 'Tacna',
                'district' => 'Ciudad Nueva',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'ubigeo_id' => 4,
                'ubigeo_code' => '230108',
                'departament' => 'Tacna',
                'province' => 'Tacna',
                'district' => 'Pocollay',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'ubigeo_id' => 5,
                'ubigeo_code' => '230110',
                'departament' => 'Tacna',
                'province' => 'Tacna',
                'district' => 'Crl. Greg. Albarracín',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('correlatives')->insert([
            [
                'correlative_id' => 1,
                'invoice_serie' => 'B001',
                'invoice_correlative' => 0,
                'invoice_type' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'correlative_id' => 2,
                'invoice_serie' => 'F001',
                'invoice_correlative' => 0,
                'invoice_type' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

    }
}
