<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

/**
 * Settings
 *
 * Format:
 * [
 *  'domain_1' =>
 *     [
 *      'foo' => 'bar',
 *      'foo2' => 'bar2'
 *     ],
 *  'domain_2' =>
 *     [
 *      'bars' => 5,
 *      'baz' => true
 *     ]
 * ]
 */
return [
  'db' => [
      // SQL server host name
    'host' => 'localhost',
      // SQL user name
    'user' => 'leltar_ADMIN',
      // password
    'pass' => 'admin',
      // database name
    'name' => 'inventory',
      // database port
    'port' => '3306',
  ],
  'general' => [
      // HTML title
    'title' => 'Leltár',
      // Stylesheets
    'stylesheet' => [
      'style/general.css',
      'style/table.css',
      'style/form.css',
      'style/message.css',
      'style/special.css',
      'style/button.css',
      'icon/fa-icon.css',
      'style/rwd.css',
      'style/containers.css',
    ],
  ],
];
