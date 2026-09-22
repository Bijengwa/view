<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authentication_model extends MY_Model
{

    // checking login credential
    public function login_credential($username, $password)
    {
        $this->db->select('*');
        $this->db->from('login_credential');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $verify_password = $this->app_lib->verify_password($password, $query->row()->password);
            if ($verify_password) {
                return $query->row();
            }
        }
        return false;
    }

    public function get_school_context($user_id, $role_id, $branch_id = null)
    {
        if ($this->db->table_exists('school_profile_admins') && $role_id == 1) {
            $admin = $this->db->select('spa.school_profile_id, sp.status')
                ->from('school_profile_admins spa')
                ->join('school_profiles sp', 'sp.id = spa.school_profile_id')
                ->where('spa.staff_id', $user_id)
                ->where('spa.status', 1)
                ->where('spa.is_primary', 1)
                ->limit(1)
                ->get()
                ->row_array();
            if (!empty($admin)) {
                return $admin;
            }
        }

        if (empty($branch_id)) {
            return null;
        }

        return $this->db->select('b.school_profile_id, sp.status')
            ->from('branch b')
            ->join('school_profiles sp', 'sp.id = b.school_profile_id', 'left')
            ->where('b.id', $branch_id)
            ->limit(1)
            ->get()
            ->row_array();
    }

    public function get_school_by_host($host)
    {
        $base_domain = trim((string) $this->config->item('eduview_base_domain'));
        if (empty($base_domain)) {
            return null;
        }
        $host = strtolower(trim((string) $host));
        $base_domain = strtolower(ltrim($base_domain, '.'));
        $suffix = '.' . $base_domain;
        if (substr($host, -strlen($suffix)) !== $suffix) {
            return null;
        }
        $slug = substr($host, 0, -strlen($suffix));
        if (empty($slug) || strpos($slug, '.') !== false) {
            return null;
        }
        return $this->db->where('subdomain', $slug)
            ->where('status', 1)
            ->limit(1)
            ->get('school_profiles')
            ->row_array();
    }

    public function get_default_branch_for_school($school_profile_id)
    {
        return $this->db->select('id')
            ->where('school_profile_id', $school_profile_id)
            ->where('status', 1)
            ->order_by('id', 'ASC')
            ->limit(1)
            ->get('branch')
            ->row_array();
    }

    // password forgotten
    public function lose_password($username)
    {
        if (!empty($username)) {
            $this->db->select('*');
            $this->db->from('login_credential');
            $this->db->where('username', $username);
            $this->db->limit(1);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $login_credential = $query->row();
                $getUser = $this->application_model->getUserNameByRoleID($login_credential->role, $login_credential->user_id);
                $key = hash('sha512', $login_credential->role . $login_credential->username . app_generate_hash());
                $query = $this->db->get_where('reset_password', array('login_credential_id' => $login_credential->id));
                if ($query->num_rows() > 0) {
                    $this->db->where('login_credential_id', $login_credential->id);
                    $this->db->delete('reset_password');
                }
                $arrayReset = array(
                    'key' => $key,
                    'login_credential_id' => $login_credential->id,
                    'username' => $login_credential->username,
                );
                $this->db->insert('reset_password', $arrayReset);
                // send email for forgot password
                $this->load->model('email_model');
                $arrayData = array(
                    'role' => $login_credential->role,
                    'branch_id' => $getUser['branch_id'],
                    'username' => $login_credential->username,
                    'name' => $getUser['name'],
                    'reset_url' => base_url('authentication/pwreset?key=' . $key),
                    'email' => $getUser['email'],
                );
                $this->email_model->sentForgotPassword($arrayData);
                return true;
            }
        }
        return false;
    }

    public function urlaliasToBranch($url_alias)
    {
        $saasExisting = $this->app_lib->isExistingAddon('saas');
        if ($saasExisting && $this->db->table_exists("custom_domain")) {
            $getDomain = $this->getCurrentDomain();
            if(!empty($getDomain)) {
                return $getDomain->school_id;
            }
        }

        $get = $this->db->select('branch_id')
            ->where('url_alias', $url_alias)
            ->get('front_cms_setting')
            ->row_array();
        if (empty($url_alias) || empty($get)) {
            return null;
        } else {
            return $get['branch_id'];
        }
    }

    public function getSegment($id = '')
    {
        $segment = $this->uri->segment($id);
        if (empty($segment)) {
            return '';
        } else {
            return '/' . $segment;
        }
    }

    public function getCurrentDomain()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url = rtrim($url, '/');
        $domain =  parse_url($url, PHP_URL_HOST);
        $getDomain = $this->db->select('school_id')->get_where('custom_domain', array('status' => 1, 'url' => $domain))->row();
        return $getDomain;
    }
}
