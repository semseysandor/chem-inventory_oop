<?php
/**
 * Config file
 *********************************************************/

// LDAP server
define('LDAP_HOST', 'your_host');            # LDAP host
define('LDAP_DN', 'CN=Users,DC=company,DC=local');                # LDAP dn
define('LDAP_USR_DOM', '@company.local');  # LDAP user domain

// Array to executeQuery config
return [
    // # SQL server host name
  'DB_host' => 'localhost',
    // SQL user name
  'DB_user' => 'leltar_ADMIN',
    // password
  'DB_pass' => 'admin',
    // database name
  'DB_name' => 'inventory',
    // database port
  'DB_port' => '3306',

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
];
