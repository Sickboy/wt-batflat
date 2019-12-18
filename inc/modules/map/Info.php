<?php

return [
    'name'          =>  'Mapa obwodów',
    'description'   =>  '',
    'author'        =>  'pl',
    'version'       =>  '1.0',
    'compatibility'    =>    '1.3.*',                                // Compatibility with Batflat version
    'icon'          =>  'map',                                 // Icon from http://fontawesome.io/icons/

    // Registering page for possible use as a homepage
    'pages'            =>  ['Sample Page' => 'sample'],

    'install'       =>  function () use ($core) {
    },
    'uninstall'     =>  function () use ($core) {
    }
];
