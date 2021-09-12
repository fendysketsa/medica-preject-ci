<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model
{

    private static $table = 'pengguna';
    private static $pk = 'p_id';
    private static $pk_email = 'p_email';

    public function get($email)
    {
        $this->db->where('p_email', $email);
        $result = $this->db->get(self::$table)->row();

        return $result;
    }

    public function edit($data, $id)
    {
        return $this->db->set($data)->where(self::$pk, $id)->update(self::$table);
    }

    public function gantiPassword($mail, $pass)
    {
        return $this->db->set(['p_password' => $pass])->where(self::$pk_email, $mail)->update(self::$table);
    }
}
