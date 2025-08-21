<?php
/**
 * _ide_helper.php
 *
 * File ini hanya untuk membantu IntelliSense di editor seperti VS Code.
 * Tidak dipanggil oleh CodeIgniter saat runtime.
 */

/**
 * @property CI_Loader        $load
 * @property CI_Input         $input
 * @property CI_Session       $session
 * @property CI_DB_mysqli_driver $db
 * @property CI_Form_validation $form_validation
 * @property CI_Output           $output
 */
class CI_Controller {}

/**
 * @property CI_DB_query_builder|CI_DB_mysqli_driver $db
 */
class CI_Model {}

/**
 * Dummy function untuk helper.
 * Bisa ditambah sesuai kebutuhan.
 */
function base_url($uri = '') {}
function site_url($uri = '') {}
