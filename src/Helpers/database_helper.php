<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
if (! function_exists('principal_connect')) {
    /**
     * Establish a principal database connection.
     *
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     */
    function principal_connect($hostname, $username, $password, $database)
    {
        // Erase the principal connection, thus making Laravel get the default values all over again.
        DB::purge('principal');
        // Make sure to use the database name we want to establish a connection.
        Config::set('database.connections.principal.host', $hostname);
        Config::set('database.connections.principal.database', $database);
        Config::set('database.connections.principal.username', $username);
        Config::set('database.connections.principal.password', $password);
        // Rearrange the connection data
        DB::reconnect('principal');
        // Ping the database. This will throw an exception in case the database does not exists.
        Schema::connection('principal')->getConnection()->reconnect();
    }
}
if (! function_exists('principal_migrate')) {
    /**
     * Run Tenant Migrations in the connected principal database.
     */
    function principal_migrate()
    {
        Artisan::call('migrate', [
            '--database' => 'principal',
            '--path' => 'database/migrations_principal'
        ]);
    }
}