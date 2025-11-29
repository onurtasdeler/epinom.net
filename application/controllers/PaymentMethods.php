<?php

class PaymentMethods extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("pages_model");
        websiteStatus();
    }

    function index()
    {

        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(base_url('bakiye-yukle')));
            return;
        }

        if (isset($_GET['gpay_return'])) {
            echo "<script>window.parent.window.location.href = '" . base_url('odeme-yontemleri') . "';</script>";
        }

        $viewData = [
            'page' => $this->pages_model->getPage([
                'id' => 8
            ])
        ];

        if (isset($_POST['addBalance']) && getActiveUser()) {
            $data = getPaymentMethod([
                'price' => $this->input->post('addbalance', TRUE),
                'user' => getActiveUser()
            ]);
            if ($data) {
                $viewData['alert'] = [
                    'class' => 'success',
                    'message' => 'Başarılı.'
                ];
                $viewData['paymentData'] = $data;
            } else {
                $viewData['alert'] = [
                    'class' => 'danger',
                    'message' => 'Sorun oluştu. Lütfen daha sonra tekrar deneyin. <a onclick="window.location.href=\'' . base_url('odeme-yontemleri') . '\'" class="text-danger" href="javascript:;">Kapat</a>'
                ];
            }
        }

        if (isset($_POST['sendPaymentInformation']) && getActiveUser()) {
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'sendTime',
                    'label' => 'Ödeme Tarihi',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'senderFullName',
                    'label' => 'Gönderen Adı Soyadı',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'bankAccountIBAN',
                    'label' => 'Ödeme Yaptığınız Hesap IBAN',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'price',
                    'label' => 'Tutar',
                    'rules' => 'required|trim|integer'
                ),
                array(
                    'field' => 'description',
                    'label' => 'İletmek İstedikleriniz',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'sendPaymentInformation',
                    'label' => 'Ödeme Bildirimi',
                    'rules' => 'required'
                )
            ));

            if ($this->form_validation->run() == TRUE) {


                $this->db->insert('payment_notifications', [
                    'user_id' => getActiveUser()->id,
                    'price' => $this->input->post('price', TRUE),
                    'information_json' => json_encode([
                        'sendTime' => $this->input->post('sendTime', TRUE),
                        'senderFullName' => $this->input->post('senderFullName', TRUE),
                        'bankAccountIBAN' => $this->input->post('bankAccountIBAN', TRUE),
                        'price' => $this->input->post('price', TRUE),
                        'description' => $this->input->post('description', TRUE),
                        'sendPaymentInformation' => $this->input->post('sendPaymentInformation', TRUE)
                    ])
                ]);
                if ($this->db->insert_id()) {
                    $viewData['sendPaymentInformationFormAlert'] = [
                        'class' => 'success',
                        'message' => 'Ödeme bildirimi başarıyla yapıldı. En kısa sürede yanıtlanacaktır.'
                    ];
                } else {
                    $viewData['sendPaymentInformationFormAlert'] = [
                        'class' => 'danger',
                        'message' => 'Hata: Ödeme bildirimi yapılamadı. Lütfen daha sonra tekrar deneyin.'
                    ];
                }
            } else {
                $viewData['sendPaymentInformationFormError'] = TRUE;
            }
        }

        $this->load->view('pages/paymentmethods/index', (object)$viewData);
    }

    function gpay($selected_payment = NULL)
    {
        $gpay = $this->db->where([
            'id' => 4
        ])->get('payment_methods')->row();

        if ($gpay->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'goToPay' => '#pay'
        ];

        if ($selected_payment) {
            switch ($selected_payment) {
                case 'havale':
                    if (isset($_POST['addbalance'])) :
                        $viewData['gpay_response'] = gpayPaymentForm($this->input->post('addbalance', TRUE), getActiveUser(), 'havale');
                    endif;
                    $viewData['heading'] = 'GPAY Havale/EFT Bildirimi';
                    $this->load->view('pages/paymentmethods/gpay/process', (object)$viewData);
                    break;
                default:
                case 'kredi-karti':
                    if (isset($_POST['addbalance'])) :
                        $viewData['gpay_response'] = gpayPaymentForm($this->input->post('addbalance', TRUE), getActiveUser(), 'krediKarti');
                    endif;
                    $viewData['heading'] = 'GPAY Kredi Kartı/Banka Kartı ile Ödeme';
                    $this->load->view('pages/paymentmethods/gpay/process', (object)$viewData);
                    break;
                case 'ininal':
                    if (isset($_POST['addbalance'])) :
                        $viewData['gpay_response'] = gpayPaymentForm($this->input->post('addbalance', TRUE), getActiveUser(), 'ininal');
                    endif;
                    $viewData['heading'] = 'GPAY İninal Kart ile Ödeme';
                    $this->load->view('pages/paymentmethods/gpay/process', (object)$viewData);
                    break;
                case 'bkmexpress':
                    if (isset($_POST['addbalance'])) :
                        $viewData['gpay_response'] = gpayPaymentForm($this->input->post('addbalance', TRUE), getActiveUser(), 'bkmexpress');
                    endif;
                    $viewData['heading'] = 'GPAY BKM Express ile Ödeme';
                    $this->load->view('pages/paymentmethods/gpay/process', (object)$viewData);
                    break;
                case 'mobilodeme':
                    if (isset($_POST['addbalance'])) :
                        $viewData['gpay_response'] = gpayPaymentForm($this->input->post('addbalance', TRUE), getActiveUser(), 'mobilOdeme');
                    endif;
                    $viewData['heading'] = 'GPAY Mobil Ödeme';
                    $this->load->view('pages/paymentmethods/gpay/process', (object)$viewData);
                    break;
            }
            return;
        }

        $this->load->view('pages/paymentmethods/gpay/process', (object)$viewData);
    }

    function paytr($selected_payment = NULL)
    {
        $paytr = $this->db->where([
            'id' => 2
        ])->get('payment_methods')->row();

        if ($paytr->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'goToPay' => '#pay'
        ];

        if ($selected_payment) {
            switch ($selected_payment) {
                default:
                case 'kredi-karti':
                    if (isset($_POST['addbalance'])) :
                        $viewData['paytr_response'] = paytrPaymentForm($this->input->post('addbalance', TRUE), getActiveUser());
                    endif;
                    $viewData['heading'] = 'PAYTR Kredi Kartı ile Ödeme';
                    $viewData['commission'] = 2.99;
                    $this->load->view('pages/paymentmethods/paytr/process', (object)$viewData);
                    break;
                case 'havale':
                    if (isset($_POST['addbalance'])) :
                        $viewData['paytr_response'] = paytrEftForm($this->input->post('addbalance', TRUE), getActiveUser());
                    endif;
                    $viewData['heading'] = 'PAYTR Havale/EFT Bildirimi';
                    $viewData['commission'] = 1;
                    $this->load->view('pages/paymentmethods/paytr/process', (object)$viewData);
                    break;
                case 'ininal':
                    if (isset($_POST['addbalance'])) :
                        $viewData['paytr_response'] = paytrPaymentForm($this->input->post('addbalance', TRUE), getActiveUser());
                    endif;
                    $viewData['heading'] = 'PAYTR İninal Kart ile Ödeme';
                    $viewData['commission'] = 2.99;
                    $this->load->view('pages/paymentmethods/paytr/process', (object)$viewData);
                    break;
            }
            return;
        }
        redirect('bakiye-yukle');
        return;
    }

    function payreks($selected_payment = NULL)
    {
        $payreks = $this->db->where([
            'id' => ($selected_payment=='kredikarti')?6:5
        ])->get('payment_methods')->row();

        if ($payreks->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }

        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'goToPay' => '#pay'
        ];

        if ($selected_payment) {
            switch ($selected_payment) {
                default:
                case 'mobilodeme':
                    if (isset($_POST['addbalance'])) :
                        $viewData['payreks_response'] = payreksPaymentForm($this->input->post('addbalance', TRUE), getActiveUser());
                    endif;
					$viewData['id'] = 5;
                    $viewData['heading'] = 'PAYREKS Mobil Ödeme';
                    $viewData['commission'] = 100;
                    $this->load->view('pages/paymentmethods/payreks/process', (object)$viewData);
                    break;
                case 'kredikarti':
                    if (isset($_POST['addbalance'])) :
                        $viewData['payreks_response'] = payreksPaymentForm($this->input->post('addbalance', TRUE), getActiveUser(),1);
                    endif;
					$viewData['id'] = 6;
                    $viewData['heading'] = 'PAYREKS Kredi Kartı';
                    $viewData['commission'] = 8;
                    $this->load->view('pages/paymentmethods/payreks/process', (object)$viewData);
                    break;
            }
            return;
        }
        redirect('bakiye-yukle');
        return;
    }

    function paybrothers($selected_payment = NULL)
    {
        $paybrothers = $this->db->where([
            'id' => 6
        ])->get('payment_methods')->row();

        if ($paybrothers->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }

        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'goToPay' => '#pay'
        ];

        if ($selected_payment) {
            switch ($selected_payment) {
                default:
                case 'kredi-karti':
                    if (isset($_POST['addbalance'])) :
                        $viewData['paybros_response'] = payBrothersPaymentForm($this->input->post('addbalance', TRUE), getActiveUser());
                    endif;
                    $viewData['heading'] = 'PAYBROTHERS Kredi Kartı ile Ödeme';
                    $viewData['commission'] = 1;
                    $this->load->view('pages/paymentmethods/paybros/process', (object)$viewData);
                    break;
            }
            return;
        }
        redirect('bakiye-yukle');
        return;
    }

    function paymax($selected_payment = NULL)
    {
        $paymax = $this->db->where([
            'id' => 8
        ])->get('payment_methods')->row();

        if ($paymax->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'goToPay' => '#pay'
        ];

        if (isset($_POST['addbalance'])) :
            $request = paymaxPaymentForm($this->input->post('addbalance', TRUE), getActiveUser());
            $viewData['paymax_response'] = $request['payment_page_url'];
        endif;
        $viewData['heading'] = 'Paymax Kredi Kartı ile Ödeme';
        $viewData['commission'] = 3;
        $this->load->view('pages/paymentmethods/paymax/process', (object)$viewData);
        return;
    }
    function paybyme($selected_payment = NULL)
    {
        $paybyme = $this->db->where([
            'id' => 7
        ])->get('payment_methods')->row();

        if ($paybyme->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }

        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'goToPay' => '#pay'
        ];

        if ($selected_payment) {
            switch ($selected_payment) {
                default:
                case 'kredi-karti':
                    if (isset($_POST['addbalance'])) :
                        $viewData['paybyme_response'] = payByMePaymentForm($this->input->post('addbalance', TRUE), getActiveUser());
                    endif;
                    $viewData['heading'] = 'PAYBYME Kredi Kartı ile Ödeme';
                    $viewData['commission'] = 1;
                    $this->load->view('pages/paymentmethods/paybyme/process', (object)$viewData);
                    break;
            }
            return;
        }
        redirect('bakiye-yukle');
        return;
    }

    function paymes()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . current_url());
            return;
        }

        $paymes = $this->db->where([
            'id' => 7
        ])->get('payment_methods')->row();

        if ($paymes->is_active == 0) {
            redirect('bakiye-yukle');
            return;
        }

        $viewData = [];
        $viewData['heading'] = 'PAYMES Kredi Kartı ile Ödeme';
        $viewData['commission'] = 1;

        if ($this->input->get('addBalance', TRUE)) {
            $viewData['selectedPrice'] = $this->input->get('addBalance', TRUE);
        }

        if (isset($_POST['submitCredit'])) :
            $_POST['card_number'] = str_replace(' ', null, $_POST['card_number']);
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'amount',
                    'label' => 'Tutar',
                    'rules' => 'required|trim|numeric'
                ),
                array(
                    'field' => 'card_owner',
                    'label' => 'Kart Sahibi',
                    'rules' => 'required|trim|min_length[5]'
                ),
                array(
                    'field' => 'card_number',
                    'label' => 'Kart Numarası',
                    'rules' => 'required|trim|integer|min_length[16]|max_length[16]'
                ),
                array(
                    'field' => 'card_last_m',
                    'label' => 'Son Kullanma Ayı',
                    'rules' => 'trim|integer|required'
                ),
                array(
                    'field' => 'card_last_y',
                    'label' => 'Son Kullanma Yılı',
                    'rules' => 'required|trim|integer'
                ),
                array(
                    'field' => 'card_cvc',
                    'label' => 'CVV/CVC Kodu',
                    'rules' => 'trim|required|min_length[3]|max_length[3]'
                )
            ));

            if ($this->form_validation->run() == TRUE) {

                $result = paymesPaymentForm($this->input->post('amount', TRUE), getActiveUser(), (object)[
                    'creditCardNumber' => $this->input->post('card_number', TRUE),
                    'owner' => $this->input->post('card_owner', TRUE),
                    'expiryMonth' => $this->input->post('card_last_m', TRUE),
                    'expiryYear' => $this->input->post('card_last_y', TRUE),
                    'cvv' => $this->input->post('card_cvc', TRUE),
                ]);

                if ($result) {
                    $viewData['paymentData'] = $result;
                    $viewData['alert'] = [
                        'class' => 'info',
                        'message' => 'Lütfen ödemeyi tamamlayın.'
                    ];
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Ödeme başarısız oldu.'
                    ];
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        endif;

        $this->load->view('pages/paymentmethods/paymes/index', (object)$viewData);
    }

    function bank_accounts()
    {
        if (!getActiveUser()) { // || !getActiveUser()->is_dealer
            redirect();
            return;
        }

        $viewData = [
            'bank_accounts' => $this->db->order_by('id DESC')->get('bank_accounts')->result()
        ];

        if (isset($_POST['sendPaymentInformation']) && getActiveUser()) {
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'sendTime',
                    'label' => 'Ödeme Tarihi',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'senderFullName',
                    'label' => 'Gönderen Adı Soyadı',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'bankAccount',
                    'label' => 'Ödeme Yaptığınız Banka',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'price',
                    'label' => 'Tutar',
                    'rules' => 'required|trim|numeric'
                ),
                array(
                    'field' => 'description',
                    'label' => 'İletmek İstedikleriniz',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'sendPaymentInformation',
                    'label' => 'Ödeme Bildirimi',
                    'rules' => 'required'
                )
            ));

            if ($this->form_validation->run() == TRUE) {
                $userID = getActiveUser()->id;
                $query = $this->db->query("SELECT IFNULL(COUNT(*),0) as 'notificationCount' FROM payment_notifications WHERE status=0 AND user_id={$userID}");
                $result = $query->result();
                $count = $result[0]->notificationCount;
                if ($count == 0) {
                    $bank = $this->db->where('id', $this->input->post('bankAccount', TRUE))->get('bank_accounts')->row();
                    if (isset($bank->id)) {

                        $this->db->insert('payment_notifications', [
                            'user_id' => getActiveUser()->id,
                            'price' => $this->input->post('price', TRUE),
                            'information_json' => json_encode([
                                'sendTime' => $this->input->post('sendTime', TRUE),
                                'senderFullName' => $this->input->post('senderFullName', TRUE),
                                'bankAccount' => $bank->name . ' - ' . $bank->iban,
                                'price' => $this->input->post('price', TRUE),
                                'description' => $this->input->post('description', TRUE),
                                'sendPaymentInformation' => $this->input->post('sendPaymentInformation', TRUE)
                            ])
                        ]);

                        if ($this->db->insert_id()) {
                            foreach ($this->db->where('is_admin', 1)->get('users')->result() as $_admin) :
                                sendEmail($_admin->email, 'Yeni Ödeme Bildirimi', '
                                <strong>Adı Soyadı: </strong> ' . $this->input->post('senderFullName', TRUE) . '<br>
                                <strong>Gönderilen Banka Hesabı: </strong> ' . $bank->name . ' - ' . $bank->iban . '<br>
                                <strong>Tutar: </strong> ' . number_format($this->input->post('price', TRUE), 2) . 'TL
                            ');
                            endforeach;
                            $viewData['sendPaymentInformationFormAlert'] = [
                                'class' => 'success',
                                'message' => 'Ödeme bildirimi başarıyla yapıldı. En kısa sürede yanıtlanacaktır.'
                            ];
                        } else {
                            $viewData['sendPaymentInformationFormAlert'] = [
                                'class' => 'danger',
                                'message' => 'Hata: Ödeme bildirimi yapılamadı. Lütfen daha sonra tekrar deneyin.'
                            ];
                        }
                    } else {
                        $viewData['sendPaymentInformationFormAlert'] = [
                            'class' => 'danger',
                            'message' => 'Hata: Lütfen geçerli bir banka belirtin.'
                        ];
                    }
                } else {
                    $viewData['sendPaymentInformationFormAlert'] = [
                        'class' => 'warning',
                        'message' => 'Uyarı: Onay yada İptal Bekleyen Ödeme Bildiriminiz Zaten Mevcut. Lütfen daha sonra tekrar deneyin.'
                    ];
                }
            } else {
                $viewData['sendPaymentInformationFormError'] = TRUE;
            }
        }
        $this->load->view('pages/paymentmethods/bank_accounts', (object)$viewData);
    }
}
