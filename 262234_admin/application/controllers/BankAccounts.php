<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankAccounts extends CI_Controller
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
        $this->List();
    }

    public function List()
    {
        $viewData = [
            'bank_accounts' => $this->db->order_by('id DESC')->get('bank_accounts')->result()
        ];
        $this->load->view('pages/bank_accounts/list', (object)$viewData);
    }

    public function Edit($id = null)
    {
        $slide = $this->db->where([
            'id' => $id
        ])->get('bank_accounts')->row();

        if (!isset($slide->id)) {
            redirect('bank_accounts');
            return;
        }

        $viewData = [
            'item' => $slide
        ];

        if(isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'name',
                    'label' => 'İsimlendirme',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'iban',
                    'label' => 'IBAN',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'text',
                    'label' => 'Yazı',
                    'rules' => 'trim|required'
                ],
            ];

            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $config['upload_path'] = '../public/bank_accounts/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5000;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                $image_url = $slide->image_url;
                if(!empty($_FILES["image"])){
                    if ($this->upload->do_upload('image')){
                        $image_url = $this->upload->data()["file_name"];
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Görsel yüklenemedi."
                        ];
                    }
                }

                //update
                $this->db->update('bank_accounts', [
                    "name" => $this->input->post("name", TRUE),
                    "iban" => $this->input->post("iban", TRUE),
                    "image_url" => $image_url,
                    "text" => $this->input->post('text', TRUE),
                ], [
                    "id" => $slide->id
                ]);

                if($this->db->affected_rows()>0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi. Sayfa yenileniyor..."
                    ];
                    header("Refresh:2;url=" . base_url("bankaccounts/edit/" . $slide->id));
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Kaydetme başarısız."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view('pages/bank_accounts/edit', (object)$viewData);
    }

    public function Add()
    {
        $viewData = [];

        if(isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'name',
                    'label' => 'İsimlendirme',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'iban',
                    'label' => 'IBAN',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'text',
                    'label' => 'Yazı',
                    'rules' => 'trim|required'
                ],
            ];
            if(!$_FILES["image"]){
                $form_rules[] = [
                    'field' => 'image',
                    'label' => 'Görsel',
                    'rules' => 'required|trim'
                ];
            }

            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $config['upload_path'] = '../public/bank_accounts/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5000;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('image')){
                    //insert
                    $this->db->insert('bank_accounts', [
                        "name" => $this->input->post("name", TRUE),
                        "iban" => $this->input->post("iban", TRUE),
                        "image_url" => $this->upload->data()["file_name"],
                        "text" => $this->input->post('text', TRUE),
                    ]);

                    if($this->db->insert_id()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla eklendi."
                        ];
                        header("Refresh:2;url=" . base_url("bankaccounts/list"));
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Kaydetme başarısız."
                        ];
                    }
                } else {
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Görsel yüklenemedi."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view('pages/bank_accounts/add', (object)$viewData);
    }

    public function Delete($id = null)
    {
        if($id){
            $this->db->delete('bank_accounts', [
                'id' => $id
            ]);
        }
        redirect('bankaccounts');
    }

}
