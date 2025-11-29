<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Adsorders extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "orders/ads_orders_list";

    public $viewFile = "blank";

    public $tables = "table_orders_adverts";

    public $baseLink = "ilan-siparisler";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        $this->load->helper("netgsm_helper");

        loginControl(84);

        $this->settings = getSettings();

    }



    //index

    public function index()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);



        if($this->input->get("u")){

            $cekk=getTableSingle("table_users",array("id" => $this->input->get("u")));

            if($cekk){

                $page = array(

                    "pageTitle" => "İlan sipariş Yönetimi - " . $this->settings->site_name,

                    "subHeader" => "İlan sipariş Yönetimi - <a href='" . base_url("ilan-siparisler") . "'>İlan Siparişleri</a>",

                    "h3" => "<a href='".base_url("uye-guncelle/".$cekk->id)."'><b class='text-info'>".$cekk->nick_name."</b></a> Adlı Üyeye Ait İlan Siparişleri",

                    "btnText" => "", "btnLink" => base_url("ilan-ekle"));

            }else{

                redirect(base_url("ilan-siparisler"));

            }

        }else{

            $page = array(

                "pageTitle" => "İlan Sipariş Yönetimi - " . $this->settings->site_name,

                "subHeader" => "İlan Sipariş Yönetimi - <a href='" . base_url("ilan-siparisler") . "'>İlan Siparişleri</a>",

                "h3" => "Sipariş",

                "btnText" => "", "btnLink" => base_url("ilan-ekle"));

        }





        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }



    //LİST TABLE AJAX

    public function list_table()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $u="";

                $u2="";

                if($this->input->get("u")){

                    $u=" where s.user_id = ".$this->input->get("u");

                    $u2="  s.user_id = ".$this->input->get("u")." and ";

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s ".$u." and s.is_delete=0");



                }else{

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.is_delete=0 ");

                }

                $sql = "select s.id as ssid,us.magaza_name as mname,s.status,s.kullanici_iptal,s.created_at as cdate,s.sell_at as sl,s.quantity,s.price_total,pp.type as tt,s.price,s.user_id as userid,s.sell_user_id as selluserid,s.sipNo,pp.ad_name,s.advert_id,us.nick_name as saticiadi,u.nick_name as uyeadi,us.id as tss,s.invoice_id,s.invoice_date from " . $this->tables . " as s  ";

                $join = " 

        left join table_users as u on s.user_id=u.id 

        left join table_users as us on s.sell_user_id=us.id 

        left join table_adverts as pp on s.advert_id=pp.id";

                $where = [];

                $order = ['cdate', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {



                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "image_urun" && $column["data"] != "sl" && $column["data"] != "status" && $column["data"] != "cdate" && $column["data"] != "price" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" && $column["data"] != "tt") {

                            if (!empty($column['search']['value'])) {

                                $where[] = str_replace("saticiadi","us.full_name",str_replace("uyeadi","u.full_name",$column['data'])) . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';

                            } else {

                                $where[] =  str_replace("saticiadi","us.full_name",str_replace("uyeadi","u.full_name",$column['data'])) . ' LIKE "%' . $_POST['search']['value'] . '%" ';

                            }

                        }

                    }

                } else {

                    foreach ($_POST['columns'] as $column) {

                        if (!empty($column['search']['value'])) {

                            $where[] = $column['data'] . ' LIKE "%' . $column['search']['value'] . '%" ';

                        }

                    }

                }





                if (count($where) > 0) {

                    if($u){

                        $sql .= $join . ' WHERE (s.is_delete=0 and s.user_id = '.$this->input->get("u").') and ( ' . implode(' or ', $where) . " )  ";



                    }else{

                        $sql .= $join . ' WHERE  s.is_delete=0 and ( ' . implode(' or ', $where) . " ) ";



                    }

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    if($u){

                        $sql .= $join ." ".$u."  order by " . $order[0] . " " . $order[1] . " ";

                    }else{

                        $sql .= $join ." where s.is_delete=0  order by " . $order[0] . " " . $order[1] . " ";

                    }

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }





                $veriler = $this->m_tr_model->query($sql);

                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {



                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE  '.$u2." s.is_delete=0 and ( ". implode(' or ', $where) : ' ) ') . " )  ");



                } else {

                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join." where s.is_delete=0");



                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                foreach ($veriler as $veri) {

                    $user = getTableSingle("table_users", array("id" => $veri->selluserid));
                    $user2 = getTableSingle("table_users", array("id" => $veri->userid));

                    $response["data"][] = [

                        "ssid" => $veri->ssid,

                        "ad_name" => $veri->ad_name,

                        "sipNo" => $veri->sipNo,

                        "userid" => $veri->userid,

                        "tss" => $veri->tss,

                        "selluserid" => $veri->selluserid,

                        "advert_id" => $veri->advert_id,

                        "saticiadi" => $veri->saticiadi,

                        "uyeadi" => $user2->email,

                        "mname" => $user->email,

                        "price" => $veri->price,

                        "quantity" => $veri->quantity,

                        "kullanici_iptal" => $veri->kullanici_iptal,

                        "price_total" => $veri->price_total,

                        "cdate" => $veri->cdate,

                        "status" => $veri->status,

                        "tt" => $veri->tt,

                        "sl" => $veri->sl,

                        "invoice_id"=>$veri->invoice_id,
                        "invoice_date"=>$veri->invoice_date,

                        "action" => [

                            [

                                "title" => "Düzenle",

                                "url" => "asd.hmtl",

                                'class' => 'btn btn-primary'

                            ],

                            [

                                "title" => "Sil",

                                "url" => "asdf.hmtl",

                                'class' => 'btn btn-danger'

                            ]

                        ]

                    ];

                }

                echo json_encode($response);



            }

        }



    }





    //UPDATE

    public function actions_update($id)

    {

        $kontrol = getTableSingle($this->tables, array("id" => $id));

        if ($kontrol) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);

            $page = array(

                "pageTitle" => $kontrol->name . " Sipariş Bilgileri  - " . $this->settings->site_name,

                "subHeader" => "İlan Sipariş Yönetimi - <a href='" . base_url("ilan-siparisler") . "'>İlan Siparişleri</a> - İlan Sipariş Bilgileri ",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->sipNo . "</strong> - İlan Sipariş Güncelle ");

            if ($_POST) {

                header('Content-Type: application/json');



                if ($this->formControl == $this->session->userdata("formCheck")) {

                    if ($veri["err"] != true) {

                        $enc = "";

                        $urun = getTableSingle("table_adverts", array("id" => $kontrol->advert_id));



                        if($this->input->post("status")==0){

                            //beklemede

                            //alıcıya ve satıcıya bildirim

                        }else if($this->input->post("status")==1){

                            echo json_encode(array("err" => true, "tur" => 1, "message" => "Bu işlem manuel yapılamaz. Üye Onayı Beklenmektedir."));

                        }else if($this->input->post("status")==2){

                            echo json_encode(array("err" => true, "tur" => 1, "message" => "Bu işlem manuel yapılamaz. Alıcı Onayı Beklenmektedir."));



                        }else if($this->input->post("status")==3){

                            if($kontrol->status==2){

                                $guncelleDate=date("Y-m-d H:i:s");

                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(

                                    "status" => 3,

                                    "admin_onay_at" => $guncelleDate

                                ),array("id" => $kontrol->id));
                                
                                if($guncelle){

                                    $mailBilgiAlici="";

                                    $mailBilgiSatici="";

                                    $users=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));

                                    $useralici=getTableSingle("table_users",array("id" => $kontrol->user_id));

                                    $mailgonderAlici = sendMails($useralici->email, 1, 22, $kontrol);

                                    $mailgonderSatici = sendMails($users->email, 1, 23, $kontrol);

                                    if($mailgonderAlici){ $mailBilgiAlici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiAlici="Mail Gönderilemedi."; }

                                    if($mailgonderSatici){ $mailBilgiSatici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiSatici="Mail Gönderilemedi."; }







                                    addNoti($kontrol->user_id,1,20,$kontrol->advert_id,$kontrol->id);

                                    addNoti($kontrol->sell_user_id,1,19,$kontrol->advert_id,$kontrol->id);



                                    $cekAyar = getTableSingle("table_options_sms", array("id" => 1));

                                    $smsBilgiSatici="Modül Aktif Değil.";

                                    $smsBilgiAlici="Modül Aktif Değil.";

                                    if ($cekAyar->modul_aktif==1) {

                                        try {

                                            $cekSablon = getTableSingle("table_lang_sms_mail", array("order_id" => 6, "lang_id" => $kontrol->teslim_lang));

                                            if ($cekSablon) {

                                                $smsSablon = str_replace("{name}", kisalt($urun->ad_name,20), $cekSablon->value);

                                                $smsSablon = str_replace("{sipno}", $kontrol->sipNo, $smsSablon);

                                                $sms = smsGonder($users->phone, $smsSablon . ". B" . rand(1, 2000));

                                                $sms = explode(" ", $sms);

                                                if ($sms[0] == "00" || $sms[0] == "02") {

                                                    $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";

                                                } else {

                                                    $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";

                                                }

                                            }else{

                                                $smsBilgiSatici="Şablon Bulunamadı.";

                                            }

                                            $cekSablon = getTableSingle("table_lang_sms_mail", array("order_id" => 7, "lang_id" => $kontrol->onay_lang));

                                            if ($cekSablon) {

                                                $smsSablon = str_replace("{name}", kisalt($urun->ad_name,20), $cekSablon->value);

                                                $smsSablon = str_replace("{sipno}", $kontrol->sipNo, $smsSablon);

                                                $users=getTableSingle("table_users",array("id" => $kontrol->user_id));

                                                $sms = smsGonder($users->phone, $smsSablon . ". B" . rand(1, 2000));

                                                $sms = explode(" ", $sms);

                                                if ($sms[0] == "00" || $sms[0] == "02") {

                                                    $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";

                                                } else {

                                                    $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";

                                                }

                                            }else{

                                                $smsBilgiAlici="Şablon Bulunamadı.";

                                            }

                                        } catch (Exception $ex) {

                                            $smsBilgiSatici="APIde hata meydana geldi.";

                                        }

                                    }



                                    $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(

                                        "admin_onay_sms" => $smsBilgiSatici,

                                        "admin_onay_mail" => $mailBilgiSatici,

                                        "admin_onay_email_user" => $mailBilgiAlici,

                                        "admin_onay_sms_user" => $smsBilgiAlici,

                                    ),array("id" => $kontrol->id));



                                    //bakiye previzyon kaldır

                                    $bakiyeDus=$this->m_tr_model->updateTable("table_users_balance_history",

                                        array("status" => 2,

                                            "update_at" => date("Y-m-d H:i:s")),

                                        array("order_id" => $kontrol->id,"advert_id" => $kontrol->advert_id,"user_id" => $kontrol->user_id));

                                    $cekAyar = getTableSingle("table_options", array("id" => 1));

                                    $kazancKaydet=$this->m_tr_model->add_new(array(

                                        "user_id" => $kontrol->sell_user_id,

                                        "advert_id" => $kontrol->advert_id,

                                        "order_id" => $kontrol->id,

                                        "is_blocked" => 1,

                                        "created_at" => date("Y-m-d H:i:s"),

                                        "unblocked_at" =>  date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s")))),

                                        "price" => $kontrol->price_total,

                                        "cash_price" => $kontrol->kom_kazanc,

                                        "commission" => $kontrol->kom_tutar

                                    ),"table_users_ads_cash");



                                    if($kazancKaydet){

                                        $ceksaticii=getTableSingle("table_users",array("id" =>  $kontrol->sell_user_id));



                                        $logEkle=$this->m_tr_model->add_new(array(

                                            "date" => date("Y-m-d H:i:s"),

                                            "status" => 1,

                                            "order_id" => $kontrol->id,

                                            "advert_id" => $kontrol->advert_id,

                                            "mesaj_title" => "Satıcıya Bakiye Aktarılacak.",

                                            "mesaj" => $kontrol->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklendi.".date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s"))))." tarihinde satıcının hesabına geçecek."

                                        ),"bk_logs");

                                    }else{

                                        $logEkle=$this->m_tr_model->add_new(array(

                                            "date" => date("Y-m-d H:i:s"),

                                            "status" => 3,

                                            "order_id" => $kontrol->id,

                                            "advert_id" => $kontrol->advert_id,

                                            "mesaj_title" => "Satıcıya Bakiye Aktarılırken Kritik Hata",

                                            "mesaj" => $kontrol->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklenirken kritik hata meydana geldi."

                                        ),"bk_logs");

                                    }



                                    $logEkle=$this->m_tr_model->add_new(array(

                                        "date" => date("Y-m-d H:i:s"),

                                        "status" => 1,

                                        "order_id" => $kontrol->id,

                                        "advert_id" => $kontrol->advert_id,

                                        "mesaj_title" => "İlan Siparişi Onaylandı",

                                        "mesaj" => $kontrol->sipNo." No'lu İlan Siparişi Tamamlandı olarak güncellendi."

                                    ),"bk_logs");



                                    echo json_encode(array("err" => false, "tur" => 1, "message" => "İşlem Başarılı"));

                                    exit;

                                }



                            }else if($kontrol->status==1){

                                echo json_encode(array("err" => true, "tur" => 1, "message" => "Alıcı Onayı tamamlanmadan sipariş onaylanamaz."));

                            }else if($kontrol->status==0){

                                echo json_encode(array("err" => true, "tur" => 1, "message" => "Satıcı ve Alıcı Onayı tamamlanmadan sipariş onaylanamaz."));

                            }else if($kontrol->status==4){

                                echo json_encode(array("err" => true, "tur" => 1, "message" => "Bu sipariş daha önce iptal edilmiştir. Tekrar onaylanamaz."));

                            }



                            //tamamlandı

                            //alıcıya ve satıcıya sms bildirim email

                            //alıcının bakiye logunu bakiyeden düşüldü olarak

                            //24 saat sonra

                        }else if($this->input->post("status")==4){

                            if($kontrol->status==1 || $kontrol->status==0 ||  $kontrol->status==2 || $kontrol->status==3){



                                $guncelleDate=date("Y-m-d H:i:s");

                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(

                                    "status" => 4,

                                    "admin_red_at" => $guncelleDate,"red_nedeni" =>  $this->input->post("rednedeni")

                                ),array("id" => $kontrol->id));

                                $kontrol=getTableSingle("table_orders_adverts",array("id" => $kontrol->id));



                                if($guncelle){

                                    $mailBilgiAlici="";

                                    $mailBilgiSatici="";

                                    $users=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));

                                    $useralici=getTableSingle("table_users",array("id" => $kontrol->user_id));







                                    $users=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));

                                    $useralici=getTableSingle("table_users",array("id" => $kontrol->user_id));

                                    $mailgonderAlici = sendMails($useralici->email, 1, 25, $kontrol);

                                    $mailgonderSatici = sendMails($users->email, 1, 24, $kontrol);

                                    if($mailgonderAlici){ $mailBilgiAlici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiAlici="Mail Gönderilemedi."; }

                                    if($mailgonderSatici){ $mailBilgiSatici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiSatici="Mail Gönderilemedi."; }





                                    addNoti($kontrol->user_id,2,22,$kontrol->advert_id,$kontrol->id);

                                    addNoti($kontrol->sell_user_id,2,21,$kontrol->advert_id,$kontrol->id);



                                    $cekAyar = getTableSingle("table_options_sms", array("id" => 1));

                                    $smsBilgiSatici="Modül Aktif Değil.";

                                    $smsBilgiAlici="Modül Aktif Değil.";

                                    if ($cekAyar->modul_aktif==1) {

                                        try {

                                            $cekSablon = getTableSingle("table_lang_sms_mail", array("order_id" => 9, "lang_id" => $kontrol->teslim_lang));

                                            if ($cekSablon) {

                                                $smsSablon = str_replace("{name}", kisalt($urun->ad_name,20), $cekSablon->value);

                                                $smsSablon = str_replace("{sipno}", $kontrol->sipNo, $smsSablon);

                                                $sms = smsGonder($users->phone, $smsSablon . ". B" . rand(1, 2000));

                                                $sms = explode(" ", $sms);

                                                if ($sms[0] == "00" || $sms[0] == "02") {

                                                    $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";

                                                } else {

                                                    $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";

                                                }

                                            }else{

                                                $smsBilgiSatici="Şablon Bulunamadı.";

                                            }

                                            $cekSablon = getTableSingle("table_lang_sms_mail", array("order_id" => 8, "lang_id" => $kontrol->onay_lang));

                                            if ($cekSablon) {

                                                $smsSablon = str_replace("{name}", kisalt($urun->ad_name,20), $cekSablon->value);

                                                $smsSablon = str_replace("{sipno}", $kontrol->sipNo, $smsSablon);

                                                $users=getTableSingle("table_users",array("id" => $kontrol->user_id));

                                                $sms = smsGonder($users->phone, $smsSablon . ". B" . rand(1, 2000));

                                                $sms = explode(" ", $sms);

                                                if ($sms[0] == "00" || $sms[0] == "02") {

                                                    $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";

                                                } else {

                                                    $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";

                                                }

                                            }else{

                                                $smsBilgiAlici="Şablon Bulunamadı.";

                                            }

                                        } catch (Exception $ex) {

                                            $smsBilgiSatici="APIde hata meydana geldi.";

                                        }

                                    }



                                    $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(

                                        "red_sms" => $smsBilgiSatici,

                                        "red_mail" => $mailBilgiSatici,

                                        "red_user_mail" => $mailBilgiAlici,

                                        "red_user_sms" => $smsBilgiAlici,

                                        "red_nedeni" => $this->input->post("rednedeni"),

                                    ),array("id" => $kontrol->id));



                                    //bakiye previzyon kaldır

                                    $bakiyeDus=$this->m_tr_model->updateTable("table_users_balance_history",

                                        array("status" => 3,

                                            "update_at" => date("Y-m-d H:i:s")),

                                        array("order_id" => $kontrol->id,"advert_id" => $kontrol->advert_id,"user_id" => $kontrol->user_id));

                                    $useralici=getTableSingle("table_users",array("id" => $kontrol->user_id));

                                    $islem=$useralici->balance + $kontrol->price;

                                    $guncelleBakiye=$this->m_tr_model->updateTable("table_users",array("balance" => $islem),array("id" => $useralici->id));

                                    if($guncelleBakiye){

                                        $logEkle=$this->m_tr_model->add_new(array(

                                            "date" => date("Y-m-d H:i:s"),

                                            "status" => 2,

                                            "order_id" => $kontrol->id,

                                            "advert_id" => $kontrol->advert_id,

                                            "mesaj_title" => "Bakiye İade Edildi..",

                                            "mesaj" => $kontrol->sipNo." no'lu ".$urun->ad_name." adlı ilan siparişi iptal edildi.".$kontrol->price." TL tutarındaki Bakiye Alıcıya iade edildi."

                                        ),"bk_logs");



                                    }else{

                                        $logEkle=$this->m_tr_model->add_new(array(

                                            "date" => date("Y-m-d H:i:s"),

                                            "status" => 3,

                                            "order_id" => $kontrol->id,

                                            "advert_id" => $kontrol->advert_id,

                                            "mesaj_title" => "İlan Sipariş İptali Bakiye İadesi Kritik Hata",

                                            "mesaj" => $kontrol->sipNo." no'lu ".$urun->ad_name." adlı ilan siparişi iptal edildi.".$kontrol->price." TL tutarındaki Bakiye Alıcıya iade edilirken hata meydana geldi.."

                                        ),"bk_logs");

                                    }

                                    $logEkle=$this->m_tr_model->add_new(array(

                                        "date" => date("Y-m-d H:i:s"),

                                        "status" => 2,

                                        "order_id" => $kontrol->id,

                                        "advert_id" => $kontrol->advert_id,

                                        "mesaj_title" => "İlan Siparişi İptal Edildi",

                                        "mesaj" => $kontrol->sipNo." No'lu İlan Siparişi İptal Edildi olarak güncellendi."

                                    ),"bk_logs");

                                    echo json_encode(array("err" => false, "tur" => 1, "message" => "Sipariş Başarılı Şekilde İptal Edildi."));

                                    exit;

                                }

                            }

                        }

                    } else {

                        $data = array("err" => true, "tur" => 13, "data" => "Üye Bakiyesi Yetersiz");

                        pageCreate($view, $data, $page, $_POST);



                    }

                }

            } else {

                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);

            }

        } else {

            redirect(base_url("404"));

        }





    }



    //AJAX GET RECORD

    public function get_record()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                $veri = getRecord($this->tables, "ad_name", $this->input->post("data"));

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

                    if ($kontrol)

                        $guncelle = $this->m_tr_model->updateTable($this->tables, array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                            array("id" => $kontrol->id));

                    $guncelle = $this->m_tr_model->updateTable("table_orders_adverts_message", array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                        array("advert_id" => $kontrol->advert_id));

                    $guncelle = $this->m_tr_model->updateTable("table_talep", array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                        array("advert_id" => $kontrol->advert_id,"order_id" => $kontrol->id ));

                    $guncelle = $this->m_tr_model->updateTable("table_users_balance_history", array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                        array("advert_id" => $kontrol->advert_id,"order_id" => $kontrol->id));

                    //$sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

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

    }



    //Ajax Img DELETE

    public function action_img_delete()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $tur = $this->input->post("tur");



                        $cekResim = $this->m_tr_model->getTableSingle("table_adverts_upload_image", array("id" => $tur));

                        if ($cekResim) {

                            img_delete("ilanlar_users/" . $cekResim->image);

                            $guncelle = $this->m_tr_model->delete("table_adverts_upload_image", array("id" => $cekResim->id));

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

                    $this->load->view("errors/404s");

                }

            } else {

                $this->load->view("errors/404d");

            }

        }

    }



    //AJAX İS ACTİVE SET

    public function isActiveSetter($id = '')

    {

        if (($id != "") and (is_numeric($id))) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array("status" => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }



    //AJAX İS ACTİVE SET SPECIAL

    public function isSetter($types = '', $id)

    {

        if (($id != "") and (is_numeric($id)) and ($types != "")) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array($types => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }



    public function get_category()

    {

        if ($_POST) {

            $data = $this->input->post("data");

            $tur = $this->input->post("tur");

            if ($data && $tur) {

                if ($tur == 1) {

                    $kont = getTableOrder("table_advert_category", array("parent_id" => 0, "top_id" => $data, "status" => 1,), "name", "asc");

                    if ($kont) {

                        $str .= "<option value=''>Seçiniz</option>";

                        foreach ($kont as $item) {

                            $str .= "<option value='" . $item->id . "'>" . $item->name . "</option>";

                        }

                        echo $str;

                    }

                } else if ($tur == 2) {

                    $kk = getTableSingle("table_advert_category", array("id" => $data));

                    $kont = getTableOrder("table_advert_category", array("parent_id " => $data, "top_id" => $kk->top_id, "status" => 1,), "name", "asc");

                    if ($kont) {

                        $str .= "<option value=''>Seçiniz</option>";

                        foreach ($kont as $item) {

                            $str .= "<option value='" . $item->id . "'>" . $item->name . "</option>";

                        }

                        echo $str;

                    } else {

                        $str .= "<option value=''><Alt></Alt> Kategori Bulunamadı.</option>";

                        echo $str;

                    }

                }

            }

        } else {

            redirect(base_url(404));

        }

    }



    public function getAdsCommission()

    {

        try {

            if ($_POST) {



                header('Content-Type: application/json');

                if ($this->input->post("data", true)) {

                    $data = str_replace(",", ".", $this->input->post("data"));

                    if ($this->input->post("top", true)) {

                        if ($this->input->post("parent", true)) {

                            if ($this->input->post("parent", true) == 0) {

                                $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("top", true)));

                                if ($cek) {

                                    if (substr($this->input->post("data"), -1) != ".") {

                                        if (is_numeric($data)) {

                                            $islem = $data - (($cek->commission * $data) / 100);

                                            echo json_encode(array("kom" => $cek->commission, "veri" => number_format($islem, 2)));

                                        }

                                    }

                                }

                            } else {

                                $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("parent", true)));

                                if ($cek) {

                                    if (substr($this->input->post("data"), -1) != ".") {

                                        if (is_numeric($data)) {

                                            $islem = $data - (($cek->commission * $data) / 100);

                                            echo json_encode(array("kom" => $cek->commission, "veri" => number_format($islem, 2)));

                                        }

                                    }

                                }

                            }

                        } else {

                            $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("top", true)));

                            if ($cek) {

                                if (substr($this->input->post("data"), -1) != ".") {

                                    if (is_numeric($data)) {

                                        $islem = $data - (($cek->commission * $data) / 100);

                                        echo json_encode(array("kom" => $cek->commission, "veri" => number_format($islem, 2)));

                                    }

                                }

                            }

                        }

                    }

                } else {

                }



            } else {

            }

        } catch (Exception $ex) {

        }



    }



    public function stock_product_update_cron(){

        $this->load->model("m_tr_model");

        $cek=$this->m_tr_model->getTable("table_products",array("status" => 1,"is_stock" => 0,"is_api" => 0));

        if($cek){

            foreach ($cek as $item) {

                $stokCek=$this->m_tr_model->getTable("table_products_stock",array("p_id" => $item->id,"status" => 1));

                if($stokCek){

                    $guncelle=$this->m_tr_model->updateTable("table_products",array("stok" => count($stokCek)),array("id" => $item->id ));

                }else{

                    $guncelle=$this->m_tr_model->updateTable("table_products",array("stok" => 0),array("id" => $item->id ));

                }

            }

        }

    }

    public function create_invoice($id) {
        $this->load->library('Parasutlib');
        $order = getTableSingle("table_orders_adverts",array("id"=>$id));
        if($order) {
            $this->parasutlib->create_invoice($order,true);
        }
        header('Location:' .base_url("ilan-siparisler"));
    }
	public function show_invoice($invoice_id) {
		$this->load->library('Parasutlib');
        $order = getTableSingle("table_orders_adverts",array("invoice_id"=>$invoice_id));
        if($order) {
            $this->parasutlib->show_invoice($order);
        } else {
            echo "Sipariş bulunamadı";
        }
	}
}

