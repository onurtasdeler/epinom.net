<?php

class Pvpservers extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $this->list();
    }

    function list(){
        $viewData = [
            "items" => $this->db->order_by('id DESC')->get('pvp_servers')->result()
        ];
        $this->load->view("pages/pvpservers/list", (object)$viewData);
    }

    function waitingservers(){
        $viewData = [
            "items" => $this->db->where([
                'user_id !=' => 0
            ])->get('pvp_servers')->result()
        ];
        $this->load->view("pages/pvpservers/user_list", (object)$viewData);
    }

    function insert(){
        $viewData = [];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'name',
                    'label' => 'İsim',
                    'rules' => 'required|trim|min_length[3]'
                ],
                [
                    'field' => 'security',
                    'label' => 'Güvenlik',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'beta_date',
                    'label' => 'Beta Tarihi',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'official_date',
                    'label' => 'Official Tarihi',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'game_type',
                    'label' => 'Oyun Türü',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'lang',
                    'label' => 'Dil',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'platform',
                    'label' => 'Platform',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'link',
                    'label' => 'Link',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'status',
                    'label' => 'Yayın Durumu',
                    'rules' => 'required|trim|integer'
                ],
            ];
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                //insert
                $this->db->insert('pvp_servers', [
                    "name" => $this->input->post("name", TRUE),
                    "security" => $this->input->post("security", TRUE),
                    "beta_date" => $this->input->post("beta_date", TRUE),
                    "official_date" => $this->input->post("official_date", TRUE),
                    "game_type" => $this->input->post("game_type", TRUE),
                    "lang" => $this->input->post("lang", TRUE),
                    "platform" => $this->input->post("platform", TRUE),
                    "link" => $this->input->post("link", TRUE),
                    "is_active" => 1,
                    "status" => $this->input->post("status", TRUE) == 1 ? 1 : 0
                ]);
                if($this->db->insert_id()){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla eklendi."
                    ];
                    header("Refresh:2;url=" . base_url("pvpservers/list"));
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Ekleme başarısız."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/pvpservers/insert", (object)$viewData);
    }

    function edit($item_id){
        $item = $this->db->where([
            'id' => $item_id
        ])->get('pvp_servers')->row();
        if(isset($item->id)){
            $viewData = [
                "item" => $item
            ];

            if(isset($_GET["is_active"])):
                $this->db->update('pvp_servers', [
                    'is_active' => $item->is_active == 1 ? 0 : 1
                ], [
                    'id' => $item->id
                ]);
                redirect("pvpservers/waitingservers");
                return;
            endif;

            if(isset($_GET["delete"])):
                $this->db->delete('pvp_servers', [
                    "id" => $item->id
                ]);
                redirect("pvpservers/list");
                return;
            endif;

            if(isset($_POST["submitForm"])):
                $form_rules = [
                    [
                        'field' => 'name',
                        'label' => 'İsim',
                        'rules' => 'required|trim|min_length[3]'
                    ],
                    [
                        'field' => 'security',
                        'label' => 'Güvenlik',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'beta_date',
                        'label' => 'Beta Tarihi',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'official_date',
                        'label' => 'Official Tarihi',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'game_type',
                        'label' => 'Oyun Türü',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'lang',
                        'label' => 'Dil',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'platform',
                        'label' => 'Platform',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'link',
                        'label' => 'Link',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'status',
                        'label' => 'Yayın Durumu',
                        'rules' => 'required|trim|integer'
                    ]
                ];
                
                $this->form_validation->set_rules($form_rules);
    
                if ($this->form_validation->run() == TRUE){
                    
                    //update
                    $this->db->update('pvp_servers', [
                        "name" => $this->input->post("name", TRUE),
                        "security" => $this->input->post("security", TRUE),
                        "beta_date" => $this->input->post("beta_date", TRUE),
                        "official_date" => $this->input->post("official_date", TRUE),
                        "game_type" => $this->input->post("game_type", TRUE),
                        "lang" => $this->input->post("lang", TRUE),
                        "platform" => $this->input->post("platform", TRUE),
                        "link" => $this->input->post("link", TRUE),
                        "status" => $this->input->post("status", TRUE) == 1 ? 1 : 0
                    ], [
                        "id" => $item->id
                    ]);

                    if($this->db->affected_rows()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla güncellendi."
                        ];
                        header("Refresh:2;url=" . base_url("pvpservers/edit/" . $item->id));
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

            $this->load->view("pages/pvpservers/edit", (object)$viewData);
        }else{
            redirect("pvpservers");
            return;
        }
    }

    function advertising(){
        $viewData = [
            'advertising_spaces' => $this->db->where('id=1')->get('advertising_spaces')->row()
        ];

        if(isset($_GET['delete'])):
            $this->db->update('advertising_spaces', [
                $this->input->get('delete', TRUE) => ''
            ]);
            redirect('pvpservers/advertising');
        endif;

        if (isset($_POST['submitForm'])):

            $config['upload_path'] = '../public/ads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 3000;
            $config['file_ext_tolower'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            $uArray = [
                'updated_at' => date('Y-m-d H:i:s'),
                'p_ad_1_link' => $this->input->post('p_ad_1_link', TRUE),
                'p_ad_2_link' => $this->input->post('p_ad_2_link', TRUE),
                'p_ad_3_link' => $this->input->post('p_ad_3_link', TRUE),
                'p_ad_4_link' => $this->input->post('p_ad_4_link', TRUE),
                'p_ad_5_link' => $this->input->post('p_ad_5_link', TRUE),
                'p_ad_6_link' => $this->input->post('p_ad_6_link', TRUE),
                'home_1_link' => $this->input->post('home_1_link', TRUE),
                'home_2_link' => $this->input->post('home_2_link', TRUE),
                'left_fixed_link' => $this->input->post('left_fixed_link', TRUE),
                'right_fixed_link' => $this->input->post('right_fixed_link', TRUE)
            ];

            if(isset($_FILES['ad_1']['name']) && !empty($_FILES['ad_1']['name'])):
                if ($this->upload->do_upload('ad_1')){
                    $uArray['p_ad_1'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "1. görsel yüklenemedi. " . $this->upload->display_errors()
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['ad_2']['name']) && !empty($_FILES['ad_2']['name'])):
                if ($this->upload->do_upload('ad_2')){
                    $uArray['p_ad_2'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "2. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['ad_3']['name']) && !empty($_FILES['ad_3']['name'])):
                if ($this->upload->do_upload('ad_3')){
                    $uArray['p_ad_3'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "3. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['ad_4']['name']) && !empty($_FILES['ad_4']['name'])):
                if ($this->upload->do_upload('ad_4')){
                    $uArray['p_ad_4'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "4. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['ad_5']['name']) && !empty($_FILES['ad_5']['name'])):
                if ($this->upload->do_upload('ad_5')){
                    $uArray['p_ad_5'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "5. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['ad_6']['name']) && !empty($_FILES['ad_6']['name'])):
                if ($this->upload->do_upload('ad_6')){
                    $uArray['p_ad_6'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "6. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['home_1']['name']) && !empty($_FILES['home_1']['name'])):
                if ($this->upload->do_upload('home_1')){
                    $uArray['home_1'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Anasayfa 1. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['home_2']['name']) && !empty($_FILES['home_2']['name'])):
                if ($this->upload->do_upload('home_2')){
                    $uArray['home_2'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Anasayfa 2. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['left_fixed']['name']) && !empty($_FILES['left_fixed']['name'])):
                if ($this->upload->do_upload('left_fixed')){
                    $uArray['left_fixed'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Sabit 1. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            if(isset($_FILES['right_fixed']['name']) && !empty($_FILES['right_fixed']['name'])):
                if ($this->upload->do_upload('right_fixed')){
                    $uArray['right_fixed'] = $this->upload->data()["file_name"];
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Sabit 2. görsel yüklenemedi."
                    ];
                    $this->load->view('pages/pvpservers/advertising', (object)$viewData);
                    return;
                }
            endif;

            $this->db->where([
                'id' => 1
            ])->update('advertising_spaces', $uArray);

            if ($this->db->affected_rows()>0) {
                $viewData["alert"] = [
                    "class" => "success",
                    "message" => "Başarıyla güncellendi."
                ];
                header('Refresh:1;url=' . current_url());
            } else {
                $viewData["alert"] = [
                    "class" => "danger",
                    "message" => "Güncellenemedi."
                ];
            }

        endif;

        $this->load->view('pages/pvpservers/advertising', (object)$viewData);
    }
}
