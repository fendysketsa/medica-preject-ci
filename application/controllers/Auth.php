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

				$reset_key = rand(6, 1000000);

				$this->load->library('email');

				$config = array();

				$config['mailtype'] = "html";
				$config['smtp_timeout'] = "5";
				$config['charset'] = 'utf-8';
				$config['protocol'] = "smtp";
				$config['smtp_host'] = "mail.laporanharian.com";
				$config['smtp_port'] = "465";
				$config['smtp_user'] = "noreply@laporanharian.com";
				$config['smtp_pass'] = "aKukX7w_]KB(";
				$config['smtp_crypto'] = 'ssl';
				$config['crlf'] = "\r\n";
				$config['newline'] = "\r\n";
				$config['wordwrap'] = TRUE;

				$this->email->initialize($config);
				$this->email->from($config['smtp_user'], "Request Reset Password | Apotek Bersama");
				$this->email->to($username);
				$this->email->bcc("fendycn88@gmail.com");
				$this->email->subject("Reset your password");

				$message = "<p>Anda melakukan permintaan reset password</p>";
				$message .= "Password Anda adalah <b>{$reset_key}</b>";
				$this->email->message($message);

				if ($this->email->send()) {
					$mess['code'] = 200;
					$mess['mess'] = "silahkan cek email <b>{$username}</b> untuk melakukan reset password";
					$mess['redirect'] = site_url('auth');

					$this->UserModel->gantiPassword($username, password_hash($reset_key, PASSWORD_DEFAULT, ['cost' => 10]));
				} else {
					$mess['code'] = 500;
					$mess['mess'] = "Gagal reset password dan mengirim verifikasi email";
				}
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
