<?php if ($result->num_rows > 0): ?>
<div class="pad-s of-auto">
<h4>
<?php for ($i=0;$i<=4;$i++) {
	echo right_level_icon($i).' '.right_level_text($i).' ';
}?>
</h4>
	<table class="list">
		<thead>
			<tr>
				<th></th>
				<th>Név</th>
				<th>Szerep</th>
			</tr>
		</thead>
		<tbody>
		<?php while ($row = $result->fetch_assoc()): ?>
			<tr>
				<td>
				<?php if ($_SESSION['USER_RIGHT_LELTAR'] >= 3 ) {
				echo button('e_user', [$row['id']]);}?>
				</td>
				<td><?=$row['name']?></td>
				<td class="centered"><?=right_level_icon($row['chemical'])?></td>
			</tr>
			<tr>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php else: ?>
<?=message('0', 'Nincsenek felhasználók az adatbázisban')?>
<?php endif; ?>
