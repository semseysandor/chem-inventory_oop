<?php
/**
 * Config file
 *********************************************************/

// LDAP server
define('LDAP_HOST', 'your_host');            # LDAP host
define('LDAP_DN', 'CN=Users,DC=company,DC=local');                # LDAP dn
define('LDAP_USR_DOM', '@company.local');  # LDAP user domain

// Array to store config
return [
    // # SQL server host name
  'DBHost' => 'localhost',
    // SQL user name
  'DBUser' => 'leltar_ADMIN',
    // password
  'DBPass' => 'admin',
    // database name
  'DBName' => 'inventory',

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
