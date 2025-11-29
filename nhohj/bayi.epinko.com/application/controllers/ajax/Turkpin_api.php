<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Turkpin_api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //Türkpin kategoriye göre ürün getirir
    public function get_category_product()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $turkpin = new TurkPin();
                    $sonuclar = $turkpin->urunListesi($this->input->post("data"));
                    ?>
                    <label><b>Türkpin </b>Ürün</label>
                    <select name="turkpin_urun_id" class="form-control turkpinoyun">
                        <option value="0">Ürün Seçiniz</option>
                        <?php
                        foreach($sonuclar as $row)
                        {
                            ?>
                            <option  value="<?=$row->id?>"><?=$row->name?> - Fiyat : (<?=$row->price?>) </option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
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


    public function get_product_price()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                $turkpin = new TurkPin();
                $sonuclar = $turkpin->urunListesi($this->input->post("cat"));
                foreach($sonuclar as $row)
                {
                    if($this->input->post("id")==$row->id){
                        $sayi=floor(str_replace(",",".",$row->price)*100)/100;
                        echo $sayi;
                    }
                }


            } else {
                $this->load->view("errors/404df");
            }
        } else {
            $this->load->view("errors/404gf");
        }
    }

    public function get_category_product_2()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $turkpin = new TurkPin();
                    $sonuclar = $turkpin->urunListesi($this->input->post("data"));

                    $str2='	<div class="col-12 col-lg-12 col-form-label" bis_skin_checked="1">
                                <div class="checkbox-list" bis_skin_checked="1">
                                ';

                    foreach($sonuclar as $row)
                    {
                        $vericek=$this->m_tr_model->getTableSingle("table_import_turkpin_product",array("turkpin_cat_id" => $this->input->post("data"),"turkpin_urun_id" => $row->id));
                        if($vericek){
                            if($vericek->status==1){
                                $str2.='<label class="checkbox">
                        <input type="checkbox" checked name="urun'.$this->input->post("data").'[]" value="'.$row->id.'-'.$row->name.'-'.$row->price.'-'.$row->stock.'">
                                    <span></span>'.$row->name.'</label>';
                            }else{
                                $str2.='<label class="checkbox">
                        <input type="checkbox" name="urun'.$this->input->post("data").'[]" value="'.$row->id.'-'.$row->name.'-'.$row->price.'-'.$row->stock.'">
                                    <span></span>'.$row->name.'</label>';
                            }
                        }else{
                            $str2.='<label class="checkbox">
                        <input type="checkbox" name="urun'.$this->input->post("data").'[]" value="'.$row->id.'-'.$row->name.'-'.$row->price.'-'.$row->stock.'">
                                    <span></span>'.$row->name.'</label>';
                        }

                    }
                    $str2.=" </div>
                                </div>";
                    echo $str2;
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
}
