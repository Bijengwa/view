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

    public function save($data)
    {
        $arrayBranch = array(
            'name' => $data['branch_name'],
            'school_name' => $data['school_name'],
            'email' => $data['email'],
            'mobileno' => $data['mobileno'],
            'currency' => $data['currency'],
            'symbol' => $data['currency_symbol'],
            'city' => $data['city'],
            'state' => $data['state'],
            'address' => $data['address'],
        );
        if (is_school_context()) {
            $arrayBranch['school_profile_id'] = get_loggedin_school_profile_id();
        }
        if (!isset($data['branch_id'])) {
            $this->db->insert('branch', $arrayBranch);
            $id = $this->db->insert_id();
        } else {
            $id = $data['branch_id'];
            if (is_school_context() && !$this->belongs_to_current_school($id)) {
                return false;
            }
            $this->db->where('id', $data['branch_id']);
            if (is_school_context()) {
                $this->db->where('school_profile_id', get_loggedin_school_profile_id());
            }
            $this->db->update('branch', $arrayBranch);
        }

        $file_upload = false;
        if (isset($_FILES["logo_file"]) && !empty($_FILES['logo_file']['name'])) {
            $fileInfo = pathinfo($_FILES["logo_file"]["name"]);
            $img_name = $id . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["logo_file"]["tmp_name"], "uploads/app_image/logo-" . $img_name);
            $file_upload = true;
        }
        if (isset($_FILES["text_logo"]) && !empty($_FILES['text_logo']['name'])) {
            $fileInfo = pathinfo($_FILES["text_logo"]["name"]);
            $img_name = $id . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["text_logo"]["tmp_name"], "uploads/app_image/logo-small-" . $img_name);
            $file_upload = true;
        }

        if (isset($_FILES["print_file"]) && !empty($_FILES['print_file']['name'])) {
            $fileInfo = pathinfo($_FILES["print_file"]["name"]);
            $img_name = $id . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["print_file"]["tmp_name"], "uploads/app_image/printing-logo-" . $img_name);
            $file_upload = true;
        }

        if (isset($_FILES["report_card"]) && !empty($_FILES['report_card']['name'])) {
            $fileInfo = pathinfo($_FILES["report_card"]["name"]);
            $img_name = $id . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["report_card"]["tmp_name"], "uploads/app_image/report-card-logo-" . $img_name);
            $file_upload = true;
        }

        if ($this->db->affected_rows() > 0 || $file_upload == true) {
            return true;
        } else {
            return false;
        }
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
