<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReasonController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('ReasonModel');
    }

    private function validationReason()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('rv_reason_sort', 'Urutan', 'trim|required|min_length[1]|max_length[3]');
        $this->form_validation->set_rules('rv_reason_code', 'Kode Alasan', 'trim|required|min_length[1]|max_length[3]');
        $this->form_validation->set_rules('rv_reason_name', 'Nama Alasan', 'trim|required|min_length[2]|max_length[200]');

        return $this->form_validation->run();
    }

    public function index()
    {
        if ($this->session->userdata('role') != 'administrator')
            show_404();

        $data = [
            'title' => 'Master Data - Alasan Kedatangan',
            'js' => '',
            'menu' => 'master-data',
            'link' => 'active',
            'sub_menu' => 'reason',
        ];

        $this->render_backend('reason', $data);
    }

    public function data()
    {
        $this->dataPost();

        return $this->reasonData();
    }

    public function save()
    {
        $this->dataPost();

        if (!$this->validationReason()) {
            $mess['code'] = 500;
            $mess['mess'] = "Lengkapi data Anda! <br>" . validation_errors();
        } else {
            if ($this->ReasonModel->onExist('', $this->input->post('rv_reason_code', TRUE)) == TRUE) {
                $mess['code'] = 500;
                $mess['mess'] = "Maaf data Kode Alasan Kedatangan telah digunakan!";
            } else {
                $data = [
                    'rv_reason_code' => $this->input->post('rv_reason_code', TRUE),
                    'rv_reason_parent' => $this->input->post('rv_reason_parent', TRUE),
                    'rv_reason_shortname' => $this->input->post('rv_reason_shortname', TRUE),
                    'rv_reason_name' => $this->input->post('rv_reason_name', TRUE),
                    'rv_reason_type' => $this->input->post('rv_reason_type', TRUE),
                    'rv_reason_sum' => $this->input->post('rv_reason_sum', TRUE),
                    'rv_reason_sort' => $this->input->post('rv_reason_sort', TRUE),
                    'rv_reason_group' => $this->input->post('rv_reason_group', TRUE),
                    'rv_reason_class' => $this->input->post('rv_class', TRUE),
                    'rv_reason_status' => $this->input->post('rv_reason_status', TRUE),
                ];

                $this->ReasonModel->add($data);

                $mess['code'] = 200;
                $mess['mess'] = "Data berhasil ditambah!";
            }
        }
        echo json_encode($mess, true);
    }

    public function update()
    {
        $this->dataPost();

        $id = $this->input->post('id', true);
        $where = "rv_id = '$id'";
        $data = $this->ReasonModel->is_exist($where);

        if (!$this->validationReason()) {
            $mess['code'] = 500;
            $mess['mess'] = "Lengkapi data Anda!";
        } else {
            if ($this->ReasonModel->onExist($id, $this->input->post('rv_reason_code', TRUE)) == TRUE) {
                $mess['code'] = 500;
                $mess['mess'] = "Maaf data Kode Alasan Kedatangan telah digunakan!";
            } else {
                $data = [
                    'rv_id' => $id,
                    'rv_reason_code' => $this->input->post('rv_reason_code', TRUE),
                    'rv_reason_parent' => $this->input->post('rv_reason_parent', TRUE),
                    'rv_reason_shortname' => $this->input->post('rv_reason_shortname', TRUE),
                    'rv_reason_name' => $this->input->post('rv_reason_name', TRUE),
                    'rv_reason_type' => $this->input->post('rv_reason_type', TRUE),
                    'rv_reason_sum' => $this->input->post('rv_reason_sum', TRUE),
                    'rv_reason_sort' => $this->input->post('rv_reason_sort', TRUE),
                    'rv_reason_group' => $this->input->post('rv_reason_group', TRUE),
                    'rv_reason_class' => $this->input->post('rv_class', TRUE),
                    'rv_reason_status' => $this->input->post('rv_reason_status', TRUE),
                ];

                $this->ReasonModel->edit($data, $id);

                $mess['code'] = 200;
                $mess['mess'] = "Data berhasil diperbarui" . ($this->db->affected_rows() > 0 ? ' dan disimpan!' : ', namun tidak ada perubahan!');
            }
        }
        echo json_encode($mess, true);
    }

    public function import()
    {
        $this->dataPost();

        $this->load->helper('string');

        if (empty($_FILES['scsv']['tmp_name'])) {
            $mess['code'] = 500;
            $mess['mess'] = "Form file data Alasan Kedatangan wajib diisi!";

            echo json_encode($mess, true);
            die;
        }

        $eks = explode('.', $_FILES['scsv']['name']);

        if (strtolower(end($eks)) === 'csv') {
            $handle = fopen($_FILES['scsv']['tmp_name'], "r");
            $fileData = [];
            while (($row = fgetcsv($handle, 2048))) {
                array_push($fileData, $row);
            }
            fclose($handle);

            $uploaded = 0;

            foreach ($fileData as $index => $row) {

                if (count($row) != 5) {
                    $mess['code'] = 500;
                    $mess['mess'] = "File format salah.!";
                    echo json_encode($mess, true);
                    die;
                } else if ($index == 0 && $row[0] != 'Urutan' && $row[3] != 'Format Rupiah ?') {
                    $mess['code'] = 500;
                    $mess['mess'] = "File format tidak berlaku.!";
                    echo json_encode($mess, true);
                    die;
                } else if ($index > 0) {

                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                        $data = [
                            'rv_reason_sort' => $row[0],
                            'rv_reason_code' => $row[1],
                            'rv_reason_name' => $row[2],
                            'rv_reason_type' => $row[3],
                            'rv_reason_sum' => $row[4],
                        ];

                        $whereCek = "rv_reason_code = '$row[1]'";
                        $dataCek = $this->ReasonModel->is_exist($whereCek);

                        if (empty($dataCek)) {
                            $this->ReasonModel->add($data);
                            $uploaded++;
                        }
                    }
                }
            }

            $mess['code'] = 200;
            $mess['mess'] = '( ' . $uploaded . ' ) Data Alasan Kedatangan berhasil diimport.';
        } else {
            $mess['code'] = 500;
            $mess['mess'] = "Format file yang diperbolehkan hanya *.csv.!";
        }

        echo json_encode($mess, true);
    }

    public function getOption()
    {
        if (empty($_GET)) {
            return show_404();
        }

        $param = $_GET['param'];

        $opt = $this->ReasonModel->getItOption($param);

        if ($opt) {
            $mess['code'] = 200;
            $mess['msg'] = 'Berhasil get data';
            $mess['data'] = $opt;
        } else {
            $mess['code'] = 500;
            $mess['msg'] = 'Gagal get data';
        }

        echo json_encode($mess, true);
    }

    public function delete()
    {
        $this->dataPost();

        $id = $this->input->post('id', true);
        $deleted = $this->ReasonModel->deleteIt($id);
        if (!$deleted) {
            $mess['code'] = 500;
            $mess['mess'] = "Lengkapi data Anda!";
        } else {
            $mess['code'] = 200;
            $mess['mess'] = "Berhasil menghapus data Anda!";
        }
        echo json_encode($mess, true);
    }

    private function reasonData()
    {
        header('Content-Type: application/json');
        echo $this->ReasonModel->getReason_visit();
    }
}
