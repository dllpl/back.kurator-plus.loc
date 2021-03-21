<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 15.08.2019
 * Time: 12:33
 */

use App\Classes\Migration;

class CreatePassportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->run([
            'prefix' =>  env('APP_INSTANCE', 'prod') !== 'prod' ? env('APP_INSTANCE') . '.' : '',
            'client_id' => config('auth.client_id')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->reverse();
    }
}
