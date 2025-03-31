<?php
defined('BASEPATH') OR exit('No direct script access allowed');

return [ // Cambiar de $db a return
    'default' => [
        'dsn'   => '',
        'hostname' => 'localhost',
        'username' => 'cmdb_user',
        'password' => 'nbFRtTwX?3ugx@cEZA2SdM',
        'database' => 'cmdb',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8mb4', // Cambiar aquí
        'dbcollat' => 'utf8mb4_unicode_ci', // Cambiar aquí
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => [],
        'save_queries' => TRUE
    ]
];