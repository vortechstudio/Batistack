<?php
return [
    'plugins' => [
        'sweetalert' => [
            'scripts' => [
                '/vendor/flasher/sweetalert2.min.js',
                '/vendor/flasher/flasher-sweetalert.min.js',
            ],
            'styles' => [
                '/vendor/flasher/sweetalert2.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                // 'position' => 'center'
            ],
        ],
        'toastr' => [
            'scripts' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/toastr.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => [
                '/vendor/flasher/toastr.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                // 'closeButton' => true
            ],
        ],
    ],
];
