<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->authenticated();
    }

    private static $table = 'ahass';

    public function authenticated()
    {
        if (
            $this->uri->segment(1) != 'auth'
            && ($this->uri->segment(1) != 'send' && $this->uri->segment(2) != 'forgot-password')
            && $this->uri->segment(1) != 'forgot-password'
            && $this->uri->segment(1) != ''
        ) {
            if (!$this->session->userdata('authenticated'))
                redirect('auth');
        }
    }

    public function render_login($content, $data = NULL)
    {
        $data['contentnya'] = $this->load->view($content, $data, TRUE);

        $this->load->view('template/login/index', $data);
    }

    public function render_forgot($content, $data = NULL)
    {
        $data['contentnya'] = $this->load->view($content, $data, TRUE);

        $this->load->view('template/forgot/index', $data);
    }

    public function render_backend($content, $data = NULL)
    {
        $data['headernya'] = $this->load->view('template/backend/header', $data, TRUE);
        $data['contentnya'] = $this->load->view($content, $data, TRUE);

        $this->load->view('template/backend/index', $data);
    }

    public function dataPost()
    {
        if ($this->input->method() == 'get') {
            return show_404();
        }
    }
}
