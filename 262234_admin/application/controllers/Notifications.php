<?php

class Notifications extends CI_Controller
{
    function __construct(){
        parent::__construct();
        header("Content-Type:application/json");
        $this->load->model("notifications_model");
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }
    public function add()
    {
        $response = (object)["status"=>false,"message"=>"Başlık veya Kullanıcı Bilgisi Zorunludur."];
        $form_rules = [
            [
                'field' => 'title',
                'label' => 'Başlık',
                'rules' => 'required|trim|min_length[3]'
            ],
            [
                'field' => 'user_id',
                'label' => 'Kullanıcı',
                'rules' => 'required|trim|integer'
            ]
        ];
        $this->form_validation->set_rules($form_rules);

        if ($this->form_validation->run() == TRUE){
            try {
                if($this->input->post("user_id") === '0') {
                    $sql = "INSERT INTO notifications (user_id,type,title,detail,link)
                            SELECT id,?,?,?,? FROM users";
                    $this->db->query($sql, array(
                        $this->input->post("type"),
                        $this->input->post("title"),
                        $this->input->post("detail"),
                        $this->input->post("link")
                    ));
                    if($this->db->affected_rows() > 0)
                        $response->status = true;
                    else
                        $response->message = "Bildirim gönderilirken bir hatayla karşılaşıldı.";
                } else {
                    $this->notifications_model->addItem([
                        "user_id"=>$this->input->post("user_id"),
                        "type"=>$this->input->post("type"),
                        "title"=>$this->input->post("title"),
                        "detail"=>$this->input->post("detail"),
                        "link"=>$this->input->post("link")
                    ]);
                    $response->status = true;
                }
            } catch (PDOException $e) {
                $response->message = $e->getMessage();
            }
        }
        echo json_encode($response);
    }
}