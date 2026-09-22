<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* School-level profile. Only the school superadmin can edit it. */
class School_profile extends Admin_Controller
{
    private $logo_types = array(
        'logo_file' => 'logo',
        'text_logo' => 'logo-small',
        'print_file' => 'printing-logo',
        'report_card' => 'report-card-logo',
    );

    public function __construct()
    {
        parent::__construct();
        if (!is_superadmin_loggedin()) {
            access_denied();
        }
    }

    public function index()
    {
        $school_id = (int) get_loggedin_school_profile_id();
        $school = $this->db->where('id', $school_id)->get('school_profiles')->row_array();
        if (empty($school)) {
            show_404();
        }

        if ($this->input->post('submit') == 'save') {
            $this->form_validation->set_rules('name', 'School Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('email', translate('email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', translate('mobile_no'), 'trim');
            $this->form_validation->set_rules('website', 'Website', 'trim');
            $this->form_validation->set_rules('address', translate('address'), 'trim');
            $this->form_validation->set_rules('description', 'Description', 'trim');
            $this->form_validation->set_rules('currency', translate('currency'), 'trim|required');
            $this->form_validation->set_rules('currency_symbol', translate('currency_symbol'), 'trim|required');
            $this->form_validation->set_rules('timezone', translate('timezone'), 'trim|required');
            if ($this->form_validation->run() == true) {
                $post = $this->input->post(null, true);
                $data = array(
                    'name' => $post['name'],
                    'email' => $post['email'],
                    'phone' => $post['phone'],
                    'website' => $post['website'],
                    'address' => $post['address'],
                    'description' => $post['description'],
                    'currency' => $post['currency'],
                    'currency_symbol' => $post['currency_symbol'],
                    'timezone' => $post['timezone'],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->trans_start();
                $this->db->where('id', $school_id)->update('school_profiles', $data);
                // keep every branch of this school in sync with school-level fields
                $this->db->where('school_profile_id', $school_id)->update('branch', array(
                    'school_name' => $data['name'],
                    'currency' => $data['currency'],
                    'symbol' => $data['currency_symbol'],
                    'timezone' => $data['timezone'],
                ));
                $this->db->trans_complete();

                foreach ($this->logo_types as $field => $type) {
                    save_uploaded_logo($field, 'uploads/app_image/school-' . $type . '-' . $school_id . '.png');
                }
                set_alert('success', translate('information_has_been_updated_successfully'));
                redirect(base_url('school_profile'));
            }
            $school = array_merge($school, $this->input->post(null, true));
        }

        $this->data['school'] = $school;
        $this->data['branches'] = $this->db->where('school_profile_id', $school_id)->order_by('id', 'ASC')->get('branch')->result_array();
        $this->data['timezones'] = $this->app_lib->timezone_list();
        $this->data['title'] = 'School Profile';
        $this->data['sub_page'] = 'school_profile/index';
        $this->data['main_menu'] = 'school_profile';
        $this->data['headerelements'] = array(
            'css' => array('vendor/dropify/css/dropify.min.css'),
            'js' => array('vendor/dropify/js/dropify.min.js'),
        );
        $this->load->view('layout/index', $this->data);
    }
}
