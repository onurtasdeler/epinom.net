<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Functions extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";





    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        loginControl(-1);

        $this->settings = getSettings();

    }





    //AJAX GET RECORD

    public function getRecord()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                

                if($this->input->post("field")){

                    $veri = getRecord($this->input->post("table"), $this->input->post("field"), $this->input->post("data"));

                    echo $veri;

                }else{

                    header('Content-Type: application/json; charset=utf-8');

                    $veri = getTableSingle($this->input->post("table"), array("id" => $this->input->post("data") ));

                    echo json_encode($veri);

                }



            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }



    //AJAX DELETE RECORD

    public function deleteRecord()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if($this->input->post("field")){



                }else{

                    header('Content-Type: application/json; charset=utf-8');

                    $veri = getTableSingle($this->input->post("table"), array("id" => $this->input->post("data") ));

                    if($veri){

                        $sil=$this->m_tr_model->delete($this->input->post("table"),array($this->input->post("deleteField") => $this->input->post("data")));

                        if($sil){

                            echo json_encode(array("hata" => "yok"));

                        }else{

                            echo json_encode(array("hata" => "var"));

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



    //AJAX CHANGE STATUS

    public function statusChange($id='')

    {

        if(($id!="") and (is_numeric($id)) ){

            if($_POST){

                $items=getTableSingle($this->input->post("table"),array("id" => $id));

                if($items){

                    $isActive=($this->input->post("data") === "true") ? 1 : 0;

                    $update=$this->m_tr_model->updateTable($this->input->post("table"),array(($this->input->post("type") == 1 ? "havale_status":"status") => $isActive),array("id" => $id));

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



    public function imageDelete(){

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if($this->input->post("table")=="table_theme_options"){

                      if($this->input->post("tur")==2){

                          img_delete("icon"."/".getTableSingle("table_theme_options",array("id" => 1))->home_populer_image_urun);

                          $guncelle=$this->m_tr_model->updateTable($this->input->post("table"),array("home_populer_image_urun" => ""),array("id" => 1));

                          if($guncelle){

                              header('Content-Type: application/json; charset=utf-8');

                              echo json_encode(array("hata" => "yok" ,"message" => "Resim başarılı şekilde silindi"));

                          }else{

                              header('Content-Type: application/json; charset=utf-8');

                              echo json_encode(array("hata" => "var" ,"message" => "Resim silme başarısız."));

                          }

                      }else{

                          img_delete("icon"."/".getTableSingle("table_theme_options",array("id" => 1))->home_populer_img_1);

                          $guncelle=$this->m_tr_model->updateTable($this->input->post("table"),array("home_populer_img_1" => ""),array("id" => 1));

                          if($guncelle){

                              header('Content-Type: application/json; charset=utf-8');

                              echo json_encode(array("hata" => "yok" ,"message" => "Resim başarılı şekilde silindi"));

                          }else{

                              header('Content-Type: application/json; charset=utf-8');

                              echo json_encode(array("hata" => "var" ,"message" => "Resim silme başarısız."));

                          }

                      }

                }else{

                    $cek=$this->m_tr_model->query("select *,".$this->input->post("field")." as kosul from ".$this->input->post("table")." where id=".$this->input->post("data"));

                    if($cek){

                        if($cek[0]->kosul){

                            img_delete($this->input->post("folder")."/".$cek[0]->kosul);

                            $guncelle=$this->m_tr_model->updateTable($this->input->post("table"),array($this->input->post("field") => ""),array("id" => $cek[0]->id));

                            if($guncelle){

                                header('Content-Type: application/json; charset=utf-8');

                                echo json_encode(array("hata" => "yok" ,"message" => "Resim başarılı şekilde silindi"));

                            }else{

                                header('Content-Type: application/json; charset=utf-8');

                                echo json_encode(array("hata" => "var" ,"message" => "Resim silme başarısız."));

                            }

                        }



                    }

                }



            }

        }

    }



}

