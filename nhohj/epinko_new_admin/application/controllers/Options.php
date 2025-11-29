<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends CI_Controller {

    public $formControl="";


    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata("user1")){

            $this->load->model("m_tr_model");
            $this->formControl= uniqid("user_");
            setSession2("formCheck",$this->formControl);
            $this->load->helper("model_helper");
        }else{
            redirect(base_url("giris"));
        }
    }


	public function index()
	{
        $this->viewFile="opt_general";
        $this->viewFolder="opt_general_item";
	    $viewData=new stdClass();
		$this->load->view('opt_general',$viewData);
	}

    public function img_upload_ck(){
        $CKEditor = $_GET['CKEditor'];
        $funcNum = $_GET['CKEditorFuncNum'];
        $name = $_GET['namse'];
        $target_dir = "../upload/icerik/";
        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $newfilename = $name."-".uniqid(rand(1,1000000)).".".$imageFileType;
        if(move_uploaded_file($_FILES["upload"]["tmp_name"], $target_dir . $newfilename)){
            $url = "../upload/icerik/".$newfilename;
            echo "<script>window.parent.CKEDITOR.tools.callFunction('".$funcNum."', '".$url."', '');</script>";
        }
    }


    //logo options
    public function logo_opt_index(){
        $this->viewFile="opt_logo";
            $this->viewFolder="opt_logo_item";
            $this->load->helper("functions_helper");
            $viewData=new stdClass();
        $ayarlar=getTableSingle("options_general",array("id" => 1));
            $viewData->pageTitle=" Logo ve Favicon Ayarları - ".$ayarlar->site_name;
            $ayarlar=getTableSingle("options_general",array("id" => 1));


            if($_POST["logo"]){

                if($_FILES["file"]["tmp_name"]==""){
                    $guncelle=$this->m_tr_model->updateTable("options_general",array(
                        "site_logo_alt" => $this->input->post("twitter")
                    ),array("id" => 1));
                }else{
                    $f1="";
                    $resim_url = "../upload/logo/200x40/".$ayarlar->site_logo;
                    if(file_exists($resim_url)):
                        unlink($resim_url);
                    endif;
                    $target_dir = "../upload/logo/200x40/";
                    $target_file = $target_dir . basename($_FILES["file"]["name"]);
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $newfilename = permalink($ayarlar->site_name. "-logo-").".". $imageFileType;
                    if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType=="webp" || $imageFileType=="svg") {
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $newfilename)) {
                            $f1 = $newfilename;
                        }
                    }
                    if($f1!=""){

                        $guncelle=$this->m_tr_model->updateTable("options_general",array(
                            "site_logo" => $f1,
                            "site_logo_alt" => $ayarlar->site_name." Logo"
                        ),array("id" => 1));

                    }

                }
            }else if($_POST["fav"]){
                if ($_FILES["file2"]["tmp_name"] != "") {
                    $viewData->err = "";
                    $target_dir = "../upload/logo/32x32/";
                    $target_file = $target_dir . basename($_FILES["file2"]["name"]);
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    $newfilename = "favicon.". $imageFileType;
                    if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "ico") {
                        if (move_uploaded_file($_FILES["file2"]["tmp_name"], $target_dir . $newfilename)) {
                            $f2 = $newfilename;
                            $guncelle=$this->m_tr_model->updateTable("options_general",array(
                                "favicon" => $f2
                            ),array("id" => 1));
                        }
                    }
                }
            }else {
                if ($_POST["logo2"]) {
                    if($_FILES["file3"]["tmp_name"]==""){
                        $guncelle=$this->m_tr_model->updateTable("options_general",array(
                            "site_logo_alt" => $this->input->post("twitter2")
                        ),array("id" => 1));
                    }else{
                        $f1="";
                        $resim_url = "../upload/logo/200x40/".$ayarlar->site_logo;
                        if(file_exists($resim_url)):
                            unlink($resim_url);
                        endif;
                        $target_dir = "../upload/logo/200x40/";
                        $target_file = $target_dir . basename($_FILES["file3"]["name"]);
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $newfilename = permalink($ayarlar->site_name. "-logo-").".". $imageFileType;
                        if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType=="webp" || $imageFileType=="svg") {
                            if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_dir . $newfilename)) {
                                $f1 = $newfilename;
                            }
                        }
                        if($f1!=""){
                            $guncelle=$this->m_tr_model->updateTable("options_general",array(
                                "site_logo_light" => $f1,
                                "site_logo_light_alt" => $ayarlar->site_name." Logo"
                            ),array("id" => 1));
                        }
                    }
                }
            }
            $this->load->view('blank',$viewData);
    }
    

    public function pass_opt_index(){

        $this->viewFile="opt_contact";
        $this->viewFolder="pass_change_items";
        $this->load->helper("functions_helper");

        $items=$this->m_tr_model->getTableSingle("ft_users",array("id" => 26));
        $viewData=new stdClass();
        $viewData->items="";
        if($items){
            $viewData->items=$items;
        }else{
            $viewData->items="";
        }

        $viewData->pageTitle="Şifre Ayarları - ".$ayarlar->site_name;
        $this->load->view('blank',$viewData);
    }

        //Contact Save
        public function contact_add_update(){
            if($this->formControl==$this->session->userdata("formCheck")){
                if($_POST){
                    $kontrol=$this->m_tr_model->getTable("bk_opt_contact");
                    if($kontrol){
                        $guncelle_kaydet=$this->m_tr_model->updateTable("bk_opt_contact",
                            array(
                                "tel1"  =>  $this->input->post("tel1"),
                                "tel2"  =>  $this->input->post("tel2"),
                                "tel1_v"  =>  str_replace(" ","",$this->input->post("tel1")),
                                "tel2_v"  =>  str_replace(" ","",$this->input->post("tel2")),
                                "email"  =>  $this->input->post("email"),
                                "email2"  =>  $this->input->post("email2"),
                                "address"  =>  $this->input->post("address"),
                                "il"  =>  $this->input->post("il"),
                                "ilce"  =>  $this->input->post("ilce"),
                                "map"  =>  $this->input->post("map"),
                                "work_time"  =>  $this->input->post("worktime"),
                                "mmail"  =>  $this->input->post("mmail"),
                                "mad"  =>  $this->input->post("mad"),
                                "mhost"  =>  $this->input->post("mhost"),
                                "muser"  =>  $this->input->post("muser"),
                                "mpass"  =>  $this->input->post("mpass"),
                                "mport"  =>  $this->input->post("mport"),
                                "fax"  =>  $this->input->post("fax")

                            ),array("id" => 1));
                    }else{
                        $guncelle_kaydet=$this->m_tr_model->add_new(
                            array(
                                "tel1"  =>  $this->input->post("tel1"),
                                "tel2"  =>  $this->input->post("tel2"),
                                "tel1_v"  =>  str_replace(" ","",$this->input->post("tel1")),
                                "tel2_v"  =>  str_replace(" ","",$this->input->post("tel2")),
                                "email"  =>  $this->input->post("email"),
                                "email2"  =>  $this->input->post("email2"),
                                "address"  =>  $this->input->post("address"),
                                "il"  =>  $this->input->post("il"),
                                "ilce"  =>  $this->input->post("ilce"),
                                "map"  =>  $this->input->post("map"),
                                "work_time"  =>  $this->input->post("worktime"),
                                "mmail"  =>  $this->input->post("mmail"),
                                "mad"  =>  $this->input->post("mad"),
                                "mhost"  =>  $this->input->post("mhost"),
                                "muser"  =>  $this->input->post("muser"),
                                "mpass"  =>  $this->input->post("mpass"),
                                "mport"  =>  $this->input->post("mport"),
                                "fax"  =>  $this->input->post("fax")
                            ),"bk_opt_contact");
                    }
                    if($guncelle_kaydet){
                        echo true;
                    }else{
                        echo false;
                    }
                }else{
                    $this->load->view("errors/404");
                }
            }else{
                $this->load->view("errors/404");
                // $this->load->view("errors/404");
            }
        }

    public function pass_update(){

        if($this->formControl==$this->session->userdata("formCheck")){
            if($_POST){
                $kontrol=$this->m_tr_model->getTable("ft_users");
                if($kontrol){
                    if($this->input->post("p1") == $this->input->post("p2")){
                        $guncelle_kaydet=$this->m_tr_model->updateTable("ft_users",
                            array(
                                "user_m_kad" => $this->input->post("kad"),
                                "user_m_pass" => md5(sha1(md5($this->input->post("p1"))))

                            ),array("id" => 26));
                        if($guncelle_kaydet){
                            echo "1";
                        }else{
                            echo "4";
                        }

                    }else{
                        echo "2";
                    }

                }else{

                }

            }else{
                $this->load->view("errors/404");
            }
        }else{
            $this->load->view("errors/404");
            // $this->load->view("errors/404");
        }
    }

    


}

