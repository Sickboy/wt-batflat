<?php


return [
    'name'          =>  'Dokumenty',
    'description'   =>  'Zarządzanie dokumentami',
    'author'        =>  'pl',
    'version'       =>  '1.0',
    'compatibility'    =>    '1.3.*',                                // Compatibility with Batflat version
    'icon'          =>  'file-alt',                                 // Icon from http://fontawesome.io/icons/

    // Registering page for possible use as a homepage
    'pages'            =>  ['Sample Page' => 'sample'],

    'install'       =>  function () use ($core) {
        $core->db()->pdo()->exec("CREATE TABLE IF NOT EXISTS `documents` (
            `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `title`	TEXT NOT NULL,
            `desc`	TEXT NOT NULL,
            `uid`	INTEGER NOT NULL REFERENCES users(id),
            `publisher`	TEXT NOT NULL,
            `published`	INTEGER NOT NULL,
            `status`	TEXT NOT NULL,
            `did`	INTEGER default NULL REFERENCES documents(id),
            `file`	TEXT NOT NULL,
            `rel`	INTEGER NOT NULL
        );");
        mkdir(BASE_DIR.'/uploads/documents', 0777);
    },
    'uninstall'     =>  function () use ($core) {
        $core->db()->pdo()->exec("DROP TABLE `documents`");
    }
];
