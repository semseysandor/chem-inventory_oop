<?php
/**
 * UPDATE queries
 *********************************************************/

/**
 * UPDATE compound
 *
 * @param		mysqli_link	$link
 * @param		int					$comp_id
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
function sql_update_compound($link, $comp_id, $name, $name_alt, $abbrev, $chem_name,
														$iupac, $chem_form, $cas, $smiles, $subcat, $oeb,
														$mol_weight, $melt, $note, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_compound
	SET
		name = ?,
		name_alt = ?,
		abbrev = ?,
		chemical_name = ?,
		iupac_name = ?,
		chem_formula = ?,
		cas = ?,
		smiles = ?,
		sub_category_id = ?,
		oeb = ?,
		mol_weight = ?,
		melting_point = ?,
		note = ?,
		last_mod_by = ?
	WHERE leltar_compound.compound_id = ?
	');
	$stmt->bind_param('ssssssssiidsssi',$name, $name_alt, $abbrev, $chem_name, $iupac,
																			$chem_form, $cas, $smiles, $subcat, $oeb,
																			$mol_weight, $melt, $note, $user_name, $comp_id);

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
 * UPDATE batch
 *
 * @param		mysqli_link	$link
 * @param		int					$batch_id
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
function sql_update_batch($link, $batch_id, $manfac, $name, $lot, $arr,
													$open, $exp, $note, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_batch
	SET
		manfac_id = ?,
		name = ?,
		lot = ?,
		date_arr = ?,
		date_open = ?,
		date_exp = ?,
		note = ?,
		last_mod_by = ?
	WHERE
		leltar_batch.batch_id = ?
	');
	$stmt->bind_param('isssssssi',$manfac, $name, $lot, $arr, $open,
																$exp, $note, $user_name, $batch_id);

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
 * UPDATE pack
 *
 * @param		mysqli_link	$link
 * @param		int					$pack_id
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
function sql_update_pack($link, $pack_id, $loc_id, $is_orig,
												$size, $weight, $note, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_pack
	SET
		location_id = ?,
		is_original = ?,
		size = ?,
		weight = ?,
		note = ?,
		last_mod_by = ?
	WHERE
		leltar_pack.pack_id = ?
	');
	$stmt->bind_param('sisissi',$loc_id, $is_orig, $size, $weight,
															$note, $user_name, $pack_id);

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
 * UPDATE barcode
 *
 * @param		mysqli_link	$link
 * @param		int					$pack_id
 * @param		string			$barcode
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_update_barcode($link, $pack_id, $barcode, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE leltar_pack
	SET
		barcode = ?,
		last_mod_by = ?
	WHERE leltar_pack.pack_id = ?
	');
	$stmt->bind_param('ssi', $barcode, $user_name, $pack_id);

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
 * Inactivate batch
 *
 * @param		mysqli_link	$link
 * @param		int					$batch_id
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_inactivate_batch($link, $batch_id, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE leltar_batch
	SET
		date_arch = CURRENT_DATE(),
		is_active = 0,
		last_mod_by = ?
	WHERE leltar_batch.batch_id = ?
	');
	$stmt->bind_param('si', $user_name, $batch_id);
	
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
 * Inactivate pack
 *
 * @param		mysqli_link	$link
 * @param		int					$pack_id
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_inactivate_pack($link, $pack_id, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_pack
	SET
		is_active = 0,
		last_mod_by = ?
	WHERE leltar_pack.pack_id = ?
	');
	$stmt->bind_param('si', $user_name, $pack_id);

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
 * UPDATE manfac data
 *
 * @param		mysqli_link	$link
 * @param		int					$manfac_id
 * @param		string			$name
 * @param		int					$is_freq
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_update_manfac_data($link, $manfac_id, $name, $is_freq, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_manfac
	SET
		name = ?,
		is_frequent = ?,
		last_mod_by = ?
	WHERE
		leltar_manfac.manfac_id = ?
	');
	$stmt->bind_param('sisi', $name, $is_freq, $user_name, $manfac_id);

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
 * UPDATE lab data
 *
 * @param		mysqli_link	$link
 * @param		int					$lab_id
 * @param		string			$name
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_update_lab_data($link, $lab_id, $name, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_loc_lab
	SET
		name = ?,
		last_mod_by = ?
	WHERE
		leltar_loc_lab.loc_lab_id = ?
	');
	$stmt->bind_param('ssi', $name, $user_name, $lab_id);

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
 * UPDATE place data
 *
 * @param		mysqli_link	$link
 * @param		int					$place_id
 * @param		string			$name
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_update_place_data($link, $place_id, $name, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_loc_place
	SET
		name = ?,
		last_mod_by = ?
	WHERE
		leltar_loc_place.loc_place_id = ?
	');
	$stmt->bind_param('ssi', $name, $user_name, $place_id);

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
 * UPDATE sub data
 *
 * @param		mysqli_link	$link
 * @param		int					$sub_id
 * @param		string			$name
 * @param		string			$user_name (= $_SESSION['USER_NAME'])
 *
 * @throws	leltar_exception if SQL query failed
 *
 * @return	bool
 *	TRUE		on success
 */
function sql_update_sub_data($link, $sub_id, $name, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_loc_sub
	SET
		name = ?,
		last_mod_by = ?
	WHERE
		leltar_loc_sub.loc_sub_id = ?
	');
	$stmt->bind_param('ssi', $name, $user_name, $sub_id);

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
 * UPDATE location data
 *
 * @param		mysqli_link	$link
 * @param		int					$location_id
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
function sql_update_location_data($link, $location_id, $lab_id, $place_id, $sub_id, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		leltar_location
	SET
		loc_lab_id = ?,
		loc_place_id = ?,
		loc_sub_id = ?,
		last_mod_by = ?
	WHERE
		leltar_location.location_id = ?
	');
	$stmt->bind_param('iiisi', $lab_id, $place_id, $sub_id, $user_name, $location_id);

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
 * UPDATE user data
 *
 * @param mysqli_link $link
 * @param int $user_id
 * @param int $chemical
 * @param string $user_name (= $_SESSION['USER_NAME'])
 *
 * @return    bool
 *    TRUE        on success
 * @throws leltar_exception if SQL query failed
 */
function sql_update_user_data($link, $user_id, $chemical, $user_name) {

	$stmt = $link->init();
	$stmt = $link->prepare('
	UPDATE
		main_users
	SET
		right_level_leltar = ?,
		last_mod_by = ?
	WHERE
		main_users.user_id = ?
	');
	$stmt->bind_param('isi', $chemical, $user_name, $user_id);

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
