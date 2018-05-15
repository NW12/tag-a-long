<?php

/*
----------------------------
Site settings     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Site_settings extends CI_Controller {



    public $tbl = 'site_settings';



    public function __construct() {

        parent::__construct();

        // check if admin login

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        // Check rights

        if (rights(5) != true) {

            redirect(base_url('admin/dashboard'));

        }

        $this->load->model('site_settings_model');

    }



// End __construct

    /**

     * Method: index

     */

    public function index() {

        $result = $this->site_settings_model->getSettings();

        $row = array();

        foreach($result as $row1)

        {

            $row[$row1['option_name']] = $row1['option_value'];

        }    

        $data['row'] = $row;

        

        if ($this->input->post()) {

            /// SITE LOGO

            if ($_FILES['site_logo']['name'] != '') {

                unlink('uploads/site/pic/' . $_POST['old_site_logo']);

                unlink('uploads/site/small/' . $_POST['old_site_logo']);

                $extension = $this->common->getExtension($_FILES ['site_logo'] ['name']);

                $extension = strtolower($extension);

                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {

                    return false;

                }

                $path = 'uploads/site/';

                $allow_types = 'gif|jpg|jpeg|png';

                $max_height = '8000';

                $max_width = '8000';

                $site_logo = $this->common->do_upload_image($path, $allow_types, $max_height, $max_width, $_FILES ['site_logo']['tmp_name'], $_FILES ['site_logo']['name']);

            }



            /// FAVICON

            if ($_FILES['favicon']['name'] != '') {

                unlink('uploads/site/pic/' . $_POST['old_favicon']);

                unlink('uploads/site/small/' . $_POST['old_favicon']);

                $extension = $this->common->getExtension($_FILES ['favicon'] ['name']);

                $extension = strtolower($extension);

                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {

                    return false;

                }

                $path = 'uploads/site/';

                $allow_types = 'gif|jpg|jpeg|png';

                $max_height = '8000';

                $max_width = '8000';

                $favicon = $this->common->do_upload_favicon($path, $allow_types, $max_height, $max_width, $_FILES ['favicon']['tmp_name'], $_FILES ['favicon']['name']);

            }



            $db_query = $this->site_settings_model->saveItem($_POST, $site_logo, $favicon);



            if ($db_query) {

                $this->session->set_flashdata('success_message', 'Information successfully saved.');

                redirect('admin/site_settings'); // due to flash data.

            } else {

                $this->session->set_flashdata('error_message', 'Opps! Error saving informtion. Please try again.');

            }

        }

        $data['adExpiryDaysArr'] = $this->adExpiryDays();

        $data ['content'] = $this->load->view('site_settings/form', $data, true); //Return View as data

        $this->load->view('templete-view', $data);

    }



    /**

	 * Method: adExpiryDays

	 * Returns: array

	 */

	public function adExpiryDays(){

		$result = array();

		for($i=730; $i>=1; $i--){

			$result[$i] = $i;

		}

		return $result;

	}

}



//End Class