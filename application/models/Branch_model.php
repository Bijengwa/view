<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Branch_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /* update branch-only fields; school-level fields live in School Profile */
    public function save($data)
    {
        $id = (int) $data['branch_id'];
        if (empty($id) || (is_school_context() && !$this->belongs_to_current_school($id))) {
            return false;
        }
        $arrayBranch = array(
            'name' => trim($data['branch_name']),
            'email' => trim((string) $data['email']),
            'mobileno' => trim((string) $data['mobileno']),
            'city' => trim((string) $data['city']),
            'state' => trim((string) $data['state']),
            'address' => trim((string) $data['address']),
        );
        $this->db->where('id', $id);
        if (is_school_context()) {
            $this->db->where('school_profile_id', get_loggedin_school_profile_id());
        }
        $this->db->update('branch', $arrayBranch);
        return $this->db->affected_rows() >= 0;
    }

    /* create a branch with only branch-specific fields; the rest comes from the school */
    public function create_for_school($data)
    {
        $school_profile_id = get_loggedin_school_profile_id();
        $school = $this->db->where('id', $school_profile_id)->get('school_profiles')->row_array();
        if (empty($school)) {
            return false;
        }
        $email = trim((string) $data['email']);
        $phone = trim((string) $data['mobileno']);
        $arrayBranch = array(
            'name' => trim($data['branch_name']),
            'school_name' => $school['name'],
            'email' => $email !== '' ? $email : (string) $school['email'],
            'mobileno' => $phone !== '' ? $phone : (string) $school['phone'],
            'currency' => !empty($school['currency']) ? $school['currency'] : 'Tzs',
            'symbol' => !empty($school['currency_symbol']) ? $school['currency_symbol'] : 'TZS',
            'timezone' => !empty($school['timezone']) ? $school['timezone'] : 'Africa/Dar_es_Salaam',
            'city' => trim((string) $data['city']),
            'state' => trim((string) $data['state']),
            'address' => trim((string) $data['address']),
            'translation' => 'english',
            'school_profile_id' => $school_profile_id,
            'status' => 1,
        );
        $this->db->insert('branch', $arrayBranch);
        $id = $this->db->insert_id();
        return $id ? $id : false;
    }

    public function get_branches_by_school($school_profile_id)
    {
        return $this->db->where('school_profile_id', $school_profile_id)
            ->where('status', 1)
            ->order_by('name', 'ASC')
            ->get('branch')
            ->result_array();
    }

    public function belongs_to_current_school($branch_id)
    {
        return is_branch_in_current_school($branch_id);
    }
}
