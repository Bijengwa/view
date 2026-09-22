<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eduview_admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('authentication_model');
        $this->load->model('eduview_platform_model');
    }

    public function login()
    {
        if (is_eduview_admin_loggedin()) {
            redirect(base_url('eduview-admin/home'));
        }
        if ($this->input->method() === 'post') {
            $credential = $this->authentication_model->login_credential(
                $this->input->post('email', true),
                $this->input->post('password')
            );
            $allowed = false;
            if ($credential && (int) $credential->role === 1 && $this->db->table_exists('eduview_platform_admins')) {
                $allowed = $this->db->where('staff_id', $credential->user_id)
                    ->where('status', 1)
                    ->count_all_results('eduview_platform_admins') === 1;
            }
            if ($allowed && (int) $credential->active === 1) {
                $user = $this->application_model->getUserNameByRoleID($credential->role, $credential->user_id);
                $this->session->set_userdata(array(
                    'name' => $user['name'],
                    'loggedin_id' => $credential->id,
                    'loggedin_userid' => $credential->user_id,
                    'loggedin_role_id' => $credential->role,
                    'loggedin_branch' => null,
                    'loggedin_school_profile_id' => null,
                    'eduview_admin_loggedin' => true,
                    'loggedin_type' => 'platform_admin',
                    'loggedin' => true,
                ));
                redirect(base_url('eduview-admin/home'));
            }
            set_alert('error', translate('username_password_incorrect'));
            redirect(base_url('eduview-admin/login'));
        }
        $this->load->view('eduview_admin/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('eduview-admin/login'));
    }
}