<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eduview_platform_model extends MY_Model
{
    private $reserved_subdomains = array('www', 'admin', 'api', 'mail', 'ftp', 'eduview-admin');

    public function get_schools()
    {
        return $this->db->select('sp.*, COUNT(DISTINCT spa.id) as admin_count, COUNT(DISTINCT b.id) as branch_count')
            ->from('school_profiles sp')
            ->join('school_profile_admins spa', 'spa.school_profile_id = sp.id AND spa.status = 1', 'left')
            ->join('branch b', 'b.school_profile_id = sp.id', 'left')
            ->group_by('sp.id')
            ->order_by('sp.created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function create_school($school, $admin)
    {
        $subdomain = strtolower(trim($school['subdomain']));
        if (!$this->valid_subdomain($subdomain) || !$this->is_subdomain_available($subdomain)) {
            return false;
        }
        if (!$this->is_admin_email_available($admin['email'])) {
            return false;
        }

        $this->db->trans_begin();
        $this->db->insert('school_profiles', array(
            'uuid' => sprintf('%s-%s-%s-%s-%s', bin2hex(random_bytes(4)), bin2hex(random_bytes(2)), bin2hex(random_bytes(2)), bin2hex(random_bytes(2)), bin2hex(random_bytes(6))),
            'name' => $school['name'],
            'slug' => $subdomain,
            'subdomain' => $subdomain,
            'email' => $school['email'],
            'phone' => $school['phone'],
            'address' => $school['address'],
            'website' => $school['website'],
            'status' => 1,
        ));
        $school_id = $this->db->insert_id();

        $this->db->insert('staff', array(
            'staff_id' => substr(md5(uniqid('', true)), 0, 7),
            'name' => $admin['name'],
            'department' => 0,
            'qualification' => '',
            'designation' => 0,
            'joining_date' => date('Y-m-d'),
            'birthday' => '',
            'sex' => '',
            'religion' => '',
            'blood_group' => '',
            'present_address' => '',
            'permanent_address' => '',
            'mobileno' => $admin['phone'],
            'email' => $admin['email'],
            'salary_template_id' => 0,
        ));
        $staff_id = $this->db->insert_id();

        $this->db->insert('login_credential', array(
            'user_id' => $staff_id,
            'username' => $admin['email'],
            'password' => password_hash($admin['password'], PASSWORD_BCRYPT),
            'role' => 1,
            'active' => 1,
        ));
        $this->db->insert('school_profile_admins', array(
            'school_profile_id' => $school_id,
            'staff_id' => $staff_id,
            'is_primary' => 1,
            'status' => 1,
        ));
        $this->db->insert('branch', array(
            'name' => $school['name'],
            'school_name' => $school['name'],
            'email' => $school['email'],
            'mobileno' => $school['phone'],
            'currency' => 'Tzs',
            'symbol' => 'TZS',
            'city' => '',
            'state' => '',
            'address' => $school['address'],
            'timezone' => 'Africa/Nairobi',
            'school_profile_id' => $school_id,
            'status' => 1,
        ));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return array('id' => $school_id, 'slug' => $subdomain);
    }

    public function get_school($school_id)
    {
        return $this->db->where('id', $school_id)->get('school_profiles')->row_array();
    }

    public function update_school($school_id, $school)
    {
        $subdomain = strtolower(trim($school['subdomain']));
        if (!$this->valid_subdomain($subdomain) || !$this->is_subdomain_available($subdomain, $school_id)) {
            return false;
        }
        return $this->db->where('id', $school_id)->update('school_profiles', array(
            'name' => $school['name'],
            'subdomain' => $subdomain,
            'slug' => $subdomain,
            'email' => $school['email'],
            'phone' => $school['phone'],
            'address' => $school['address'],
            'website' => $school['website'],
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    public function valid_subdomain($subdomain)
    {
        return preg_match('/^[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?$/', $subdomain) === 1
            && !in_array($subdomain, $this->reserved_subdomains, true);
    }

    public function is_subdomain_available($subdomain, $except_id = null)
    {
        $this->db->where('subdomain', $subdomain);
        if ($except_id) {
            $this->db->where('id !=', $except_id);
        }
        return $this->db->count_all_results('school_profiles') === 0;
    }

    public function is_admin_email_available($email, $except_user_id = null)
    {
        $this->db->where('username', $email);
        if ($except_user_id) {
            $this->db->where('user_id !=', $except_user_id);
        }
        return $this->db->count_all_results('login_credential') === 0;
    }

    public function get_school_branches($school_id)
    {
        return $this->db->where('school_profile_id', $school_id)
            ->order_by('name', 'ASC')
            ->get('branch')
            ->result_array();
    }

    public function set_school_status($school_id, $status)
    {
        return $this->db->where('id', $school_id)->update('school_profiles', array(
            'status' => ((int) $status === 1 ? 1 : 0),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    public function get_school_admins()
    {
        return $this->db->select('s.name as admin_name, s.email, s.mobileno, sp.name as school_name, sp.slug, spa.status')
            ->from('school_profile_admins spa')
            ->join('staff s', 's.id = spa.staff_id')
            ->join('school_profiles sp', 'sp.id = spa.school_profile_id')
            ->order_by('sp.name', 'ASC')
            ->order_by('s.name', 'ASC')
            ->get()
            ->result_array();
    }
}