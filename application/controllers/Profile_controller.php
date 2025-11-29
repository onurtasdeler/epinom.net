<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile Controller
 * Kullanici profil, ayarlar, bakiye ve siparis islemleri.
 */
class Profile_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'user_model');
        $this->load->model('User_balance_model', 'balance_model');
        $this->load->library('User/User_authentication', NULL, 'auth');
        $this->load->library('User/Password_handler', NULL, 'password');
        $this->load->library('form_validation');
        websiteStatus();
    }

    private function _requireLogin() {
        if (!$this->auth->isLoggedIn()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            exit;
        }
        return $this->auth->getUser();
    }

    // ══════════════════════════════════════════
    // HESABIM
    // ══════════════════════════════════════════

    public function dashboard() {
        $user = $this->_requireLogin();
        $viewData = [
            'user' => $user,
            'balance' => $this->balance_model->getBalance($user->id),
            'recent_transactions' => $this->balance_model->getHistory($user->id, 5)
        ];
        $this->load->view('pages/user/dashboard', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // PROFIL AYARLARI
    // ══════════════════════════════════════════

    public function settings() {
        $user = $this->_requireLogin();
        $viewData = ['user' => $user];

        if ($this->input->post('update_profile')) {
            $this->form_validation->set_rules('firstname', 'Ad', 'trim|max_length[100]');
            $this->form_validation->set_rules('lastname', 'Soyad', 'trim|max_length[100]');
            $this->form_validation->set_rules('phone_number', 'Telefon', 'trim|max_length[20]');

            if ($this->form_validation->run()) {
                $this->user_model->update($user->id, [
                    'firstname' => $this->input->post('firstname', TRUE),
                    'lastname' => $this->input->post('lastname', TRUE),
                    'phone_number' => $this->input->post('phone_number', TRUE)
                ]);
                $viewData['alert'] = ['class' => 'success', 'message' => 'Profil guncellendi.'];
                $user = $this->user_model->find($user->id);
                $viewData['user'] = $user;
            }
        }

        $this->load->view('pages/user/settings', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // SIFRE DEGISTIRME
    // ══════════════════════════════════════════

    public function changePassword() {
        $user = $this->_requireLogin();
        $viewData = ['user' => $user];

        if ($this->input->post('change_password')) {
            $this->form_validation->set_rules('current_password', 'Mevcut Sifre', 'required');
            $this->form_validation->set_rules('new_password', 'Yeni Sifre', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Sifre Tekrar', 'required|matches[new_password]');

            if ($this->form_validation->run()) {
                if ($this->password->verify($this->input->post('current_password'), $user->password)) {
                    $strength = $this->password->validateStrength($this->input->post('new_password'));
                    if ($strength['valid']) {
                        $newHash = $this->password->hash($this->input->post('new_password'));
                        $this->user_model->updatePassword($user->id, $newHash);
                        $viewData['alert'] = ['class' => 'success', 'message' => 'Sifreniz guncellendi.'];
                    } else {
                        $viewData['alert'] = ['class' => 'danger', 'message' => implode(' ', $strength['errors'])];
                    }
                } else {
                    $viewData['alert'] = ['class' => 'danger', 'message' => 'Mevcut sifre hatali.'];
                }
            }
        }

        $this->load->view('pages/user/change_password', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // TC DOGRULAMA
    // ══════════════════════════════════════════

    public function tcVerification() {
        $user = $this->_requireLogin();
        $viewData = ['user' => $user];

        if ($this->input->post('verify_tc')) {
            $this->form_validation->set_rules('firstname', 'Ad', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('lastname', 'Soyad', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('birthyear', 'Dogum Yili', 'required|integer|exact_length[4]');
            $this->form_validation->set_rules('tc_no', 'TC Kimlik No', 'required|exact_length[11]|integer');

            if ($this->form_validation->run()) {
                try {
                    $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
                    $result = $client->TCKimlikNoDogrula([
                        'TCKimlikNo' => $this->input->post('tc_no', TRUE),
                        'Ad' => mb_strtoupper($this->input->post('firstname', TRUE), 'UTF-8'),
                        'Soyad' => mb_strtoupper($this->input->post('lastname', TRUE), 'UTF-8'),
                        'DogumYili' => $this->input->post('birthyear', TRUE)
                    ]);

                    if ($result->TCKimlikNoDogrulaResult) {
                        $this->user_model->update($user->id, [
                            'tc_no' => $this->input->post('tc_no', TRUE),
                            'firstname' => $this->input->post('firstname', TRUE),
                            'lastname' => $this->input->post('lastname', TRUE),
                            'birthyear' => $this->input->post('birthyear', TRUE)
                        ]);
                        $viewData['alert'] = ['class' => 'success', 'message' => 'TC Kimlik dogrulandi.'];
                    } else {
                        $viewData['alert'] = ['class' => 'danger', 'message' => 'Bilgiler NVI ile eslesmedi.'];
                    }
                } catch (Exception $e) {
                    $viewData['alert'] = ['class' => 'danger', 'message' => 'Dogrulama servisi su anda calismiyor.'];
                }
            }
        }

        $this->load->view('pages/user/tc_verification', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // BAKIYE ISLEMLERI
    // ══════════════════════════════════════════

    public function balance() {
        $user = $this->_requireLogin();
        $viewData = [
            'user' => $user,
            'balance' => $this->balance_model->getBalance($user->id),
            'history' => $this->balance_model->getHistory($user->id, 50),
            'total_deposits' => $this->balance_model->getTotalDeposits($user->id),
            'total_spent' => $this->balance_model->getTotalSpent($user->id)
        ];
        $this->load->view('pages/user/balance', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // SIPARISLER
    // ══════════════════════════════════════════

    public function orders() {
        $user = $this->_requireLogin();
        $this->load->model('orders_model');
        $viewData = [
            'user' => $user,
            'orders' => $this->orders_model->getAll(['user_id' => $user->id], null, 'id DESC')
        ];
        $this->load->view('pages/user/orders', (object)$viewData);
    }

    public function gameMoneyOrders() {
        $user = $this->_requireLogin();
        $viewData = [
            'user' => $user,
            'orders' => $this->db->where('user_id', $user->id)->order_by('status ASC, id DESC')->limit(50)->get('game_moneys_orders')->result()
        ];
        $this->load->view('pages/user/gamemoneyorders', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // BILDIRIMLER
    // ══════════════════════════════════════════

    public function notifications() {
        $user = $this->_requireLogin();
        $this->db->update('notifications', ['is_viewed' => 1], ['user_id' => $user->id]);
        $viewData = [
            'user' => $user,
            'notifications' => $this->db->where('user_id', $user->id)->order_by('id DESC')->get('notifications')->result()
        ];
        $this->load->view('pages/user/notifications', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // BANKA HESAPLARI
    // ══════════════════════════════════════════

    public function bankAccounts() {
        $user = $this->_requireLogin();

        // Silme islemi
        if ($this->input->get('delete') && $this->input->get('id')) {
            $account = $this->db->where(['user_id' => $user->id, 'id' => $this->input->get('id', TRUE)])->get('user_bank_accounts')->row();
            if ($account) {
                $this->db->delete('user_bank_accounts', ['id' => $account->id]);
            }
            redirect(current_url());
            return;
        }

        $viewData = [
            'user' => $user,
            'accounts' => $this->db->where('user_id', $user->id)->order_by('id DESC')->get('user_bank_accounts')->result()
        ];
        $this->load->view('pages/user/user_bank_accounts', (object)$viewData);
    }

    public function addBankAccount() {
        $user = $this->_requireLogin();
        $viewData = ['user' => $user];

        if ($this->input->post('add_account')) {
            $this->form_validation->set_rules('bank_name', 'Banka', 'required|trim');
            $this->form_validation->set_rules('iban', 'IBAN', 'required|trim|min_length[26]|max_length[34]');
            $this->form_validation->set_rules('account_holder', 'Hesap Sahibi', 'required|trim');

            if ($this->form_validation->run()) {
                $this->db->insert('user_bank_accounts', [
                    'user_id' => $user->id,
                    'bank_name' => $this->input->post('bank_name', TRUE),
                    'iban' => strtoupper(str_replace(' ', '', $this->input->post('iban', TRUE))),
                    'account_holder' => $this->input->post('account_holder', TRUE),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                redirect('uye/banka-hesaplarim');
                return;
            }
        }

        $this->load->view('pages/user/add_user_bank_account', (object)$viewData);
    }

    // ══════════════════════════════════════════
    // REFERANS SISTEMI
    // ══════════════════════════════════════════

    public function referrals() {
        $user = $this->_requireLogin();
        $viewData = [
            'user' => $user,
            'referrals' => $this->user_model->getReferrals($user->id),
            'ref_link' => base_url('?ref=' . $user->id)
        ];
        $this->load->view('pages/user/referrals', (object)$viewData);
    }
}
