<?php

class Announcements extends CI_Controller
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
            'announcements' => $this->db->get('announcements')->result()
        ];
        $this->load->view('pages/announcements/list', (object)$viewData);
    }

    public function Edit($id = null)
    {
        $announcement = $this->db->where([
            'id' => $id
        ])->get('announcements')->row();

        if (!isset($announcement->id)) {
            redirect('announcements');
            return;
        }

        $viewData = [
            'item' => $announcement
        ];

        if(isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'content',
                    'label' => 'İçerik',
                    'rules' => 'required'
                ],
                [
                    'field' => 'a_link',
                    'label' => 'URL',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Yayın Durumu',
                    'rules' => 'trim|required|integer|in_list[1,0]'
                ]
            ];
            
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){

                $this->db->update('announcements', [
                    "content" => $this->input->post("content", TRUE),
                    "a_link" => $this->input->post("a_link", TRUE),
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                ], [
                    "id" => $announcement->id
                ]);

                if($this->db->affected_rows()>0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi. Sayfa yenileniyor..."
                    ];
                    header("Refresh:2;url=" . base_url("announcements/edit/" . $announcement->id));
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

        $this->load->view('pages/announcements/edit', (object)$viewData);
    }

    public function Add()
    {
        $viewData = [];

        if(isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'content',
                    'label' => 'İçerik',
                    'rules' => 'required'
                ],
                [
                    'field' => 'a_link',
                    'label' => 'URL',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Yayın Durumu',
                    'rules' => 'trim|required|integer|in_list[1,0]'
                ]
            ];
            
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){

                    //insert
                    $this->db->insert('announcements', [
                        "content" => $this->input->post("content", TRUE),
                        "a_link" => $this->input->post("a_link", TRUE),
                        "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,                    ]);

                    if($this->db->insert_id()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla eklendi."
                        ];
                        header("Refresh:2;url=" . base_url("announcements/list"));
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

        $this->load->view('pages/announcements/add', (object)$viewData);
    }

    public function Delete($id = null)
    {
        if($id){
            $this->db->delete('announcements', [
                'id' => $id
            ]);
        }
        redirect('announcements');
    }

}
