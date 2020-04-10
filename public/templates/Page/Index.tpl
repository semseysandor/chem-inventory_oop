{*
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
*}
{extends file='page.tpl'}
{block body}
  <h1>Inventory</h1>
  <h2>Welcome {$user}</h2>
  <a href="log-out">
    <button>Logout</button>
  </a>
{/block}
