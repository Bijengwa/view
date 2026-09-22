<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eduview_admin_dashboard extends Eduview_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('eduview_platform_model');
    }

    public function index()
    {
        $this->data['schools'] = $this->eduview_platform_model->get_schools();
        $this->data['title'] = 'EduView Platform Administration';
        $this->load->view('eduview_admin/dashboard', $this->data);
    }

    public function schools()
    {
        $this->data['schools'] = $this->eduview_platform_model->get_schools();
        $this->data['title'] = 'Schools';
        $this->load->view('eduview_admin/schools', $this->data);
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
            set_alert('error', 'Enter valid school and administrator details.');
        }
        $this->data['title'] = 'Register School';
        $this->load->view('eduview_admin/create_school', $this->data);
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
        $this->data['title'] = 'School Details';
        $this->load->view('eduview_admin/school_view', $this->data);
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
            set_alert('error', 'Enter valid school details and an available subdomain.');
        }
        $this->data['school'] = $school;
        $this->data['title'] = 'Edit School';
        $this->load->view('eduview_admin/edit_school', $this->data);
    }

    public function school_admins()
    {
        $this->data['admins'] = $this->eduview_platform_model->get_school_admins();
        $this->data['title'] = 'School Admins';
        $this->load->view('eduview_admin/school_admins', $this->data);
    }
}