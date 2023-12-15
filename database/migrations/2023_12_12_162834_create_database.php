<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Migration
{
    private $databaseName = 'brokerchooser_backend_interview_homework';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE DATABASE IF NOT EXISTS $this->databaseName");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the database if it exists
        if (DB::statement("DROP DATABASE IF EXISTS $this->databaseName")) {
            echo "Database $this->databaseName dropped successfully.";
        } else {
            throw new \Exception("Error dropping database $this->databaseName");
        }
    }
}
