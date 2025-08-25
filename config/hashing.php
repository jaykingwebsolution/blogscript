<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | The default password hashing driver to use for the application. This
    | corresponds to one of the "drivers" below, and provides the defaults
    | for password hashing for your application. The "bcrypt" driver is the
    | default driver for this configuration, as it provides a good balance
    | of performance and security.
    |
    | Supported drivers: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of rounds used by the bcrypt hashing
    | function. By default, this will be set to the default value of 10.
    | However, you may wish to increase the rounds to provide additional
    | security for your password hashes. Just ensure that your application's
    | performance can handle the increased rounds.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default configuration for the argon hash driver.
    | These options allow you to control the time, memory, and thread resources
    | that will be used by the argon hash driver when hashing passwords.
    |
    */

    'argon' => [
        'memory' => 65536,
        'threads' => 1,
        'time' => 4,
    ],

];