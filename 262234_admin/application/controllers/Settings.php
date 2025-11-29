<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {


    public function __construct(){
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }

        $this->load->model("setting");
        $this->load->model("social_media");
    }

    public function index()
    {
        $this->general();
    }

    public function general(){

        $viewData = [
            "config" => $this->setting->getRow()
        ];

        if(isset($_GET['clear_cache'])):
            $deletedCount = 0;
            $this->load->helper('directory');
            $cacheFolder = $_SERVER['DOCUMENT_ROOT'] . '/application/cache';
            $map = directory_map($cacheFolder, 1, FALSE);
            foreach($map as $m):
                if($m != 'index.html' && $m != 'sessions\\') {
                    unlink($cacheFolder . '/' . $m);
                    $deletedCount++;
                }
            endforeach;
            $viewData['alert'] = [
                'class' => 'success',
                'message' => $deletedCount . ' adet önbellek(cache) başarıyla temizlendi.'
            ];
            $this->load->view("pages/settings/general", (object)$viewData);
            header('Refresh:2;url=' . current_url());
            return;
        endif;

        if(isset($_POST["submitGeneral"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'site_title',
                    'label' => 'Site Başlığı',
                    'rules' => 'required|trim|min_length[1]'
                ],
                [
                    'field' => 'site_status',
                    'label' => 'Site Durumu',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'enable_snowflakes',
                    'label' => 'Kar Modu',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'home_page_popular_count',
                    'label' => 'Anasayfa Popüler Ürünler Sayısı',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'user_activation_required',
                    'label' => 'Üyelik Aktivasyonu',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'tc_activation_required',
                    'label' => 'T.C Doğrulama Aktivasyonu',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'show_slider_on_home_page',
                    'label' => 'Üyelik Aktivasyonu',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'footer_scripts',
                    'label' => 'Script Kodları',
                    'rules' => 'trim|min_length[1]'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){

                $this->db->where([
                    "id" => 1
                ])->update("config", [
                    "site_title" => $this->input->post("site_title", TRUE),
                    "site_status" => $this->input->post("site_status", TRUE),
                    "user_activation_required" => $this->input->post("user_activation_required", TRUE) ? 1 : 0,
                    "tc_activation_required" => $this->input->post("tc_activation_required", TRUE) ? 1 : 0,
                    "home_page_popular_count" => $this->input->post("home_page_popular_count", TRUE),
                    "show_slider_on_home_page" => $this->input->post("show_slider_on_home_page", TRUE) ? 1 : 0,
                    "enable_snowflakes" => $this->input->post("enable_snowflakes", TRUE) ? 1 : 0,
                    "footer_script" => $_POST['footer_scripts'],
                    "whatsapp_no" => $this->input->post("whatsapp_no", TRUE),
					"dark_mode" => $this->input->post("dark_mode", TRUE),
                    "contact_email" => $this->input->post("contact_email", TRUE),
                    "contact_phone" => $this->input->post("contact_phone", TRUE),
                    "contact_vd" => $this->input->post("contact_vd", TRUE),
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Bilgiler başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("settings/general"));

                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Bilgiler güncellenemedi."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/settings/general", (object)$viewData);
    }

    public function social(){
        $viewData = [
            "accounts" => $this->social_media->getAll()
        ];
        $this->load->view("pages/settings/social", (object)$viewData);
    }

    public function email(){
        $viewData = [
            "config" => $this->setting->getRow()
        ];

        if(isset($_POST["submitEmailConfig"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'is_email_active',
                    'label' => 'E-Posta Gönderimi',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'email_smtp_host',
                    'label' => 'SMTP Host',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'email_smtp_user',
                    'label' => 'SMTP User',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'email_smtp_password',
                    'label' => 'SMTP Password',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'email_smtp_port',
                    'label' => 'SMTP Port',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'email_address',
                    'label' => 'E-Posta Adresi',
                    'rules' => 'required|trim|valid_email'
                ],
                [
                    'field' => 'email_from',
                    'label' => 'E-Posta (Kimden)',
                    'rules' => 'required|trim'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){

                $this->db->where([
                    "id" => 1
                ])->update("config", [
                    "is_email_active" => $this->input->post("is_email_active", TRUE),
                    "email_smtp_host" => $this->input->post("email_smtp_host", TRUE),
                    "email_smtp_user" => $this->input->post("email_smtp_user", TRUE),
                    "email_smtp_password" => $this->input->post("email_smtp_password", TRUE),
                    "email_smtp_port" => $this->input->post("email_smtp_port", TRUE),
                    "email_address" => $this->input->post("email_address", TRUE),
                    "email_from" => $this->input->post("email_from", TRUE)
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Bilgiler başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("settings/email"));

                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Bilgiler güncellenemedi."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/settings/mail", (object)$viewData);
    }

    public function sms(){
        $viewData = [
            "config" => $this->setting->getRow()
        ];

        if(isset($_POST["submitSMSConfig"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'is_sms_active',
                    'label' => 'E-Posta Gönderimi',
                    'rules' => 'required|integer'
                ],
                [
                    'field' => 'sms_username',
                    'label' => 'Kullanıcı Adı',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'sms_password',
                    'label' => 'Şifre',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'sms_heading',
                    'label' => 'SMS Başlığı',
                    'rules' => 'required|trim'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){

                $this->db->where([
                    "id" => 1
                ])->update("config", [
                    "is_sms_active" => $this->input->post("is_sms_active", TRUE),
                    "sms_username" => $this->input->post("sms_username", TRUE),
                    "sms_password" => $this->input->post("sms_password", TRUE),
                    "sms_heading" => $this->input->post("sms_heading", TRUE)
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Bilgiler başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("settings/sms"));

                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Bilgiler güncellenemedi."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/settings/sms", (object)$viewData);
    }

    public function payment($payment_method_id = null){
        $defaultPaymentMethodId = $this->db->where(['id'=>1])->get('config')->row()->payment_method;
        if($payment_method_id == null){
            if(isset($_GET['dp'])):
                if(count($this->db->where('id=' . $this->input->get('dp', TRUE))->get('payment_methods')->result())>0){
                    $this->db->update('config', [
                        'payment_method' => $this->input->get('dp', TRUE)
                    ],[
                        'id' => 1
                    ]);
                }
                redirect(current_url());
            endif;

            $viewData = [
                'payments' => $this->db->get('payment_methods')->result(),
                'defaultPaymentMethodId' => $defaultPaymentMethodId
            ];
            $this->load->view("pages/settings/payments", (object)$viewData);
            return;
        }else{
            $method = $this->db->where([
                'id' => $payment_method_id
            ])->get('payment_methods')->row();

            if(!isset($method->id)):
                redirect('payment');
                return;
            endif;

            if(isset($_GET['modal']) && isset($_POST['editPaymentMethod'])){
                $is_active = $this->input->post('is_active', TRUE);
                unset($_POST['editPaymentMethod']);
                unset($_POST['is_active']);
                $this->db->update('payment_methods', [
                    'api_json' => json_encode($_POST),
                    'is_active' => ($is_active == 1 ? 1 : 0)
                ], [
                    'id' => $method->id
                ]);
                redirect('settings/payment?open_modal=' . urlencode('#paymentMethodModal' . $method->id) . '&update_modal_ok=1');
                return;
            }

            redirect('settings/payment');
        }
    }

    public function seller($method_id = null){
        if($method_id == null){
            $viewData = [
                'sellers' => $this->db->get('seller_integrations')->result()
            ];
            $this->load->view("pages/settings/sellers", (object)$viewData);
            return;
        }else{
            $method = $this->db->where([
                'id' => $method_id
            ])->get('seller_integrations')->row();

            if(!isset($method->id)):
                redirect('seller');
                return;
            endif;

            if(isset($_GET['modal']) && isset($_POST['editSellerMethod'])){
                unset($_POST['editSellerMethod']);
                $this->db->update('seller_integrations', [
                    'api_json' => json_encode($_POST),
                ], [
                    'id' => $method->id
                ]);
                redirect('settings/seller?open_modal=' . urlencode('#sellerMethodModal' . $method->id) . '&update_modal_ok=1');
                return;
            }

            redirect('settings/seller');
        }
    }

    public function seo() {
        $viewData = [
            "config" => $this->setting->getRow()
        ];

        if(isset($_POST["submitSeoConfig"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'meta_description',
                    'label' => 'Meta Açıklama',
                    'rules' => 'trim'
                ],
                [
                    'field' => 'meta_keywords',
                    'label' => 'Meta Anahtar Kelimeler',
                    'rules' => 'trim'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){

                $this->db->where([
                    "id" => 1
                ])->update("config", [
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Bilgiler başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("settings/seo"));

                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Bilgiler güncellenemedi."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/settings/seo", (object)$viewData);
    }

    public function theme() {
        $config = $this->setting->getRow();
        $viewData = [
            "config" => $config
        ];

        if(isset($_POST["submitThemeSettings"])):
            $form_rules = [
                [
                    'field' => 'submitThemeSettings',
                    'label' => 'submitThemeSettings',
                    'rules' => 'required|trim'
                ]
            ];
            $this->form_validation->set_rules($form_rules);
            if ($this->form_validation->run() == TRUE){

                $this->load->library('upload', [
                    'upload_path' => '../public/theme',
                    'allowed_types' => 'gif|jpg|png|jpeg',
                    'max_size' => 3000,
                    'file_ext_tolower' => TRUE,
                    'encrypt_name' => TRUE
                ]);

                $logo_image_url = $config->logo_image_url;
                if(!empty($_FILES['logo'])){
                    if ($this->upload->do_upload('logo')){
                        $logo_image_url = $this->upload->data()['file_name'];
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Görsel yüklenemedi."
                        ];
                        $this->load->view("pages/settings/theme", (object)$viewData);
                        return;
                    }
                }

                $this->db->update("config", [
                    "logo_image_url" => $logo_image_url
                ], [
                    'id' => 1
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Ayarlar başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("settings/theme"));

                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Ayarlar güncellenemedi."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/settings/theme", (object)$viewData);
    }

}
