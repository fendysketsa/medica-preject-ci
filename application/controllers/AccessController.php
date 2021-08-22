<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AccessController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('UserModel', 'PenggunaModel');
    }

    private function validation_profile()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('u_fname', 'Nama Pengguna', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('u_pass', 'Password Baru', 'trim|min_length[5]');
        $this->form_validation->set_rules('u_passconf', 'Konfirmasi Password', 'trim|min_length[5]|matches[u_pass]');

        return $this->form_validation->run();
    }


    public function profile()
    {
        $this->dataPost();

        if ($this->validation_profile()) {
            $this->load->helper('form');

            $id = $this->session->userdata['UserAksesID'];

            $dataPassword = [];
            if ((!empty($this->input->post('u_pass', TRUE)) && !empty($this->input->post('u_passconf', TRUE))) &&
                ($this->input->post('u_pass', TRUE) == $this->input->post('u_passconf', TRUE))
            ) {
                $dataPassword = [
                    'p_password' => password_hash($this->input->post('u_pass', TRUE), PASSWORD_DEFAULT, ['cost' => 5]),
                ];
            }

            $dataProfile = [
                'p_nama' => $this->input->post('u_fname', TRUE),
            ];

            $data = array_merge($dataProfile, $dataPassword);

            $this->PenggunaModel->edit($data, $id);

            $mess['code'] = 200;
            $mess['mess'] = "Data berhasil diperbarui!";
            $mess['redirect'] = base_url('auth/logout');
        } else {
            $mess['code'] = 500;
            $mess['mess'] = "Data profile gagal diperbarui!";
        }
        echo json_encode($mess, true);
    }
}
