<?php
/**
 * INSERT queries
 *********************************************************/

/**
 * Insert new compound
 *
 * @param		mysqli_link	$link
 * @param		string			$name
 * @param		string			$name_alt
 * @param		string			$abbrev
 * @param		string			$chem_name
 * @param		string			$iupac
 * @param		string			$chem_form
 * @param		string			$cas
 * @param		string			$smiles
 * @param		int					$subcat
 * @param		int					$oeb
 * @param		double			$mol_weight
 * @param		string			$melt
 * @param		string			$note
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_compound($link, $name, $name_alt, $abbrev, $chem_name,
														$iupac, $chem_form, $cas, $smiles, $subcat,
														$oeb, $mol_weight, $melt, $note, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO leltar_compound
		(name,
		name_alt,
		abbrev,
		chemical_name,
		iupac_name,
		chem_formula,
		cas,
		smiles,
		sub_category_id,
		oeb,
		mol_weight,
		melting_point,
		note,
		last_mod_by)
	VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
	');
	$stmt->bind_param('ssssssssiidsss', $name, $name_alt, $abbrev, $chem_name,
																			$iupac, $chem_form, $cas, $smiles,
																			$subcat, $oeb, $mol_weight,
																			$melt, $note, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new batch
 *
 * @param		mysqli_link	$link
 * @param		int					$comp_id
 * @param		int					$manfac
 * @param		string			$name
 * @param		string			$lot
 * @param		string			$arr
 * @param		string			$open
 * @param		string			$exp
 * @param		string			$note
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_batch($link, $comp_id, $manfac, $name, $lot, $arr,
													$open, $exp, $note, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO leltar_batch
		(compound_id,
		manfac_id,
		name,
		lot,
		date_arr,
		date_open,
		date_exp,
		note,
		is_active,
		last_mod_by)
	VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
	');
	$stmt->bind_param('iisssssss',$comp_id, $manfac, $name, $lot, $arr,
																$open, $exp, $note, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new pack
 *
 * @param		mysqli_link	$link
 * @param		int					$batch_id
 * @param		int					$loc_id
 * @param		int					$is_orig
 * @param		string			$size
 * @param		string			$weight
 * @param		string			$note
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_pack($link, $batch_id, $loc_id, $is_orig,
												$size, $weight, $note, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO leltar_pack
		(batch_id,
		location_id,
		is_original,
		size,
		weight,
		note,
		last_mod_by,
		is_active)
	VALUES (?, ?, ?, ?, ?, ?, ?, 1)
	');
	$stmt->bind_param('iiissss',$batch_id, $loc_id, $is_orig,
															$size, $weight, $note, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
} 

/**
 * Insert new user
 *
 * @param		mysqli_link	$link
 * @param		string			$login
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_user($link, $login, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO main_users
		(name,
		right_level_leltar,
		last_mod_by)
	VALUES (?, DEFAULT, ?)
	');
	$stmt->bind_param('ss', $login, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new manufacturer
 *
 * @param		mysqli_link	$link
 * @param		string			$name
 * @param		int					$is_freq
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_manfac($link, $name, $is_freq, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO
		leltar_manfac
		(name,
		is_frequent,
		last_mod_by)
	VALUES (?, ?, ?)
	');
	$stmt->bind_param('sis', $name, $is_freq, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new lab
 *
 * @param		mysqli_link	$link
 * @param		string			$name
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_lab($link, $name, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO
		leltar_loc_lab
		(name,
		last_mod_by)
	VALUES (?, ?)
	');
	$stmt->bind_param('ss', $name, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new place
 *
 * @param		mysqli_link	$link
 * @param		string			$name
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_place($link, $name, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO
		leltar_loc_place
		(name,
		last_mod_by)
	VALUES (?, ?)
	');
	$stmt->bind_param('ss', $name, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new sub
 *
 * @param		mysqli_link	$link
 * @param		string			$name
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_sub($link, $name, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO
		leltar_loc_sub
		(name,
		last_mod_by)
	VALUES (?, ?)
	');
	$stmt->bind_param('ss', $name, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Insert new location
 *
 * @param		mysqli_link	$link
 * @param		int					$lab_id
 * @param		int					$place_id
 * @param		int					$sub_id
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_location($link, $lab_id, $place_id, $sub_id, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO
		leltar_location
		(loc_lab_id,
		loc_place_id,
		loc_sub_id,
		last_mod_by)
	VALUES (?, ?, ?, ?)
	');
	$stmt->bind_param('iiis', $lab_id, $place_id, $sub_id, $user_name);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Append pack to missing list
 *
 * @param		mysqli_link	$link
 * @param		int					$pack_id
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_insert_pack_missing($link, $pack_id) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	INSERT INTO
		temp_missing
		(pack_id)
	VALUES (?)
	');
	$stmt->bind_param('i', $pack_id);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Delete pack from missing list
 *
 * @param		mysqli_link	$link
 * @param		int					$pack_id
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_delete_pack_missing($link, $pack_id) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	DELETE FROM
		temp_missing
	WHERE temp_missing.pack_id = ?
	');
	$stmt->bind_param('i', $pack_id);

	if (!($stmt->execute())) {
		throw new leltar_exception('sql_fail', 1);
	}

	if ($stmt->affected_rows == 1) {
		return TRUE;
	} else {
		return FALSE;
	}
}
?>
