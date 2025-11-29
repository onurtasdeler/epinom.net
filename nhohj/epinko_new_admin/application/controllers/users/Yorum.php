<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Yorum extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "comment";
    public $viewFile = "blank";
    public $tables = "table_comments";
    public $baseLink = "yorumlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }



    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Yorum Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Yorum Yönetimi - <a href='" . base_url("yorumlar") . "'>Yorumlar</a>",
            "h3" => "Yorumlar",
            "btnText" => "",
            "btnLink" => base_url("yorum-ekle")
        );

        if ($this->input->get("up")) {
            orderChange($this->tables, "up", $this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables, "down", $this->input->get("down"));
        }
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    public function list_table($id = "")
    {

        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s");
        $sql = "select s.id as ssid,s.order_id,s.order_advert_id,s.status,s.is_yayin,s.puan,u.full_name,s.user_id,s.comment,s.created_at from " . $this->tables . " as s
         left join table_users as u on s.user_id=u.id ";
        $where = [];
        $order = ['created_at', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];

        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {

                if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "created_at" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

                    if (!empty($column['search']['value'])) {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" or ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
                    } else {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                    }
                }
            }
        } else {
            foreach ($_POST['columns'] as $column) {
                if (!empty($column['search']['value'])) {
                    $where[] = $column['data'] . ' LIKE "%' . $column['search']['value'] . '%" ';
                }
            }
        }





        if (count($where) > 0) {
            $sql .= ' WHERE  ' . implode(' or ', $where) . "  ";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= "  order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }



        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE  ' . implode(' or ', $where) : ' ') . "  ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_users as u on s.user_id=u.id   ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {
            $user = getTableSingle("table_users", array("id" => $veri->user_id));
            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "full_name"             => $user->email,
                "comment"               => $veri->comment,
                "order_id"              => $veri->order_id,
                "order_advert_id"       => $veri->order_advert_id,
                "user_id"               => $veri->user_id,
                "created_at"            => $veri->created_at,
                "is_yayin"            => $veri->is_yayin,
                "puan"                  => $veri->puan,
                "status"                => $veri->status,
                "action"                => [
                    [
                        "title"    => "Düzenle",
                        "url"    => "asd.hmtl",
                        'class'    => 'btn btn-primary'
                    ],
                    [
                        "title"    => "Sil",
                        "url"    => "asdf.hmtl",
                        'class'    => 'btn btn-danger'
                    ]
                ]
            ];
        }
        echo json_encode($response);
    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>   " Yorum Güncelle - " . $this->settings->site_name,
                "subHeader" => "Yorum Yönetimi - <a href='" . base_url("yorumlar") . "'>Yorumlar</a> - Yorum Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Yorum Güncelle "
            );
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc = "";
                        if ($this->input->post("status") == 2) {
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                                "comment" => $this->input->post("yorum", true),
                                "puan" => $this->input->post("puan"),
                                "update_at" => date("Y-m-d H:i:s"),
                                "status" => $this->input->post("status"),
                                "is_yayin" =>   $this->input->post("is_yayin")
                            ), array("id" => $kontrol->id));
                        } else if ($this->input->post("status") == 3) {
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                                "comment" => $this->input->post("yorum", true),
                                "puan" => $this->input->post("puan"),

                                "status" => $this->input->post("status"),
                                "is_yayin" =>   $this->input->post("is_yayin")
                            ), array("id" => $kontrol->id));
                        }


                        if ($guncelle) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "name", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX DELETE
    public function action_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                        if ($sil) {
                            if ($kontrol->order_id != 0) {
                                $ug = $this->m_tr_model->updateTable("table_orders", array("comment_id" => 0), array("id" => $kontrol->order_id));
                            } else {
                            }
                            echo "1";
                        } else {
                            echo "2";
                        }
                    }
                } else {
                    $this->load->view("errors/404");
                }
            } else {
                $this->load->view("errors/404");
            }
        } else {
            $this->load->view("errors/404");
        }
    }

    public function fakeYorum()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/fake/create", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Yorum Üretici - " . $this->settings->site_name,
            "subHeader" => "Yorum Üretici - <a href='" . base_url("yorumlar") . "'>Fake Yorum Üret</a>",
            "h3" => "Yorum Üretici",
            "btnText" => "",
            "btnLink" => base_url("yorum-ekle")
        );

        if ($this->input->get("up")) {
            orderChange($this->tables, "up", $this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables, "down", $this->input->get("down"));
        }
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }

    public function search_categories()
    {
        header('Content-Type: application/json');
        $term = $this->input->get('term');

        $this->db->select('id, c_name');
        $this->db->from('table_products_category');
        $this->db->like('c_name', $term);
        $query = $this->db->get();

        $results = $query->result_array();

        echo json_encode($results);
    }

    public function fakeYorumSave()
    {
        header('Content-Type: application/json');
        try {
            $comments = $this->input->post('comments');

            $comment_lines = explode("\n", $comments);

            $this->load->database();

            foreach ($comment_lines as $comment) {
                $comment = trim($comment);

                if (!empty($comment)) {
                    $this->db->select('id');
                    $this->db->from('table_users');
                    $this->db->order_by('RAND()');
                    $this->db->limit(1);
                    $query = $this->db->get();
                    $user = $query->row();

                    if ($user) {
                        $data = array(
                            'user_id' => $user->id,
                            'comment' => $comment,
                            'status' => 2,
                            'is_yayin' => 1,
                            'puan' => $this->input->post('point'),
                            'cat_id' => $this->input->post('category_id'),
                            'created_at' => $this->createRandomDate($this->input->post('start_date'))
                        );

                        $this->db->insert('table_comments', $data);
                    }
                }
            }

            echo json_encode(array('status' => true, 'message' => 'Yorumlar başarıyla oluşturuldu.'));
        } catch (\Throwable $th) {
            echo json_encode(array('status' => false, 'message' => 'Yorumlar oluşturulurken bir hata oluştu.'));
        }
    }

    private function createRandomDate($start){
        $start = strtotime($start);
        $end = strtotime(date('Y-m-d H:i:s'));

        $timestamp = mt_rand($start, $end);

        return date("Y-m-d H:i:s", $timestamp);
    }
}
