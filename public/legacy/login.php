<?php
/**
 * This file is part of chem-inventory.
 * Written by Sandor Semsey.
 *
 * Copyright (c)  2020.
 * This is work licenced under the GNU General Public License v3.0. All rights reserved.
 *
 * This is a free software;)
 */

/**
 * Login page
 *********************************************************/

$config = require('default.php');

$config['title'] = 'LelTár - Bejelentkezés';

require(ROOT.'/templates/head.php');?>
<header>
	<div>
		<a href ="../index.php">
			<img src="icon/logo.png" alt="logofasz" class="rwd" width="293" height="91" />
		</a>
	</div>
</header>
<hr/>
<main>
	<section id="msg_center"></section>
	<form class="login unit" action="exec/login.php" method="post" <?=js_spec('login')?>>
		<table class="form">
			<caption>Bejelentkezés</caption>
			<tr>
				<th>Felhasználónév</th>
				<td><input type="text" id="user" autofocus required /></td>
			</tr>
			<tr>
				<th>Jelszó</th>
				<td><input type="password" id="pass" required /></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<button type="submit" class="button submit font-l">
						<i class="fas fa-sign-in-alt"></i> Belépés
					</button>
				</td>
			</tr>
		</table>
	</form>
</main>
<?php require(ROOT.'/templates/footer.php');?>