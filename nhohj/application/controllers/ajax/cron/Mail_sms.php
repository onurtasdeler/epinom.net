<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mail_sms extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
    }

    public function index($token = "")
    {


        $this->mails_cron();
        sleep(1);

    }


    private function mails_cron()
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
                            $uye=getTableSingle("table_users",array("id" => $m->user_id));
                            if($uye){
                                if($item->category_id!=""){
                                    foreach (json_decode($item->category_id) as $itemc) {
                                        $kat=$this->m_tr_model->getTableSingle("table_products_category",array("id" => $itemc));
                                        if($kat){
                                            $veri=str_replace("[kategori_adi]",$kat->c_name,$item->content);
                                            $veri=str_replace("[musteri_adi]",$uye->full_name,$veri);
                                            $verisub=str_replace("[kategori_adi]",$kat->c_name,$item->subject);
                                            $verisub=str_replace("[musteri_adi]",$uye->full_name,$verisub);

                                            $veri=str_replace("[kategori_resim]","<img style='width:400px' src='".$this->m_tr_model->getTableSingle("options_general",array("id" => 1))->site_link."/upload/category/".$kat->image."'>",$veri);
                                            $sendMail=sendMails($m->mail_adresi,1,-1,"",array("content" => str_replace("[musteri_adi]",$uye->full_name,$veri),"konu" => $verisub));
                                            if($sendMail){
                                                sleep(1);
                                                $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 1,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                            }else{
                                                $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                            }
                                        }

                                    }
                                }else{
                                    $sendMail=sendMails($m->mail_adresi,1,-1,"",array("content" => str_replace("[musteri_adi]",$uye->full_name,$item->content),"konu" => $item->subject));
                                    if($sendMail){
                                        $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 1,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                    }else{
                                        $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                    }
                                }


                            }else{
                                $guncelle=$this->m_tr_model->updateTable("t_mail_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                //$sendMail=sendMails($m->mail_adresi,1,-1,"","verification",0,array("content" => $item->content,"konu" => $item->subject));
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

    private function sms_cron()
    {
        if($_SESSION["userAdmin"]["id"]==2){
            echo json_encode(array("hata" => "var","message" => "Demo hesabında işlem yetkiniz yoktur."));
        }else{
            $cek=getTableOrder("t_sms_job_grup",array("status" => 0),"gonderim_tarih","asc");
            if($cek){
                foreach ($cek as $item) {
                    $secilenTarih = new DateTime($item->gonderim_tarih);
                    $simdi = new DateTime();
                    if($secilenTarih<$simdi){
                        $mailler=getTableOrder("t_sms_job",array("job_grup_id" => $item->id,"status" => 0),"id","asc");

                        if($mailler){
                            foreach ($mailler as $m) {
                                $uye=getTableSingle("t_customer",array("phone" => $m->mail_adresi));
                                if($uye){

                                    $cevir=str_replace("[musteri_adi]",$uye->name_surname,$item->subject);
                                    $sms=sendSms($m->mail_adresi,$cevir,"manuel");
                                }else{
                                    $cevir=str_replace("[musteri_adi]","Müşterimiz",$item->subject);
                                    $sms=sendSms($m->mail_adresi,$cevir,"manuel");
                                }
                                if($sms){
                                    $guncelle=$this->m_tr_model->updateTable("t_sms_job",array("status" => 1,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
                                }else{
                                    $guncelle=$this->m_tr_model->updateTable("t_sms_job",array("status" => 2,"islem_tarihi" => date("Y-m-d H:i:s")),array("id" => $m->id));
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
}

