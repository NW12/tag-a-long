<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// --------------------------------------------------------------------------
// Engine Init Class - V1.0
// --------------------------------------------------------------------------

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
 * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
 * FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
 * OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
 * COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
 * BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
 * DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://gnu.org/licenses/>.
 */
class Engineinit {

    function __construct() {
        $CI = & get_instance();
    }

    /**
     * General site data retrival
     * @access public
     * @return mixed
     */
    function boot_engine() {
        $CI = &get_instance();
        $data['site_name'] = $CI->config->item('site_name');
        $data['base_url'] = $CI->config->item('base_url');
        $data['site_email'] = $CI->config->item('site_email');
        $data['site_version'] = $CI->config->item('site_version');
        log_message('info', $data['site_name'] . ' ' . $data['site_version'] . ' Booted.');
        return $data;
    }

    /**
     * Get User ID from the logged in session.
     * @access	private
     * @return string
     */
    function _get_session_uid() {
        $CI = & get_instance();
        $uid = $CI->session->userdata('user_id');
        return $uid;
    }

    /**
     * Get Email from the logged in session.
     * @access	private
     * @return string
     */
    function _get_session_email() {
        $CI = & get_instance();
        $uid = $CI->session->userdata('email');
        return $uid;
    }

    /**
     * Get Full Name from the logged in session.
     * @access	private
     * @return string
     */
    function _get_session_fullname() {
        $CI = & get_instance();
        $uid = $CI->session->userdata('full_name');
        return $uid;
    }

    /**
     * Get User Name from the logged in session.
     * @access	private
     * @return string
     */
    function get_session_username() {
        $CI = & get_instance();
        $username = $CI->session->userdata('user_name');
        return $username;
    }

    /**
     * Redirect user if user is not logged in
     * @access	private
     */
    function _is_not_admin_logged_in_redirect($redirect_url) {
        $CI = & get_instance();
        $is_logged_in = $CI->session->userdata('user_is_logged_in');
        $is_admin = $CI->session->userdata('is_admin');

        if ($is_logged_in == '' || ($is_admin == '' || $is_admin == FALSE)) {
            $last_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
            $last_url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];

// @todo CI is initialized twice due the redirect, need to verify and fix it.
            redirect($redirect_url . '?last_url=' . urlencode($last_url));
        }
    }

    /**
     * Redirect user if user is not Super Admin
     * @access	private
     */
    function _is_not_super_admin_redirect($redirect_url) {
        $CI = & get_instance();
        $is_logged_in = $CI->session->userdata('role_id');
        $is_admin = $CI->session->userdata('is_admin');
        if ($is_logged_in <> '0' && $is_admin <> '') {
// @todo CI is initialized twice due the redirect, need to verify and fix it.
            redirect($redirect_url);
        }
    }

    /**
     * Redirect user if already logged in
     * @access	private
     */
    function _is_logged_in_redirect($redirect_url) {
        $CI = & get_instance();
        $is_logged_in = $CI->session->userdata('user_is_logged_in');
        if ($is_logged_in == '1') {
// @todo CI is initialized twice due the redirect, need to verify and fix it.
            redirect($redirect_url);
        }
    }

    /**
     * Redirect user if user is not logged in
     * @access	private
     */
    function _is_not_logged_in_redirect($redirect_url) {
        $CI = & get_instance();
        $is_logged_in = $CI->session->userdata('user_is_logged_in');

        if ($is_logged_in != 1) {
            $last_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
            $last_url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];

// @todo CI is initialized twice due the redirect, need to verify and fix it.
            redirect($redirect_url . '?last_url=' . urlencode($last_url));
        }
    }

    /**
     * Get photo from the logged in session.
     * @access	private
     * @return string
     */
    function get_session_user_photo() {
        $CI = & get_instance();
        $fullname = $CI->session->userdata('photo');
        return $fullname;
    }

    function check_patient_logged_in() {
        $CI = & get_instance();
        $user_type = $CI->session->userdata('user_type');
        if ($user_type != '3') {
            redirect('home');
        }
    }

    function check_doctor_logged_in() {
        $CI = & get_instance();
        $user_type = $CI->session->userdata('user_type');

        if ($user_type == '2' || $user_type == '6') {
            
        } else {
            redirect('home');
        }
    }

    /**
     * Get admin from the logged in session.
     * @access	private
     * @return string
     */
    function get_session_super_admin() {
        $CI = & get_instance();
        $role_id = $CI->session->userdata('role_id');
        return $role_id;
    }

    function checkDomianCountry() {
        
        $CI = & get_instance();
        $domainCountries = get_all_selected_countries();
        $country_codes = array();
        foreach ($domainCountries as $resp) {
            $country_codes[] = $resp['sortname'];
        }

        $CI->load->library('geolib/geolib');

        if (IP_ADDRESS_FLAG == 0) {
            $ip_address = '202.166.172.60';
        } else {
            $ip_address = $CI->input->ip_address();
        }
        // echo $ip_address;
        $georesp = $CI->geolib->ip_info($ip_address);
        $country = get_country_id($georesp['geoplugin_countryCode']);
//        echo "<pre>";
//        print_r($country);
        $domaincountry = get_domain_country_id($country['id']);
        $CI->session->set_userdata('domain_country_code', $domaincountry['code']);
        $CI->session->set_userdata('domain_country_id', $domaincountry['id']);
        $CI->session->set_userdata('domain_country_img',base_url("uploads/country/pic/" . $domaincountry['image']));
        
        if($domaincountry['timezone'] <> '')
        {
            $CI->session->set_userdata('domain_timezone', $domaincountry['timezone']);
            date_default_timezone_set($domaincountry['timezone']);
        }

//        echo "<pre>";
//        print_r($domaincountry);
//        exit('asdad');
//
//        if (in_array($georesp['geoplugin_countryCode'], $country_codes)) {
//            //echo "Match found";
//        } else {
//            redirect('not-access');
//        }
    }

}

?>
