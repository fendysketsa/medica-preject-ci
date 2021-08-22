<?php defined('BASEPATH') or exit('No direct script access allowed');

class ReasonModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    private static $table = 'reason_visit';

    private static $pk = 'rv_id';
    private static $prt = 'rv_reason_parent';

    public function is_exist($where)
    {
        return $this->db->where($where)->get(self::$table)->row_array();
    }

    public function onExist($id, $param)
    {
        if (!empty($id)) {
            $this->db->where('rv_id !=', $id);
        }
        return $this->db->where('rv_reason_code', $param)->get(self::$table)->num_rows() > 0 ? true : false;
    }

    public function getReason_visit()
    {
        $this->datatables->select('rv_id,rv_reason_code,rv_reason_name,rv_reason_type,rv_reason_sum,rv_reason_sort,rv_reason_group,rv_reason_shortname,rv_reason_parent,rv_reason_class,rv_reason_status');
        $this->datatables->from(self::$table);
        $this->datatables->add_column(
            'view',
            '<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" class="edit btn btn-info btn-xs" data-id="$1" data-code="$2" data-name="$3" data-type="$4" data-sum="$5" data-sort="$6" data-group="$7" data-sh-name="$8" data-parent="$9">
                <em class="glyphicon glyphicon-pencil"></em> Edit</a>
             <a href="javascript:void(0);" class="remove btn btn-danger btn-xs" data-id="$1">
                <em class="glyphicon glyphicon-trash"></em> Hapus</a>',
            'rv_id,rv_reason_code,rv_reason_name,rv_reason_type,rv_reason_sum,rv_reason_sort,rv_reason_group,rv_reason_shortname,rv_reason_parent,rv_reason_class,rv_reason_status'
        );
        return $this->datatables->generate();
    }

    public function add($data)
    {
        return $this->db->insert(self::$table, $data);
    }

    public function do_import($data)
    {
        return $this->db->insert(self::$table, $data);
    }

    public function edit($data, $id)
    {
        return $this->db->set($data)->where(self::$pk, $id)->update(self::$table);
    }

    public function deleteIt($id)
    {
        $this->db->where(self::$pk, $id);
        return $this->db->delete(self::$table);
    }

    public function getItOption($param)
    {
        if ($param == 'parent') {
            $this->db->where(self::$prt, null);
        }
        return $param == 'parent' ? $this->db->get(self::$table)->result_array() : $this->db->get(self::$tableClass)->result_array();
    }
}
