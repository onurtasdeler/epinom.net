<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Optionshesap  extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "firma/profile";
    public $viewFile = "blank";
    public $tables = "ft_users";
    public $baseLink = "hesabim";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $this->viewFolder="firma/profile";
        $view = array(
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolder."/info",
            "viewFolderSafe" => $this->viewFolderKullanici);
        $page = array(
            "pageTitle" => "Hesap Bilgileri  - " . $this->settings->firma_unvan,
            "subHeader" => "Hesap Bilgileri",
            "h3" => "Hesap Bilgileri",
            "btnText" => "", "btnLink" => base_url(""));

        if($_POST){

            if($this->input->post("ad") && $this->input->post("mail")){
                    $guncelle=$this->m_tr_model->updateTable("ft_users",array(
                        "user_m_ad" => $this->input->post("ad"),
                        "user_m_mail" => $this->input->post("mail"),
                        "user_m_tel" => $this->input->post("tel"),
                        "dgun" => $this->input->post("dgun"),
                        "adres" => $this->input->post("adres"),
                        "sehir" => $this->input->post("sehir")
                    ),array("id" => $_SESSION["user1"]["user"]));
                    if($guncelle){
                        pageCreate($view, array("hata" =>"1", "v" => getTableSingle("ft_users",array("id" => $_SESSION["user1"]["user"]))), $page, array());

                    }else{
                        pageCreate($view, array("hata" =>"Demo Hesabında İşlem Yetkisi Bulunmamaktadır", "v" => getTableSingle("ft_users",array("id" => $_SESSION["user1"]["user"]))), $page, array());
                    }
            }else{
                pageCreate($view, array("hata" =>"Lütfen E-posta ve Ad Soyad alanı zorunludur.", "v" => getTableSingle("ft_users",array("id" => $_SESSION["user1"]["user"]))), $page, array());

            }
        }else{
            pageCreate($view, array("v" => getTableSingle("ft_users",array("id" => $_SESSION["user1"]["user"]))), $page, array());
        }
    }
    public function index_update()
    {

        $this->viewFolder="firma/profile/pass";
        $view = array(
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolder."/info",
            "viewFolderSafe" => $this->viewFolderKullanici);
        $page = array(
            "pageTitle" => "Firma Bilgileri  - " . $this->settings->firma_unvan,
            "subHeader" => "Firma Bilgileri",
            "h3" => "Firma Bilgileri",
            "btnText" => "", "btnLink" => base_url(""));
        if($_POST){
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if($this->input->post("sifre") == $this->input->post("sifre_tekrar")){
                    header('Content-Type: application/json; charset=utf-8');
                    $guncelle=$this->m_tr_model->updateTable("ft_users",array(
                        "user_m_pass" => $this->input->post("sifre")
                    ),array("id" => $_SESSION["user1"]["user"]));
                    if($guncelle){
                        $log=$this->m_tr_model->add_new(
                            array(
                                "user_id" => $_SESSION["user1"]["user"],
                                "title" => "Şifre Güncellendi",
                                "description" => $_SESSION["user1"]["username"]." adlı üye şifresini başarılı şekilde değiştirdi.",
                                "date" => date("Y-m-d H:i:s"),
                                "status" => 2,
                                "agent" => $_SERVER["HTTP_USER_AGENT"],
                                "ip" => $_SERVER["REMOTE_ADDR"]
                            ),"ft_logs");
                        echo json_encode(array("err" => false,"message" => "Şifre başarılı şekilde güncellendi. Yönlendiriliyorsunuz"));
                    }else{
                        echo json_encode(array("err" => true,"message" => "Şifreler birbiri ile uyuşmuyor"));
                    }
                }else{
                    echo json_encode(array("err" => true,"message" => "Şifreler birbiri ile uyuşmuyor"));
                }
            }
        }else{
            pageCreate($view, array("v" => getTableSingle("options_general",array("id" => 1))), $page, array());

        }

    }

    public function index_list()
    {
        $this->viewFolder = "tasks/";
        $view = array(
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolder . "/list",
            "viewFolderSafe" => $this->viewFolderKullanici);
        $page = array(
            "pageTitle" => "İş Emirleri - " . $this->settings->firma_unvan,
            "subHeader" => "İş Emirleri",
            "h3" => "İş Emri Yönetimi",
            "btnText" => "", "btnLink" => base_url(""));

        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }

    //ADD
    public function actions_add()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("plaka") || $this->input->post("ad_soyad")) {
                    header('Content-Type: application/json; charset=utf-8');
                    $kon = getTableSingle("table_is_emri", array("tokens" => time()));
                    if ($kon) {
                        $data = array("err" => true, "message" => "Aynı anda birden çok kayıt oluşturulamaz.");
                        echo json_encode($data);
                    } else {
                        $cekMusteri = getTableSingle("table_musteri", array("id" => $this->input->post("ad_soyad"), "is_delete" => 0));
                        if ($cekMusteri) {
                            if ($this->input->post("total") > 0) {
                                $hizmetler = getTable("table_hizmetler", array("status" => 1, "is_delete" => 0));
                                if ($hizmetler) {
                                    $str = "";
                                    $total = 0;
                                    foreach ($hizmetler as $item) {
                                        if ($this->input->post("hizmet-" . $item->id)) {
                                            $str .= $item->id . ",";
                                            $total += $item->price;
                                        }
                                    }
                                }
                                if ($str) {
                                    $str = rtrim($str, ",");
                                }

                                $kaydet = $this->m_tr_model->add_new(array(
                                    "tokens" => time(),
                                    "musteri_id" => $this->input->post("ad_soyad"),
                                    "tutar" => $total,
                                    "islem_tarih" => $this->input->post("date"),
                                    "status" => 0,
                                    "hizmetler" => $str,
                                ), "table_is_emri");


                                if ($kaydet) {
                                    $fiskaydet = $this->m_tr_model->add_new(array(
                                        "SiparisNo" => $kaydet,
                                        "Plaka" => $cekMusteri->plaka,
                                        "MusteriKodu" => $cekMusteri->id,
                                        "Fiyat" => $total,
                                        "Alinan" => 0,
                                        "Iade" => 0,
                                        "OdemeTuru" => 0,
                                        "IslemTuru" => 1,
                                        "Ekleyen" => $_SESSION["user1"]["username"],
                                        "Aciklama" => "",
                                        "Tarih" => date("Y-m-d"),
                                        "Ay" => date("m"),
                                        "Yil" => date("Y"),
                                        "Token" => time(),
                                        "IslemTarih" => $this->input->post("date")
                                    ), "table_cari_odeme");
                                    if ($fiskaydet) {
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                                        echo json_encode($data);
                                    }

                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                                    echo json_encode($data);
                                }

                            } else {
                                $data = array("err" => true, "message" => "Tutar 0'dan küçük olamaz.");
                                echo json_encode($data);
                            }

                        } else {
                            $data = array("err" => true, "message" => "Kayıt getirilemedi");
                            echo json_encode($data);
                        }

                    }


                } else {
                    $data = array("err" => true, "message" => "Lütfen plaka veya Müşteri Seçiniz");
                    echo json_encode($data);
                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //İş emri durumu ve ödeme durumu günceller
    public function update_tasks()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
               
                header('Content-Type: application/json; charset=utf-8');
                if ($this->input->post("islemId")) {
                    $kontrol=getTableSingle("table_is_emri",array("id" => $this->input->post("islemId"),"is_delete" => 0));
                    if($kontrol){
                        if($kontrol->status!=$this->input->post("islem")){
                            if($kontrol->status==0 && $this->input->post("islem")==1 ){

                                if($this->input->post("tur")){

                                    if($this->input->post("tur")==0 || $this->input->post("tur")==""){
                                        $cekOdeme=getTableSingle("table_cari_odeme",array("SiparisNo" => $kontrol->id,"IslemTuru" => 1,"OdemeTuru <>" => 5 ));
                                        if($cekOdeme){
                                            $guncelleMain=$this->m_tr_model->updateTable("table_is_emri",array("status" => 1,
                                                "update_user" => $_SESSION["user1"]["username"],
                                                "update_at" => date("Y-m-d H:i:s")
                                            ),array("id" =>  $kontrol->id));
                                            $guncelle=$this->m_tr_model->updateTable("table_cari_odeme",array("odemeTuru" => 5,
                                                "Aciklama" => $this->input->post("aciklama")
                                            ),array("id" =>  $cekOdeme->id));
                                            if($guncelle){
                                                $data = array("err" => false, "message" => "İşlem Başarılı");
                                                echo json_encode($data);
                                            }else{
                                                $data = array("err" => true, "message" => "İşlem sırasında hata meydana geldi.");
                                                echo json_encode($data);
                                            }
                                        }
                                    }else{

                                        $cekOdeme=getTableSingle("table_cari_odeme",array("SiparisNo" => $kontrol->id,"IslemTuru" => 1));
                                        if($cekOdeme){
                                            if($cekOdeme->OdemeTuru==5){
                                                $guncelle=$this->m_tr_model->updateTable("table_cari_odeme",array("OdemeTuru" => 0),array("id" => $cekOdeme->id));
                                            }
                                            $fiskaydet = $this->m_tr_model->add_new(array(
                                                "SiparisNo" => $kontrol->id,
                                                "Plaka" => $cekOdeme->Plaka,
                                                "MusteriKodu" => $kontrol->musteri_id,
                                                "Fiyat" => 0,
                                                "Alinan" => $cekOdeme->Fiyat,
                                                "Iade" => 0,
                                                "OdemeTuru" => $this->input->post("tur"),
                                                "IslemTuru" => 2,
                                                "Ekleyen" => $_SESSION["user1"]["username"],
                                                "Aciklama" => $this->input->post("aciklama"),
                                                "Tarih" => date("Y-m-d"),
                                                "Ay" => date("m"),
                                                "Yil" => date("Y"),
                                                "Token" => time(),
                                                "IslemTarih" => date("Y-m-d H:i:s")
                                            ), "table_cari_odeme");
                                            if($fiskaydet){
                                                $guncelle=$this->m_tr_model->updateTable("table_is_emri",array("odenen" => $cekOdeme->Fiyat,"status" => 1),array("id" => $cekOdeme->SiparisNo));
                                                $data = array("err" => false, "message" => "Kayıt Başarılı");
                                                echo json_encode($data);
                                            }else{
                                                $data = array("err" => true, "message" => "Kayıt Sırasında Hata meydana geldi");
                                                echo json_encode($data);
                                            }
                                        }else{
                                            $data = array("err" => true, "message" => "Kayıt getirilemedi");
                                            echo json_encode($data);
                                        }

                                    }
                                }else{
                                    $cekOdeme=getTableSingle("table_cari_odeme",array("SiparisNo" => $kontrol->id,"IslemTuru" => 2));
                                    $cekOdeme2=getTableSingle("table_cari_odeme",array("SiparisNo" => $kontrol->id,"IslemTuru" => 1));
                                    if($cekOdeme){
                                        if($kontrol->status==0){
                                            $guncelle=$this->m_tr_model->updateTable("table_is_emri",array("odenen" => $cekOdeme->Alinan,"status" => 1),array("id" => $cekOdeme->SiparisNo));
                                            if($guncelle){
                                                $data = array("err" => false, "message" => "Kayıt Başarılı");
                                                echo json_encode($data);
                                            }else{
                                                $data = array("err" => true, "message" => "Kayıt Sırasında Hata meydana geldi");
                                                echo json_encode($data);
                                            }
                                        }
                                    }else if($cekOdeme2){
                                        if($cekOdeme2->OdemeTuru==0){
                                            $guncelle=$this->m_tr_model->updateTable("table_cari_odeme",array("OdemeTuru" => 5),array("id" => $cekOdeme2->id));
                                            $guncelle=$this->m_tr_model->updateTable("table_is_emri",array("status" => 1),array("id" => $cekOdeme2->SiparisNo));
                                            if($guncelle){
                                                $data = array("err" => false, "message" => "Kayıt Başarılı");
                                                echo json_encode($data);
                                            }else{
                                                $data = array("err" => true, "message" => "Kayıt Sırasında Hata meydana geldi");
                                                echo json_encode($data);
                                            }
                                        }
                                    }
                                }
                            }else if($kontrol->status==0 && $this->input->post("islem")==0){

                                $cekOdeme=getTableSingle("table_cari_odeme",array("SiparisNo" => $kontrol->id,"IslemTuru" => 1));
                                if($cekOdeme){
                                    if($this->input->post("tur")!=0){
                                        if($cekOdeme->OdemeTuru==5){
                                            $guncelle=$this->m_tr_model->updateTable("table_cari_odeme",array("OdemeTuru" => 0),array("id" => $cekOdeme->id));
                                        }

                                        $fiskaydet = $this->m_tr_model->add_new(array(
                                            "SiparisNo" => $kontrol->id,
                                            "Plaka" => $cekOdeme->Plaka,
                                            "MusteriKodu" => $kontrol->musteri_id,
                                            "Fiyat" => 0,
                                            "Alinan" => $cekOdeme->Fiyat,
                                            "Iade" => 0,
                                            "OdemeTuru" => $this->input->post("tur"),
                                            "IslemTuru" => 2,
                                            "Ekleyen" => $_SESSION["user1"]["username"],
                                            "Aciklama" => $this->input->post("aciklama"),
                                            "Tarih" => date("Y-m-d"),
                                            "Ay" => date("m"),
                                            "Yil" => date("Y"),
                                            "Token" => time(),
                                            "IslemTarih" => date("Y-m-d H:i:s")
                                        ), "table_cari_odeme");
                                        if($fiskaydet){
                                            $guncelle=$this->m_tr_model->updateTable("table_is_emri",array("odenen" => $cekOdeme->Fiyat),array("id" => $cekOdeme->SiparisNo));
                                            $data = array("err" => false, "message" => "Kayıt Başarılı");
                                            echo json_encode($data);
                                        }else{
                                            $data = array("err" => true, "message" => "Kayıt Sırasında Hata meydana geldi");
                                            echo json_encode($data);
                                        }
                                    }
                                }else{
                                    $data = array("err" => true, "message" => "Kayıt getirilemedi");
                                    echo json_encode($data);
                                }
                            }
                        }else{

                            $cekOdeme=getTableSingle("table_cari_odeme",array("SiparisNo" => $kontrol->id,"IslemTuru" => 1));
                            if($cekOdeme){
                                if($this->input->post("tur")!=0){
                                    if($cekOdeme->OdemeTuru==5){
                                        $guncelle=$this->m_tr_model->updateTable("table_cari_odeme",array("OdemeTuru" => 0),array("id" => $cekOdeme->id));
                                    }

                                    $fiskaydet = $this->m_tr_model->add_new(array(
                                        "SiparisNo" => $kontrol->id,
                                        "Plaka" => $cekOdeme->Plaka,
                                        "MusteriKodu" => $kontrol->musteri_id,
                                        "Fiyat" => 0,
                                        "Alinan" => $cekOdeme->Fiyat,
                                        "Iade" => 0,
                                        "OdemeTuru" => $this->input->post("tur"),
                                        "IslemTuru" => 2,
                                        "Ekleyen" => $_SESSION["user1"]["username"],
                                        "Aciklama" => $this->input->post("aciklama"),
                                        "Tarih" => date("Y-m-d"),
                                        "Ay" => date("m"),
                                        "Yil" => date("Y"),
                                        "Token" => time(),
                                        "IslemTarih" => date("Y-m-d H:i:s")
                                    ), "table_cari_odeme");
                                    if($fiskaydet){
                                        $guncelle=$this->m_tr_model->updateTable("table_is_emri",array("odenen" => $cekOdeme->Fiyat),array("id" => $cekOdeme->SiparisNo));
                                        $data = array("err" => false, "message" => "Kayıt Başarılı");
                                        echo json_encode($data);
                                    }else{
                                        $data = array("err" => true, "message" => "Kayıt Sırasında Hata meydana geldi");
                                        echo json_encode($data);
                                    }
                                }
                            }else{
                                $data = array("err" => true, "message" => "Kayıt getirilemedi");
                                echo json_encode($data);
                            }
                        }
                    }else{
                        $data = array("err" => true, "message" => "Kayıt getirilemedi");
                        echo json_encode($data);
                    }
                } else {

                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX list table
    public function list_table()
    {
        $join = " left join table_marka_model as m on s.marka_id=m.id left join table_marka_model as mo on s.model_id=mo.id ";
        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s " . $join . " where s.is_delete=0 ");
        $sql = "select s.id as ssid,s.name as mad,s.plaka,s.telefon,m.name as marka_adi,mo.name as model_adi,s.status as stat,m.logo as logos,s.created_at as cdate from " . $this->tables . " as s " . $join;
        $where = [];
        $order = ['mad', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];


        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            if ($order[0] == "cdate") {
                $order[0] = "s.created_at";
            }
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {
                if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "cdate" && $column["data"] != "logos" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
                    if (!empty($column['search']['value'])) {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
                    } else {
                        if ($column['data'] == "marka_adi") {
                            $where[] = "m.name LIKE '%" . $_POST['search']['value'] . "%' ";
                        } else if ($column['data'] == "model_adi") {
                            $where[] = "mo.name LIKE '%" . $_POST['search']['value'] . "%' ";
                        } else if ($column['data'] == "mad") {
                            $where[] = "s.name LIKE '%" . $_POST['search']['value'] . "%' ";
                        } else {
                            $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                        }
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
            $sql .= ' WHERE s.is_delete=0 and (   ' . implode(' or ', $where) . "  )";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= " where s.is_delete=0 order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join . (count($where) > 0 ? ' WHERE  s.is_delete=0 and ( ' . implode(' or ', $where) : ' ') . "  ) ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s " . $join . " where s.is_delete=0 ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {

            $response["data"][] = [
                "ssid" => $veri->ssid,
                "mad" => $veri->mad,
                "plaka" => $veri->plaka,
                "marka_adi" => $veri->marka_adi,
                "model_adi" => $veri->model_adi,
                "cdate" => date("Y-m-d", strtotime($veri->cdate)),
                "telefon" => $veri->telefon,
                "stat" => $veri->stat,
                "logos" => $veri->logos,
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

    //AJAX get recırd
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "title", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX set status
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

    //AJAX record multi delete
    public function get_record_all_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            $parse = rtrim($this->input->post("data"), ",");
            $parse = explode(",", $parse);
            if ($this->input->post("tur") == 1) {
                $veri = "";
                foreach ($parse as $item) {
                    $k = getRecord($this->tables, "name", $item);
                    $veri .= "<b class='text-danger'>" . $k . " </b>,";
                }
                echo rtrim($veri, ",");
            } else {
                parse_str($this->input->post("data"), $searcharray);
                $searcharray = array_unique($searcharray["id"]);
                $str = "";
                foreach ($searcharray as $item) {
                    $str .= $item . ",";
                }
                $str = rtrim($str, ",");
                $cek = $this->m_tr_model->query("select * from " . $this->tables . " where is_delete=0 and id in(" . $str . ") ");
                if ($cek) {
                    foreach ($cek as $item) {
                        if ($item->logo != "") {
                            img_delete("marka/" . $item->logo);
                        }
                        $sil = $this->m_tr_model->delete($this->tables, array("id" => $item->id));
                    }
                    echo 1;
                }
            }

        } else {
            redirect(base_url("404"));
        }
    }


}
