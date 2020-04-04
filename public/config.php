<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020 Sandor Semsey                  |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

define('LDAP_HOST', 'your_host');            # LDAP host
define('LDAP_DN', 'CN=Users,DC=company,DC=local');                # LDAP dn
define('LDAP_USR_DOM', '@company.local');  # LDAP user domain

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
