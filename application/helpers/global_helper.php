<?php
/*
----------------------------
GLOBAL     ----    HELPER
----------------------------
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Method: rights
 * Params: $right_id
 * Return: True / False
 */
if (!function_exists('rights')) {

    function rights($right_id) {
        $ci = &get_instance();
        if ($ci->session->userdata('role_id') == 0) {
            return true;
        }
        $query = 'SELECT
		count(*) as  counter
		FROM
		admin_permissions as permission
		WHERE
		permission.right_id ="' . $right_id . '"
		 and role_id= "' . $ci->session->userdata('role_id') . '" limit 1';
        $query = $ci->db->query($query);
        $row = $query->row();
        if ($row->counter > 0) {
            return true;
        } else {
         //   $ci->session->set_flashdata('error_message', 'You don\'t have permissions for this module. Please contact your administrator.');
            return false;
        }
    }

}
/**
 * Method: getColumns
 * Params: $table
 * Return: Fields of table
 */
if (!function_exists('getColumns')) {

    function getColumns($table) {
        $result = "";
        $ci = &get_instance();
        $table = $ci->db->dbprefix . $table;
        $sql = "SHOW COLUMNS FROM " . $table;
        $query = $ci->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result [$row->Field] = "";
            }
        }
        return $result;
    }

}

/**
 * Method: getVal
 * Params: $col, $table, $where, $criteria
 * Return: array
 */
function getVal($col, $table, $where = '', $criteria = '') {
    $ci = &get_instance();
    $arr_results = array();
    $ci->db->select($col);
    $ci->db->where($where, $criteria);
    $ci->db->from($table);
    $ci->db->limit(1);
    $results = $ci->db->get();
    if ($results->num_rows() > 0) {
        return $results->row($col);
    }
}

function getVal2($col, $table, $where = '', $criteria = '') {
    $ci = &get_instance();
    $arr_results = array();
    $ci->db->select($col);
    $ci->db->where($where, $criteria);
    $ci->db->from($table);
    $ci->db->limit(1);
    //echo $ci->db->get_compiled_select();
    $results = $ci->db->get();
    if ($results->num_rows() > 0) {
        return $results->row($col);
    }
}

/**
 * Method: getValArray
 * Params: $cols, $table, $where, $criteria
 * Return: array
 */
function getValArray($cols, $table, $where = '', $criteria = '') {
    $ci = &get_instance();
    $ci->db->select($cols);
    $ci->db->where($where, $criteria);
    $ci->db->from($table);
    $ci->db->limit(1);
    //$ci->db->get_compiled_select();
    $results = $ci->db->get();
    if ($results->num_rows() > 0) {
        return $results->row_array();
    }
}

/**
 * Method: getCount
 * Params: $cols, $table,$as ,$where, $criteria
 * Return: result
 */
function getCount($col, $as,$table, $where = '', $criteria = '') {
    $ci = &get_instance();
    $query = "SELECT count(".$col.") as ".$as."
     FROM " .$table. "  WHERE ".$where." = ".$criteria ." limit 1 ";
   
    $query = $ci->db->query($query);
    $results = $query->row();
     return $results->$as;
}

/**
 * Mehtod: init_admin_pagination
 * params: $uri, $total_records,$perpage
 * return: pagination configuration
 */
if (!function_exists('init_admin_pagination')) {

    function init_admin_pagination($uri, $total_records, $perpage, $id = '') {
        $ci = & get_instance();
        $config ["base_url"] = base_url() . $uri;
        $prev_link = '&laquo;';
        $next_link = '&raquo;';
        $config ["total_rows"] = $total_records;
        $config ["per_page"] = $perpage;
        if ($id)
            $config ['uri_segment'] = '5';
        else
            $config ['uri_segment'] = '4';
        $config ['first_link'] = 'First';
        $config ['last_link'] = 'Last';
        $config ['num_links'] = '5';
        $config ['prev_link'] = $prev_link;
        $config ['next_link'] = $next_link;
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a>';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['prev_tag_open'] = '<li>';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_tag_open'] = '<li>';
        $config ['next_tag_close'] = '</li>';
        $config ['page_query_string'] = FALSE;
        $ci->pagination->initialize($config);
        return $config;
    }

}
/**
 * Mehtod: init_front_pagination
 * params: $uri, $total_records,$perpage
 * return: pagination configuration
 */
if (!function_exists('init_front_pagination')) {

    function init_front_pagination($url, $total_records, $perpage) {
        $ci = & get_instance();
        $config ["base_url"] = base_url() . $url;
        $prev_link = '&lsaquo;';
        $next_link = '&rsaquo;';
        $config ["total_rows"] = $total_records;
        $config ["per_page"] = $perpage;
        $config ['uri_segment'] = '4';
        $config ['first_link'] = 'First &laquo;';
        $config ['last_link'] = '&raquo; Last';
        $config ['first_tag_open'] = '<li>';
        $config ['first_tag_close'] = '</li>';
        $config ['last_tag_open'] = '<li>';
        $config ['last_tag_close'] = '</li>';
        $config ['num_links'] = '5';
        $config ['prev_link'] = $prev_link;
        $config ['next_link'] = $next_link;
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a>';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['prev_tag_open'] = '<li>';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_tag_open'] = '<li>';
        $config ['next_tag_close'] = '</li>';
        $config ['page_query_string'] = TRUE;
        $ci->pagination->initialize($config);
        return $config;
    }

}

/**
 * Get get_all_countries.
 * @access	private
 * @return array
 */
function get_all_countries() {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('countries');
    $q = $CI->db->get();
    return $q->result_array();
}

function get_all_jobs_status() {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('job_status');
    $q = $CI->db->get();
    return $q->result_array();
}

function get_roles() {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('admin_roles');
    $CI->db->where("id !=", '0');
    $q = $CI->db->get();
    return $q->result_array();
}

function get_video_categories() {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('video_categories');
    $q = $CI->db->get();
    return $q->result_array();
}

/**
 * Get get_company_types.
 * @access	private
 * @return array
 */
function get_company_types() {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('c_users_company_types');
    $CI->db->where('status', 1);
    $q = $CI->db->get();
    return $q->result_array();
}

/* check view port */
if (!function_exists('checkIsTablet')) {

    function checkIsTablet() {
        $ci = & get_instance();
        $ci->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        if ($detect->isTablet()) {
            return true;
        } else {
            return false;
        }
    }

}

/**
 * Method: getChildren
 * params: $table, $ids
 * Returns: $ids
 */
if (!function_exists('getChilder')) {

    function getChildren($table, $ids) {
        $ci = &get_instance();
        $ids = (array) $ids;
        $catid = array_unique($ids);
        sort($ids);
        $array = $ids;
        $implodeArray = implode(',', $array);
        $arrayNew = array();
        for ($i = 0; $i <= count($array); $i++) {
            $query = "SELECT category_id FROM " . $ci->db->dbprefix($table) . " WHERE status=1 AND parent_id IN (" . $implodeArray . ") AND category_id NOT IN (" . $implodeArray . ") ";
            $query = $ci->db->query($query);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $arrayNew [] = $row->category_id;
                }
            }
            $ids = array_merge($ids, $arrayNew);
        }
        $ids = array_unique($ids);
        return $ids;
    }

}
if (!function_exists('dump_var')) {

    function dump_var($ar) {
        echo '<pre>';
        var_dump($ar);
        echo '</pre>';
        die();
    }

}

/**
 * Method: show_custom_options
 * @param $type, $description,$description_ar
 * @return string
 */
function show_custom_options($type, $description, $description_ar) {
    $output = '';
    if ($type == 'selectlist') {
        $total_options_arr = explode(',', $description);
        if (is_array($total_options_arr)) {
            $i = 1;
            foreach ($total_options_arr as $k => $v) {
                if ($v != "") {
                    $option_values_arr = explode(':', $v);
                    $option_label = replace_in_view($option_values_arr[0]);
                    $option_default = $option_values_arr[1];
                    $option_value = replace_in_view(strtolower($option_label));

                    if ($option_default == 1) {
                        $yes = 'checked="checked"';
                        $no = '';
                    } else {
                        $no = 'checked="checked"';
                        $yes = '';
                    }
                    $output .= '<ol id="ol_' . $i . '" class="media-list"> <li id="h_' . $i . '"><strong>Option ' . $i . '</strong></li><li><label for="opt_label_' . $i . '">Option Label</label>&nbsp;<input type="text" name="option_label_' . $i . '" id="option_label_' . $i . '" value="' . $option_value . '" />&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="delete_cf_options(this.id)" id="' . $i . '"><i class="ti-close"></i> Delete</button></li><li><label for="opt_default_' . $i . '">Default</label>&nbsp;&nbsp;<input type="radio" name="option_default_' . $i . '"  value="1" id="yes_option_default_' . $i . '" ' . $yes . '/>&nbsp;Yes&nbsp;&nbsp;<input type="radio" name="option_default_' . $i . '"  value="0" ' . $no . ' id="no_option_default_' . $i . '" />&nbsp;No</li></ol>';
                }
                $i++;
                //}
            }
        }
    } else {
        $total_options_arr = explode(',', $description);
        if (is_array($total_options_arr)) {
            $i = 1;
            foreach ($total_options_arr as $k => $v) {

                if ($v != "") {
                    $option_values_arr = explode(':', $v);
                    $option_label = replace_in_view($option_values_arr[0]);
                    $option_default = $option_values_arr[1];
                    $option_value = replace_in_view(strtolower($option_label));

                    if ($option_default == 1) {
                        $yes = 'checked="checked"';
                        $no = '';
                    } else {
                        $no = 'checked="checked"';
                        $yes = '';
                    }
                    $output .= '<ol id="ol_' . $i . '" class="media-list"> <li id="h_' . $i . '"><strong>Option ' . $i . '</strong></li><li><label for="opt_label_' . $i . '">Option Label</label>&nbsp;<input type="text" name="option_label_' . $i . '" id="option_label_' . $i . '" value="' . $option_value . '" />&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="delete_cf_options(this.id)" id="' . $i . '"><i class="ti-close"></i> Delete</button></li><li><label for="opt_default_' . $i . '">Default</label>&nbsp;&nbsp;<input type="radio" name="option_default_' . $i . '"  value="1" id="yes_option_default_' . $i . '" ' . $yes . '/>&nbsp;Yes&nbsp;&nbsp;<input type="radio" name="option_default_' . $i . '"  value="0" ' . $no . ' id="no_option_default_' . $i . '" />&nbsp;No</li></ol>';
                }
                $i++;
            }
        }
    }
    return $output;
}

/**
 * Method: getFieldTypes
 * Returns: field types array
 */
if (!function_exists('getFieldTypes')) {

    function getFieldTypes() {
        $cutom_field_types = array(
            'text' => 'Text Field',
            'textarea' => 'Text Area',
            'radio' => 'Radio Button',
            'checkbox' => 'Check Box',
            'selectlist' => 'Selection List'
        );
        return $cutom_field_types;
    }

}

/**
 * Method: replace_in_db
 * @param $str
 * @return mixed
 */
function replace_in_db($str) {
    $arr_replace = array(
        ',',
        ':'
    );
    $arr_replace_with = array(
        '##@@#@##',
        '@@##@#@@'
    );
    $output = str_replace($arr_replace, $arr_replace_with, $str);
    return $output;
}

/**
 * Method: replace_in_view
 * @param $str
 * @return mixed
 */
function replace_in_view($str) {
    $arr_replace_with = array(
        ',',
        ':'
    );
    $arr_replace = array(
        '##@@#@##',
        '@@##@#@@'
    );
    $output = str_replace($arr_replace, $arr_replace_with, $str);
    return $output;
}

function createForm($category_id, $product_id = '') {
    $ci = &get_instance();
    $where = 'status = 1  AND ';
    $r = 1;
    foreach ($category_id as $id) {
        if ($r < count($category_id))
            $where .= ' category_id = ' . $id . ' OR ';
        else if ($r == count($category_id))
            $where .= ' category_id = ' . $id;
        $r++;
    }
    $f = $w = '';
    if ($product_id <> 0 && $product_id <> '') {
        $f = ' ,c_extrafieldvalues.values as value ,
        c_extrafieldvalues.id,c_extrafieldvalues.extra_field_id,c_extrafieldvalues.product_id';
        $w = 'INNER  JOIN c_extrafieldvalues ON (c_extrafieldvalues.extra_field_id = c_extrafields.extra_field_id AND c_extrafieldvalues.product_id=' . $product_id . ')';
    }
    $query = 'SELECT c_extrafields.* ' . $f . '
        FROM
        (c_extrafields)
        ' . $w . '

        WHERE
            ' . $where;
    $query = $ci->db->query($query);
    if ($query->num_rows() > 0) {
        $n = 1;
        foreach ($query->result_array() as $row) {
            $required = '';
            $req = '';
            switch ($row['type']) {

                /*                 * Text Box */
                CASE 'text':
                    $txt = explode(',', $row['values']);
                    if ($row['required'] == 1) {
                        $required = 'required';
                        $req = '*';
                    }
                    $maxlength = '';
                    if ($txt [0] <> '') {
                        $maxlength = 'maxlength="' . $txt [0] . '"';
                    }

                    echo '<div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">' . $row['label'] . ' ' . $req . '</label>
                        <div class="col-xs-12 col-sm-9"><div class="clearfix">
                    <input type="' . $row['type'] . '" ' . $maxlength . ' class="col-xs-12 col-sm-5 ' . $required . '" id="c_form_' . $n . '" name="c_form_' . $n . '" placeholder="' . $row['label'] . '" value="' . $row['value'] . '">
                        <input type="hidden"name="extra_field_id[]" value="' . $row['extra_field_id'] . '"/></div>
                    </div></div>
';
                    break;

                /*                 * Text Box */
                CASE 'textfield':
                    $txt = explode(',', $row['values']);
                    if ($row['required'] == 1) {
                        $required = 'required';
                        $req = '*';
                    }
                    $maxlength = '';
                    if ($txt [0] <> '') {
                        $maxlength = 'maxlength="' . $txt [0] . '"';
                    }
                    echo '<div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">' . $row['label'] . ' ' . $req . '</label>
                        <div class="col-xs-12 col-sm-9"><div class="clearfix">
                    <input type="' . $row['type'] . '" ' . $maxlength . ' class="col-xs-12 col-sm-5 ' . $required . '" id="c_form_' . $n . '" name="c_form_' . $n . '" placeholder="' . $row['label'] . '" value="' . $row['value'] . '">
                        <input type="hidden"name="extra_field_id[]" value="' . $row['extra_field_id'] . '"/></div>
                    </div></div>
';
                    break;


                /*                 * Textarea */
                CASE 'textarea':
                    echo '<div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">' . $row['label'] . ' ' . $req . '</label>
                        <div class="col-xs-12 col-sm-9"><div class="clearfix">
                    <textarea  class="col-xs-12 col-sm-5 ' . $required . '" id="c_form_' . $n . '" name="c_form_' . $n . '" placeholder="' . $row['label'] . '">' . $row['value'] . '</textarea>
                        <input type="hidden"name="extra_field_id[]" value="' . $row['extra_field_id'] . '"/></div>
                    </div></div>
';
                    break;

                /*                 * Radio Buttons */
                CASE 'radio':
                    // Radio button
                    $val = rtrim($row['values'], ","); // trim last Comma in values
                    $values = explode(',', $val);
                    if ($row['required'] == 1) {
                        $required = 'required';
                        $req = '*';
                    }

                    echo '<div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">' . $row['label'] . ' ' . $req . '</label>
                        <div class="col-xs-12 col-sm-9">';
                    for ($i = 0; $i < count($values); $i++) {
                        $subVal = explode(':', $values[$i]);
                        $r_check = '';
                        // for checked or not

                        if ($row['value'] <> '') {
                            if ($row['value'] == $subVal[0]) {
                                $r_check = 'checked="checked"';
                            }
                        } else {
                            if ($subVal[1] == 1) {
                                $r_check = 'checked="checked"';
                            }
                        }

                        echo '<div><label class="blue"><input type="' . $row['type'] . '" name="c_form_' . $n . '" value="' . $subVal[0] . '" ' . $r_check . ' class="' . $required . '" ><span class="lbl">&nbsp;' . $subVal[0] . '</span></label></div>';
                    }
                    echo '<input type="hidden"name="extra_field_id[]" value="' . $row['extra_field_id'] . '"/></div></div>';
                    break;

                /*                 * Checkboxes */
                CASE 'checkbox':
                    // checkbox
                    $val = rtrim($row['values'], ","); // trim last Comma in values
                    $values = explode(',', $val);
                    if ($row['required'] == 1) {
                        $required = 'required';
                        $req = '*';
                    }

                    echo '<div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">' . $row['label'] . ' ' . $req . '</label>
                        <div class="col-xs-12 col-sm-9">';
                    for ($i = 0; $i < count($values); $i++) {
                        $subVal = explode(':', $values[$i]);
                        $checked = '';
                        // for check box is checked or not;

                        if ($row['value'] <> '') {
                            $val = explode(',', $row['value']);
                            if (in_array($subVal[0], $val, true)) {
                                $checked = 'checked="checked"';
                            }
                        } else {
                            if ($subVal[1] == 1) {
                                $checked = 'checked="checked"';
                            }
                        }

                        echo '<div><label class="blue"><input type="' . $row['type'] . '" name="c_form_' . $n . '[]" value="' . $subVal[0] . '" ' . $checked . ' class="' . $required . '" ><span class="lbl">&nbsp;' . $subVal[0] . '</span></label></div>';
                    }
                    echo '<input type="hidden"name="extra_field_id[]" value="' . $row['extra_field_id'] . '"/></div></div>';
                    break;

                /*                 * Select List */
                CASE 'selectlist':
                    // Select List
                    $val = rtrim($row['values'], ","); // trim last Comma in values
                    $values = explode(',', $val);
                    if ($row['required'] == 1) {
                        $required = 'required';
                        $req = '*';
                    }

                    echo '<div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">' . $row['label'] . ' ' . $req . '</label>
                        ';
                    echo '<div class="col-xs-12 col-sm-9"><div class="clearfix">
                        <select class="col-xs-12 col-sm-5 ' . $required . '" id="c_form_' . $n . '" name="c_form_' . $n . '">';
                    for ($i = 0; $i < count($values); $i++) {
                        $subVal = explode(':', $values[$i]);
                        $selected = '';
                        // for check box is checked or not;
                        if ($row['value'] <> '') {
                            if ($row['value'] == $subVal[0]) {
                                $selected = 'selected';
                            }
                        } else {
                            if ($subVal[1] == 1) {
                                $selected = 'selected';
                            }
                        }
                        echo '<option value="' . $subVal[0] . '" ' . $selected . '>' . $subVal[0] . '</option>';
                    }
                    echo '</select><input type="hidden"name="extra_field_id[]" value="' . $row['extra_field_id'] . '"/></div></div></div>';
                    break;



                default:
            }
            $n++;
        }
    }
}

if (!function_exists('get_pages_footer')) {

    function get_pages_footer($limit) {
        $ci = &get_instance();
        $ci->db->cache_on();
        $ci->db->select('*');
        $ci->db->where('status', 1);
        $ci->db->where('show_footer', 1);
        $ci->db->order_by('title', 'ASC');
        $ci->db->limit($limit);
        $q = $ci->db->get('c_contentmanagement');
        $ci->db->cache_off();
        return $q->result_array();
    }

}
if (!function_exists('get_header_menu')) {

    function get_header_menu($limit) {
        $ci = &get_instance();
        $ci->db->cache_on();
        $ci->db->select('*');
        $ci->db->where('status', 1);
        $ci->db->where('show_header', 1);
        $ci->db->where('is_main_page', 1);
        $ci->db->order_by('title', 'ASC');
        $ci->db->limit($limit);
        $q = $ci->db->get('c_contentmanagement');
        $ci->db->cache_off();
        return $q->result_array();
    }

}
if (!function_exists('get_subMenu')) {

    function get_subMenu($id) {
        $ci = &get_instance();
        $ci->db->select('*');
        $ci->db->where('status', 1);
        $ci->db->where('page_id', $id);
        $ci->db->order_by('title', 'ASC');
        $q = $ci->db->get('c_contentmanagement');
        return $q->result_array();
    }

}

/**
 * Method: getCompanyData
 * Params: $id
 * Return: data row
 */
function getCompanyData($id) {
    $ci = get_instance();
    $sql_ = 'SELECT com.* from c_users_companies as com ';
    $sql_ .= ' WHERE com.company_id=' . $id;
    $query = $ci->db->query($sql_);
    if ($query->num_rows() > 0) {
        return $query->row_array();
    }
}

/**
 * Method: get_email_tempData
 * Params: $email_type
 * Return: array
 */
if (!function_exists('get_email_tempData')) {

    function get_email_tempData($email_type) {
        $ci = get_instance();
        $ci->db->select("*");
        $ci->db->from('c_email_templates');
        $ci->db->where('email_template_type', $email_type);
        $ci->db->where('status', 1);
        $ci->db->order_by('id', 'desc');
        $ci->db->limit(1);
        $query = $ci->db->get();
        if ($query->num_rows >= 1) {
            return $query->row_array();
        }
    }

}
/**
 * ******For single column value
 * */
if (!function_exists('get_user_col_value')) {

    function get_user_col_value($cols, $where = '', $criteria = '') {
        $ci = &get_instance();
        $arr_results = array();
        $ci->db->select($cols);
        $ci->db->where($where, $criteria);
        $ci->db->from('resellers');
        $ci->db->limit(1);
        $results = $ci->db->get();
        if ($results->num_rows() > 0) {
            return $results->row_array();
        }
    }

}
/**
 * ******For complete user data
 * */
if (!function_exists('get_user_data')) {

    function get_user_data($col, $where = '', $criteria = '') {
        $ci = &get_instance();
        $ci->db->select($col);
        $ci->db->where($where, $criteria);
        $ci->db->from('resellers');
        $ci->db->limit(1);
        $results = $ci->db->get();
        if ($results->num_rows() > 0) {
            return $results->row_array();
        }
    }

}

/**
 * Method: generateCategories for advertisements
 * Params: $parent,$level,$sel
 * Return: categories
 */
if (!function_exists('generateCategories')) {

    function generateCategories($parent, $level, $sel) {
        $ci = &get_instance();
        $ci->db->where('parent_id', $parent);
        $ci->db->select('category_id,category_name');
        $ci->db->where('status', 1);
        $query = $ci->db->get('c_product_categories');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if (is_array($sel)) {
                    if (in_array($row->category_id, $sel)) {
                        $seletd = 'selected="selected"';
                    } else {
                        $seletd = '';
                    }
                } else {
                    if ($row->category_id == $sel) {
                        $seletd = 'selected="selected"';
                    } else {
                        $seletd = '';
                    }
                }
                echo '<option value="' . $row->category_id . '" ' . $seletd . '>' . str_repeat('-', $level) . ' ' . $row->category_name . '</option>';
                generateCategories($row->category_id, $level + 1, $sel);
            }
        }
    }

}

/* Get Banner Code* */

function get_banner_code($direction, $advertising_id, $parent_categories) {
    $cat_id = '';
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    $urlType = @$uri[1];
    $urlType1 = @$uri[2];
    if ($urlType == '' || $urlType == 'post') {
        $type = 1;
    } elseif ($urlType == 'equipment-listings' || $urlType == 'parts-listings') {
        $type = 2;
        if ($urlType1 <> '') {
            $cat_id = getVal('category_id', 'c_product_categories', 'category_slug', $urlType1);
        }
    } else {
        $type = 1;
    }
    if ($type <> 0) {
        $whr = '';
        if ($advertising_id <> '' && $advertising_id <> 0) {
            $whr .= ' AND advertising_id <> ' . $advertising_id;
        }
        if ($parent_categories <> '' && $parent_categories <> 0) {
            $whr .= ' AND category_id IN (' . $parent_categories . ')';
        }
        if ($type <> '' && $type <> 0) {
            $whr .= ' AND is_home  = ' . $type;
        }
        if ($cat_id <> '') {
            $whr .= ' AND category_id = ' . $cat_id;
        }
        $CI = & get_instance();
        $query = "SELECT *
                  FROM
                 	c_advertisings
					 WHERE  end_date >= '" . date('Y-m-d') . "' AND advertising_destination_id = '" . $direction . "' and status = 1 " . $whr . "
					 ORDER BY  RAND(), `advertising_id` desc limit 1
                ";
//    $CI->db->cache_on();
//    $CI->db->cache_delete();
        $query = $CI->db->query($query);
//    $CI->db->cache_off();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
    }
}

/* Get Banner Code* */

function get_banner_code_array($direction, $advertising_id, $parent_categories) {
    $cat_id = '';
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    $urlType = @$uri[1];
    $urlType1 = @$uri[2];
    if ($urlType == '' || $urlType == 'post') {
        $type = 1;
    } elseif ($urlType == 'equipment-listings' || $urlType == 'parts-listings') {
        $type = 2;
        if ($urlType1 <> '') {
            $cat_id = getVal('category_id', 'c_product_categories', 'category_slug', $urlType1);
        }
    } else {
        $type = 1;
    }
    if ($type <> 0) {
        $whr = '';
        if ($advertising_id <> '' && $advertising_id <> 0) {
            $whr .= ' AND advertising_id <> ' . $advertising_id;
        }
        if ($parent_categories <> '' && $parent_categories <> 0) {
            $whr .= ' AND category_id IN (' . $parent_categories . ')';
        }
        if ($type <> '' && $type <> 0) {
            $whr .= ' AND is_home  = ' . $type;
        }
        if ($cat_id <> '') {
            $whr .= ' AND category_id = ' . $cat_id;
        }
        $CI = & get_instance();
        $query = "SELECT *
                  FROM
                 	c_advertisings
					 WHERE  end_date >= '" . date('Y-m-d') . "' AND advertising_destination_id = '" . $direction . "' and status = 1 " . $whr . "
					 ORDER BY  RAND(), `advertising_id` desc limit 3
                ";
        $query = $CI->db->query($query);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
    }
    
}

function get_assignable_bars($val){
        if($val=='12') 
            $ary=array(4,8,12);  
        else if($val=='8')
            $ary=array(4,8);  
        else
            $ary=array(4);  
        
        return $ary;
   }
