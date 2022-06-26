<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'approval' => 'c,r,u,d',
            //'daftar'  => 'c,r,u,d',
        ],
        'dinas' => [
            //'users' => 'c,r,u,d',
            'approval' => 'c,r,u,d',
            //'daftar'  => 'r,u',
        ],
        'sekolah' => [
            //'users' => 'c,r,u,d',
            'approval' => 'c,r,u,d',
            //'daftar'  => 'r,u',
        ],
        'siswa' => [
            //'users' => 'r',
            //'approval' => 'r',
            'daftar'  => 'c,r,u,d',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
