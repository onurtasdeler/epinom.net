<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Mails extends CI_Controller
{

    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="mails";
    public $viewFile="blank";
    public $tables="t_mail_job";
    public $baseLink="ayarlar/banka-hesaplari";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }
    //index

    public function index_main()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Mail Otomatsyon Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Mail Otomatsyon Yönetimi - <a href='" . $this->baseLink . "'>Mail Otomasyon</a>",
            "h3" => "Banka Hesapları",
            "btnText" => "", "btnLink" => base_url("banka-hesap-ekle"));

        if ($this->input->get("up")) {
            orderChange($this->tables,"up",$this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables,"down",$this->input->get("down"));
        }
        if($this->input->get("sil")){
            $sil=$this->m_tr_model->delete("t_mail_job_grup",array("id" => $this->input->get("sil")));
            if($sil){
                $sil2=$this->m_tr_model->delete("t_mail_job",array("job_grup_id" => $this->input->get("sil")));
                if($sil2 && $sil){
                    $viewData->silindi=1;
                }
            }
        }
        $data=getTable($this->tables,array());
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

        $sabloncek=getTableSingle("table_mail_templates",array("id"  => $this->input->post("sablon")));
        if($sabloncek){
            $jsons=json_decode($sabloncek->field_data);
            echo json_encode(array("ad" => $sabloncek->name,"icerik" => $jsons[0]->content,"konu" => $jsons[0]->konu));
        }
    }

    public function sablon_kaydet()
    {
        header('Content-Type: application/json; charset=utf-8');
        $kontrol=getTableSingle("table_mail_templates",array("name" => $this->input->post("name")));
        if($kontrol){
            echo json_encode(array("hata" => "var","message" => "Bu adda şablon mevcuttur lütfen farklı bir ad kulllanınız"));
        }else{
            $cek2=getTableSingle("table_mail_templates",array("id" => 1));
            $subtr="";
            $suben="";
            $contenttr="";
            $contenten="";
            $enc="";
            $lang=getTable("table_langs",array());

            $langValue[]=array(
                "lang_id" => 1,
                "konu" => $this->input->post("konu"),
                "content" => $_POST["icerik"],
            );

            $enc= json_encode($langValue);

            $ekle=$this->m_tr_model->add_new(array(
                "name" => $this->input->post("name"),
                "subject_tr" => $this->input->post("konu"),
                "content_tr" => $_POST["icerik"],
                'top' => $cek2->top,
                'user_task' =>1,
                "field_data" => $enc,
                'bottom' => $cek2->bottom,
            ),"table_mail_templates");
            if($ekle){
                echo json_encode(array("hata" => "yok","message" => "Şablon Başarılı şekilde kayıt edildi. "));
            }else{
                echo json_encode(array("hata" => "var","message" => "Kayıt sırasında hata meydana geldi tekrar deneyiniz."));
            }
        }

    }

    public function send_mails()
    {
        if($this->input->post("grup")){
            $tarih="";
            if($this->input->post("tarih")){
                $tarih=$this->input->post("tarih");
            }else{
                $tarih=date("Y-m-d H:i:s");
            }

            if($_POST["kategori"]){

                foreach ($_POST["kategori"] as $item) {

                }

                $ekle=$this->m_tr_model->add_new(array(
                    "content" => $_POST["micerik"],
                    "subject" => $this->input->post("mkonu"),
                    "category_id" => json_encode($_POST["kategori"]),
                    "status" => 0,
                    "gonderim_tarih" => $tarih,
                    "sablon_id" => $this->input->post("sablon"),
                    "created_at" => date("Y-m-d H:i:s")
                ),"t_mail_job_grup");
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
                                    "job_grup_id"  => $ekle
                                ),"t_mail_job");
                            }
                        }else{
                            $ekle2=$this->m_tr_model->add_new(array(
                                "mail_adresi" => $item,
                                "status" => 0,
                                "created_at" => date("Y-m-d H:i:s"),
                                "gonderim_tarihi" => $tarih,
                                "job_grup_id"  => $ekle
                            ),"t_mail_job");
                        }
                    }
                }
            }else{
                $ekle=$this->m_tr_model->add_new(array(
                    "content" => $_POST["micerik"],
                    "subject" => $this->input->post("mkonu"),
                    "status" => 0,
                    "gonderim_tarih" => $tarih,
                    "sablon_id" => $this->input->post("sablon"),
                    "created_at" => date("Y-m-d H:i:s")
                ),"t_mail_job_grup");
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
                                    "job_grup_id"  => $ekle
                                ),"t_mail_job");
                            }
                        }else{
                            $ekle2=$this->m_tr_model->add_new(array(
                                "mail_adresi" => $item,
                                "status" => 0,
                                "created_at" => date("Y-m-d H:i:s"),
                                "gonderim_tarihi" => $tarih,
                                "job_grup_id"  => $ekle
                            ),"t_mail_job");
                        }
                    }
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
                    "content" => $_POST["micerik"],
                    "subject" => $this->input->post("mkonu"),
                    "category_id" => json_encode($_POST["kategori"]),
                    "status" => 0,
                    "gonderim_tarih" => $tarih,
                    "sablon_id" => $this->input->post("sablon"),
                    "created_at" => date("Y-m-d H:i:s")
                ),"t_mail_job_grup");
                if($ekle){
                    foreach ($_POST["kategori"] as $item) {


                        $cc=$this->m_tr_model->query("SELECT 
                            u.email,
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
                                $uye=getTableSingle("table_users",array("email" => $items->email));
                                if($uye){
                                    $ekle2=$this->m_tr_model->add_new(array(
                                        "mail_adresi" => $uye->email,
                                        "status" => 0,
                                        "user_id" => $uye->id,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "gonderim_tarihi" => $tarih,
                                        "job_grup_id"  => $ekle
                                    ),"t_mail_job");
                                }
                            }

                        }

                    }
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
    public function mails_cron()
    {
        $cek=getTableOrder("t_mail_job_grup",array("status" => 0),"gonderim_tarih","asc");
        if($cek){
            foreach ($cek as $item) {
                $secilenTarih = new DateTime($item->gonderim_tarih);
                $simdi = new DateTime();
                if($secilenTarih<$simdi){
                    $mailler=getTableOrder("t_mail_job",array("job_grup_id" => $item->id,"status" => 0),"id","asc");
                    if($mailler){
                        foreach ($mailler as $m) {

                            $sendMail=sendMails($m->mail_adresi,1,-1,"","verification",0,array("content" => $item->content,"konu" => $item->subject));

                            if($sendMail){
                                $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 1,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                            }else{
                                $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                            }
                            sleep(1);
                        }
                    }
                    $guncelle=$this->m_tr_model->updateTable("t_mail_job_grup",array("status" => 1),array("id" => $item->id));
                }else{


                }
            }
        }


    }




}
