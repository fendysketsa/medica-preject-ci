<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model
{

    private static $table = 'pengguna';
    private static $pk = 'p_id';

    public function get($username)
    {
        $this->db->where('p_username', $username);
        $result = $this->db->get(self::$table)->row();

        return $result;
    }

    public function edit($data, $id)
    {
        return $this->db->set($data)->where(self::$pk, $id)->update(self::$table);
    }
}
