<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eduview_admin_dashboard extends Eduview_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('eduview_platform_model');
    }

    private function render($sub_page, $title, $main_menu)
    {
        $this->data['sub_page'] = 'eduview_admin/' . $sub_page;
        $this->data['title'] = $title;
        $this->data['main_menu'] = $main_menu;
        $this->load->view('eduview_admin/layout', $this->data);
    }

    public function index()
    {
        $this->data['schools'] = $this->eduview_platform_model->get_schools();
        $this->render('home', 'Home', 'home');
    }

    public function schools()
    {
        $this->data['schools'] = $this->eduview_platform_model->get_schools();
        $this->render('schools', 'Schools', 'schools');
    }

    public function create_school()
    {
        if ($this->input->method() === 'post') {
            $school = array(
                'name' => trim($this->input->post('school_name', true)),
                'subdomain' => strtolower(trim($this->input->post('school_subdomain', true))),
                'email' => trim($this->input->post('school_email', true)),
                'phone' => trim($this->input->post('school_phone', true)),
                'address' => trim($this->input->post('school_address', true)),
                'website' => trim($this->input->post('school_website', true)),
            );
            $admin = array(
                'name' => trim($this->input->post('admin_name', true)),
                'email' => trim($this->input->post('admin_email', true)),
                'phone' => trim($this->input->post('admin_phone', true)),
                'password' => $this->input->post('admin_password'),
            );
            if ($school['name'] && $this->eduview_platform_model->valid_subdomain($school['subdomain']) && filter_var($school['email'], FILTER_VALIDATE_EMAIL) && $admin['name'] && filter_var($admin['email'], FILTER_VALIDATE_EMAIL) && strlen($admin['password']) >= 8 && $admin['password'] === $this->input->post('admin_password_confirmation')) {
                $result = $this->eduview_platform_model->create_school($school, $admin);
                if ($result) {
                    set_alert('success', 'School registered at ' . $result['slug']);
                    redirect(base_url('eduview-admin/schools'));
                }
            }
            $this->data['page_alert'] = array('error', 'Enter valid school and administrator details.');
        }
        $this->render('create_school', 'Register School', 'register_school');
    }

    public function set_school_status($school_id, $status)
    {
        if ($this->input->method() !== 'post') {
            show_error('Method Not Allowed', 405);
        }
        $this->eduview_platform_model->set_school_status((int) $school_id, (int) $status);
        redirect(base_url('eduview-admin/schools'));
    }

    public function view_school($school_id)
    {
        $school = $this->eduview_platform_model->get_school((int) $school_id);
        if (empty($school)) {
            show_404();
        }
        $this->data['school'] = $school;
        $this->data['branches'] = $this->eduview_platform_model->get_school_branches($school_id);
        $this->render('school_view', 'School Details', 'schools');
    }

    public function edit_school($school_id)
    {
        $school_id = (int) $school_id;
        $school = $this->eduview_platform_model->get_school($school_id);
        if (empty($school)) {
            show_404();
        }
        if ($this->input->method() === 'post') {
            $data = array(
                'name' => trim($this->input->post('school_name', true)),
                'subdomain' => strtolower(trim($this->input->post('school_subdomain', true))),
                'email' => trim($this->input->post('school_email', true)),
                'phone' => trim($this->input->post('school_phone', true)),
                'address' => trim($this->input->post('school_address', true)),
                'website' => trim($this->input->post('school_website', true)),
            );
            if ($data['name'] && filter_var($data['email'], FILTER_VALIDATE_EMAIL) && $this->eduview_platform_model->update_school($school_id, $data)) {
                set_alert('success', 'School updated successfully.');
                redirect(base_url('eduview-admin/schools/view/' . $school_id));
            }
            $this->data['page_alert'] = array('error', 'Enter valid school details and an available subdomain.');
        }
        $this->data['school'] = $school;
        $this->render('edit_school', 'Edit School', 'schools');
    }

    public function school_admins()
    {
        $this->data['admins'] = $this->eduview_platform_model->get_school_admins();
        $this->render('school_admins', 'School Admins', 'school_admins');
    }

    public function settings()
    {
        $credential_id = (int) $this->session->userdata('loggedin_id');
        $staff_id = (int) $this->session->userdata('loggedin_userid');
        $credential = $this->db->where('id', $credential_id)->get('login_credential')->row_array();
        $staff = $this->db->select('name')->where('id', $staff_id)->get('staff')->row_array();
        if (empty($credential)) {
            redirect(base_url('eduview-admin/logout'));
        }

        if ($this->input->method() === 'post') {
            $name = trim($this->input->post('name', true));
            $email = strtolower(trim($this->input->post('email', true)));
            $new_password = (string) $this->input->post('new_password');
            $confirm = (string) $this->input->post('confirm_password');
            $current = (string) $this->input->post('current_password');

            $error = '';
            if (!$this->app_lib->verify_password($current, $credential['password'])) {
                $error = 'Current password is incorrect.';
            } elseif ($name === '') {
                $error = 'Name is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Enter a valid email.';
            } elseif ($this->db->where('username', $email)->where('id !=', $credential_id)->count_all_results('login_credential') > 0) {
                $error = 'This email is already used by another account.';
            } elseif ($new_password !== '' && strlen($new_password) < 8) {
                $error = 'New password must be at least 8 characters.';
            } elseif ($new_password !== $confirm) {
                $error = 'New password and confirm password do not match.';
            }

            if ($error === '') {
                $update = array('username' => $email, 'updated_at' => date('Y-m-d H:i:s'));
                if ($new_password !== '') {
                    $update['password'] = $this->app_lib->pass_hashed($new_password);
                }
                $this->db->where('id', $credential_id)->update('login_credential', $update);
                $this->db->where('id', $staff_id)->update('staff', array('name' => $name, 'email' => $email));
                $this->session->set_userdata('name', $name);
                set_alert('success', 'Account updated successfully.');
                redirect(base_url('eduview-admin/settings'));
            }
            $this->data['page_alert'] = array('error', $error);
        }

        $this->data['account'] = array(
            'name' => isset($staff['name']) ? $staff['name'] : '',
            'username' => $credential['username'],
        );
        $this->render('settings', 'Settings', 'settings');
    }
}