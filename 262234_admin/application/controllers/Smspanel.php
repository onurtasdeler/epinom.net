<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smspanel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    public function Index()
    {
        $viewData = [
            'users' => $this->db->where([
                'phone_number !=' => NULL,
                'activation_status' => 1
            ])->get('users')->result()
        ];

        if (isset($_GET['export_phone_numbers'])){
            $phone_numbers = [];
            foreach($viewData['users'] as $_u) {
                if (!in_array($_u->phone_number, $phone_numbers)) {
                    if (!empty($_u->phone_number)) {
                        $phone_numbers[] = $_u->phone_number;
                    }
                }
            }
            $this->load->helper('download');
            force_download('Üye Telefon Numaraları - ' . date('d-m-Y H-i') . '.txt', implode("\n", $phone_numbers));
            redirect(current_url());
            return;
        }

        if (isset($_POST['submitForm'])):

            if (strlen($this->input->post('message', TRUE)) > 2) {

                $numbers = [];

                if ($this->input->post('user') == 0) {
                    foreach($viewData['users'] as $_u):
                        $numbers[] = $_u->phone_number;
                    endforeach;
                } else {
                    $numbers[] = $this->db->where('id', $this->input->post('user'))->get('users')->row()->phone_number;
                }

                $status = sendSMS($numbers, $this->input->post('message'));

                if ($status != FALSE && @explode(' ', $status)[0] == '00') {
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => '<strong>' . count($numbers) . ' adet</strong> mesaj gönderildi.'
                    ];
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Mesaj gönderilemedi.'
                    ];
                }

            } else {
                $viewData['alert'] = [
                    'class' => 'danger',
                    'message' => 'Mesaj 2 karakterden fazla olmalıdır.'
                ];
            }

        endif;

        $this->load->view('pages/smspanel/index', (object)$viewData);
    }

}