<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Language extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
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

    //sepet detay
    public function getVal()
    {
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    if ($this->input->post("data", true)) {
                        langS($this->input->post("data"));
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "Language Getval ", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", " Language Getval  POST", 3);
            }
        } catch (Exception $ex) {

            addLog("Language AJAX getval hatası"," Laguage getVal catch");
        }

    }

}


