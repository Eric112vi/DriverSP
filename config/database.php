<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'ngk_part' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_NGK', '110.232.72.162'),
            'port' => env('DB_PORT_NGK', '3310'),
            'database' => env('DB_DATABASE_NGK', 'db_part'),
            'username' => env('DB_USERNAME_NGK', 'Super4dmin'),
            'password' => env('DB_PASSWORD_NGK', '@@1t4lf4Yamaha'),
            'unix_socket' => env('DB_SOCKET_NGK', ''),
            'charset' => env('DB_CHARSET_NGK', 'utf8mb4'),
            'collation' => env('DB_COLLATION_NGK', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'flk_part' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_FLK', '110.232.72.162'),
            'port' => env('DB_PORT_FLK', '3310'),
            'database' => env('DB_DATABASE_FLK', 'db_falken'),
            'username' => env('DB_USERNAME_FLK', 'Super4dmin'),
            'password' => env('DB_PASSWORD_FLK', '@@1t4lf4Yamaha'),
            'unix_socket' => env('DB_SOCKET_FLK', ''),
            'charset' => env('DB_CHARSET_FLK', 'utf8mb4'),
            'collation' => env('DB_COLLATION_FLK', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'philips_part' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PHP', '110.232.72.162'),
            'port' => env('DB_PORT_PHP', '3310'),
            'database' => env('DB_DATABASE_PHP', 'db_philips'),
            'username' => env('DB_USERNAME_PHP', 'Super4dmin'),
            'password' => env('DB_PASSWORD_PHP', '@@1t4lf4Yamaha'),
            'unix_socket' => env('DB_SOCKET_PHP', ''),
            'charset' => env('DB_CHARSET_PHP', 'utf8mb4'),
            'collation' => env('DB_COLLATION_PHP', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'mitsu_part' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_MTSB', '110.232.72.162'),
            'port' => env('DB_PORT_MTSB', '3310'),
            'database' => env('DB_DATABASE_MTSB', 'db_mitsuboshi'),
            'username' => env('DB_USERNAME_MTSB', 'Super4dmin'),
            'password' => env('DB_PASSWORD_MTSB', '@@1t4lf4Yamaha'),
            'unix_socket' => env('DB_SOCKET_MTSB', ''),
            'charset' => env('DB_CHARSET_MTSB', 'utf8mb4'),
            'collation' => env('DB_COLLATION_MTSB', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'pku_part' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PARTPKU', '110.232.72.162'),
            'port' => env('DB_PORT_PARTPKU', '3310'),
            'database' => env('DB_DATABASE_PARTPKU', 'db_partpku'),
            'username' => env('DB_USERNAME_PARTPKU', 'Super4dmin'),
            'password' => env('DB_PASSWORD_PARTPKU', '@@1t4lf4Yamaha'),
            'unix_socket' => env('DB_SOCKET_PARTPKU', ''),
            'charset' => env('DB_CHARSET_PARTPKU', 'utf8mb4'),
            'collation' => env('DB_COLLATION_PARTPKU', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
