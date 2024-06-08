<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
        CREATE TABLE reports (

            id                  			INTEGER PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
            asset_id						INTEGER REFERENCES assets,
            feedback						CITEXT,
            image						    VARCHAR,
            status						    CITEXT,

            created_at                      TIMESTAMP DEFAULT NOW(),
            created_by					    CITEXT,
            updated_at                      TIMESTAMP,
            updated_by						CITEXT,
            deleted_at                      TIMESTAMP

            );
        SQL;

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
