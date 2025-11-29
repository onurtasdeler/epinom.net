<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron_sms_system extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
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

