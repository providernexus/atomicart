<?php
/* 
	* Author: Subhash Shipu
	* Email: provider.nexus@gmail.com
	* Skype: provider.nexus@gmail.com
 */

namespace App\Models;

use CodeIgniter\Model;

class Common extends Model
{
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }

    public function GetSingleName()
    {
        $builder = $this->db->table('tbl_admin');
        $builder->select('*');
        $builder->where('id', '5', '6');
        $query = $builder->get();
        $builder->resetQuery();
        $arr = $query->getResultArray();

        if ($arr) {
            if (empty($arr)) {
                return false;
            }
            return $query->getRowArray()[$select];
        } else {
            return false;
        }
    }

    //for employe skip tracing data get  
    # Method for  Join
    public function JoinMethod()
    {
        $employe_id = $_SESSION['admin_id'];
        $results = $this->db->query("SELECT tbl_skip_tracing_records.*,tbl_team.name FROM tbl_skip_tracing_records
                 INNER JOIN tbl_team ON tbl_team.id = tbl_skip_tracing_records.team_id
                 WHERE tbl_team.employee_id IN ($employe_id)");
        $result = $results->getResultArray();
        if ($result) {
            if (empty($result)) {
                return false;
            }
            return $result;
        } else {
            return false;
        }
    }

    public function GetFieldByInCond($table, $column, $where = array())
    {
        $builder = $this->db->table($table);
        $builder->select($column);
        $builder->whereIn($where[0], $where[1]);
        $data = $builder->get()->getResultArray();
        return $data;
        //echo $this->db->getLastQuery();
        die();
    }

    public function GetFieldByFindInSetCond($table, $column, $where = array())
    {
        $builder = $this->db->table($table);
        $builder->select($column);
        $builder->where('find_in_set("' . $where[0] . '", ' . $where[1] . ') <> 0');
        $data = $builder->get()->getResultArray();
        return $data;
        //echo $this->db->getLastQuery();
        die();
    }

    public function GetTotalName($value)
    {
        $results = $this->db->query("SELECT name FROM tbl_admin WHERE id IN ($value)");
        $result = $results->getResultArray();
        if ($result) {
            if (empty($result)) {
                return false;
            }
            return $result;
        } else {
            return false;
        }
    }
    public function GetAllName($table, $field_name, $value)
    {
        $results = $this->db->query("SELECT name FROM $table WHERE $field_name IN ($value)");
        $result = $results->getResultArray();
        if ($result) {
            if (empty($result)) {
                return false;
            }
            return $result;
        } else {
            return false;
        }
    }
    public function GetSingleRow($table, $where = null, $order = array('id', 'desc'))
    {
        $builder = $this->db->table($table);
        if (!empty($where)) {
            $builder->where($where);
        }
        if (is_array($order)) {
            $builder->orderBy($order[0], $order[1]);
        }
        return $builder->get()->getRowArray();
        return $builder->get()->getRowArray();
    }

    public function GetNextPreRow($table, $where = null, $type = "next")
    {
        $builder = $this->db->table($table);
        if (!empty($where)) {
            $builder->where($where);
        }
        $query = $builder->get();
        $data['next'] = $query->getNextRow('array');
        $data['pre'] = $query->getPreviousRow('array');
        return $data;
    }

    /* Function used to get table rows  */
    public function GetTableRows($table, $where = null, $order = array('id', 'desc'), $limit_perpage = 0, $offset = 0)
    {
        $builder = $this->db->table($table);
        if (!empty($where)) {
            $builder->where($where);
        }
        if (empty($order)) {
            $order = array('id', 'desc');
        }
        if (is_array($order)) {
            $builder->orderBy($order[0], $order[1]);
        }
        if (!empty($limit_perpage)) {
            $builder->limit($limit_perpage, $offset);
        }

        return $builder->get()->getResultArray();
    }

    /* Function used to get single value from table */
    public function GetSingleValue($table, $select, $where)
    {
        $builder = $this->db->table($table);

        $builder->select($select);
        $builder->where($where);
        $builder->limit(1);
        $query = $builder->get();
        $builder->resetQuery();
        $arr = $query->getRowArray();
        if ($arr) {
            if (empty($arr)) {
                return false;
            }
            return $query->getRowArray()[$select];
        } else {
            return false;
        }
    }
 /* Function used to get GetMinandMaxValue value from table */
    public function GetMinandMaxValue($table, $select, $where)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        $builder->where($where);
        $builder->limit(1);
        $query = $builder->get();
        $builder->resetQuery();
        $arr = $query->getRowArray();
        if ($arr) {
            if (empty($arr)) {
                return false;
            }
            return $query->getRowArray();
        } else {
            return false;
        }
    }
    /* Get the selected fields from table */
    public function GetSelectedFields($table, $fields, $where = null)
    {
        $builder = $this->db->table($table);
        if (!empty($where)) {
            $builder->where($where);
        }
        if (!empty($fields)) {
            $builder->select($fields);
        }
        $result = $builder->get()->getResultArray();
        return $result;
    }

    /* update table row */
    public function UpdateTableData($table, $data, $where)
    {
        $builder = $this->db->table($table);
        if ($where) {
            $builder->where($where);
        }
        if ($builder->update($data)) {
            return true;
        } else {
            return false;
        }
    }

    /* insert data into table */
    public function InsertTableData($table, $data)
    {
        $builder = $this->db->table($table);
        if ($builder->insert($data)) {
            $insert_id = $this->db->insertID();
            return  $insert_id;
        } else {
            return false;
        }
    }
    /* insert multiple data into table */
    public function InsertMultipleData($table, $data)
    {
        $builder = $this->db->table($table);
        if ($builder->insertBatch($data)) {
            return true;
        } else {
            return false;
        }
    }

    /* delete row  */
    public function DeleteTableData($table, $where)
    {
        $builder = $this->db->table($table);
        if ($where) {
            $builder->where($where);
        }
        if ($builder->delete()) {
            return true;
        } else {
            return false;
        }
    }

    // Raw query
    function GetDataByRawQuery($query, $limit = "all")
    {
        $db = db_connect();
        if ($limit == "single") {
            $results = $db->query($query)->getRowArray();
        } else {
            $results = $db->query($query)->getResultArray();
        }
        return $results;
    }

    /* Get media data */
    public function getMediaData($id)
    {
        $json_data['media_src'] = '';
        $json_data['original_name'] = '';
        $file = $this->GetSingleRow(MEDIA_TABLE, array('id' => $id));
        if (!empty($file)) :
            $file_name = $file['name'];
            $json_data['name'] = $file['name'];
            $json_data['original_name'] = $file['original_name'];
            if (!empty($file_name)) :
                if (file_exists(FCPATH . "uploads/" . $file_name)) :
                    //echo base_url();
                    $media_src = base_url('/uploads/' . $file_name . '');
                    //echo $media_src;
                    $json_data['media_src'] = $media_src;
                endif;
            endif;
        endif;
        return json_encode($json_data);
    }

    /* Get total counts  */
    public function GetTotalCount($table, $where = "")
    {
        $builder = $this->db->table($table);
        if ($where) {
            $builder->where($where);
        }
        return $builder->countAllResults();
    }
    /* Select dropdown */
    public function SelectDropdown($table, $option, $field, $value = array(), $where = "", $extra_field = '', $order = '') // selected
    {
        $html = "";
        $builder = $this->db->table($table);
        if (!empty($where)) {
            $builder->where($where);
        }
        if (is_array($order)) {
            $builder->orderBy($order[0], $order[1]);
        }
        $rows = $builder->get()->getResultArray();
        foreach ($rows as $row) {
            $selected = "";
            if (is_array($value)) {
                if (in_array($row[$field], $value)) {
                    $selected = "selected";
                }
            }
            $efield = '';
            if (!empty($extra_field)) {
                $efield = $row[$extra_field];
            }
            $html .= '<option value = "' . $row[$field] . '" ' . $selected . ' extra_field = "' . $efield . '" >' . $row[$option] . '</option>';
        }
        return $html;
    }

    public function getSum($table, $field, $cond = array())
    {
        $builder = $this->db->table($table);
        $builder->selectSum($field);
        if (count($cond)) {
            $builder->where($cond);
        }
        $query = $builder->get();
        if ($query) {
            return $query->getRowArray();
        }
        return false;
    }
    public function update_setting_data($user_data)
    {
        //die('sd');
        foreach ($user_data as $data) {
            $type = $data['type'];
            $condition = array('type' => $type);
            $key_exist = self::GetTotalCount(SETTINGS_TABLE, $condition);
            if ($key_exist > 0) {
                self::UpdateTableData(SETTINGS_TABLE, $data, $condition);
            } else {
                self::InsertTableData(SETTINGS_TABLE, $data);
            }
        }
        return true;
    }
    // Function used to get user data from meta table; /
    public function get_setting_data($type = '')
    {
        $condition  = "";
        if (!empty($type)) {
            $condition = array('type' => $type);
        }
        $values = self::GetTableRows(SETTINGS_TABLE, $condition);
        $new_data = [];
        if ($values) {
            foreach ($values as $key => $value) {
                $new_data[$value['type']] = $value['value'];
            }
        }
        return $new_data;
    }

    /* FUNCTION USED TO SEND EMAIL ; */
    public function SendEmail($to, $from, $subject, $message)
    {
        $black_list = array('::1', '127.0.0.1'); // GRAB THE LOCALHOST IP ADDRESS
        if (!in_array($_SERVER['REMOTE_ADDR'], $black_list)) // CHECK IF NOT LOCALHOST
        {
            $email = \Config\Services::email();
            $email->setFrom('noreply@phpcodetech.com', 'The Escape Room ');
            $email->setTo($to);

            $email->setSubject($subject);
            $email->setMessage($message);

            //Send mail 
            if ($email->send()) // if successfully send 
            {
                return true;
            } else {
                return false;
            }
        }
    }
}
