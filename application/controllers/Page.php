<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DashboardModel');
		$this->load->helper('global_helper');
	}

	public function dashboard()
	{
		$akses = $this->session->userdata('role') == 'kasir' ? $this->session->userdata('username') : '';

		$data = [
			'title' => 'Dashboard - ' . $this->session->userdata('nama'),
			'css' => [],
			'js' => [],
			'menu' => 'dashboard',
			'link' => 'active',
			'data' => []
		];

		$this->render_backend('dashboard', $data);
	}

	public function home()
	{
		$data = [
			'title' => 'Home - ' . $this->session->userdata('nama'),
			'menu' => '',
			'link' => ''
		];
		
		$this->render_backend('home', $data);
	}
}
