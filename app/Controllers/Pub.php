<?php

namespace App\Controllers;

use  App\Models\User_Mod;
use CodeIgniter\I18n\Time;

class Pub extends BaseController
{
	protected $session;

	function __construct()
	{
		helper('form', 'url');
		$this->session = \Config\Services::session();
	}

	public function index()
	{
		return view('public/home');
	}

	public function login()
	{
		$session = session();
		$user = new User_Mod();
		$validation =  \Config\Services::validation();
		if (!empty($_POST)) {
			$validation->setRules([
				'email' => ['Email' => 'email', 'rules' => 'required'],
				'password' => ['Password' => 'password', 'rules' => 'required'],
			]);
			$isValid = $validation->withRequest($this->request)->run();

			if ($isValid) {
				$pass = $this->request->getVar('password');
				$email = $this->request->getVar('email');
				$data = $user->where('email', $email)->first();
				if ($data) {
					$pass_db = $data['password'];
					$verify = password_verify($pass, $pass_db);
					if ($verify) {
						$session_data = [
							'IDuser' => $data['IDuser'],
							'email' => $data['email'],
							'username' => $data['username'],
							'name' => $data['name'],
							'logged_in' => TRUE,
						];
						$session->set($session_data);
						return redirect()->to(base_url('/dev-info'));
					} else {
						$session->setFlashdata('error', 'wrong password');
						return redirect()->to('/sign-in');
					}
				} else {
					$session->setFlashdata('error', 'Email not found');
					return redirect()->to('/sign-in');
				}
			} else {
				$this->session->setFlashdata('error', $validation->listErrors());
				return redirect()->route('sign-in');
			}
		}
		return view('public/login');
	}

	public function logout()
	{
		$user = new User_Mod();
		$date = Time::now('Asia/Jakarta', 'en_US');
		$last_login = $date->toDateTimeString();
		$IDuser = $this->session->IDuser;

		$user->set('last_log', $last_login);
		$user->where('IDuser', $IDuser);
		$user->update();

		$this->session->destroy();
		return redirect()->to('/home');
	}

	public function register()
	{

		$user = new User_Mod();
		$validation =  \Config\Services::validation();

		if (!empty($_POST)) {
			$validation->setRules([
				'fname' => [
					'rules' => 'required|char_only[fname]',
					'errors' => [
						'required' => 'First name is required',
						'char_only' => 'Last name not allowed using special character'
					]
				],
				'lname' => [
					'rules' => 'required|char_only[lname]',
					'errors' => [
						'required' => 'Last name is required',
						'char_only' => 'Last name not allowed using special character'
					]
				],
				'email' => [
					'rules' => 'required|valid_email|is_unique[user.email]',
					'errors' => [
						'required' => 'Email is required',
						'valid_email' => 'Please use valid email',
						'is_unique' => 'This email is already registered'
					]
				],
				'password' => [
					'rules' => 'max_length[15]|required|pass_check[6]',
					'errors' => [
						'required' => 'Password is required'
					]
				],
				'passconf' => [
					'rules' => 'matches[password]',
					'errors' => [
						'matches' => 'Password confirmation not match'
					]
				]

			]);
			$isValid = $validation->withRequest($this->request)->run();

			if ($isValid) {
				$captcha_response = trim($this->request->getPost('g-recaptcha-response'));
				$finalResponse = array();

				if ($captcha_response != '') {
					$key_secret = '6LeDQA4bAAAAANx2JjqVfqnZxzJFx3GSYvIp2b4E';

					$check = array(
						'secret' => $key_secret,
						'response' => $this->request->getVar('g-recaptcha-response'),
					);

					$start_process = curl_init();

					curl_setopt($start_process, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

					curl_setopt($start_process, CURLOPT_POST, true);

					curl_setopt($start_process, CURLOPT_POSTFIELDS, http_build_query($check));

					curl_setopt($start_process, CURLOPT_SSL_VERIFYPEER, false);

					curl_setopt($start_process, CURLOPT_RETURNTRANSFER, true);

					$receive_data = curl_exec($start_process);
					$finalResponse = json_decode($receive_data, true);

					if ($finalResponse != null) {
						if ($finalResponse['success']) {
							$IDuser = '';
							$cek = true;

							while ($cek) {
								$IDuser = uniqid();
								$cek = $this->cek_IDuser($IDuser);
							}

							$email = $this->request->getVar('email');
							$username = substr($email, 0, strpos($email, '@'));

							$user->insert([
								'IDuser' => $IDuser,
								'name' => $this->request->getVar('fname') . ' ' . $this->request->getVar('lname'),
								'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
								'email' => $email,
								'role' => 'user',
								'username' => $username,
							]);

							$this->session->setFlashdata('succ', 'Account registered');
							return redirect()->to(base_url('/sign-up'));
						}
					}
				} else {
					$finalResponse = null;
					$this->session->setFlashdata('error', 'Invalid Recaptcha');
					return view('public/sign-up');
				}
			} else {
				$this->session->setFlashdata('error', $validation->listErrors());
				return view('public/sign-up');
			}
		}

		return view('public/sign-up');
	}

	public function cek_IDuser($IDuser)
	{
		$user = new User_Mod();
		$user->select('IDuser');
		$temp['data'] = $user->where('IDuser', $IDuser)->findAll();
		if (count($temp['data']) > 0) {
			return true;
		} else {
			return false;
		}
	}
}
