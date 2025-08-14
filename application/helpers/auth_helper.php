<?php
function check_login() {
    $CI =& get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('auth');
    }
}

function check_admin() {
    $CI =& get_instance();
    if ($CI->session->userdata('role') !== 'admin') {
        show_error('Anda tidak memiliki akses ke halaman ini.', 403);
    }
}

