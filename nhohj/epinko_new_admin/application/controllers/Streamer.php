<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Streamer extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "streamer";

    public $viewFile = "blank";

    public $tables = "streamer_users";

    public $baseLink = "yayinci-basvurulari";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        $this->settings = getSettings();
    }





    //LİST

    public function index()

    {


        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);

        loginControl(123);

        $page = array(

            "pageTitle" => "Yayıncı Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Yayıncı Yönetimi - <a href='" . base_url("yayinci-basvurulari ") . "'>Yayıncı Başvuruları</a>",

            "h3" => "Yayıncı Başvuruları",

            "btnText" => ""
        );

        //$data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());
    }

    public function index_yayinci()

    {

        loginControl(125);

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list_index", "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" => "Yayıncı Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Yayıncı Yönetimi - <a href='" . base_url("yayincilar ") . "'>Yayıncılar</a>",

            "h3" => "Yayıncılar",

            "btnText" => "",
            "btnLink" => base_url("yayinci-ekle")
        );

        //$data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());
    }

    public function donation_history()

    {


        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/donation/list", "viewFolderSafe" => $this->viewFolder);

        loginControl(123);

        $page = array(

            "pageTitle" => "Bağış Geçmişi Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Bağış Geçmişi Yönetimi - <a href='" . base_url("bagis-gecmisi ") . "'>Bağış Geçmişi</a>",

            "h3" => "Bağış Geçmişi",

            "btnText" => ""
        );

        //$data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());
    }

    public function donation_list_table()

    {

        if ($_POST) {


            $toplam = $this->m_tr_model->query("select count(*) as sayi from donation_history AS dh ");



            $sql = "select str.id AS streamer_user_id,str.nick_name AS streamer_nick_name,
                        su.id,su.username,u.id AS donator_user_id,u.nick_name AS donator_nick_name,
                        dh.donator_username,dh.donator_message,dh.donation_amount,dh.comission_amount,dh.net_profit,dh.created_at
                        FROM donation_history as dh
                        LEFT JOIN streamer_users AS su ON su.id=dh.streamer_id
                        LEFT JOIN table_users AS str ON str.id=su.user_id
                        LEFT JOIN table_users AS u ON u.id=dh.donator_user_id ";

            $where = [];

            $order = ['dh.created_at', 'desc'];

            $column = $_POST['order'][0]['column'];

            $columnName = $_POST['columns'][$column]['data'];

            $columnOrder = $_POST['order'][0]['dir'];



            if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                switch ($columnName) {
                    case "streamerNickname":
                        $columnName = "str.nick_name";
                        break;
                    case "streamerUsername":
                        $columnName = "su.username";
                        break;
                    case "donatorNickname":
                        $columnName = "u.nick_name";
                        break;
                    case "donatorUsername":
                        $columnName = "dh.donator_user_name";
                        break;
                    case "donatorMessage":
                        $columnName = "dh.donator_message";
                        break;
                    case "createdAt":
                        $columnName = "dh.created_at";
                        break;
                }
                $order[0] = $columnName;

                $order[1] = $columnOrder;
            }


            if (!empty($_POST['search']['value'])) {
                foreach ($_POST['columns'] as $column) {

                    switch ($column["data"]) {
                        case "streamerNickname":
                            $columnName = "str.nick_name";
                            break;
                        case "streamerUsername":
                            $columnName = "su.username";
                            break;
                        case "donatorNickname":
                            $columnName = "u.nick_name";
                            break;
                        case "donatorUsername":
                            $columnName = "dh.donator_user_name";
                            break;
                        case "donatorMessage":
                            $columnName = "dh.donator_message";
                            break;
                        case "createdAt":
                            $columnName = "dh.created_at";
                            break;
                    }

                    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                }
            }
            if (count($where) > 0) {


                $sql .= ' WHERE (  ' . implode(' or ', $where) . " )  ";


                $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
            } else {
                $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
            }
            $veriler = $this->m_tr_model->query($sql);

            $response = [];

            $response["data"] = [];

            $response["recordsTotal"] = $toplam[0]->sayi;

            if (count($where) > 0) {

                $filter = $this->m_tr_model->query("select count(*) as toplam FROM donation_history as dh
                        LEFT JOIN streamer_users AS su ON su.id=dh.streamer_id
                        LEFT JOIN table_users AS str ON str.id=su.user_id
                        LEFT JOIN table_users AS u ON u.id=dh.donator_user_id " . (count($where) > 0 ? ' WHERE (  ' . implode(' or ', $where) : ' ) ') . " )  ");
            } else {

                $filter = $this->m_tr_model->query("select count(*) as toplam FROM donation_history as dh
                        LEFT JOIN streamer_users AS su ON su.id=dh.streamer_id
                        LEFT JOIN table_users AS str ON str.id=su.user_id
                        LEFT JOIN table_users AS u ON u.id=dh.donator_user_id");
            }
            $response["sql"] = $sql;
            $response["recordsFiltered"] = $filter[0]->toplam;

            $iliski = "";

            foreach ($veriler as $veri) {
                $response["data"][] = [
                    "streamerId"                => $veri->id,
                    "streamerUsername"      => $veri->username,
                    "streamerUserId"        => $veri->streamer_user_id,
                    "streamerNickname"      => $veri->streamer_nick_name,
                    "donatorId"             => $veri->donator_user_id,
                    "donatorNickname"       => $veri->donator_nick_name,
                    "donatorUsername"       => $veri->donator_username,
                    "donatorMessage"        => $veri->donator_message,
                    "donationAmount"        => $veri->donation_amount,
                    "comissionAmount"        => $veri->comission_amount,
                    "netProfit"        => $veri->net_profit,
                    "createdAt"        => $veri->created_at
                ];
            }

            echo json_encode($response);
        } else {

            redirect(base_url("404"));
        }
    }







    //UPDATE

    public function actions_update($id)

    {

        $kontrol = getTableSingle($this->tables, array("id" => $id));

        if ($kontrol) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);

            $page = array(

                "pageTitle" => "Yayıncı Başvuru Yönetimi - " . $this->settings->site_name,

                "subHeader" => "Yayıncı Başvuru Yönetimi - <a href='" . base_url("yayinci-basvurulari") . "'>Yayıncılar</a> - Yayıncı Bilgileri",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->username . "</strong> - Yayıncı Bilgileri "
            );

            if ($_POST) {





                header('Content-Type: application/json; charset=utf-8');


                if ($veri["err"] != true) {

                    if ($_FILES["image"]) {

                        if ($_FILES["image"]["tmp_name"] != "") {
                            if (strpos($kontrol->image, "https"))
                                img_delete("avatar/" . $kontrol->image);

                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                            $up = img_upload($_FILES["image"], "streamer-" . $this->input->post("name"), "avatar", "", "", "");
                        }
                    }
                    $user = getTableSingle("table_users", array("id" => $kontrol->user_id));
                    $guncelle = $this->m_tr_model->updateTable("streamer_users", array(
                        "username" => $this->input->post("username"),
                        "twitch_link" => $this->input->post("twitch_link"),
                        "youtube_link" => $this->input->post("youtube_link"),
                        "facebook_link" => $this->input->post("facebook_link"),
                        "twitter_link" => $this->input->post("twitter_link"),
                        "instagram_link" => $this->input->post("instagram_link"),
                        "minimum_price" => $this->input->post("minimum_price"),
                        "profile_note" => $this->input->post("profile_note"),
                        "twitch_active" => $this->input->post("twitch_active"),
                        "youtube_active" => $this->input->post("youtube_active"),
                        "comission" => $this->input->post("comission"),
                        "profile_note" => $this->input->post("profile_note"),
                        "status" => $this->input->post("status"),
                    ), array("id" => $kontrol->id));
                    if (($kontrol->status == 0 || $kontrol->status == 2) && $this->input->post("status") == 1) {

                        $bildirim = $this->m_tr_model->add_new(array("user_id" => $kontrol->id, "noti_id" => 36,  "type" => 1, "created_at" => date("Y-m-d H:i:s")), "table_notifications_user");

                        $mailgonder = sendMails($kontrol->email, 1, 37, $kontrol);

                        if ($mailgonder) {

                            $logekle = $this->m_tr_model->add_new(array(

                                "user_id" => $user->id,

                                "user_email" => $user->email,

                                "ip" => $_SERVER["REMOTE_ADDR"],

                                "title" => "Yayıncı Başvurusu Onaylandı",

                                "description" => $kontrol->username . " adlı yayıncı başvurusu onaylandı. Üyeye email gönderildi.",

                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1

                            ), "ft_logs");
                            $logEkle = $this->m_tr_model->add_new(array(
                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1,

                                "mesaj_title" => "Yayıncı Başvurusu Onaylandı",

                                "mesaj" => $kontrol->username . " adlı yayıncı başvurusu onaylandı."
                            ), "bk_logs");
                        }
                    }
                    if ($kontrol->status == 0 && $this->input->post("status") == 2) {

                        $bildirim = $this->m_tr_model->add_new(array("user_id" => $kontrol->id, "noti_id" => 36,  "type" => 1, "created_at" => date("Y-m-d H:i:s")), "table_notifications_user");

                        $mailgonder = sendMails($kontrol->email, 1, 36, $kontrol);

                        if ($mailgonder) {

                            $logekle = $this->m_tr_model->add_new(array(

                                "user_id" => $user->id,

                                "user_email" => $user->email,

                                "ip" => $_SERVER["REMOTE_ADDR"],

                                "title" => "Yayıncı Başvurusu Reddedildi",

                                "description" => $kontrol->username . " adlı yayıncı başvurusu reddedildi. Üyeye email gönderildi.",

                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1

                            ), "ft_logs");

                            $logEkle = $this->m_tr_model->add_new(array(
                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1,

                                "mesaj_title" => "Yayıncı Başvurusu Reddedildi",

                                "mesaj" => $kontrol->username . " adlı yayıncı başvurusu reddedildi."
                            ), "bk_logs");
                        }
                    }

                    if ($guncelle) {

                        $data = array("err" => false, "message" => "İşlem başarılı");

                        echo json_encode($data);
                    } else {

                        $data = array("err" => true, "message" => "Hata meydana geldi");

                        echo json_encode($data);
                    }
                } else {

                    if ($veri["type"] == 1) {

                        $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);

                        pageCreate($view, $data, $page, $_POST);
                    }
                }
            } else {

                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
            }
        } else {

            redirect(base_url("404"));
        }
    }

    public function action_img_delete()
    {

        if ($_POST) {

            if ($this->input->post("data")) {

                $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));

                if ($kontrol) {


                    img_delete("avatar/" . $kontrol->magaza_logo);

                    $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));



                    if ($guncelle) {

                        echo "1";
                    } else {

                        echo "2";
                    }
                } else {

                    $this->load->view("errors/404");
                }
            } else {

                $this->load->view("errors/404s");
            }
        } else {

            $this->load->view("errors/404d");
        }
    }





    //AJAX GET RECORD

    public function get_record()

    {



        if ($_POST) {

            header('Content-Type: application/json; charset=utf-8');

            $veri = getTableSingle($this->tables, array("id" => $this->input->post("data")));

            echo json_encode(array("username" => $veri->username));
        } else {

            redirect(base_url("404"));
        }
    }



    public function mesajYukle()

    {

        //print_r($_POST);

        if ($this->formControl == $this->session->userdata("formCheck")) {



            $talep = getTableSingle("table_talep", array("id" => $this->input->post("talep")));

            $uyeCek = getTableSingle("table_users", array("id" => $talep->user_id));

            $cekayar = getTableSingle("options_general", array("id" => 1));

            $cek = getTableOrder("table_talep_message", array("talep_id" => $this->input->post("talep")), "id", "asc");



            if ($cek) {

                $str = "";

                $str .= ' <div class="d-flex flex-column mb-5 align-items-start">

                        <div class="d-flex align-items-center">

                            <div class="symbol symbol-circle symbol-40 mr-3">

                                <img alt="Pic" src="' . str_replace("admin", "", base_url("upload/users/" . $uyeCek->image)) . '">

                            </div>

                            <div>

                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">' . $uyeCek->full_name . '</a>

                                <span class="text-muted font-size-sm">' . date("Y-m-d H:i", strtotime($talep->created_at)) . '</span>

                            </div>

                        </div>

                        <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">

                            ' . $talep->message . '</div>

                    </div>';

                foreach ($cek as $item) {

                    if ($item->tur == 1) {

                        $str .= '<div class="d-flex flex-column mb-5 align-items-end">

                            <div class="d-flex align-items-center">

                                <div>

                                    <span class="text-muted font-size-sm">' . date("Y-m-d H:i", strtotime($item->created_at)) . '</span>

                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Yönetici</a>

                                </div>

                                <div class="symbol symbol-circle symbol-40 ml-3">

                                  

                                    <img alt="Pic" src="../../upload/logo/' . $cekayar->site_logo . '">

                                </div>

                            </div>

                            <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">

                            ' . $item->message . '</div>

                        </div>';
                    } else {

                        $str .= '<div class="d-flex flex-column mb-5 align-items-start">

                                <div class="d-flex align-items-center">

                                    <div class="symbol symbol-circle symbol-40 mr-3">

                                        <img alt="Pic" src="' . base_url("../upload/users/" . $uyeCek->image) . '">

                                    </div>

                                    <div>

                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">' . $uyeCek->full_name . '</a>

                                        <span class="text-muted font-size-sm">' . date("Y-m-d H:i", strtotime($item->created_at)) . '</span>

                                    </div>

                                </div>

                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">

                                ' . $item->message . '</div>

                            </div>';
                    }
                }



                echo $str;
            }
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

                        $ug = $this->m_tr_model->updateTable($this->tables, array("is_delete" => 1, "delete_at" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));

                        if ($ug) {

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

    public function isSetter($types = '', $id)

    {

        if (($id != "") and (is_numeric($id)) and ($types != "")) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array($types => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }
    public function action_delete_yayinci()

    {

        if ($_POST) {



            if ($this->input->post("data")) {

                $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));

                if ($kontrol) {

                    $ug = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

                    if ($ug) {

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
    }
}
