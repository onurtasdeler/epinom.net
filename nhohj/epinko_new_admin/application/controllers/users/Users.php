<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Users extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "users/users_items";

    public $viewFile = "blank";

    public $tables = "table_users";

    public $baseLink = "uyeler";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        loginControl(106);

        $this->settings = getSettings();

    }





    public function onayMailManuel()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $ayarlar = getTableSingle("options_general", array("id" => 1));

                $tokenUret = tokengenerator(6, 2);

                $tokenUret = uniqid($tokenUret . time());

                if ($tokenUret) {

                    $uye = getTableSingle("table_users", array("id" => $this->input->post("id")));

                    if ($uye) {

                        $token = md5($uye->id . "-" . rand(1, 234567));

                        $gun = $this->m_tr_model->updateTable("table_users", array("email_onay_send_at" => date("Y-m-d H:i:s"), "email_onay_kod" => $token), array("id" => $uye->id));

                        if ($gun) {

                            $kontrol = getTableSingle("table_users", array("id" => $uye->id));

                            $mailgonder = sendMails($kontrol->email, 1, 2, $kontrol);

                            if ($mailgonder) {

                                $logekle = $this->m_tr_model->add_new(array(

                                    "user_id" => $kontrol->id,

                                    "user_email" => $kontrol->email,

                                    "ip" => $_SERVER["REMOTE_ADDR"],

                                    "title" => "Manuel Üyelik  Onay Maili Başarılı Şekilde Gönderildi..",

                                    "description" => $this->input->post("nickname", TRUE) . " kullanıcı adlı üyeye üyelik doğrulama maili gönderildi - Manuel.",

                                    "date" => date("Y-m-d H:i:s"),

                                    "status" => 1

                                ), "ft_logs");

                                echo json_encode(array("hata" => "var", "tur" => 1, "message" => "Onay Maili başarılı şekilde gönderildi."));

                            } else {

                                echo json_encode(array("hata" => "yok", "message" => "Üyelik Onay Maili Gönderilirken Hata Meydana Geldi."));

                            }

                        }

                    }

                }

            }

        }

    }



    //index

    public function index()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" => "Üye Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Üye Yönetimi - <a href='" . base_url("uyeler") . "'>Üyeler</a>",

            "h3" => "Üyeler",

            "btnText" => "",

            "btnLink" => ""

        );





        pageCreate($view, array(), $page, array());

    }

    public function index_banka($id)

    {

        if ($id) {

            $kontrol = getTableSingle("table_users", array("id" => $id));

            if ($kontrol) {

                $this->viewFolder = "users/banks";

                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);

                $page = array(

                    "pageTitle" => "Üye Banka Hesapları - " . $this->settings->site_name,

                    "subHeader" => "Üye Banka Hesapları - <a href='" . base_url("uyeler") . "'>Üyeler</a> -  Banka Hesapları",

                    "h3" => $kontrol->email . " - Üye Banka Hesapları",

                    "btnText" => "",

                    "btnLink" => ""

                );



                $data = array("veri" => $kontrol);

                pageCreate($view, $data, $page, array());

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }



    public function index_settings()

    {



        $this->viewFolder = "users/settings";

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" => "Üye Yönetimi - Ayarlar -" . $this->settings->site_name,

            "subHeader" => "Üye Yönetimi - <a href='" . base_url("uyeler") . "'>Üyeler</a> - Ayarlar",

            "h3" => "Üyelik Ayarları",

            "btnText" => "",

            "btnLink" => ""

        );

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                header('Content-Type: application/json; charset=utf-8');

                $guncelle = $this->m_tr_model->updateTable("table_options", array("uyelik_email_onay" => $this->input->post("secim", TRUE)), array("id" => 1));

                if ($guncelle) {

                    $data = array("err" => false, "message" => "İşlem Başarılı.");

                    echo json_encode($data);

                    die();

                } else {

                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");

                    echo json_encode($data);

                    die();

                }

            }

        }

        $data = getTableSingle("table_options", array("id" => 1));

        pageCreate($view, array("veri" => $data), $page, array());

    }



    private function dakikaFarki($tarih1, $tarih2)

    {

        $tarih1 = new DateTime($tarih1);

        $tarih2 = new DateTime($tarih2);

        $fark = $tarih1->diff($tarih2);

        $dakika = $fark->days * 24 * 60;

        $dakika += $fark->h * 60;

        $dakika += $fark->i;

        return $dakika;

    }

    //LİST TABLE AJAX

    public function list_table()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.is_delete=0");

                $sql = "select s.id as ssid,s.status,s.full_name,s.ilan_balance,s.nick_name,s.token_end_date,s.email,s.balance,s.created_at,s.tel_onay,s.email_onay,s.tc_onay from " . $this->tables . " as s  ";

                $where = [];

                $order = ['full_name', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {



                        if ($column["data"] != "ssid" && $column["data"] != "currency" && $column["data"] != "created_at" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {

                            if (!empty($column['search']['value'])) {

                                $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';

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

                    $sql .= ' WHERE s.is_delete=0 and (  ' . implode(' or ', $where) . ")  ";

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    $sql .= " where s.is_delete=0  order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }



                $veriler = $this->m_tr_model->query($sql);

                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {



                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . (count($where) > 0 ? ' WHERE s.is_delete=0 and ( ' . implode(' or ', $where) : ' ) ') . " ) ");

                } else {



                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s where s.is_delete=0 ");

                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                $iliski = "";

                $currency = getcur();

                foreach ($veriler as $veri) {

                    $email_onay = $veri->email_onay;

                    if ($veri->email_onay == 0 and $veri->status == 0) {

                        $fark = $this->dakikaFarki($veri->token_end_date, date("Y-m-d H:i:s"));

                        if ($fark >= 30) {

                            $email_onay = 2;

                        } else {

                            $email_onay = $veri->email_onay;

                        }

                    }



                    $response["data"][] = [

                        "ssid" => $veri->ssid,

                        "nick_name" => $veri->nick_name,

                        "email" => $veri->email,

                        "balance" => $veri->balance,

                        "ilan_balance" => $veri->ilan_balance,

                        "created_at" => $veri->created_at,

                        "tc_onay" => $veri->tc_onay,

                        "email_onay" => $email_onay,

                        "tel_onay" => $veri->tel_onay,

                        "currency" => $currency,

                        "status" => $veri->status,

                        "action" => [

                            [

                                "title" => "Düzenle",

                                "url" => "asd.hmtl",

                                'class' => 'btn btn-primary'

                            ],

                            [

                                "title" => "Sil",

                                "url" => "asdf.hmtl",

                                'class' => 'btn btn-danger'

                            ]

                        ]

                    ];

                }

                echo json_encode($response);

            }

        }

    }

    public function list_table_bayi()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.is_delete=0 and s.uye_category!=0");

                $sql = "select s.id as ssid,s.status,s.full_name,s.nick_name,s.token_end_date,s.email,s.balance,s.created_at,s.tel_onay,s.email_onay,s.tc_onay from " . $this->tables . " as s  ";

                $where = [];

                $order = ['full_name', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {



                        if ($column["data"] != "ssid" && $column["data"] != "currency" && $column["data"] != "created_at" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {

                            if (!empty($column['search']['value'])) {

                                $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';

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

                    $sql .= ' WHERE s.is_delete=0 and s.uye_category!=0 and (  ' . implode(' or ', $where) . ")  ";

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    $sql .= " where s.is_delete=0 and s.uye_category!=0  order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }



                $veriler = $this->m_tr_model->query($sql);

                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {



                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . (count($where) > 0 ? ' WHERE s.uye_category!=0 and s.is_delete=0 and ( ' . implode(' or ', $where) : ' ) ') . " ) ");

                } else {



                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s where s.is_delete=0 and s.uye_category!=0");

                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                $iliski = "";

                $currency = getcur();

                foreach ($veriler as $veri) {

                    $email_onay = $veri->email_onay;

                    if ($veri->email_onay == 0 and $veri->status == 0) {

                        $fark = $this->dakikaFarki($veri->token_end_date, date("Y-m-d H:i:s"));

                        if ($fark >= 30) {

                            $email_onay = 2;

                        } else {

                            $email_onay = $veri->email_onay;

                        }

                    }



                    $response["data"][] = [

                        "ssid" => $veri->ssid,

                        "nick_name" => $veri->nick_name,

                        "email" => $veri->email,

                        "balance" => $veri->balance,

                        "created_at" => $veri->created_at,

                        "tc_onay" => $veri->tc_onay,

                        "email_onay" => $email_onay,

                        "tel_onay" => $veri->tel_onay,

                        "currency" => $currency,

                        "status" => $veri->status,

                        "action" => [

                            [

                                "title" => "Düzenle",

                                "url" => "asd.hmtl",

                                'class' => 'btn btn-primary'

                            ],

                            [

                                "title" => "Sil",

                                "url" => "asdf.hmtl",

                                'class' => 'btn btn-danger'

                            ]

                        ]

                    ];

                }

                echo json_encode($response);

            }

        }

    }



    public function index_bayi()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => "users/bayi/list", "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" => "Bayi Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Bayi Yönetimi - <a href='" . base_url("bayiler") . "'>Bayiler</a>",

            "h3" => "Bayiler",

            "btnText" => "",

            "btnLink" => ""

        );



        //$data = getTable($this->tables, array());

        pageCreate($view, array(), $page, array());

    }



    //UPDATE

    public function actions_update($id)

    {

        $kontrol = getTableSingle($this->tables, array("id" => $id));

        if ($kontrol) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);

            $page = array(

                "pageTitle" => $kontrol->full_name . " Üye Güncelle - " . $this->settings->site_name,

                "subHeader" => "Üye Yönetimi - <a href='" . base_url("uyeler") . "'>Üyeler</a> - Üye Güncelle",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->full_name . "</strong> - Üye Güncelle "

            );

            if ($_POST) {



                if ($this->formControl == $this->session->userdata("formCheck")) {

                    header('Content-Type: application/json; charset=utf-8');



                    if ($veri["err"] != true) {

                        $enc = "";



                        if ($this->input->post("password")) {

                            $pass = md5($this->input->post("password"));



                            $this->m_tr_model->updateTable($this->tables, array(

                                "password" => $pass

                            ), array("id" => $kontrol->id));

                        }



                        if ($kontrol->nick_name != $this->input->post("nickname")) {

                            $emailsorgula = getTableSingle("table_users", array("id !=" => $kontrol->id, "nick_name" => $this->input->post("nickname", true)));

                            if ($emailsorgula) {

                                $data = array("err" => true, "message" => "Bu kullanıcı adı ile üyelik mevcuttur.");

                                echo json_encode($data);

                                exit;

                            }

                        }



                        if ($kontrol->email != $this->input->post("email")) {

                            $emailsorgula = getTableSingle("table_users", array("id !=" => $kontrol->id, "email" => $this->input->post("email", true)));

                            if ($emailsorgula) {

                                $data = array("err" => true, "message" => "Bu email ile üyelik mevcuttur.");

                                echo json_encode($data);

                                exit;

                            }

                        }







                        if ($emailsorgula) {

                            $data = array("err" => true, "message" => "Email,telefon veya tc'ye ait kayıt mevcuttur.");

                            echo json_encode($data);

                        } else {

                            $bayitoken = $kontrol->bayi_token;

                            if ($kontrol->uye_category != $this->input->post("bayi_category")) {

                                if ($this->input->post("bayi_category")) {

                                    if ($kontrol->uye_category == "0") {

                                        $kon = getTableSingle("table_users", array("uye_category" => $this->input->post("bayi_category")));

                                        if ($kon) {

                                            $bayitoken = $kontrol->bayi_token;

                                            $data = array("err" => true, "message" => "Bu kategoriye bayi tanımlanmıştır.");

                                            echo json_encode($data);

                                            exit;

                                        } else {

                                            $bayitoken = md5($kontrol->id);

                                            $kat = getTableSingle("table_products_category", array("id" =>  $this->input->post("bayi_category")));

                                            $catguncelle = $this->m_tr_model->updateTable("table_products_category", array("uye_komisyon" => $this->input->post("bayi_komisyon"), "uye_id" => $kontrol->id), array("id" => $kat->id));

                                        }

                                    } else {

                                    }

                                }

                            } else {

                                if ($kontrol->uye_category != "") {

                                    $kat = getTableSingle("table_products_category", array("id" =>  $kontrol->uye_category));

                                    $catguncelle = $this->m_tr_model->updateTable("table_products_category", array("uye_komisyon" => $this->input->post("bayi_komisyon"), "uye_id" => $kontrol->id), array("id" => $kat->id));

                                }

                            }


                            $logekle = $this->m_tr_model->add_new(array(
                                "date" => date("Y-m-d H:i:s"),
                                "mesaj_title" => "Yönetici Üye Bilgileri Düzenledi",
                                "mesaj" => $kontrol->email . " E-Posta'lı kullanıcının bilgilerini " . $_SESSION["user1"]["name"] . " yöneticisi düzenledi. İlk Bakiye : ". $kontrol->balance ." Son Bakiye : ". $this->input->post("balance",true) . " İlk İlan Bakiye : " . $kontrol->ilan_balance . " Son İlan Bakiye " . $this->input->post("ilan_balance",true),
                                "status" => 1
                            ), "bk_logs");
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array(

                                "full_name" => $this->input->post("name", true),

                                "name" => $this->input->post("sname", true),

                                "surname" => $this->input->post("ssurname", true),

                                "email" => $this->input->post("email", true),

                                "nick_name" => $this->input->post("nickname", true),

                                "tc" => $this->input->post("tc", true),

                                "balance" => $this->input->post("balance", true),

                                "phone" => $this->input->post("tel", true),

                                "ilan_balance" => $this->input->post("adbalance", true),

                                "bonus_balance" => $this->input->post("bonus", true),

                                "image" => $up,

                                "image_banner" => $up2,

                                "uye_category" => $this->input->post("bayi_category"),

                                "bayi_created_at" => date("Y-m-d H:i:s"),

                                "bayi_komisyon" => $this->input->post("bayi_komisyon"),

                                "status" => $this->input->post("status"),

                                "bayi_token" => $bayitoken,

                                "reference_username" => $this->input->post("reference_username")

                            ), array("id" => $kontrol->id));



                            $invoiceDatas = [

                                'user_id' => $kontrol->id,

                                'company_name' => $this->input->post("company_name"),

                                'tax_office' => $this->input->post("tax_office"),

                                'tax_number' => $this->input->post("tax_number"),

                                'country' => 'Türkiye',

                                'province' => $this->input->post("province"),

                                'district' => $this->input->post("district"),

                                'address' => $this->input->post("address"),

                                'company_owner' => $this->input->post("company_owner"),

                                'phone_one' => $this->input->post("phone_one"),

                                'phone_two' => $this->input->post("phone_two"),

                            ];



                            $invoiceInfo = $this->db->select("*")

                                ->from("invoice_infos")

                                ->where("user_id", $kontrol->id)

                                ->get()

                                ->row();



                            if ($invoiceInfo) {

                                $invoiceDatas['updated_at'] = date("Y-m-d H:i:s");

                                $this->db->where("user_id", $kontrol->id)->update("invoice_infos", $invoiceDatas);

                            } else {

                                $invoiceDatas['created_at'] = date("Y-m-d H:i:s");

                                $this->db->insert("invoice_infos", $invoiceDatas);

                            }



                            if ($guncelle) {

                                $data = array("err" => false, "message" => "İşlem Başarılı.");

                                echo json_encode($data);

                            } else {

                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");

                                echo json_encode($data);

                            }

                        }

                    } else {

                        if ($veri["type"] == 1) {

                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);

                            pageCreate($view, $data, $page, $_POST);

                        }

                    }

                }

            } else {

                $invoiceInfo = $this->db->select("*")

                    ->from("invoice_infos")

                    ->where("user_id", $kontrol->id)

                    ->get()

                    ->row();



                $turkeyProvinces = $this->db->select("*")

                    ->from("il")

                    ->get()

                    ->result();



                $turkeyDistricts = [];



                if ($invoiceInfo->province) {

                    $provinceInfo = $this->db->select("*")

                        ->from("il")

                        ->where("ad", $invoiceInfo->province)

                        ->get()

                        ->row();



                    $turkeyDistricts = $this->db->select("*")

                        ->from("ilce")

                        ->where("il_id", $provinceInfo->id)

                        ->get()

                        ->result();

                }

                pageCreate($view, array("veri" => $kontrol, 'invoice' => $invoiceInfo, 'turkeyProvinces' => $turkeyProvinces, 'turkeyDistricts' => $turkeyDistricts), $page, $kontrol);

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

                $veri = getRecord($this->tables, "nick_name", $this->input->post("data"));

                echo $veri;

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }



    public function yesBan()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("id")) {

                    header('Content-Type: application/json; charset=utf-8');

                    $veri = getTableSingle("table_users", array("id" => $this->input->post("id")));

                    if ($veri) {

                        if ($veri->banned == 1) {

                            $banla = $this->m_tr_model->updateTable("table_users", array("banned" => 0), array("id" => $veri->id));

                            if ($banla) {

                                echo json_encode(array("hata" => "yok"));

                            } else {

                                echo json_encode(array("hata" => "var", "message" => "Güncelleme sırasında hata meydana geldi"));

                            }

                        } else {

                            //banlanacak

                            $banla = $this->m_tr_model->updateTable("table_users", array("banned" => 1, "ban_end_date" => $this->input->post("tarih"), "ban_sebep" => $this->input->post("sebep")), array("id" => $veri->id));

                            if ($banla) {

                                echo json_encode(array("hata" => "yok"));

                            } else {

                                echo json_encode(array("hata" => "var", "message" => "Güncelleme sırasında hata meydana geldi"));

                            }

                        }

                    }

                }

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



                        img_delete("users/" . $kontrol->image);

                        img_delete("users/" . $kontrol->image_banner);



                        $tasi = $this->m_tr_model->add_new($kontrol, "table_users_deleted");

                        $guncelle = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

                        if ($tasi && $guncelle) {

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



    //Ajax Img DELETE

    public function action_img_delete()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $tur = $this->input->post("tur");

                        if ($tur == 1) {

                            img_delete("users/" . $kontrol->image);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));

                        }

                        if ($tur == 2) {

                            img_delete("users/" . $kontrol->image_banner);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner" => ""), array("id" => $kontrol->id));

                        }

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

    }



    //AJAX İS ACTİVE SET

    public function isActiveSetter($id = '')

    {

        if (($id != "") and (is_numeric($id))) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array("status" => $isActive), array("id" => $id));

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



    //AJAX İS ACTİVE SET SPECIAL

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



    public function uyePhoneVerify()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $ayarlar = getTableSingle("options_general", array("id" => 1));

                $uye = getTableSingle("table_users", array("id" => $this->input->post("id")));

                if ($uye) {

                    $updated = $this->m_tr_model->updateTable("table_users", array("tel_onay" => 1), array("id" => $uye->id));



                    if ($updated) {

                        $logekle = $this->m_tr_model->add_new(array(

                            "user_id" => $uye->id,

                            "user_email" => $uye->email,

                            "ip" => $_SERVER["REMOTE_ADDR"],

                            "title" => "Telefon Onayı Başarılı",

                            "description" => $uye->nick_name . " kullanıcı adlı üyenin telefon onayı yönetici tarafından yapıldı.",

                            "date" => date("Y-m-d H:i:s"),

                            "status" => 1

                        ), "ft_logs");

                        echo json_encode(array("hata" => "yok", "message" => "Telefon Onayı Başarılı."));

                    } else {

                        echo json_encode(array("hata" => "var", "message" => "Telefon Onayı Sırasında Hata Meydana Geldi."));

                    }

                }

            }

        }

    }



    public function uyePhoneUnverify()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $ayarlar = getTableSingle("options_general", array("id" => 1));

                $uye = getTableSingle("table_users", array("id" => $this->input->post("id")));

                if ($uye) {

                    $updated = $this->m_tr_model->updateTable("table_users", array("tel_onay" => 0), array("id" => $uye->id));



                    if ($updated) {

                        $logekle = $this->m_tr_model->add_new(array(

                            "user_id" => $uye->id,

                            "user_email" => $uye->email,

                            "ip" => $_SERVER["REMOTE_ADDR"],

                            "title" => "Telefon Onayı Kaldırıldı",

                            "description" => $uye->nick_name . " kullanıcı adlı üyenin telefon onayı yönetici tarafından kaldırıldı.",

                            "date" => date("Y-m-d H:i:s"),

                            "status" => 1

                        ), "ft_logs");

                        echo json_encode(array("hata" => "yok", "message" => "Telefon Onayı Kaldırıldı."));

                    } else {

                        echo json_encode(array("hata" => "var", "message" => "Telefon Onayı Kaldırılırken Hata Meydana Geldi."));

                    }

                }

            }

        }

    }



    public function uyeTCVerify()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $ayarlar = getTableSingle("options_general", array("id" => 1));

                $uye = getTableSingle("table_users", array("id" => $this->input->post("id")));

                if ($uye) {

                    $updated = $this->m_tr_model->updateTable("table_users", array("tc_onay" => 1), array("id" => $uye->id));



                    if ($updated) {

                        $logekle = $this->m_tr_model->add_new(array(

                            "user_id" => $uye->id,

                            "user_email" => $uye->email,

                            "ip" => $_SERVER["REMOTE_ADDR"],

                            "title" => "TC Kimlik Onayı Başarılı",

                            "description" => $uye->nick_name . " kullanıcı adlı üyenin TC kimlik onayı yönetici tarafından yapıldı.",

                            "date" => date("Y-m-d H:i:s"),

                            "status" => 1

                        ), "ft_logs");

                        echo json_encode(array("hata" => "yok", "message" => "TC Kimlik Onayı Başarılı."));

                    } else {

                        echo json_encode(array("hata" => "var", "message" => "TC Kimlik Onayı Sırasında Hata Meydana Geldi."));

                    }

                }

            }

        }

    }



    public function uyeTCUnverify()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $ayarlar = getTableSingle("options_general", array("id" => 1));

                $uye = getTableSingle("table_users", array("id" => $this->input->post("id")));

                if ($uye) {

                    $updated = $this->m_tr_model->updateTable("table_users", array("tc_onay" => 0), array("id" => $uye->id));



                    if ($updated) {

                        $logekle = $this->m_tr_model->add_new(array(

                            "user_id" => $uye->id,

                            "user_email" => $uye->email,

                            "ip" => $_SERVER["REMOTE_ADDR"],

                            "title" => "TC Kimlik Onayı Kaldırıldı",

                            "description" => $uye->nick_name . " kullanıcı adlı üyenin TC kimlik onayı yönetici tarafından kaldırıldı.",

                            "date" => date("Y-m-d H:i:s"),

                            "status" => 1

                        ), "ft_logs");

                        echo json_encode(array("hata" => "yok", "message" => "TC Kimlik Onayı Kaldırıldı."));

                    } else {

                        echo json_encode(array("hata" => "var", "message" => "TC Kimlik Onayı Kaldırılırken Hata Meydana Geldi."));

                    }

                }

            }

        }

    }

}

