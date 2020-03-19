<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

// LDAP server
// LEGACY code
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
