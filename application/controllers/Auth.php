<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('UserModel');
		$this->load->library('Recaptcha');
	}

	public function index()
	{
		if ($this->session->userdata('authenticated'))
			redirect('page/home');

		$data = [
			'title' => 'Apotek Bersama | Login',
			'captcha' => $this->recaptcha->getWidget(),
			'script_captcha' => $this->recaptcha->getScriptTag(),
		];
		$this->render_login('login', $data);
	}

	public function forgot()
	{
		if ($this->session->userdata('authenticated'))
			redirect('auth');

		$data = [
			'title' => 'Apotek Bersama | Forgot Password',
			'captcha' => $this->recaptcha->getWidget(),
			'script_captcha' => $this->recaptcha->getScriptTag(),
		];
		$this->render_forgot('forgot', $data);
	}

	public function sendResetPassword()
	{
		$this->dataPost();

		$username = $this->input->post('email', TRUE);

		$user = $this->UserModel->get($username);

		$mess = null;

		if (empty($user)) {
			$mess['code'] = 500;
			$mess['mess'] = 'Identitas tidak dikenal!';
		} else {

			$recaptcha = $this->input->post('g-recaptcha-response', TRUE);
			$response = $this->recaptcha->verifyResponse($recaptcha);

			if (!$recaptcha) {
				$mess['code'] = 500;
				$mess['mess'] = 'Recaptcha wajib diisikan!';
			} else if (!isset($response['success']) || $response['success'] <> true) {
				$mess['code'] = 500;
				$mess['mess'] = 'Verifikasi recaptcha salah!';
			} else {

				//Proses kirim password ke email
			}
		}

		echo json_encode($mess, true);
	}

	public function login()
	{
		$this->dataPost();

		$username = $this->input->post('email', TRUE);
		$password = $this->input->post('password', TRUE);

		$user = $this->UserModel->get($username);

		$mess = null;

		if (empty($user)) {
			$mess['code'] = 500;
			$mess['mess'] = 'Identitas tidak dikenal!';
		} else {

			$recaptcha = $this->input->post('g-recaptcha-response', TRUE);
			$response = $this->recaptcha->verifyResponse($recaptcha);

			if (!$recaptcha) {
				$mess['code'] = 500;
				$mess['mess'] = 'Recaptcha wajib diisikan!';
			} else if (!isset($response['success']) || $response['success'] <> true) {
				$mess['code'] = 500;
				$mess['mess'] = 'Verifikasi recaptcha salah!';
			} else {
				if (password_verify($password, $user->p_password)) {
					$session = array(
						'authenticated' => true,
						'UserAksesID' => $user->p_id,
						'username' => $user->p_username,
						'nama' => $user->p_nama,
						'role' => $user->p_level,
						'area' => $user->p_area
					);

					$this->session->set_userdata($session);
					$mess['code'] = 200;
					$mess['mess'] = 'Berhasil login!';
					$mess['redirect'] = $user->p_level == 'kasir' ? 'mng/unit-entry?show=' . md5($user->p_id . $user->p_username) : 'page/home';
				} else {
					$mess['code'] = 500;
					$mess['mess'] = 'Identitas tidak dikenal!';
				}
			}
		}

		echo json_encode($mess, true);
	}

	public function logout()
	{
		$this->dataPost();

		$keluar = $this->session->sess_destroy();
		$out = $this->input->post('out', true);

		$mess = null;
		if (!$keluar && !empty($out)) {
			$mess['code'] = 200;
			$mess['mess'] = 'Anda berhasil keluar!';
			$mess['redirect'] = base_url('auth');
		} else {
			$mess['code'] = 500;
			$mess['mess'] = 'Anda gagal keluar!';
		}
		echo json_encode($mess, true);
	}
}
