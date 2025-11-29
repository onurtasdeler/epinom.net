<?php

class User_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model("users");
        websiteStatus();
    }

    function Index()
    {
        $this->LoginPage();
    }

    function DonateSystem()
    {
        redirect('uye/hesabim');
        return;
    }

    function Logout()
    {
        $this->session->sess_destroy();
        redirect();
        exit;
    }

    function ActivationPage($user_hash)
    {
        $user = $this->users->getUser([
            "user_hash" => $user_hash
        ]);
        if (isset($user->id) && $user->activation_status == 0) {
            $viewData = [
                "user" => $user,
                "user_hash" => $user_hash
            ];
			
            sendEmail($user->email, 'EPİNAZ - Üyeliğinizi Doğrulayın', getEmailTemplate('user_activation', [
                'activation_code' => $user->activation_code,
            	'activation_url' => base_url('uye/aktivasyon/' . $user_hash)
			]));
            if (isset($_POST["activation"])) :
                if ($this->input->post("code", TRUE) == $user->activation_code) {
                    $this->users->userActivated([
                        "id" => $user->id
                    ]);
                    $this->session->set_userdata("user", $user);
                    $this->session->set_flashdata("login_activate_successful_toast", TRUE);

                    if (isset($_COOKIE['ref_user_id'])) {
                        delete_cookie('ref_user_id');
                        $ref_bonus_hash = md5(uniqid(time()));
                        $this->db->update('users', [
                            'ref_bonus_hash' => $ref_bonus_hash,
                            'ref_bonus_discount_percent' => 5,
                            'ref_is_active' => 1
                        ], [
                            'id' => $user->id
                        ]);
                        set_cookie('ref_bonus_hash', $ref_bonus_hash);
                        $this->db->query("UPDATE users SET balance = balance + ?, ref_points = ref_points + 1 WHERE id = ?", [
                            0.4,
                            $user->ref_user_id
                        ]);
                    }

                    insertUserStep($user->id, 'activation_ok', []);
                    redirect(base_url());
                } else {
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Aktivasyon kodu geçersiz, lütfen tekrar deneyin."
                    ];
                }
            endif;

            $this->load->view("pages/user/activation", (object)$viewData);
            return;
        }
        redirect();
        exit;
    }

    function LoginPage()
    {

        if (getActiveUser()) :
            redirect();
            exit;
        endif;

        $viewData = [];

        if (isset($_POST["login"])) :
            if (isset($_POST['g-recaptcha-response'])) {
                $googleCaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LchNZQaAAAAAI5_0a5RAh0V1XtBlK_-bw-u6eNx&response=" . $this->input->post('g-recaptcha-response') . "&remoteip=" . getIPAddress());
                $googleCaptchaKeys = json_decode($googleCaptcha, true);
            }
            $googleCaptchaKeys['success'] = 1;
            if (@$googleCaptchaKeys['success'] != 1) {
                $viewData['login_alert'] = [
                    'class' => 'danger',
                    'message' => 'Robot olmadığınız doğrulanmadı.'
                ];
            } else {
                $this->form_validation->set_rules(array(
                    array(
                        'field' => 'email',
                        'label' => 'E-Posta Adresi',
                        'rules' => 'required|trim|valid_email'
                    ),
                    array(
                        'field' => 'password',
                        'label' => 'Şifre',
                        'rules' => 'required|trim|min_length[5]'
                    )
                ));

                if ($this->form_validation->run() == TRUE) {

                    $user = $this->users->getUser([
                        "email" => $this->input->post("email", TRUE),
                        "password" => md5($this->input->post("password", TRUE))
                    ]);

                    if (isset($user->id)) {

                        if ($user->ip_control == 1) {
                            $user_ip_addresses = json_decode($user->ip_addresses);
                            if (!in_array(getIPAddress(), $user_ip_addresses)) {
                                $viewData["login_alert"] = [
                                    "class" => "danger",
                                    "message" => "Bu hesap için bu IP adresine izin verilmiyor. Bunun bir sorun olduğunu düşünüyorsanız lütfen bizimle irtibata geçin."
                                ];
                                $this->load->view("pages/user/authorization", (object)$viewData);
                                return;
                            }
                        }

                        $user_hash = $this->users->updateHash([
                            "id" => $user->id
                        ]);

                        $websiteConfig = $this->db->where('id=1')->get('config')->row();
                        if ($user->activation_status == 0 && $websiteConfig->user_activation_required == 1 && ($websiteConfig->is_sms_active == 1 || $websiteConfig->is_email_active == 1)) {
                            sendEmail($user->email, 'EPİNDENİZİ - Üyeliğinizi Doğrulayın', getEmailTemplate('user_activation', [
                                'activation_code' => $user->activation_code,
                                'activation_url' => base_url('uye/aktivasyon/' . $user_hash)
                            ]));
                            sendSMS($user->phone_number, 'Üyeliğinizi tamamlamak için sadece bir adım kaldı. ' . $user->activation_code . ' koduyla üyeliğinizi aktifleştirebilirsiniz.');
                            redirect("uye/aktivasyon/" . $user_hash);
                            return;
                        } else {
                            if ($user->activation_status == 0) :
                                $this->users->updateUser([
                                    'activation_status' => 1
                                ], [
                                    'id' => $user->id
                                ]);
                            endif;
                        }

                        $this->session->set_userdata("user", $user);

                        $this->session->set_flashdata("login_successful_toast", TRUE);

                        $this->users->updateUser([
                            'last_login_ip' => getIPAddress()
                        ], [
                            'id' => $user->id
                        ]);

                        insertUserStep($user->id, 'logged_in', []);

                        if (isset($_GET['r'])) {
                            redirect($_GET['r']);
                            return;
                        }
                        redirect(base_url());
                    } else {
                        $viewData["login_alert"] = [
                            "class" => "danger",
                            "message" => "Kullanıcı adı veya şifre yanlış."
                        ];
                    }
                } else {
                    $viewData["form_error"] = TRUE;
                }
            }
        endif;

        $this->load->view("pages/user/authorization", (object)$viewData);
    }

    function RegisterPage()
    {
        if (getActiveUser()) :
            redirect();
            exit;
        endif;

        $viewData = [];

        if (isset($_POST["register"])) :
            @$_POST['phone_number'] = str_replace([' ', '-'], null, $_POST['phone_number']);
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'email',
                    'label' => 'E-Posta Adresi',
                    'rules' => 'required|trim|valid_email|is_unique[users.email]'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Şifre',
                    'rules' => 'required|trim|min_length[5]'
                ),
                array(
                    'field' => 're_password',
                    'label' => 'Şifre Tekrar',
                    'rules' => 'required|trim|min_length[5]|matches[password]'
                ),
                array(
                    'field' => 'full_name',
                    'label' => 'Adı Soyadı',
                    'rules' => 'required|trim|min_length[3]'
                ),
                array(
                    'field' => 'phone_number',
                    'label' => 'Telefon Numarası',
                    'rules' => 'required|trim|min_length[10]|is_unique[users.phone_number]'
                ),
                array(
                    'field' => 'tc_no',
                    'label' => 'TC Kimlik Numarası',
                    'rules' => 'trim|min_length[11]|max_length[11]|is_unique[users.tc_no]'
                ),
                array(
                    'field' => 'agreement',
                    'label' => 'Kullanıcı Sözleşmesi',
                    'rules' => 'required|trim'
                )
            ));

            $this->form_validation->set_message('is_unique', '%s zaten var.');

            if ($this->form_validation->run() == TRUE) {

                $full_name_s = explode(' ', $this->input->post('full_name', TRUE));
                if (count($full_name_s) > 1) {
                    $ref_user_id = 0;
                    if (isset($_COOKIE['ref_user_id'])) {
                        $refUser = $this->db->where([
                            'id' => $this->input->cookie('ref_user_id', TRUE),
                            'is_streamer' => 1
                        ])->get('users')->row();
                        $ref_user_id = $refUser->id;
                    }

                    $this->users->addUser([
                        "email" => strtolower($this->input->post("email", TRUE)),
                        "password" => md5($this->input->post("password", TRUE)),
                        "full_name" => $this->input->post("full_name", TRUE),
                        "phone_number" => $this->input->post("phone_number", TRUE),
                        "username" => explode("@", $this->input->post("email", TRUE))[0],
                        "gender" => "male",
                        "tc_no" => $this->input->post("tc_no", TRUE),
                        "activation_code" => rand(100000, 999999),
                        "user_hash" => generateUserHash(),
                        "ref_user_id" => $ref_user_id,
                        "ref_is_active" => 0
                    ]);
                    $user_id = $this->db->insert_id();
                    if ($user_id) {

                        insertUserStep($user_id, 'registered', [
                            'ref_user' => isset($refUser) ? $refUser : NULL
                        ]);
                        $viewData["register_alert"] = [
                            "class" => "success",
                            "message" => "Üyeliğiniz başarıyla oluşturuldu. Giriş yapabilirsiniz, yönlendiriliyorsunuz..."
                        ];

                        $user = $this->db->where([
                            'id' => $user_id
                        ])->get('users')->row();

                        $user_hash = $this->users->updateHash([
                            "id" => $user->id
                        ]);

                        $websiteConfig = $this->db->where('id=1')->get('config')->row();
                        if ($user->activation_status == 0 && $websiteConfig->user_activation_required == 1 && ($websiteConfig->is_sms_active == 1 || $websiteConfig->is_email_active == 1)) {
                            if (!isset($refUser)) {
                                sendEmail($user->email, 'EPİNAZ - Üyeliğinizi Doğrulayın', getEmailTemplate('user_activation', [
                                    'activation_code' => $user->activation_code,
                                    'activation_url' => base_url('uye/aktivasyon/' . $user_hash)
                                ]));
                            }
                            sendSMS($user->phone_number, 'Üyeliğinizi tamamlamak için sadece bir adım kaldı. ' . $user->activation_code . ' koduyla üyeliğinizi aktifleştirebilirsiniz.');
                            redirect("uye/aktivasyon/" . $user_hash);
                            return;
                        } else {
                            if ($user->activation_status == 0) :
                                $this->users->updateUser([
                                    'activation_status' => 1
                                ], [
                                    'id' => $user->id
                                ]);
                            endif;
                        }

                        $this->session->set_userdata("user", $user);

                        $this->session->set_flashdata("login_successful_toast", TRUE);

                        $this->users->updateUser([
                            'last_login_ip' => getIPAddress()
                        ], [
                            'id' => $user->id
                        ]);

                        insertUserStep($user->id, 'logged_in', []);
                        redirect(base_url());
                    } else {
                        $viewData["register_alert"] = [
                            "class" => "danger",
                            "message" => "Kaydınız yapılırken bir hata oluştu."
                        ];
                    }
                } else {
                    $viewData["register_alert"] = [
                        "class" => "danger",
                        "message" => "Lütfen geçerli bir ad soyad girin."
                    ];
                }
            } else {
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/user/register", (object)$viewData);
    }

    function MyAccount()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }

        $viewData = [
            'user' => $this->users->getUser(['id' => getActiveUser()->id])
        ];

        if (isset($_POST['submitInformation'])) :
            $_POST["phoneNumber"] = str_replace([" "], null, $_POST["phoneNumber"]);
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'fullName',
                    'label' => 'Adı Soyadı',
                    'rules' => 'required|trim|min_length[3]'
                ),
                array(
                    'field' => 'phoneNumber',
                    'label' => 'Telefon Numarası',
                    'rules' => 'required|trim|min_length[11]'
                ),
                array(
                    'field' => 'username',
                    'label' => 'Kullanıcı Adı',
                    'rules' => 'required|trim|min_length[3]|max_length[35]|callback__usernameCheck'
                )
            ));

            $this->form_validation->set_message('is_unique', '%s zaten var.');

            if ($this->form_validation->run() == TRUE) {
                $this->users->updateUser([
                    'full_name' => $this->input->post('fullName', TRUE),
                    'phone_number' => $this->input->post('phoneNumber', TRUE),
                    'username' => $this->input->post('username', TRUE),
                    'gender' => 'male',
                    'address' => '',
                    'city' => 'İstanbul'
                ], [
                    'id' => getActiveUser()->id
                ]);
                $viewData['alert'] = [
                    'class' => 'success',
                    'message' => '<i data-feather="check"></i> Bilgileriniz başarıyla güncellendi. Sayfa yenileniyor...'
                ];
                header('Refresh:2;url=' . current_url());
            } else {
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view('pages/user/my_account', (object)$viewData);
    }

    function SecuritySettings()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }

        $viewData = [
            'user' => $this->users->getUser(['id' => getActiveUser()->id])
        ];

        if (isset($_POST['submitForm'])) :
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'ip_control',
                    'label' => 'IP Kontrolü',
                    'rules' => 'required|trim|in_list[0,1]'
                ),
                array(
                    'field' => 'ip_addresses',
                    'label' => 'IP Adresleri',
                    'rules' => 'trim' . ($this->input->post('ip_control') == 1 ? '|required' : NULL)
                )
            ));

            if ($this->form_validation->run() == TRUE) {

                $ipAddresses = [];
                $ipError = FALSE;
                foreach (explode("\n", $this->input->post('ip_addresses', TRUE)) as $_ip) :
                    if (!filter_var(trim($_ip), FILTER_VALIDATE_IP)) {
                        $ipError = TRUE;
                        break;
                    }
                    $ipAddresses[] = str_replace(["\r", "\t", "\n", " "], NULL, $_ip);
                endforeach;

                if ($ipError == TRUE) {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => '<i data-feather="x-circle"></i> Geçersiz bir IP adresi algılandı. Lütfen geçerli IP adresleri girin.'
                    ];
                } else {
                    $this->users->updateUser([
                        'ip_control' => $this->input->post('ip_control', TRUE),
                        'ip_addresses' => json_encode($ipAddresses)
                    ], [
                        'id' => getActiveUser()->id
                    ]);
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => '<i data-feather="check"></i> Ayarlar başarıyla güncellendi. Sayfa yenileniyor...'
                    ];
                    header('Refresh:2;url=' . current_url());
                }
            } else {
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view('pages/user/security_settings', (object)$viewData);
    }

    function RenewPassword()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }

        $viewData = [
            'user' => $this->users->getUser(['id' => getActiveUser()->id])
        ];

        if (isset($_POST['submitRenewPassword'])) :
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'currentPassword',
                    'label' => 'Mevcut Şifre',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'newPassword',
                    'label' => 'Yeni Şifre',
                    'rules' => 'required|trim|min_length[6]|max_length[12]'
                ),
                array(
                    'field' => 'newPasswordRe',
                    'label' => 'Yeni Şifre Tekrarı',
                    'rules' => 'required|trim|min_length[6]|max_length[12]|matches[newPassword]'
                )
            ));

            $this->form_validation->set_message('is_unique', '%s zaten var.');

            if ($this->form_validation->run() == TRUE) {
                if ($this->input->post('currentPassword', TRUE) != $this->input->post('newPassword', TRUE)) {
                    if (md5($this->input->post('currentPassword', TRUE)) == getActiveUser()->password) {
                        //update user password
                        $this->users->updateUser([
                            'password' => md5($this->input->post('newPassword', TRUE))
                        ], [
                            'id' => getActiveUser()->id
                        ]);
                        insertUserStep(getActiveUser()->id, 'renew_password', []);
                        $viewData['alert'] = [
                            'class' => 'success',
                            'message' => '<i data-feather="check"></i> Şifreniz değiştirildi.'
                        ];
                    } else {
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => 'Mevcut şifreniz yanlış.'
                        ];
                    }
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Yeni şifreniz eski şifrelerinizden birisi olamaz.'
                    ];
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        endif;

        $this->load->view('pages/user/renew_password', (object)$viewData);
    }

    function ForgotPassword()
    {
        if (getActiveUser()) {
            redirect();
            return;
        }

        $viewData = [];

        if (isset($_POST['forgot_password'])) {
            if ($this->input->post('user', TRUE) != '') {
                $user = $this->db->query("SELECT * FROM users WHERE email = ? OR phone_number = ?", [
                    $this->input->post('user', TRUE),
                    $this->input->post('user', TRUE)
                ])->result()[0];
                if (isset($user->id)) {
                    $user_hash = $this->users->updateHash([
                        "id" => $user->id
                    ]);
                    sendEmail($user->email, 'EPİNDENİZİ - Şifrenizi Sıfırlayın', getEmailTemplate('forgot_password', [
                        'renew_password_url' => base_url('sifremi-unuttum/' . $user_hash)
                    ]));
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => 'E-posta adresinize gönderilen bağlantı ile şifrenizi sıfırlayabilirsiniz.'
                    ];
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'E-posta adresi veya telefon numarası bulunamadı.'
                    ];
                }
            } else {
                $viewData['alert'] = [
                    'class' => 'warning',
                    'message' => 'Boş alan bırakılamaz.'
                ];
            }
        }

        $this->load->view('pages/user/forgot_password', (object)$viewData);
    }

    function ForgotPasswordStep2($user_hash = null)
    {
        if (getActiveUser()) {
            redirect();
            return;
        }

        $viewData = [];

        if ($user_hash == null) {
            redirect();
            return;
        }

        $user = $this->users->getUser([
            'user_hash' => $user_hash
        ]);

        if (!isset($user->id)) {
            redirect();
            return;
        }

        if (isset($_POST['forgot_password_step_2'])) :
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'newPassword',
                    'label' => 'Yeni Şifre',
                    'rules' => 'required|trim|min_length[5]'
                ),
                array(
                    'field' => 'newPasswordRe',
                    'label' => 'Yeni Şifre Tekrar',
                    'rules' => 'required|trim|min_length[5]|matches[newPassword]'
                )
            ));

            if ($this->form_validation->run() == TRUE) {

                $this->users->updateUser([
                    'password' => md5($this->input->post('newPassword', TRUE))
                ], [
                    'id' => $user->id
                ]);

                if ($this->db->affected_rows() > 0) {
                    $this->users->updateHash([
                        "id" => $user->id
                    ]);
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => 'Şifreniz başarıyla güncellendi. Giriş sayfasına yönlendiriliyorsunuz...'
                    ];
                    header('Refresh:2;url=' . base_url('uye/giris-yap'));
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Şifreniz güncellenirken problem oluştu. Lütfen daha sonra tekrar deneyiniz.'
                    ];
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        endif;

        $this->load->view('pages/user/forgot_password_step_2', (object)$viewData);
    }

    function TCVerification()
    {
        if (!getActiveUser()) {
            redirect();
            return;
        }

        if (isTcOk(getActiveUser()->id)) {
            redirect('uye/hesabim');
            return;
        }

        $viewData = [];

        if (isset($_POST['idVerification'])) {
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'firstname',
                    'label' => 'Adı',
                    'rules' => 'required|trim|max_length[255]'
                ),
                array(
                    'field' => 'lastname',
                    'label' => 'Soyadı',
                    'rules' => 'required|trim|max_length[255]'
                ),
                array(
                    'field' => 'birthyear',
                    'label' => 'Doğum Yılı',
                    'rules' => 'required|trim|max_length[4]|min_length[4]|integer'
                ),
                array(
                    'field' => 'tc_no',
                    'label' => 'T.C. Kimlik Numarası',
                    'rules' => 'required|trim|max_length[14]|min_length[11]'
                )
            ));

            if ($this->form_validation->run() == TRUE) {

                $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
                try {
                    $result = $client->TCKimlikNoDogrula([
                        'TCKimlikNo' => $this->input->post('tc_no', TRUE),
                        'Ad' => tr_strtoupper($this->input->post('firstname', TRUE)),
                        'Soyad' => tr_strtoupper($this->input->post('lastname', TRUE)),
                        'DogumYili' => $this->input->post('birthyear', TRUE)
                    ]);
                    if ($result->TCKimlikNoDogrulaResult) {
                        $this->db->update('users', [
                            'tc_no' => $this->input->post('tc_no', TRUE)
                        ], [
                            'id' => getActiveUser()->id
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            $viewData['alert'] = [
                                'class' => 'success',
                                'message' => 'İşleminiz başarıyla tamamlanmıştır. Alışverişinize devam edebilirsiniz.'
                            ];
                            header('Refresh:2;url=' . base_url('sepetim'));
                        } else {
                            $viewData['alert'] = [
                                'class' => 'danger',
                                'message' => 'Sorun oluştu. Lütfen daha sonra tekrar deneyiniz.'
                            ];
                        }
                    } else {
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => 'Verdiğiniz bilgiler geçersiz.'
                        ];
                    }
                } catch (Exception $e) {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Şu anda bu işlemi gerçekleştiremiyoruz. Lütfen daha sonra tekrar deneyiniz.'
                    ];
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        }

        $this->load->view('pages/user/tc_verification', (object)$viewData);
    }

    function Orders()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $this->load->model('orders_model');
        $viewData = [
            "orders" => $this->orders_model->getAll([
                'user_id' => getActiveUser()->id
            ], null, 'id DESC'),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/orders', (object)$viewData);
    }

    function GameMoneyOrders()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            "orders" => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('status ASC, id DESC')->limit(10)->get('game_moneys_orders')->result(),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/gamemoneyorders', (object)$viewData);
    }

    function GameMoneySelltous()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            "orders" => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('status ASC, id DESC')->limit(10)->get('game_moneys_selltous')->result(),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/selltouslist', (object)$viewData);
    }
    function Notifications()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $this->db->update('notifications',[
            "is_viewed"=>1            
        ],["user_id"=>getActiveUser()->id]);
        $viewData = [
            'notifications' => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('id DESC')->get('notifications')->result(),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/notifications', (object)$viewData);
    }
    function PaymentNotifications()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'notifications' => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('id DESC')->get('payment_notifications')->result(),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/payment_notifications', (object)$viewData);
    }

    function MyPaymentLogs()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'logs' => $this->db->where([
                'user_id' => getActiveUser()->id,
                'is_active' => 1
            ])->order_by('id DESC')->get('payment_log')->result(),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/payment_log', (object)$viewData);
    }

    function MyBankAccounts()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }

        if (isset($_GET['d']) && isset($_GET['i']) && isset($_GET['a'])) :
            $_uba = $this
                ->db
                ->where([
                    'user_id' => getActiveUser()->id,
                    'id' => $this->input->get('i', TRUE)
                ])
                ->get('user_bank_accounts')
                ->row();
            if (isset($_uba->id)) {
                $this->db->delete('user_bank_accounts', [
                    'id' => $_uba->id
                ]);
            }
            redirect(current_url());
            return;
        endif;

        $viewData = [
            'user_bank_accounts' => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('id DESC')->get('user_bank_accounts')->result(),
            'user' => getActiveUser()
        ];

        $this->load->view('pages/user/user_bank_accounts', (object)$viewData);
    }

    function MyBankAccountsAdd()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'user_bank_accounts' => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('id DESC')->get('user_bank_accounts')->result(),
            'user' => getActiveUser()
        ];

        if (isset($_POST['submitForm'])) :
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'account_name',
                    'label' => 'Banka Hesabı',
                    'rules' => 'required|trim|min_length[3]'
                ),
                array(
                    'field' => 'full_name',
                    'label' => 'Adı Soyadı',
                    'rules' => 'required|trim|min_length[3]'
                ),
                array(
                    'field' => 'account_number',
                    'label' => 'Banka Hesap Numarası',
                    'rules' => 'required|trim|min_length[5]'
                ),
                array(
                    'field' => 'account_office_code',
                    'label' => 'Banka Şube Kodu',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'iban',
                    'label' => 'IBAN Numarası',
                    'rules' => 'required|trim|min_length[12]'
                )
            ));

            if ($this->form_validation->run() == TRUE) {
                if (count($viewData['user_bank_accounts']) > 9) {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Maksimum 10 adet banka hesabı ekleyebilirsiniz.'
                    ];
                } else {
                    $this->db->insert('user_bank_accounts', [
                        'account_name' => $this->input->post('account_name', TRUE),
                        'full_name' => $this->input->post('full_name', TRUE),
                        'account_number' => $this->input->post('account_number', TRUE),
                        'account_office_code' => $this->input->post('account_office_code', TRUE),
                        'iban' => $this->input->post('iban', TRUE),
                        'user_id' => getActiveUser()->id
                    ]);
                    if ($this->db->insert_id()) {
                        $viewData['alert'] = [
                            'class' => 'success',
                            'message' => 'Başarıyla eklendi. Yönlendiriliyorsunuz...'
                        ];
                        header('Refresh:2;url=' . base_url('uye/banka-hesaplarim'));
                    } else {
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => 'Eklenemedi.'
                        ];
                    }
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        endif;

        $this->load->view('pages/user/add_user_bank_account', (object)$viewData);
    }

    function BalanceWithdraws()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }
        $viewData = [
            'balance_withdraw_requests' => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->order_by('id DESC')->get('balance_withdraw_requests')->result(),
            'user' => getActiveUser()
        ];
        $this->load->view('pages/user/balance_withdraw_requests', (object)$viewData);
    }

    function AddBalanceWithdrawRequest()
    {
        if (!getActiveUser()) {
            redirect('uye/giris-yap?r=' . urlencode(current_url()));
            return;
        }

        $balanceWithdrawCommissionAmount = $this->db->where('id=1')->get('config')->row()->balance_withdraw_commission_amount;

        $viewData = [
            'user' => getActiveUser(),
            'balanceWithdrawCommissionAmount' => $balanceWithdrawCommissionAmount,
            'userBankAccounts' => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->get('user_bank_accounts')->result()
        ];

        if (isset($_POST['submitForm'])) :
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'bank_account',
                    'label' => 'Banka Hesabı',
                    'rules' => 'required|trim|integer'
                ),
                array(
                    'field' => 'amount',
                    'label' => 'Tutar',
                    'rules' => 'required|trim|numeric|greater_than[0]'
                ),
            ));

            if ($this->form_validation->run() == TRUE) {

                $bank_account = $this->db->where([
                    'id' => $this->input->post('bank_account', TRUE)
                ])->get('user_bank_accounts')->row();
                if (!isset($bank_account->id)) {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => '<i data-feather="alert-circle"></i> Bir sorun oluştu. Sistemde banka hesabınız bulunmuyor veya gönderilen hesap geçersiz.'
                    ];
                    $this->load->view('pages/user/add_balance_withdraw_request', (object)$viewData);
                    return;
                }

                if ($this->db->where([
                    'user_id' => getActiveUser()->id,
                    'status' => 0
                ])->get('balance_withdraw_requests')->num_rows() > 1) {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => '<i data-feather="alert-circle"></i> Lütfen mevcut bildirimlerinizin sonuçlanmasını bekleyiniz.'
                    ];
                } else {
                    if ($this->input->post('amount', TRUE) > $balanceWithdrawCommissionAmount) {
                        if ($this->input->post('amount', TRUE) <= $this->db->where('id=' . getActiveUser()->id)->get('users')->row()->balance) {
                            $this->db->insert('balance_withdraw_requests', [
                                'user_id' => getActiveUser()->id,
                                'status' => 0, //waiting status
                                'amount' => $this->input->post('amount', TRUE) > 0 ? $this->input->post('amount', TRUE) : 0,
                                'information_json' => json_encode([
                                    'fullName' => $this->input->post('full_name', TRUE),
                                    'bank_account' => $bank_account,
                                    'amountWithoutCommissionAmount' => ($this->input->post('amount', TRUE) - $balanceWithdrawCommissionAmount)
                                ])
                            ]);
                            if ($this->db->insert_id()) {
                                $this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                                    $this->input->post('amount', TRUE),
                                    getActiveUser()->id
                                ]);
                                $viewData['alert'] = [
                                    'class' => 'success',
                                    'message' => '<i data-feather="check"></i> Talebiniz alındı. En kısa sürede sonuçlanacaktır.'
                                ];
                                header('Refresh:2;url=' . base_url('uye/cekim-bildirimlerim'));
                            } else {
                                $viewData['alert'] = [
                                    'class' => 'danger',
                                    'message' => '<i data-feather="alert-circle"></i> Talebiniz işlenemedi. Lütfen daha sonra tekrar deneyiniz.'
                                ];
                            }
                        } else {
                            $viewData['alert'] = [
                                'class' => 'danger',
                                'message' => '<i data-feather="alert-circle"></i> Talebiniz işlenemedi. <strong>Bakiyeniz yetersiz.</strong>'
                            ];
                        }
                    } else {
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => '<i data-feather="alert-circle"></i> Çekim tutarı ' . number_format($balanceWithdrawCommissionAmount, 2, ',', '.') . 'TL`den fazla olmalıdır.'
                        ];
                    }
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        endif;

        $this->load->view('pages/user/add_balance_withdraw_request', (object)$viewData);
    }

    public function _usernameCheck($username)
    {
        $this->form_validation->set_message('_usernameCheck', 'Kullanıcı adı alanı yalnızca küçük harf ve sayı içerebilir.');
        if (preg_match('/^[a-z0-9]+$/', $username))
            return TRUE;
        else
            return FALSE;
    }
}
