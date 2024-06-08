<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
        CREATE TABLE assets (

            id                  			INTEGER PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
            asset_id						CITEXT,
            asset_name						CITEXT,
            location						CITEXT,
            description						CITEXT,
            link  							CITEXT,
            image  							VARCHAR,

            UNIQUE(asset_id, link),

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
        Schema::dropIfExists('assets');
    }
}
