<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Epinkopin extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="epinkopin/items";
    public $viewFile="blank";
    public $tables="table_dis_coupon";
    public $baseLink="coupon";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(129);
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Epinkopin Kuponu Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Epinkopin Kuponu Yönetimi - <a href='" . base_url("coupon") . "'>Epinkopin Kuponları</a>",
            "h3" => "Epinkopin Kuponları",
            "btnText" => "", "btnLink" => base_url("epinkopin-kupon-ekle"));

        $hata="";
        $hatayok="";
        $veri="";
        if($this->input->get("edit")){
            $cek=getTableSingle("table_dis_coupon",array("id" => $this->input->get("edit")));
            if($cek){
                $veri=$cek;
            }
        }
        if($_POST){
            if($this->input->post("updateId")){
                $cek=getTableSingle("table_dis_coupon",array("id" => $this->input->post("updateId")));
                if($cek){
                    $code=$this->input->post("code");
                    $sayi=$this->input->post("say");
                    $tutar=$this->input->post("tutar");
                    $tarih=date("Y-m-d",strtotime($this->input->post("tarih")));
                    if($code && $sayi && $tutar){
                        if($cek->coupon_code!=$code){
                            $kont=getTableSingle("table_dis_coupon",array("coupon_code" => $code));
                            if($kont){
                                $veri=new stdClass();
                                $hata="Bu kupon daha önce tanımlanmıştır.";
                            }else{
                                $ekle=$this->m_tr_model->updateTable("table_dis_coupon",array(
                                    "coupon_code" => $code,
                                    "status" => $this->input->post("status"),
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "coupon_price" => $tutar,
                                    "adet" => $sayi,
                                    "kalan" => $this->input->post("kadet"),
                                    "gecerlilik" => $tarih,
                                ),array("id" => $cek->id));
                                if($ekle){
                                    $hatayok="Kupon Başarılı şekilde güncellendi";
                                }else{
                                    $hata="Kayıt sırasında hata meydana geldi";
                                }
                            }
                        }else{
                            $ekle=$this->m_tr_model->updateTable("table_dis_coupon",array(
                                "coupon_code" => $code,
                                "status" => $this->input->post("status"),
                                "coupon_price" => $tutar,
                                "adet" => $sayi,
                                "kalan" => $this->input->post("kadet"),
                                "gecerlilik" => $tarih,
                            ),array("id" => $cek->id));
                            if($ekle){
                                $hatayok="Kupon Başarılı şekilde güncellendi";
                            }else{
                                $hata="Kayıt sırasında hata meydana geldi";
                            }

                        }

                    }
                }

            }else{
                $sayi=$this->input->post("say");
                $tutar=$this->input->post("tutar");
                $tarih=date("Y-m-d",strtotime($this->input->post("tarih")));
                if( $sayi && $tutar){
                   for ($i=0;$i<$sayi;$i++){
                       $code=$this->generateRandomCode(12);
                       $ekle=$this->m_tr_model->add_new(array(
                           "coupon_code" => $code,
                           "status" => $this->input->post("status"),
                           "created_at" => date("Y-m-d H:i:s"),
                           "coupon_price" => $tutar,
                           "gecerlilik" => $tarih,
                           "type" => 1,
                       ),"table_dis_coupon");
                   }

                    if($ekle){
                        $hatayok="Kodlar Başarılı şekilde eklendi";
                    }else{
                        $hata="Kayıt sırasında hata meydana geldi";
                    }

                }
            }

        }
        $data=array("hata" => $hata,"hatayok" => $hatayok,"v" => $veri );
        //$data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    private function generateRandomCode($length) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomCode = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }
        $kont=getTableSingle("table_dis_coupon",array("coupon_code" => $randomCode));
        if($kont){
            return $this->generateRandomCode(12);
        }else{
            return $randomCode;
        }
    }


    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "coupon_code", $this->input->post("data"));
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
                        $guncelle=$this->m_tr_model->delete($this->tables,array("id" =>$kontrol->id));
                        if ($guncelle) {
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
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("products/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
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
    public function isActiveSetter($id='')
    {
        if(($id!="") and (is_numeric($id)) ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $isActive=($this->input->post("data") === "true") ? 1 : 0;
                    $update=$this->m_tr_model->updateTable($this->tables,array("status" => $isActive),array("id" => $id));
                    if($update){
                        echo "1";
                    }else{
                        echo "2";
                    }
                }else{
                    echo "3";
                }
            }else{
                echo "4";
            }
        }else{
            echo "4";
        }
    }

    //AJAX İS ACTİVE SET SPECIAL
    public function isSetter($types='',$id)
    {
        if(($id!="") and (is_numeric($id)) and ($types!="") ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $isActive=($this->input->post("data") === "true") ? 1 : 0;
                    $update=$this->m_tr_model->updateTable($this->tables,array($types => $isActive),array("id" => $id));
                    if($update){
                        echo "1";
                    }else{
                        echo "2";
                    }
                }else{
                    echo "3";
                }
            }else{
                echo "4";
            }
        }else{
            echo "4";
        }
    }

}
