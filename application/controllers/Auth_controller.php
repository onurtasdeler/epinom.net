<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'user_model');
        $this->load->library('User/User_authentication', NULL, 'auth');
        $this->load->library('User/Password_handler', NULL, 'password');
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        websiteStatus();
    }

    public function login() {
        if ($this->auth->isLoggedIn()) { redirect('uye/hesabim'); }
        $viewData = [];

        if ($this->input->post('login')) {
            if ($this->auth->isRateLimited()) {
                $viewData['login_alert'] = ['class' => 'danger', 'message' => 'Cok fazla deneme. 15 dk bekleyin.'];
                $this->load->view('pages/user/authorization', (object)$viewData);
                return;
            }

            $this->form_validation->set_rules('email', 'E-Posta', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Sifre', 'required|trim|min_length[5]');

            if ($this->form_validation->run()) {
                $user = $this->user_model->findByEmail($this->input->post('email', TRUE));

                if ($user && $this->password->verify($this->input->post('password'), $user->password)) {
                    if ($this->user_model->isLocked($user)) {
                        $viewData['login_alert'] = ['class' => 'danger', 'message' => 'Hesap kilitli.'];
                        $this->load->view('pages/user/authorization', (object)$viewData);
                        return;
                    }

                    if (!$this->auth->isIpAllowed($user)) {
                        $viewData['login_alert'] = ['class' => 'danger', 'message' => 'IP izni yok.'];
                        $this->load->view('pages/user/authorization', (object)$viewData);
                        return;
                    }

                    if ($this->password->needsRehash($user->password)) {
                        $this->user_model->updatePassword($user->id, $this->password->hash($this->input->post('password')));
                    }

                    $config = $this->db->where('id', 1)->get('config')->row();
                    if ($user->activation_status == 0 && $config->user_activation_required == 1) {
                        $hash = $this->user_model->refreshHash($user->id);
                        redirect('uye/aktivasyon/' . $hash);
                        return;
                    }

                    $this->auth->login($user);
                    $redir = $this->input->get('r');
                    redirect($redir ? $redir : 'uye/hesabim');
                } else {
                    $this->auth->incrementRateLimit();
                    if ($user) { $this->user_model->recordFailedLogin($user->id); }
                    $viewData['login_alert'] = ['class' => 'danger', 'message' => 'Hatali giris. Kalan: ' . $this->auth->getRemainingAttempts()];
                }
            }
        }
        $this->load->view('pages/user/authorization', (object)$viewData);
    }

    public function register() {
        if ($this->auth->isLoggedIn()) { redirect('uye/hesabim'); }
        $viewData = [];

        if ($this->input->post('register')) {
            $this->form_validation->set_rules('email', 'E-Posta', 'required|trim|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Sifre', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('re_password', 'Sifre Tekrar', 'required|trim|matches[password]');

            if ($this->form_validation->run()) {
                $userId = $this->user_model->create([
                    'email' => $this->input->post('email', TRUE),
                    'password' => $this->password->hash($this->input->post('password')),
                    'phone_number' => $this->input->post('phone', TRUE),
                    'ref_user_id' => $this->input->cookie('ref_user_id')
                ]);

                if ($userId) {
                    $user = $this->user_model->find($userId);
                    $this->_sendActivation($user);
                    redirect('uye/aktivasyon/' . $user->user_hash);
                }
            }
        }
        $this->load->view('pages/user/authorization', (object)$viewData);
    }

    public function activation($hash) {
        $user = $this->user_model->findByHash($hash);
        if (!$user || $user->activation_status == 1) { redirect('/'); return; }

        $viewData = ['user' => $user, 'user_hash' => $hash];

        if ($this->input->post('activation') && $this->input->post('code', TRUE) === $user->activation_code) {
            $this->user_model->activate($user->id);
            if ($user->ref_user_id) {
                $this->db->set('balance', 'balance + 0.4', FALSE)->set('ref_points', 'ref_points + 1', FALSE)
                    ->where('id', $user->ref_user_id)->update('users');
            }
            $this->auth->login($this->user_model->find($user->id));
            redirect('/');
            return;
        } elseif ($this->input->post('activation')) {
            $viewData['alert'] = ['class' => 'danger', 'message' => 'Kod gecersiz.'];
        }
        $this->load->view('pages/user/activation', (object)$viewData);
    }

    public function logout() { $this->auth->logout(); redirect('/'); }

    public function forgotPassword() {
        $viewData = [];
        if ($this->input->post('forgot')) {
            $user = $this->user_model->findByEmail($this->input->post('email', TRUE));
            if ($user && function_exists('sendEmail')) {
                $token = $this->user_model->setResetToken($user->id);
                sendEmail($user->email, 'Sifre Sifirlama', base_url('uye/sifre-sifirla/' . $token));
            }
            $viewData['alert'] = ['class' => 'success', 'message' => 'Link gonderildi.'];
        }
        $this->load->view('pages/user/forgot_password', (object)$viewData);
    }

    public function resetPassword($token) {
        $user = $this->user_model->findByResetToken($token);
        if (!$user) { redirect('uye/giris-yap'); return; }

        if ($this->input->post('reset')) {
            $this->form_validation->set_rules('password', 'Sifre', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Tekrar', 'required|matches[password]');
            if ($this->form_validation->run()) {
                $this->user_model->updatePassword($user->id, $this->password->hash($this->input->post('password')));
                $this->user_model->clearResetToken($user->id);
                redirect('uye/giris-yap');
                return;
            }
        }
        $this->load->view('pages/user/reset_password', (object)['token' => $token]);
    }

    private function _sendActivation($user) {
        if (function_exists('sendEmail') && function_exists('getEmailTemplate')) {
            sendEmail($user->email, 'Aktivasyon', getEmailTemplate('user_activation', [
                'activation_code' => $user->activation_code,
                'activation_url' => base_url('uye/aktivasyon/' . $user->user_hash)
            ]));
        }
    }
}
