<?php
/**
 * EXECUTE
 *
 * Insert data to DB
 *********************************************************/

$config = require('../default.php');

// Init session
session_start();

// Abort script if session not loaded
if (session_status() != PHP_SESSION_ACTIVE) {
  exit;
}

try {
  if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['data'])) {
    // Init response
    $response = [];

    // Decode JSON
    $data = json_decode($_POST['data'], true);

    // Abort script if no selector present
    if (!isset($data['selector'])) {
      exit;
    } else {
      $selector = $data['selector'];
    }

    // Security check
    switch ($selector) {
      case 'compound':
        security_check('leltar', 1);
        break;

      case 'batch':
      case 'pack':
        security_check('leltar', 2);
        break;

      case 'manfac':
      case 'lab':
      case 'place':
      case 'sub':
      case 'location':
        security_check('leltar', 3);
        break;

      default:
        exit;
    }

    // Compound
    if ($selector == 'compound') {
      // Sanitizing user inputs
      if (empty($data['name']) or (clean_input($data['name']) == '')) {
        $response['text'] = 'Név hiányzik';
        $error_flag = true;
      } elseif (empty($data['subcat_id']) or (intval($data['subcat_id']) <= 0)) {
        $response['text'] = 'Kategória hiányzik';
        $error_flag = true;
      } else {
        $name = clean_input($data['name']);
        $subcategory_id = intval($data['subcat_id']);
      }

      if (!empty($data['name_alt'])) {
        $name_alt = clean_input($data['name_alt']);
      } else {
        $name_alt = null;
      }

      if (!empty($data['abbrev'])) {
        $abbrev = clean_input($data['abbrev']);
      } else {
        $abbrev = null;
      }

      if (!empty($data['cas'])) {
        $cas = clean_input($data['cas']);

        // Check CAS
        if (!check_cas($cas)) {
          $response['text'] = 'Hibás CAS szám';
          $error_flag = true;
        }
      } else {
        $cas = null;
      }

      if (!empty($data['smiles'])) {
        $smiles = clean_input($data['smiles']);
      } else {
        $smiles = null;
      }

      if (!empty($data['oeb'])) {
        $oeb = intval($data['oeb']);
      } else {
        $oeb = null;
      }

      if (!empty($data['melt'])) {
        $melt = intval($data['melt']);
      } else {
        $melt = null;
      }

      if (!empty($data['note'])) {
        $note = clean_input($data['note']);
      } else {
        $note = null;
      }

      // Init
      $chem_form = null;
      $mol_weight = null;
      $iupac = null;
      $chem_name = null;

      // No errors -> valid user input -> DB
      if (!$error_flag) {
        // Check for duplicate
        if (sql_check_compound($link, $name)) { # There is a duplicate

          $response['text'] = 'Már van ilyen vegyszer';
          $error_flag = true;
        } else { # No duplicate -> INSERT into DB

          if ($cas != null) { # If there is a CAS# supplied

            // Get compound info from cactus
            $info = cactus_get_compound_info($cas, 'formula');
            if ($info) {
              $chem_form = $info;
            }

            $info = cactus_get_compound_info($cas, 'mw');
            if ($info) {
              $mol_weight = $info;
            }

            $info = cactus_get_compound_info($cas, 'smiles');
            if ($info and !$smiles) {
              $smiles = $info;
            }

            $info = cactus_get_compound_info($cas, 'iupac_name');
            if ($info) {
              $iupac = $info;
            }
          }

          if (sql_insert_compound(
            $link,
            $name,
            $name_alt,
            $abbrev,
            $chem_name,
            $iupac,
            $chem_form,
            $cas,
            $smiles,
            $subcategory_id,
            $oeb,
            $mol_weight,
            $melt,
            $note,
            $_SESSION['USER_NAME']
          )) {
            // Successfully inserted
            $response['text'] = 'Vegyszer hozzáadva';
          } else {
            $response['text'] = 'Nem sikerült hozzáadni a vegyszert';
            $error_flag = true;
          }
        }
      }
    }

    // Batch
    if ($selector == 'batch') {
      // Sanitizing user inputs
      if (empty($data['comp_id']) or (intval($data['comp_id']) <= 0)) {
        $response['text'] = 'Vegyszer ID hiányzik';
        $error_flag = true;
      } elseif (empty($data['manfac']) or (intval($data['manfac']) <= 0)) {
        $response['text'] = 'Gyártó hiányzik';
        $error_flag = true;
      } elseif (empty($data['name']) or (clean_input($data['name']) == '')) {
        $response['text'] = 'Név hiányzik';
        $error_flag = true;
      } elseif (empty($data['lot']) or (clean_input($data['lot']) == '')) {
        $response['text'] = 'LOT# hiányzik';
        $error_flag = true;
      } elseif (empty($data['arr']) or (clean_input($data['arr']) == '')) {
        $response['text'] = 'Érkezési dátum hiányzik';
        $error_flag = true;
      } else {
        $comp_id = intval($data['comp_id']);
        $manfac = intval($data['manfac']);
        $name = clean_input($data['name']);
        $lot = clean_input($data['lot']);
        $arr = clean_input($data['arr']);
      }

      if (!empty($data['open'])) {
        $open = clean_input($data['open']);
      } else {
        $open = null;
      }

      if (!empty($data['exp'])) {
        $exp = clean_input($data['exp']);
      } else {
        $exp = null;
      }

      if (!empty($data['note'])) {
        $note = clean_input($data['note']);
      } else {
        $note = null;
      }

      // No errors -> valid user input -> DB
      if (!$error_flag) {
        // Check for duplicate
        if (sql_check_batch($link, $comp_id, $name, $manfac, $lot)) { # There is a duplicate

          $response['text'] = 'Már van ilyen termék';
          $error_flag = true;
        } else { # No duplicate -> INSERT into DB

          if (sql_insert_batch(
            $link,
            $comp_id,
            $manfac,
            $name,
            $lot,
            $arr,
            $open,
            $exp,
            $note,
            $_SESSION['USER_NAME']
          )) {
            // Successfully inserted
            $response['text'] = 'Termék hozzáadva';
          } else {
            $response['text'] = 'Nem sikerült hozzáadni a terméket';
            $error_flag = true;
          }
        }
      }
    }

    // Pack
    if ($selector == 'pack') {
      // Sanitizing user inputs
      if (empty($data['batch_id']) or (intval($data['batch_id']) <= 0)) {
        $response['text'] = 'Termék ID hiányzik';
        $error_flag = true;
      } elseif (empty($data['loc_id']) or (intval($data['loc_id']) <= 0)) {
        $response['text'] = 'Helyzet hiányzik';
        $error_flag = true;
      } elseif (empty($data['size']) or (clean_input($data['size']) == '')) {
        $response['text'] = 'Kiszerelés hiányzik';
        $error_flag = true;
      } else {
        $batch_id = intval($data['batch_id']);
        $loc_id = intval($data['loc_id']);
        $size = clean_input($data['size']);
      }

      if (!empty($data['weight'])) {
        $weight = clean_input($data['weight']);
      } else {
        $weight = null;
      }

      if (!empty($data['note'])) {
        $note = clean_input($data['note']);
      } else {
        $note = null;
      }

      if (!empty($data['is_orig'])) {
        $is_orig = clean_input($data['is_orig']);
      } else {
        $is_orig = 0;
      }

      // No errors -> valid user input -> DB
      if (!$error_flag) {
        if (sql_insert_pack(
          $link,
          $batch_id,
          $loc_id,
          $is_orig,
          $size,
          $weight,
          $note,
          $_SESSION['USER_NAME']
        )) { # Successfully added to DB

          // Get pack ID for inserted pack
          $pack_id = mysqli_insert_id($link);

          // Error if there was problem with SQL
          if ($pack_id == 0) {
            throw new leltar_exception('sql_fail', 1);
          }

          // pack ID -> fixed length, leading zeros CODE
          $code = sprintf('%06d', $pack_id);

          // Convert UPC-E code to UPC-A
          $upc_a = upc_e_to_upc_a($code);

          // Calculate check digit
          $check_digit = calc_check_digit($upc_a);

          // Produce final UPC-E barcode

          // Put number system digit (0) and check digit
          $upc_e = '0'.$code.$check_digit;

          // Put barcode into DB
          if (sql_update_barcode($link, $pack_id, $upc_e, $_SESSION['USER_NAME'])) { # Successful

            $response['text'] = 'Kiszerelés hozzáadva';
          } else {
            $response['text'] = 'Vonalkód generálása nem sikerült';
            $error_flag = true;
          }
        } else {
          $response['text'] = 'Nem sikerült hozzáadni az adatbázishoz';
          $error_flag = true;
        }
      }
    }

    // Manufacturer
    if ($selector == 'manfac') {
      // Sanitizing user inputs
      if (empty($data['name']) or (clean_input($data['name']) == '')) {
        $response['text'] = 'Név hiányzik';
        $error_flag = true;
      } else {
        $name = clean_input($data['name']);
      }

      if (!empty($data['is_freq'])) {
        $is_freq = intval($data['is_freq']);
      } else {
        $is_freq = 0;
      }

      // No errors -> valid user input -> DB
      if (!$error_flag) {
        // Check for duplicate
        if (sql_check_manfac($link, $name)) { # There is a duplicate

          $response['text'] = 'Már van ilyen gyártó';
          $error_flag = true;
        } else { # No duplicate -> INSERT into DB

          if (sql_insert_manfac($link, $name, $is_freq, $_SESSION['USER_NAME'])) {
            // Successfully inserted
            $response['text'] = 'Sikeresen hozzáadva';
          } else {
            $response['text'] = 'Nem sikerült hozzáadni';
            $error_flag = true;
          }
        }
      }
    }

    // Lab, place or sub
    if (in_array($selector, ['lab', 'place', 'sub'])) {
      // Sanitizing user inputs
      if (empty($data['name']) or (clean_input($data['name']) == '')) {
        $response['text'] = 'Név hiányzik';
        $error_flag = true;
      } else {
        $name = clean_input($data['name']);
      }

      // No errors -> valid user input -> DB
      if (!$error_flag) {
        switch ($selector) {
          // Laboratory
          case 'lab':
            if (sql_check_lab($link, $name)) { # There is a duplicate

              $response['text'] = 'Már van ilyen labor';
              $error_flag = true;
            } elseif (sql_insert_lab($link, $name, $_SESSION['USER_NAME'])) { # No duplicate -> INSERT into DB

              // Successfully inserted
              $response['text'] = 'Sikeresen hozzáadva';
            } else {
              $response['text'] = 'Nem sikerült hozzáadni';
              $error_flag = true;
            }
            break;

          // Place
          case 'place':
            if (sql_check_place($link, $name)) { # There is a duplicate

              $response['text'] = 'Már van ilyen hely';
              $error_flag = true;
            } elseif (sql_insert_place($link, $name, $_SESSION['USER_NAME'])) { # No duplicate -> INSERT into DB

              // Successfully inserted
              $response['text'] = 'Sikeresen hozzáadva';
            } else {
              $response['text'] = 'Nem sikerült hozzáadni';
              $error_flag = true;
            }
            break;

          // Sub-place
          case 'sub':
            if (sql_check_sub($link, $name)) { # There is a duplicate

              $response['text'] = 'Már van ilyen alhely';
              $error_flag = true;
            } elseif (sql_insert_sub($link, $name, $_SESSION['USER_NAME'])) { # No duplicate -> INSERT into DB

              // Successfully inserted
              $response['text'] = 'Sikeresen hozzáadva';
            } else {
              $response['text'] = 'Nem sikerült hozzáadni';
              $error_flag = true;
            }
            break;

          default:
            $error_flag = true;
            break;
        }
      }
    }

    // Location
    if ($selector == 'location') {
      // Sanitizing user inputs
      if (empty($data['lab_id']) or (intval($data['lab_id']) < 1)) {
        $response['text'] = 'Labor hiányzik';
        $error_flag = true;
      } elseif (empty($data['place_id']) or (intval($data['place_id']) < 1)) {
        $response['text'] = 'Hely hiányzik';
        $error_flag = true;
      } elseif (empty($data['sub_id']) or (intval($data['sub_id']) < 1)) {
        $response['text'] = 'Alhely hiányzik';
        $error_flag = true;
      } else {
        $lab_id = intval($data['lab_id']);
        $place_id = intval($data['place_id']);
        $sub_id = intval($data['sub_id']);
      }

      // No errors -> valid user input -> DB
      if (!$error_flag) {
        // Check for duplicate
        if (sql_check_location($link, $lab_id, $place_id, $sub_id)) { # There is a duplicate

          $response['text'] = 'Már van ilyen lokáció';
          $error_flag = true;
        } else { # No duplicate -> INSERT into DB

          if (sql_insert_location($link, $lab_id, $place_id, $sub_id, $_SESSION['USER_NAME'])) {
            // Successfully inserted
            $response['text'] = 'Sikeresen hozzáadva';
          } else {
            $response['text'] = 'Nem sikerült hozzáadni';
            $error_flag = true;
          }
        }
      }
    }

    // Set response flag
    $response['flag'] = ($error_flag ? 'neg' : 'pos');

    // Encode response to JSON
    $response = json_encode($response, JSON_UNESCAPED_UNICODE);
    echo $response;
  }
} catch (leltar_exception $e) {
  $e->error_handling();
} ?>
