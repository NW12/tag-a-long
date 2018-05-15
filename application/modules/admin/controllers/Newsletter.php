<?php

/*
----------------------------
Newsletter     ----    Controller
----------------------------
*/

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Newsletter extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->engineinit->_is_not_admin_logged_in_redirect('admin/login');

        // Check rights

        if (rights(29) != true ) {

            redirect(base_url('admin/dashboard'));

        }

        $this->load->model('newsletter_model');

        $this->load->library('emailutility');

    }

// End __construct

    /**

      @Method: index

      @Return: vehicles Listing

     */

    public function index() {

        $data['result'] = $this->newsletter_model->loadListing();

        $data ['content'] = $this->load->view('newsletter/listing', $data, true);

        $this->load->view('templete-view.php', $data);

    }

    /**

      @Method:  Delete subscribe user email address from mailchimp and also

     * form database change newsletter_subscriber to 0

      @Params: itemId

      @Retrun: True/False

     */

    public function delete($itemId,$type) {

        error_reporting(E_ALL);

         $company_id = $this->common->decode($itemId);

        if ($type == 1) {

            $user = $this->newsletter_model->getNewsletterData($company_id);

        } else {

            $user = getCompanyData($company_id);

        }

        $chimp_email = $user['email'];

        $status = 0;

        if ($type == 1) {

            $result = $this->newsletter_model->deleteNewsLetter($company_id, $status);

        } else {

            $result = $this->newsletter_model->updateItemStatus($company_id, $status);

        }

        $list_id = MAIL_CHIMP_ID;

        $api_key = MAIL_CHIMP_KEY;

        $this->load->library('MCAPI', array('apikey' => $api_key));

        if ($this->mcapi->listUnsubscribe($list_id, $chimp_email) === true) {

            $this->mcapi->listUnsubscribe($list_id, $chimp_email);



            $this->session->set_flashdata('success_message', 'Record deleted successfully.');

                redirect('admin/newsletter'); // due to flash data.

        } else {

            $this->session->set_flashdata('error_message', 'Error: ' . $this->mcapi->errorMessage);

        }





    }

    function send_newsletter() {

        $user_data = $this->newsletter_model->loadAllSubscribers();

        if ($this->input->post()) {

            foreach ($user_data as $row) {

                $email = $row['email'];

                if ($this->input->post('title') <> '') {

                    $data['title'] = $this->input->post('title');

                    $data['content'] = $this->input->post('content');

                    $data['footer'] = $this->input->post('footer');

                } else {

                    $data['title'] = SITE_NAME;

                    $data['content'] = $this->load->view('email_templates/email_content.php', $data, true);

                    $data['footer'] = $this->load->view('email_templates/email_footer.php', $data, true);

                }

                /*                 * *****************WELCOME EMAIL********************** */

                /*                 * ** Send NEWSLETTER Email Start ***** */

                $data['email_content'] = "We hope you enjoy ".SITE_NAME." and if there's anything you would like to ask or leave a feedback, please contact us <a href='mailto:" . ADMIN_EMAIL . "'>directly via mail</a>.

                      <br /><br />Thank You,<br />";

                $subjects = $data['title'];

                 $email_contents = $this->load->view('includes/email_templates/email_template', $data, true);

                $db_query = $this->emailutility->send_email_user($email_contents, $email, $subjects);

                unset($data);

                /*                 * ** Send WELCOME Email End ***** */

            }

                $this->session->set_flashdata('success_message', 'Newsletter sent successfully.');

                redirect('admin/newsletter'); // due to flash data.



        }

        $data['emails_data'] = $this->newsletter_model->get_all_active_email_template(6);

        $id = 0;

        if (empty($data['emails_data'])) {

            $email_footer = './application/views/email_templates/email_footer.php';

            $email_content = './application/views/email_templates/email_content.php';

            $handl = fopen($email_content, "rb");

            $content = fread($handl, filesize($email_content));

            fclose($handl);

            $data['content_data'] = ($content);

            $handle = fopen($email_footer, "rb");

            $contents = fread($handle, filesize($email_footer));

            fclose($handle);

            $data['footer_data'] = ($contents);

            $data['welcome_content'] = '';

        } else {

            $data['title'] = $data['emails_data']['title'];

            $data['welcome_content'] = $data['emails_data']['welcome_content'];

            $data['content_data'] = $data['emails_data']['content'];

            $data['footer_data'] = $data['emails_data']['footer'];

            $data['id'] = $id = $data['emails_data']['id'];

            $data['is_active'] = $data['emails_data']['is_active'];

        }

        $data ['content'] = $this->load->view('newsletter/form', $data, true);

        $this->load->view('templete-view.php', $data);

    }

}

//End Class