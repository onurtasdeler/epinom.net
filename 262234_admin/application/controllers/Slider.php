<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller
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
            'slides' => $this->db->order_by('id DESC')->get('slider')->result()
        ];
        $this->load->view('pages/slider/list', (object)$viewData);
    }

    public function Edit($id = null)
    {
        $slide = $this->db->where([
            'id' => $id
        ])->get('slider')->row();

        if (!isset($slide->id)) {
            redirect('slider');
            return;
        }

        $viewData = [
            'item' => $slide
        ];

        if(isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'title',
                    'label' => 'Başlık',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'link',
                    'label' => 'URL',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Yayın Durumu',
                    'rules' => 'trim|required|integer|in_list[1,0]'
                ],
                [
                    'field' => 'rank',
                    'label' => 'Sıralama',
                    'rules' => 'trim|required|integer'
                ]
            ];

            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $config['upload_path'] = '../public/slider/';
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
                $this->db->update('slider', [
                    "title" => $this->input->post("title", TRUE),
                    "link" => $this->input->post("link", TRUE),
                    "image_url" => $image_url,
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                    "slide_area" => $this->input->post("slide_area", TRUE),
                    "rank" => $this->input->post("rank", TRUE),
                ], [
                    "id" => $slide->id
                ]);

                if($this->db->affected_rows()>0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi. Sayfa yenileniyor..."
                    ];
                    header("Refresh:2;url=" . base_url("slider/edit/" . $slide->id));
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

        $this->load->view('pages/slider/edit', (object)$viewData);
    }

    public function Add()
    {
        $viewData = [];

        if(isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'title',
                    'label' => 'Başlık',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'link',
                    'label' => 'URL',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Yayın Durumu',
                    'rules' => 'trim|required|integer|in_list[1,0]'
                ],
                [
                    'field' => 'rank',
                    'label' => 'Sıralama',
                    'rules' => 'trim|required|integer'
                ]
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
                $config['upload_path'] = '../public/slider/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
                $config['max_size'] = 5000;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')){
                    //insert
                    $this->db->insert('slider', [
                        "title" => $this->input->post("title", TRUE),
                        "link" => $this->input->post("link", TRUE),
                        "image_url" => $this->upload->data()["file_name"],
                        "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                        "slide_area" => $this->input->post("slide_area", TRUE),
                        "rank" => $this->input->post("rank", TRUE) ? $this->input->post("rank", TRUE) : 0,
                    ]);

                    if($this->db->insert_id()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla eklendi."
                        ];
                        header("Refresh:2;url=" . base_url("slider/list"));
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

        $this->load->view('pages/slider/add', (object)$viewData);
    }

    public function Delete($id = null)
    {
        if($id){
            $this->db->delete('slider', [
                'id' => $id
            ]);
        }
        redirect('slider');
    }

}
