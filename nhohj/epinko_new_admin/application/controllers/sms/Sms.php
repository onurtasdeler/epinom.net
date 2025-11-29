<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Sms extends CI_Controller
{

    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="sms_system";
    public $viewFile="blank";
    public $tables="t_sms_job";
    public $baseLink="sms/sms";

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
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Sms Otomasyon Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Sms Otomasyon Yönetimi - <a href='" . $this->baseLink . "'>Sms Otomasyon</a>",
            "h3" => "",
            "btnText" => "", "btnLink" => base_url(""));
        if($this->input->get("sil")){
            $sil=$this->m_tr_model->delete("t_sms_job_grup",array("id" => $this->input->get("sil")));
            if($sil){
                $sil2=$this->m_tr_model->delete("t_sms_job",array("job_grup_id" => $this->input->get("sil")));
                if($sil2 && $sil){
                    $viewData->silindi=1;
                }
            }
        }
        pageCreate($view, $data, $page, array());
    }

    public function getusertop(){
        // Veritabanı bağlantısını yapın
        if($this->input->get("q")){
            $grup = $this->m_tr_model->query("SELECT id, email, nick_name FROM table_users WHERE status=1  AND (email LIKE '%".$this->input->get("q")."%' OR nick_name LIKE '%".$this->input->get("q")."%')");
        }else{
            $grup = $this->m_tr_model->query("SELECT id, email, nick_name FROM table_users WHERE status=1");

        }
        $result = [];
        foreach ($grup as $item) {
            $result[] = [
                'id' => $item->id,
                'text' => $item->email . "-" . $item->nick_name
            ];
        }
        echo json_encode($result);
    }
    public function getusercategory(){
        // Veritabanı bağlantısını yapın
        if($this->input->get("q")){
            $grup = $this->m_tr_model->query("SELECT id, c_name FROM table_products_category WHERE status=1  and c_name like '%".$this->input->get("q")."%' ");
        }else{
            $grup = $this->m_tr_model->query("SELECT id, c_name FROM table_products_category WHERE status=1  ");
        }
        $result = [];
        foreach ($grup as $item) {
            $result[] = [
                'id' => $item->id,
                'text' => $item->c_name,
            ];
        }
        echo json_encode($result);
    }
    public function sablon_getir()
    {
        header('Content-Type: application/json; charset=utf-8');

        $sabloncek=getTableSingle("table_user_sms_task",array("type" => 1,"id"  => $this->input->post("sablon")));
        if($sabloncek){
            $jsons=json_decode($sabloncek->field_data);
            echo json_encode(array("ad" => $sabloncek->name,"icerik" => $jsons[0]->name));
        }
    }
    public function sablon_kaydet()
    {
        header('Content-Type: application/json; charset=utf-8');
        $kontrol=getTableSingle("table_user_sms_task",array("type" => 1,"name" => $this->input->post("name")));
        if($kontrol){
            echo json_encode(array("hata" => "var","message" => "Bu adda şablon mevcuttur lütfen farklı bir ad kulllanınız"));
        }else{
            $enc="";
            $lang=getTable("table_langs",array());

            $langValue[]=array(
                "lang_id" => 1,
                "name" => $this->input->post("konu"),
            );
            $enc= json_encode($langValue);
            $ekle=$this->m_tr_model->add_new(array(
                "name" => $this->input->post("name"),
                "field_data" => $enc,
                "status" => 1,
                'type' => 1,
            ),"table_user_sms_task");
            if($ekle){
                echo json_encode(array("hata" => "yok","message" => "Şablon Başarılı şekilde kayıt edildi. "));
            }else{
                echo json_encode(array("hata" => "var","message" => "Kayıt sırasında hata meydana geldi tekrar deneyiniz."));
            }
        }

    }

    public function send_mails()
    {
        header('Content-Type: application/json; charset=utf-8');

        if($this->input->post("grup")){
            $tarih="";
            if($this->input->post("tarih")){
                $tarih=$this->input->post("tarih");
            }else{
                $tarih=date("Y-m-d H:i:s");
            }

            if($_POST["kategori"]){
                $ekle=$this->m_tr_model->add_new(array(
                    "content" => $this->input->post("mailkonu"),
                    "subject" => $this->input->post("mkonu"),
                    "category_id" => json_encode($_POST["kategori"]),
                    "status" => 0,
                    "gonderim_tarih" => $tarih,
                    "sablon_id" => $this->input->post("sablon"),
                    "created_at" => date("Y-m-d H:i:s")
                ),"t_sms_job_grup");
                if($ekle){
                    foreach ($_POST["grup"] as $item) {
                        if(is_numeric($item)){
                            $uye=getTableSingle("table_users",array("id" => $item));
                            if($uye){
                                $ekle2=$this->m_tr_model->add_new(array(
                                    "mail_adresi" => $uye->email,
                                    "status" => 0,
                                    "user_id" => $uye->id,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "gonderim_tarihi" => $tarih,
                                    "job_grup_id"  => $ekle,
                                ),"t_sms_job");
                            }
                        }else{
                            $ekle2=$this->m_tr_model->add_new(array(
                                "mail_adresi" => $item,
                                "status" => 0,
                                "created_at" => date("Y-m-d H:i:s"),
                                "gonderim_tarihi" => $tarih,
                                "job_grup_id"  => $ekle
                            ),"t_sms_job");
                        }
                    }
                }
                echo json_encode(array("hata" => "yok","message" => "Gönderim Başarılı şekilde kayıt edildi. "));
            }
            else{
                $ekle=$this->m_tr_model->add_new(array(
                    "content" =>$this->input->post("mailkonu"),
                    "status" => 0,
                    "gonderim_tarih" => $tarih,
                    "sablon_id" => $this->input->post("sablon"),
                    "created_at" => date("Y-m-d H:i:s")
                ),"t_sms_job_grup");
                if($ekle){
                    foreach ($_POST["grup"] as $item) {
                        if(is_numeric($item)){
                            $uye=getTableSingle("table_users",array("id" => $item));
                            if($uye){
                                $ekle2=$this->m_tr_model->add_new(array(
                                    "mail_adresi" => $uye->phone,
                                    "status" => 0,
                                    "user_id" => $uye->id,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "gonderim_tarihi" => $tarih,
                                    "job_grup_id"  => $ekle
                                ),"t_sms_job");
                            }
                        }else{
                           /* $ekle2=$this->m_tr_model->add_new(array(
                                "mail_adresi" => $item,
                                "status" => 0,
                                "created_at" => date("Y-m-d H:i:s"),
                                "gonderim_tarihi" => $tarih,
                                "job_grup_id"  => $ekle
                            ),"t_sms_job");*/
                        }
                    }
                    echo json_encode(array("hata" => "yok","message" => "Gönderim Başarılı şekilde kayıt edildi. "));
                }

            }
        }else{
            $tarih="";
            if($this->input->post("tarih")){
                $tarih=$this->input->post("tarih");
            }else{
                $tarih=date("Y-m-d H:i:s");
            }
            if($_POST["kategori"]){
                $ekle=$this->m_tr_model->add_new(array(
                    "content" => $this->input->post("mailkonu"),
                    "category_id" => json_encode($_POST["kategori"]),
                    "status" => 0,
                    "gonderim_tarih" => $tarih,
                    "sablon_id" => $this->input->post("sablon"),
                    "created_at" => date("Y-m-d H:i:s")
                ),"t_sms_job_grup");
                if($ekle){
                    if($_POST["kategori"]){
                        foreach ($_POST["kategori"] as $item) {
                            $cc=$this->m_tr_model->query("SELECT 
                            u.phone,
                            GROUP_CONCAT(o.id) AS order_ids,
                            GROUP_CONCAT(o.product_id) AS product_ids,
                            GROUP_CONCAT(o.status) AS statuses
                        FROM table_orders o
                        JOIN table_products p ON o.product_id = p.id
                        JOIN table_users u ON o.user_id = u.id
                        WHERE o.status = 2
                        AND (
                            (p.category_main_id <> 0 AND p.category_id <> 0 AND p.category_id = ".$item.")
                            OR
                            (p.category_main_id = 0 AND p.category_id = ".$item.")
                            OR
                            (p.category_main_id <> 0 AND p.category_id = 0 AND p.category_main_id = ".$item.")
                        )
                        GROUP BY u.email");
                            if($cc){

                                foreach ($cc as $items) {
                                    $uye=getTableSingle("table_users",array("phone" => $items->phone));
                                    if($uye){
                                        $ekle2=$this->m_tr_model->add_new(array(
                                            "mail_adresi" => $uye->phone,
                                            "status" => 0,
                                            "user_id" => $uye->id,
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "gonderim_tarihi" => $tarih,
                                            "job_grup_id"  => $ekle,
                                            "category_ids" => $item
                                        ),"t_sms_job");
                                    }
                                }

                            }

                        }
                    }else{

                    }
                    echo json_encode(array("hata" => "yok","message" => "Gönderim Başarılı şekilde kayıt edildi. "));

                }
            }
        }
    }

    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                echo "asd";
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    public function sms_crons()
    {
        $this->load->helper("netgsm_helper");

        $cek=getTableOrder("t_sms_job_grup",array("status" => 0),"gonderim_tarih","asc");
        if($cek){
            foreach ($cek as $item) {
                $secilenTarih = new DateTime($item->gonderim_tarih);
                $simdi = new DateTime();
                if($secilenTarih<$simdi){
                    $mailler=getTableOrder("t_sms_job",array("job_grup_id" => $item->id,"status" => 0),"id","asc");
                    if($mailler){
                        foreach ($mailler as $m) {
                            $uye=getTableSingle("table_users",array("phone" => $m->mail_adresi));
                            if($uye){
                                if($m->category_ids!=0){
                                    $kat=getTableSingle("table_products_category",array("id" => $m->category_ids));
                                    if($kat){
                                        $cevir=str_replace("[kategori_adi]",$kat->c_name,$item->content);
                                        $cevir=str_replace("[musteri_adi]",$uye->full_name,$cevir);
                                    }else{
                                        $cevir=str_replace("[musteri_adi]",$uye->full_name,$item->content);
                                    }
                                }else{
                                    $cevir=str_replace("[musteri_adi]",$uye->full_name,$item->content);
                                }

                                $sms = smsGonder($uye->phone, $cevir . ". B" . rand(1, 254));
                                $sms = explode(" ", $sms);
                                if ($sms[0] == "00" || $sms[0] == "02") {
                                    $guncelle=$this->m_tr_model->updateTable("t_sms_job",array("status" => 1,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                } else {
                                    $guncelle=$this->m_tr_model->updateTable("t_sms_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                }
                            }else{
                                $cevir=str_replace("[musteri_adi]","Müşterimiz",$item->content);
                                $sms = smsGonder($m->mail_adresi, $cevir . ". B" . rand(1, 254));
                                $sms = explode(" ", $sms);
                                if ($sms[0] == "00" || $sms[0] == "02") {
                                    $guncelle=$this->m_tr_model->updateTable("t_sms_job",array("status" => 1,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                } else {
                                    $guncelle=$this->m_tr_model->updateTable("t_sms_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                }
                            }
                            sleep(2);
                        }
                    }
                    $guncelle=$this->m_tr_model->updateTable("t_sms_job_grup",array("status" => 1),array("id" => $item->id));
                }else{


                }
            }
        }



    }






}
