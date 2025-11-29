<?php
defined('BASEPATH') or exit('No direct script access allowed');

class adverts_update extends CI_Controller
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

    public function advertUpdateNoStock($id = "")
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // İzin verilen domainlerin listesi
            $parsedUrl = parse_url(base_url());
            $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

            $izinVerilenDomainler = array(
                $domain
            );

            // Gelen origin kontrolü
            $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
            // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
            if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                header('Content-Type: application/json');

                // Diğer işlemleri buraya ekleyebilirsiniz
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if ($id) {
                        $temizle = strip_tags($id);
                        $kontrol = getTableSingle("table_adverts", array("user_id" => getActiveUsers()->id, "ilanNo" => $temizle));
                        if ($kontrol) {
                            $orderr = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "is_delete" => 0,"status !=" => 4));


                            if($kontrol->is_updated==1){

                            }else{
                                //sipariş içermiyor
                                $this->load->library("form_validation");
                                $gl = $_SESSION["lang"];
                                $this->form_validation->set_rules("nametr", str_replace("\r\n", "", langS(79, 2, $gl)), "required|trim|min_length[20]|max_length[100]"
                                    , array(
                                        "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),
                                        "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "100", langS(60, 2, $gl)))
                                    ));
                                $this->form_validation->set_rules("icerik_tr", str_replace("\r\n", "", langS(80, 2, $gl)), "required|trim|min_length[20]|max_length[2000]", array(
                                    "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),
                                    "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "2000", langS(60, 2, $gl)))
                                ));
                                $mainCat = getTableSingle("table_advert_category", array("id" => $kontrol->category_main_id));
                                if ($mainCat) {
                                    if ($kontrol->category_top_id != 0) {
                                        $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_top_id, "status" => 1, "is_required" => 1), "id", "asc");
                                        if ($ozel) {
                                            foreach ($ozel as $oz) {
                                                if ($gl == 1) {
                                                    $names = $oz->name_tr;
                                                } else {
                                                    $names = $oz->name_en;
                                                }
                                                $this->form_validation->set_rules("sp" . $oz->id, str_replace("\r\n", "", $names));
                                            }
                                        }
                                    } else {
                                        $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_main_id, "status" => 1, "is_required" => 1), "id", "asc");
                                        if ($ozel) {
                                            foreach ($ozel as $oz) {
                                                if ($gl == 1) {
                                                    $names = $oz->name_tr;
                                                } else {
                                                    $names = $oz->name_en;
                                                }
                                                $this->form_validation->set_rules("sp" . $oz->id, str_replace("\r\n", "", $names));
                                            }
                                        }
                                    }
                                }
                                $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(84, 2, $gl)), "required|trim");
                                $this->form_validation->set_rules("times", str_replace("\r\n", "", langS(85, 2, $gl)), "required|trim");
                                $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim", array(
                                    "required" => langS(102, 2, $gl)
                                ));


                                $this->form_validation->set_message(array(
                                    "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $gl))));
                                $val = $this->form_validation->run();
                                if ($val) {
                                    $up = $kontrol->img_1;
                                    $up2 = $kontrol->img_2;
                                    $up3 = $kontrol->img_3;

                                    ///İsim, başlık ve link bilgileri
                                    $opt = getTableSingle("options_general", array("id" => 1));
                                    $nametr = veriTemizle($this->security->xss_clean($this->input->post("nametr")));
                                    $linktr = permalink($nametr) . "-" . rand(1000000, 9999999);
                                    $desctr = $this->input->post("icerik_tr");
                                    if ($this->input->post("nameen") != "") {
                                        $nameen = veriTemizle($this->security->xss_clean($this->input->post("nameen")));
                                    } else {
                                        $nameen = $nametr;
                                    }
                                    if ($this->input->post("icerik_en") != "") {
                                        $descen = $this->input->post("icerik_en");
                                    } else {
                                        $descen = $desctr;
                                    }
                                    $linken = permalink($nameen) . "-" . rand(1000000, 9999999);
                                    ///İsim, başlık ve link bilgileri
                                    $enc = "";
                                    $getLang = getTable("table_langs", array("status" => 1));
                                    if ($getLang) {
                                        foreach ($getLang as $item) {
                                            if ($item->id == 1) {
                                                $langValue[] = array(
                                                    "lang_id" => $item->id,
                                                    "stitle" => $nametr . " | " . $opt->site_name,
                                                    "sdesc" => $nametr,
                                                    "link" => $linktr,
                                                );
                                            } else {
                                                $langValue[] = array(
                                                    "lang_id" => $item->id,
                                                    "stitle" => $nameen . " | " . $opt->site_name,
                                                    "sdesc" => $nametr,
                                                    "link" => $linken,
                                                );
                                            }

                                        }
                                        $enc = json_encode($langValue);
                                    }

                                    if ($_FILES["fatima"]["tmp_name"] != "") {
                                        if ($_FILES["fatima"]["tmp_name"] != "") {
                                            if ($kontrol->img_1 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_1);
                                            }
                                            $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                            $up = img_upload($_FILES["fatima"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");
                                        }
                                        if ($_FILES["fatima2"]["tmp_name"] != "") {
                                            if ($kontrol->img_2 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_2);
                                            }
                                            $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                            $up2 = img_upload($_FILES["fatima2"], $nametr . "-2-" . rand(1, 234508), "ilanlar", "", "", "");
                                        }
                                        if ($_FILES["fatima3"]["tmp_name"] != "") {
                                            if ($kontrol->img_3 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_3);
                                            }
                                            $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                            $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                        }
                                    } else {
                                        if ($_FILES["fatima2"]["tmp_name"] != "") {
                                            if ($kontrol->img_2 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_2);
                                            }
                                            $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                            $up2 = img_upload($_FILES["fatima2"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");
                                            if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                if ($kontrol->img_3 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_3);
                                                }
                                                $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                        } else {
                                            if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                if ($kontrol->img_3 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_3);
                                                }
                                                $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                        }
                                    }

                                    if ($up || $up2 || $up3) {
                                        $user = getActiveUsers()->id;
                                        $token = $kontrol->token;
                                        if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") < 1000000) {
                                            if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {
                                                $komisyon_oran = $user->magaza_ozel_komisyon;
                                                $komisyon = ($this->input->post("price") * $user->magaza_ozel_komisyon) / 100;
                                                $kazanc = $this->input->post("price") - $komisyon;
                                            } else {
                                                if ($kontrol->category_top_id != 0) {
                                                    if ($kontrol->category_parent_id != 0) {
                                                        $sub = getTableSingle("table_advert_category", array("id" => $kontrol->category_parent_id));
                                                        if ($sub) {
                                                            $komisyon_oran = $sub->commission_stoksuz;
                                                            $komisyon = ($this->input->post("price") * $sub->commission_stoksuz) / 100;
                                                            $kazanc = $this->input->post("price") - $komisyon;
                                                        }
                                                    } else {
                                                        $top = getTableSingle("table_advert_category", array("id" => $kontrol->category_top_id));
                                                        if ($top) {
                                                            $komisyon_oran = $top->commission_stoksuz;
                                                            $komisyon = ($this->input->post("price") * $top->commission_stoksuz) / 100;
                                                            $kazanc = $this->input->post("price") - $komisyon;
                                                        }
                                                    }
                                                } else {
                                                    $komisyon_oran = $mainCat->commission_stoksuz;
                                                    $komisyon = ($this->input->post("price") * $mainCat->commission_stoksuz) / 100;
                                                    $kazanc = $this->input->post("price") - $komisyon;
                                                }
                                            }
                                            $ayar = getTableSingle("table_options", array("id" => 1));
                                            if ($ayar->admin_onay == 1) {
                                                $status = 0;
                                            } else {
                                                $status = 1;
                                            }
                                            $kaydet = $this->m_tr_model->updateTable("table_adverts", array(
                                                "ad_name" => $nametr,
                                                "cat_name" => $mainCat->name,
                                                "ad_name_en" => $nameen,
                                                "delivery_time" => $this->input->post("times"),
                                                "price" => $this->input->post("price", true),
                                                "sell_price" => $kazanc,
                                                "commission" => $komisyon,
                                                "commission_oran" => $komisyon_oran,
                                                "status" => $status,
                                                "update_at" => date("Y-m-d H:i:s"),
                                                "img_1" => $up,
                                                "img_2" => $up2,
                                                "img_3" => $up3,
                                                "desc_en" => $descen,
                                                "desc_tr" => $desctr,
                                                "field_data" => $enc,
                                            ), array("id" => $kontrol->id));
                                            if ($kaydet) {

                                                if($kontrol->category_top_id!=0){

                                                    $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_top_id,"status" => 1),"name","asc");
                                                    if($getSpecial){
                                                        $yt=1;
                                                        foreach ($getSpecial as $item) {
                                                            $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                                            if($cekozel){
                                                                if( $this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                        "value" =>  $this->input->post("sp".$item->id)
                                                                    ),array("id" => $cekozel->id));
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)=="0"){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),array("id" => $cekozel->id));
                                                                    }else{
                                                                        $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                                                    }
                                                                }
                                                            }else{
                                                                if($this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->add_new(array(
                                                                        "spe_id" => $item->id,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "ads_id" => $kontrol->id,
                                                                        "value" =>  $this->input->post("sp_".$item->id)
                                                                    ),"table_adverts_spe_field");
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)==0){
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "spe_id" => $item->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "ads_id" => $kontrol->id,
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),"table_adverts_spe_field");
                                                                    }
                                                                }
                                                            }
                                                            $yt++;
                                                        }
                                                    }
                                                }else{
                                                    $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_main_id,"status" => 1),"name","asc");
                                                    if($getSpecial){
                                                        $yt=1;

                                                        foreach ($getSpecial as $item) {
                                                            $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                                            if($cekozel){
                                                                if( $this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                        "value" =>  $this->input->post("sp".$item->id)
                                                                    ),array("id" => $cekozel->id));
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)=="0"){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),array("id" => $cekozel->id));
                                                                    }else{
                                                                        $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                                                    }
                                                                }
                                                            }else{

                                                                if($this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->add_new(array(
                                                                        "spe_id" => $item->id,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "ads_id" => $kontrol->id,
                                                                        "value" =>  $this->input->post("sp".$item->id)
                                                                    ),"table_adverts_spe_field");
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)==0){
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "spe_id" => $item->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "ads_id" => $kontrol->id,
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),"table_adverts_spe_field");
                                                                    }
                                                                }
                                                            }
                                                            $yt++;
                                                        }
                                                    }
                                                }



                                                if ($status == 0) {
                                                    $us=getActiveUsers();
                                                    $kontrol2=getTableSingle("table_adverts",array("id" => $kontrol->id));
                                                    adminNot(getActiveUsers()->id,"ilan-guncelle/".$kontrol->id,"İlan Mağaza Tarafından Güncellendi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->ad_name." </b> adlı ilanını güncelledi. Tarafınızdan inceleme ve onay bekleniyor");
                                                    $logEkle=$this->m_tr_model->add_new(
                                                        array(
                                                            "user_id" => $us->id,
                                                            "user_email" => $us->email,
                                                            "status" => 1,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "title" => "İlan Güncellendi. Admin onayına gönderildi",
                                                            "description" => $kontrol->ad_name." adlı ilan kullanıcı tarafından güncellendi ve yönetici onayına gönderildi",
                                                            "befores" => json_encode($kontrol),
                                                            "afters" =>json_encode($kontrol2),
                                                        ),"ft_logs"
                                                    );
                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts",array("guncelleme_talep_at" => date("Y-m-d H:i:s"),"is_updated" => 1),array("id" => $kontrol->id));
                                                    echo json_encode(array("hata" => "yok", "message" => langS(104, 2, $gl)));
                                                } else {
                                                    $us=getActiveUsers();
                                                    $kontrol2=getTableSingle("table_adverts",array("id" => $kontrol->id));

                                                    adminNot(getActiveUsers()->id,"ilan-guncelle/".$kontrol->id,"İlan Mağaza Tarafından Güncellendi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->ad_name." </b> adlı ilanını güncelledi. ");
                                                    $logEkle=$this->m_tr_model->add_new(
                                                        array(
                                                            "user_id" => $us->id,
                                                            "user_email" => $us->email,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "title" => "İlan Mağaza Tarafından Güncellendi.",
                                                            "advert_id" => $kontrol->id,
                                                            "befores" => json_encode($kontrol),
                                                            "afters" =>json_encode($kontrol2),
                                                            "status" => 1,
                                                            "description" => $kontrol->ad_name." adlı ilan kullanıcı tarafından güncellendi."
                                                        ),"ft_logs"
                                                    );
                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status" => 1,"guncelleme_talep_at" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                                                    echo json_encode(array("hata" => "yok", "message" => langS(105, 2, $gl)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "message" => langS(106, 2, $gl)));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "type" => "oturum"));
                                        }
                                    } else {
                                        $this->form_validation->set_rules("fatimas", langS(103, 2, $gl), "required|trim", array(
                                            "required" => langS(103, 2, $gl)
                                        ));
                                    }

                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "valid", "message" => validation_errors()));

                                }
                            }

                        }
                    }
                } else {
                    redirect(base_url("404"));
                }

            } else {
                // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                http_response_code(403);
                echo json_encode(['error' => 'İzin verilmeyen origin.']);
            }
        } else {
            // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
            http_response_code(403);
            echo json_encode(['error' => 'Doğrudan erişim yasak.']);
        }

    }

    public function addStocks()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // İzin verilen domainlerin listesi
            $parsedUrl = parse_url(base_url());
            $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

            $izinVerilenDomainler = array(
                $domain
            );

            // Gelen origin kontrolü
            $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
            // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
            if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                header('Content-Type: application/json');

                // Diğer işlemleri buraya ekleyebilirsiniz
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("codes",true) && $this->input->post("uniq",true)){
                        $user=getActiveUsers();
                        if($user){
                            $kontrol=getTableSingle("table_adverts",array("ilanNo" => $this->input->post("uniq",true),"user_id" => $user->id));
                            if($kontrol){
                                $mainCat = getTableSingle("table_advert_category", array("id" => $kontrol->category_main_id));
                                if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {
                                    $komisyon_oran = $user->magaza_ozel_komisyon;
                                    $komisyon = ($kontrol->price * $user->magaza_ozel_komisyon) / 100;
                                    $kazanc = $kontrol->price - $komisyon;
                                } else {
                                    if ($kontrol->category_top_id != 0) {
                                        if ($kontrol->category_parent_id != 0) {
                                            $sub = getTableSingle("table_advert_category", array("id" => $kontrol->category_parent_id));
                                            if ($sub) {
                                                $komisyon_oran = $sub->commission;
                                                $komisyon = ($kontrol->price * $sub->commission) / 100;
                                                $kazanc = $kontrol->price - $komisyon;
                                            }
                                        } else {
                                            $top = getTableSingle("table_advert_category", array("id" => $kontrol->category_top_id));
                                            if ($top) {
                                                $komisyon_oran = $top->commission;
                                                $komisyon = ($kontrol->price * $top->commission) / 100;
                                                $kazanc = $kontrol->price - $komisyon;
                                            }
                                        }
                                    } else {
                                        $komisyon_oran = $mainCat->commission;
                                        $komisyon = ($kontrol->price * $mainCat->commission) / 100;
                                        $kazanc = $kontrol->price - $komisyon;
                                    }
                                }


                                $kaydetStok = $this->m_tr_model->add_new(array(
                                    "ads_id" => $kontrol->id,
                                    "code" => $this->input->post("codes",true),
                                    "status" => 0,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "price" => $kontrol->price,
                                    "komisyon" => $komisyon,
                                    "cash" => $kazanc
                                ), "table_adverts_stock");
                                if($kaydetStok){
                                    $hesap=$kontrol->adet+1;
                                    $gun=$this->m_tr_model->updateTable("table_adverts",array("adet" => $hesap),array("id" => $kontrol->id));
                                    $logEkle=$this->m_tr_model->add_new(
                                        array(
                                            "user_id" => $user->id,
                                            "user_email" => $user->email,
                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                            "title" => "İlana Mağaza Tarafından Stok Eklendi.",
                                            "advert_id" => $kontrol->id,
                                            "status" => 1,
                                            "description" => $kontrol->ad_name." adlı ilana yeni stok eklendi. Eklenen Stok:".$this->input->post("codes")
                                        ),"ft_logs"
                                    );
                                    $stoklar=getTableOrder("table_adverts_stock",array("ads_id" => $kontrol->id),"id","asc");
                                    if($stoklar){
                                        $say=1;
                                        $str="";
                                        foreach ($stoklar as $item) {

                                            $str.='<tr style="vertical-align: middle !important">

                                                <td>'. $say .'</td>
                                                <td>'.$item->code.'</td>
                                                <td>';

                                            if($item->status==0){
                                                $str.='<span class="badge bg-warning text-dark badge-warning"><i class=" fa fa-clock-o"></i>'.(($_SESSION["lang"]==1)?"Satışta":"On Sale") .'</span>';
                                            }else{
                                                $str.='<span class="badge bg-success text-dark badge-warning"><i class=" fa fa-check"></i>'.(($_SESSION["lang"]==1)?"Satıldı":"Selled ") .'</span>';
                                            }
                                            $str.='</td>
                                                <td>';
                                            if($item->status==0){
                                                $str.='-';
                                            }else{
                                                $str.=date("d-m-Y H:i",strtotime($item->sell_at));
                                            }
                                            $str.='</td>
                                                <td>'.number_format($item->price,2).' '.getcur().' </td>
                                                <td>'.number_format($item->komisyon,2)." ".getcur().'
                                                </td>
                                                <td>'.number_format($item->cash,2)." ".getcur().'</td>
                                                <td>';
                                            if($item->status==0){
                                                $topk=rand(1000,9999)."S".rand(1,1000)."T".$kaydetStok."T".rand(1000,9999);
                                                $str.="<a onclick='modalActives(\"".$item->code."\",\"".$topk."\")' data-id='".$topk."' data-bs-toggle='modal' data-bs-target='#placebidModal2' class='btn-block  btn text-black btn-danger btn-small'
                                                           style='color: black'><i class='fa fa-trash'></i></a>";
                                            }else{
                                                $str.='-';
                                            }

                                            $str.='</td>
                                            </tr>';

                                            $say++;
                                        }
                                    }
                                    echo json_encode(array("hata" => "yok","adet" => $hesap,"message" => ($_SESSION["lang"])?"İşlem Başarılı":"Success","str" => $str));
                                }else{
                                    echo json_encode(array("hata" => "var","message" => langS(22,2)));
                                }
                            }
                        }
                    }
                } else {
                    redirect(base_url("404"));
                }

            } else {
                // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                http_response_code(403);
                echo json_encode(['error' => 'İzin verilmeyen origin.']);
            }
        } else {
            // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
            http_response_code(403);
            echo json_encode(['error' => 'Doğrudan erişim yasak.']);
        }
    }
    public function deleteStock()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // İzin verilen domainlerin listesi
            $parsedUrl = parse_url(base_url());
            $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

            $izinVerilenDomainler = array(
                $domain
            );

            // Gelen origin kontrolü
            $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
            // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
            if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                header('Content-Type: application/json');

                // Diğer işlemleri buraya ekleyebilirsiniz
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("token",true) && $this->input->post("uniq",true)){
                        $user=getActiveUsers();
                        if($user){
                            $temizle=explode("T",$this->input->post("token",true));
                            $kontrol=getTableSingle("table_adverts",array("ilanNo" => $this->input->post("uniq"),"user_id" => $user->id));
                            if($kontrol){
                                $stok=getTableSingle("table_adverts_stock",array("id" => $temizle[1],"ads_id" => $kontrol->id));
                                if($stok){
                                    $kontrol=getTableSingle("table_adverts",array("ilanNo" => $this->input->post("uniq"),"user_id" => $user->id));
                                    if($kontrol->adet==1){
                                        echo json_encode(array("hata" => "var","message" => ($_SESSION["lang"]==1)?"Min 1 Adet Stok Olmalıdır":"There Must Be Min 1 Stock"));
                                    }else{
                                        $sil=$this->m_tr_model->delete("table_adverts_stock",array("id" => $stok->id));
                                        if($sil){
                                            $logEkle=$this->m_tr_model->add_new(
                                                array(
                                                    "user_id" => $user->id,
                                                    "user_email" => $user->email,
                                                    "status" => 1,
                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                    "title" => "İlan Stok Mağaza Tarafından Silindi",
                                                    "description" => $kontrol->ad_name." adlı ilana ait stok mağaza tarafından silindi",
                                                    "befores" => json_encode($sil),
                                                ),"ft_logs"
                                            );
                                            $kontrol=getTableSingle("table_adverts",array("ilanNo" => $this->input->post("uniq"),"user_id" => $user->id));
                                            $adet=$kontrol->adet-1;
                                            if($adet>0){
                                                $guncelle=$this->m_tr_model->updateTable("table_adverts",array("adet" => $adet),array("id" => $kontrol->id));
                                            }
                                            echo json_encode(array("hata" => "yok","message" => ($_SESSION["lang"]==1)?"İşlem Başarılı":"Success"));
                                        }else{
                                            echo json_encode(array("hata" => "var","message" => ($_SESSION["lang"]==1)?"İşlem Hatası":"Error try Again"));
                                        }
                                    }

                                }
                            }

                        }
                    }
                } else {
                    redirect(base_url("404"));
                }

            } else {
                // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                http_response_code(403);
                echo json_encode(['error' => 'İzin verilmeyen origin.']);
            }
        } else {
            // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
            http_response_code(403);
            echo json_encode(['error' => 'Doğrudan erişim yasak.']);
        }
    }


    public function advertUpdateStock($id = "")
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // İzin verilen domainlerin listesi
            $parsedUrl = parse_url(base_url());
            $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

            $izinVerilenDomainler = array(
                $domain
            );

            // Gelen origin kontrolü
            $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
            // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
            if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                header('Content-Type: application/json');

                // Diğer işlemleri buraya ekleyebilirsiniz
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if ($id) {
                        $temizle = strip_tags($id);
                        $kontrol = getTableSingle("table_adverts", array("user_id" => getActiveUsers()->id, "ilanNo" => $temizle));
                        if ($kontrol) {
                            $orderr = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "is_delete" => 0,"status !=" => 4));
                            if($orderr){
                                $this->load->library("form_validation");
                                $gl = $_SESSION["lang"];

                                $this->form_validation->set_rules("icerik_tr", str_replace("\r\n", "", langS(80, 2, $gl)), "required|trim|min_length[20]|max_length[2000]", array(
                                    "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),
                                    "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "2000", langS(60, 2, $gl)))
                                ));
                                $mainCat = getTableSingle("table_advert_category", array("id" => $kontrol->category_main_id));
                                if ($mainCat) {
                                    if ($kontrol->category_top_id != 0) {
                                        $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_top_id, "status" => 1, "is_required" => 1), "id", "asc");
                                        if ($ozel) {
                                            foreach ($ozel as $oz) {
                                                if ($gl == 1) {
                                                    $names = $oz->name_tr;
                                                } else {
                                                    $names = $oz->name_en;
                                                }
                                                $this->form_validation->set_rules("sp" . $oz->id, str_replace("\r\n", "", $names));
                                            }
                                        }
                                    } else {
                                        $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_main_id, "status" => 1, "is_required" => 1), "id", "asc");
                                        if ($ozel) {
                                            foreach ($ozel as $oz) {
                                                if ($gl == 1) {
                                                    $names = $oz->name_tr;
                                                } else {
                                                    $names = $oz->name_en;
                                                }
                                                $this->form_validation->set_rules("sp" . $oz->id, str_replace("\r\n", "", $names));
                                            }
                                        }
                                    }
                                }
                                $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(84, 2, $gl)), "required|trim");
                                $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim", array(
                                    "required" => langS(102, 2, $gl)
                                ));


                                $this->form_validation->set_message(array(
                                    "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $gl))));
                                $val = $this->form_validation->run();
                                if ($val) {
                                    $up = $kontrol->img_1;
                                    $up2 = $kontrol->img_2;
                                    $up3 = $kontrol->img_3;

                                    ///İsim, başlık ve link bilgileri
                                    $opt = getTableSingle("options_general", array("id" => 1));
                                    $desctr = $this->input->post("icerik_tr");
                                    if ($this->input->post("nameen") != "") {
                                        $nameen = veriTemizle($this->security->xss_clean($this->input->post("nameen")));
                                    } else {
                                        $nameen = $kontrol->ad_name_tr;
                                    }
                                    if ($this->input->post("icerik_en") != "") {
                                        $descen = $this->input->post("icerik_en");
                                    } else {
                                        $descen = $desctr;
                                    }
                                    $linken = permalink($nameen) . "-" . rand(1000000, 9999999);
                                    ///İsim, başlık ve link bilgileri
                                    $enc = "";
                                    $getLang = getTable("table_langs", array("status" => 1));
                                    if ($getLang) {
                                        foreach ($getLang as $item) {
                                            if ($item->id == 1) {

                                            } else {
                                                $langValue[] = array(
                                                    "lang_id" => $item->id,
                                                    "stitle" => $nameen . " | " . $opt->site_name,
                                                    "sdesc" => $nametr,
                                                    "link" => $linken,
                                                );
                                            }

                                        }
                                        $enc = json_encode($langValue);
                                    }

                                    if ($_FILES["fatima"]["tmp_name"] != "") {
                                        if ($_FILES["fatima"]["tmp_name"] != "") {
                                            if ($kontrol->img_1 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_1);
                                            }
                                            $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                            $up = img_upload($_FILES["fatima"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");
                                        }
                                        if ($_FILES["fatima2"]["tmp_name"] != "") {
                                            if ($kontrol->img_2 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_2);
                                            }
                                            $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                            $up2 = img_upload($_FILES["fatima2"], $nametr . "-2-" . rand(1, 234508), "ilanlar", "", "", "");
                                        }
                                        if ($_FILES["fatima3"]["tmp_name"] != "") {
                                            if ($kontrol->img_3 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_3);
                                            }
                                            $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                            $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                        }
                                    } else {
                                        if ($_FILES["fatima2"]["tmp_name"] != "") {
                                            if ($kontrol->img_2 != "") {
                                                unlink("upload/ilanlar/" . $kontrol->img_2);
                                            }
                                            $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                            $up2 = img_upload($_FILES["fatima2"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");
                                            if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                if ($kontrol->img_3 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_3);
                                                }
                                                $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                        } else {
                                            if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                if ($kontrol->img_3 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_3);
                                                }
                                                $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                        }
                                    }

                                    if ($up || $up2 || $up3) {
                                        $user = getActiveUsers()->id;
                                        $users=getActiveUsers();
                                        $token = $kontrol->token;

                                        if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") < 1000000) {
                                            if ($users->magaza_ozel_komisyon != 0 && $users->magaza_ozel_komisyon != "") {
                                                $komisyon_oran = $users->magaza_ozel_komisyon;
                                                $komisyon = ($this->input->post("price") * $users->magaza_ozel_komisyon) / 100;
                                                $kazanc = $this->input->post("price") - $komisyon;
                                            } else {
                                                if ($kontrol->category_top_id != 0) {
                                                    if ($kontrol->category_parent_id != 0) {
                                                        $sub = getTableSingle("table_advert_category", array("id" => $kontrol->category_parent_id));
                                                        if ($sub) {
                                                            $komisyon_oran = $sub->commission_stoksuz;
                                                            $komisyon = ($this->input->post("price") * $sub->commission_stoksuz) / 100;
                                                            $kazanc = $this->input->post("price") - $komisyon;
                                                        }
                                                    } else {
                                                        $top = getTableSingle("table_advert_category", array("id" => $kontrol->category_top_id));
                                                        if ($top) {
                                                            $komisyon_oran = $top->commission_stoksuz;
                                                            $komisyon = ($this->input->post("price") * $top->commission_stoksuz) / 100;
                                                            $kazanc = $this->input->post("price") - $komisyon;
                                                        }
                                                    }
                                                } else {
                                                    $komisyon_oran = $mainCat->commission_stoksuz;
                                                    $komisyon = ($this->input->post("price") * $mainCat->commission_stoksuz) / 100;
                                                    $kazanc = $this->input->post("price") - $komisyon;
                                                }
                                            }

                                            $ayar = getTableSingle("table_options", array("id" => 1));
                                            if ($ayar->admin_onay == 1) {
                                                $status = 0;
                                            } else {
                                                $status = 1;
                                            }
                                            $kaydet = $this->m_tr_model->updateTable("table_adverts", array(
                                                "cat_name" => $mainCat->name,
                                                "ad_name_en" => $nameen,
                                                "delivery_time" => $this->input->post("times"),
                                                "price" => $this->input->post("price", true),
                                                "sell_price" => $kazanc,
                                                "commission" => $komisyon,
                                                "commission_oran" => $komisyon_oran,
                                                "status" => $status,
                                                "update_at" => date("Y-m-d H:i:s"),
                                                "img_1" => $up,
                                                "img_2" => $up2,
                                                "img_3" => $up3,
                                                "desc_en" => $descen,
                                                "desc_tr" => $desctr,
                                                "field_data" => $enc,
                                            ), array("id" => $kontrol->id));
                                            if ($kaydet) {

                                                if($kontrol->category_top_id!=0){

                                                    $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_top_id,"status" => 1),"name","asc");
                                                    if($getSpecial){
                                                        $yt=1;
                                                        foreach ($getSpecial as $item) {
                                                            $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                                            if($cekozel){
                                                                if( $this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                        "value" =>  $this->input->post("sp".$item->id)
                                                                    ),array("id" => $cekozel->id));
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)=="0"){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),array("id" => $cekozel->id));
                                                                    }else{
                                                                        $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                                                    }
                                                                }
                                                            }else{
                                                                if($this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->add_new(array(
                                                                        "spe_id" => $item->id,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "ads_id" => $kontrol->id,
                                                                        "value" =>  $this->input->post("sp_".$item->id)
                                                                    ),"table_adverts_spe_field");
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)==0){
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "spe_id" => $item->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "ads_id" => $kontrol->id,
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),"table_adverts_spe_field");
                                                                    }
                                                                }
                                                            }
                                                            $yt++;
                                                        }
                                                    }
                                                }else{
                                                    $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_main_id,"status" => 1),"name","asc");
                                                    if($getSpecial){
                                                        $yt=1;

                                                        foreach ($getSpecial as $item) {
                                                            $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                                            if($cekozel){
                                                                if( $this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                        "value" =>  $this->input->post("sp".$item->id)
                                                                    ),array("id" => $cekozel->id));
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)=="0"){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),array("id" => $cekozel->id));
                                                                    }else{
                                                                        $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                                                    }
                                                                }
                                                            }else{

                                                                if($this->input->post("sp".$item->id)){
                                                                    $guncelle=$this->m_tr_model->add_new(array(
                                                                        "spe_id" => $item->id,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "ads_id" => $kontrol->id,
                                                                        "value" =>  $this->input->post("sp".$item->id)
                                                                    ),"table_adverts_spe_field");
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)==0){
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "spe_id" => $item->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "ads_id" => $kontrol->id,
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),"table_adverts_spe_field");
                                                                    }
                                                                }
                                                            }
                                                            $yt++;
                                                        }
                                                    }
                                                }



                                                if ($status == 0) {
                                                    if($kontrol->type == 1){
                                                        //stok güncelleme
                                                        $cekstok=$this->m_tr_model->updateTable("table_adverts_stock",array(
                                                            "price" => str_replace(",",".",$this->input->post("price", true)),
                                                            "komisyon" => $komisyon,
                                                            "cash" => $kazanc,
                                                        ),array("ads_id" => $kontrol->id,"status" => 0));
                                                    }
                                                    $us=getActiveUsers();
                                                    $kontrol2=getTableSingle("table_adverts",array("id" => $kontrol->id));
                                                    adminNot(getActiveUsers()->id,"ilan-guncelle/".$kontrol->id,"İlan Mağaza Tarafından Güncellendi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->ad_name." </b> adlı ilanını güncelledi. Tarafınızdan inceleme ve onay bekleniyor");
                                                    $logEkle=$this->m_tr_model->add_new(
                                                        array(
                                                            "user_id" => $us->id,
                                                            "user_email" => $us->email,
                                                            "status" => 1,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "title" => "Stoklu İlan Güncellendi. Admin onayına gönderildi",
                                                            "description" => $kontrol->ad_name." adlı ilan kullanıcı tarafından güncellendi ve yönetici onayına gönderildi",
                                                            "befores" => json_encode($kontrol),
                                                            "afters" =>json_encode($kontrol2),
                                                        ),"ft_logs"
                                                    );
                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts",array("guncelleme_talep_at" => date("Y-m-d H:i:s"),"is_updated" => 1),array("id" => $kontrol->id));
                                                    echo json_encode(array("hata" => "yok", "message" => langS(104, 2, $gl)));
                                                } else {
                                                    $us=getActiveUsers();
                                                    $kontrol2=getTableSingle("table_adverts",array("id" => $kontrol->id));

                                                    adminNot(getActiveUsers()->id,"ilan-guncelle/".$kontrol->id,"İlan Mağaza Tarafından Güncellendi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->ad_name." </b> adlı ilanını güncelledi. ");
                                                    $logEkle=$this->m_tr_model->add_new(
                                                        array(
                                                            "user_id" => $us->id,
                                                            "user_email" => $us->email,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "title" => "Stoklu İlan Mağaza Tarafından Güncellendi.",
                                                            "advert_id" => $kontrol->id,
                                                            "befores" => json_encode($kontrol),
                                                            "afters" =>json_encode($kontrol2),
                                                            "status" => 1,
                                                            "description" => $kontrol->ad_name." adlı ilan kullanıcı tarafından güncellendi."
                                                        ),"ft_logs"
                                                    );
                                                    $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status" => 1,"guncelleme_talep_at" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                                                    echo json_encode(array("hata" => "yok", "message" => langS(105, 2, $gl)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "message" => langS(106, 2, $gl)));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "type" => "oturum"));
                                        }
                                    } else {
                                        $this->form_validation->set_rules("fatimas", langS(103, 2, $gl), "required|trim", array(
                                            "required" => langS(103, 2, $gl)
                                        ));
                                    }

                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "valid", "message" => validation_errors()));

                                }
                            }else{
                                if($kontrol->is_updated==1){
                                    //sipariş içeriyor

                                }
                                else{
                                    //sipariş içermiyor
                                    $this->load->library("form_validation");
                                    $gl = $_SESSION["lang"];
                                    $this->form_validation->set_rules("nametr", str_replace("\r\n", "", langS(79, 2, $gl)), "required|trim|min_length[20]|max_length[100]"
                                        , array(
                                            "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),
                                            "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "100", langS(60, 2, $gl)))
                                        ));
                                    $this->form_validation->set_rules("icerik_tr", str_replace("\r\n", "", langS(80, 2, $gl)), "required|trim|min_length[20]|max_length[2000]", array(
                                        "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),
                                        "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "2000", langS(60, 2, $gl)))
                                    ));
                                    $mainCat = getTableSingle("table_advert_category", array("id" => $kontrol->category_main_id));
                                    if ($mainCat) {
                                        if ($kontrol->category_top_id != 0) {
                                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_top_id, "status" => 1, "is_required" => 1), "id", "asc");
                                            if ($ozel) {
                                                foreach ($ozel as $oz) {
                                                    if ($gl == 1) {
                                                        $names = $oz->name_tr;
                                                    } else {
                                                        $names = $oz->name_en;
                                                    }
                                                    $this->form_validation->set_rules("sp" . $oz->id, str_replace("\r\n", "", $names));
                                                }
                                            }
                                        } else {
                                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_main_id, "status" => 1, "is_required" => 1), "id", "asc");
                                            if ($ozel) {
                                                foreach ($ozel as $oz) {
                                                    if ($gl == 1) {
                                                        $names = $oz->name_tr;
                                                    } else {
                                                        $names = $oz->name_en;
                                                    }
                                                    $this->form_validation->set_rules("sp" . $oz->id, str_replace("\r\n", "", $names));
                                                }
                                            }
                                        }
                                    }
                                    $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(84, 2, $gl)), "required|trim");
                                    $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim", array(
                                        "required" => langS(102, 2, $gl)
                                    ));


                                    $this->form_validation->set_message(array(
                                        "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $gl))));
                                    $val = $this->form_validation->run();
                                    if ($val) {
                                        $up = $kontrol->img_1;
                                        $up2 = $kontrol->img_2;
                                        $up3 = $kontrol->img_3;

                                        ///İsim, başlık ve link bilgileri
                                        $opt = getTableSingle("options_general", array("id" => 1));
                                        $nametr = veriTemizle($this->security->xss_clean($this->input->post("nametr")));
                                        $linktr = permalink($nametr) . "-" . rand(1000000, 9999999);
                                        $desctr = $this->input->post("icerik_tr");
                                        if ($this->input->post("nameen") != "") {
                                            $nameen = veriTemizle($this->security->xss_clean($this->input->post("nameen")));
                                        } else {
                                            $nameen = $nametr;
                                        }
                                        if ($this->input->post("icerik_en") != "") {
                                            $descen = $this->input->post("icerik_en");
                                        } else {
                                            $descen = $desctr;
                                        }
                                        $linken = permalink($nameen) . "-" . rand(1000000, 9999999);
                                        ///İsim, başlık ve link bilgileri
                                        $enc = "";
                                        $getLang = getTable("table_langs", array("status" => 1));
                                        if ($getLang) {
                                            foreach ($getLang as $item) {
                                                if ($item->id == 1) {
                                                    $langValue[] = array(
                                                        "lang_id" => $item->id,
                                                        "stitle" => $nametr . " | " . $opt->site_name,
                                                        "sdesc" => $nametr,
                                                        "link" => $linktr,
                                                    );
                                                } else {
                                                    $langValue[] = array(
                                                        "lang_id" => $item->id,
                                                        "stitle" => $nameen . " | " . $opt->site_name,
                                                        "sdesc" => $nametr,
                                                        "link" => $linken,
                                                    );
                                                }

                                            }
                                            $enc = json_encode($langValue);
                                        }

                                        if ($_FILES["fatima"]["tmp_name"] != "") {
                                            if ($_FILES["fatima"]["tmp_name"] != "") {
                                                if ($kontrol->img_1 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_1);
                                                }
                                                $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                                $up = img_upload($_FILES["fatima"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                            if ($_FILES["fatima2"]["tmp_name"] != "") {
                                                if ($kontrol->img_2 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_2);
                                                }
                                                $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                                $up2 = img_upload($_FILES["fatima2"], $nametr . "-2-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                            if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                if ($kontrol->img_3 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_3);
                                                }
                                                $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                            }
                                        } else {
                                            if ($_FILES["fatima2"]["tmp_name"] != "") {
                                                if ($kontrol->img_2 != "") {
                                                    unlink("upload/ilanlar/" . $kontrol->img_2);
                                                }
                                                $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                                $up2 = img_upload($_FILES["fatima2"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");
                                                if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                    if ($kontrol->img_3 != "") {
                                                        unlink("upload/ilanlar/" . $kontrol->img_3);
                                                    }
                                                    $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                    $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                                }
                                            } else {
                                                if ($_FILES["fatima3"]["tmp_name"] != "") {
                                                    if ($kontrol->img_3 != "") {
                                                        unlink("upload/ilanlar/" . $kontrol->img_3);
                                                    }
                                                    $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                                    $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");
                                                }
                                            }
                                        }

                                        if ($up || $up2 || $up3) {
                                            $user = getActiveUsers()->id;
                                            $users = getActiveUsers();
                                            $token = $kontrol->token;
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") < 1000000) {
                                                if ($users->magaza_ozel_komisyon != 0 && $users->magaza_ozel_komisyon != "") {
                                                    $komisyon_oran = $users->magaza_ozel_komisyon;
                                                    $komisyon = ($this->input->post("price") * $users->magaza_ozel_komisyon) / 100;
                                                    $kazanc = $this->input->post("price") - $komisyon;
                                                } else {
                                                    if ($kontrol->category_top_id != 0) {
                                                        if ($kontrol->category_parent_id != 0) {
                                                            $sub = getTableSingle("table_advert_category", array("id" => $kontrol->category_parent_id));
                                                            if ($sub) {
                                                                $komisyon_oran = $sub->commission_stoksuz;
                                                                $komisyon = ($this->input->post("price") * $sub->commission_stoksuz) / 100;
                                                                $kazanc = $this->input->post("price") - $komisyon;
                                                            }
                                                        } else {
                                                            $top = getTableSingle("table_advert_category", array("id" => $kontrol->category_top_id));
                                                            if ($top) {
                                                                $komisyon_oran = $top->commission_stoksuz;
                                                                $komisyon = ($this->input->post("price") * $top->commission_stoksuz) / 100;
                                                                $kazanc = $this->input->post("price") - $komisyon;
                                                            }
                                                        }
                                                    } else {
                                                        $komisyon_oran = $mainCat->commission_stoksuz;
                                                        $komisyon = ($this->input->post("price") * $mainCat->commission_stoksuz) / 100;
                                                        $kazanc = $this->input->post("price") - $komisyon;
                                                    }
                                                }
                                                $ayar = getTableSingle("table_options", array("id" => 1));
                                                if ($ayar->admin_onay == 1) {
                                                    $status = 0;
                                                } else {
                                                    $status = 1;
                                                }
                                                $kaydet = $this->m_tr_model->updateTable("table_adverts", array(
                                                    "ad_name" => $nametr,
                                                    "cat_name" => $mainCat->name,
                                                    "ad_name_en" => $nameen,
                                                    "delivery_time" => $this->input->post("times"),
                                                    "price" => $this->input->post("price", true),
                                                    "sell_price" => $kazanc,
                                                    "commission" => $komisyon,
                                                    "commission_oran" => $komisyon_oran,
                                                    "status" => $status,
                                                    "update_at" => date("Y-m-d H:i:s"),
                                                    "img_1" => $up,
                                                    "img_2" => $up2,
                                                    "img_3" => $up3,
                                                    "desc_en" => $descen,
                                                    "desc_tr" => $desctr,
                                                    "field_data" => $enc,
                                                ), array("id" => $kontrol->id));
                                                if ($kaydet) {

                                                    if($kontrol->category_top_id!=0){

                                                        $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_top_id,"status" => 1),"name","asc");
                                                        if($getSpecial){
                                                            $yt=1;
                                                            foreach ($getSpecial as $item) {
                                                                $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                                                if($cekozel){
                                                                    if( $this->input->post("sp".$item->id)){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),array("id" => $cekozel->id));
                                                                    }else{
                                                                        if($this->input->post("sp".$item->id)=="0"){
                                                                            $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                                "value" =>  $this->input->post("sp".$item->id)
                                                                            ),array("id" => $cekozel->id));
                                                                        }else{
                                                                            $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                                                        }
                                                                    }
                                                                }else{
                                                                    if($this->input->post("sp".$item->id)){
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "spe_id" => $item->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "ads_id" => $kontrol->id,
                                                                            "value" =>  $this->input->post("sp_".$item->id)
                                                                        ),"table_adverts_spe_field");
                                                                    }else{
                                                                        if($this->input->post("sp".$item->id)==0){
                                                                            $guncelle=$this->m_tr_model->add_new(array(
                                                                                "spe_id" => $item->id,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "ads_id" => $kontrol->id,
                                                                                "value" =>  $this->input->post("sp".$item->id)
                                                                            ),"table_adverts_spe_field");
                                                                        }
                                                                    }
                                                                }
                                                                $yt++;
                                                            }
                                                        }
                                                    }else{
                                                        $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_main_id,"status" => 1),"name","asc");
                                                        if($getSpecial){
                                                            $yt=1;

                                                            foreach ($getSpecial as $item) {
                                                                $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                                                if($cekozel){
                                                                    if( $this->input->post("sp".$item->id)){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),array("id" => $cekozel->id));
                                                                    }else{
                                                                        if($this->input->post("sp".$item->id)=="0"){
                                                                            $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                                                "value" =>  $this->input->post("sp".$item->id)
                                                                            ),array("id" => $cekozel->id));
                                                                        }else{
                                                                            $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                                                        }
                                                                    }
                                                                }else{

                                                                    if($this->input->post("sp".$item->id)){
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "spe_id" => $item->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "ads_id" => $kontrol->id,
                                                                            "value" =>  $this->input->post("sp".$item->id)
                                                                        ),"table_adverts_spe_field");
                                                                    }else{
                                                                        if($this->input->post("sp".$item->id)==0){
                                                                            $guncelle=$this->m_tr_model->add_new(array(
                                                                                "spe_id" => $item->id,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "ads_id" => $kontrol->id,
                                                                                "value" =>  $this->input->post("sp".$item->id)
                                                                            ),"table_adverts_spe_field");
                                                                        }
                                                                    }
                                                                }
                                                                $yt++;
                                                            }
                                                        }
                                                    }



                                                    if ($status == 0) {
                                                        if($kontrol->type == 1){
                                                            //stok güncelleme
                                                            $cekstok=$this->m_tr_model->updateTable("table_adverts_stock",array(
                                                                "price" => str_replace(",",".",$this->input->post("price", true)),
                                                                "komisyon" => $komisyon,
                                                                "cash" => $kazanc,
                                                            ),array("ads_id" => $kontrol->id,"status" => 0));
                                                        }
                                                        $us=getActiveUsers();
                                                        $kontrol2=getTableSingle("table_adverts",array("id" => $kontrol->id));
                                                        adminNot(getActiveUsers()->id,"ilan-guncelle/".$kontrol->id,"İlan Mağaza Tarafından Güncellendi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->ad_name." </b> adlı ilanını güncelledi. Tarafınızdan inceleme ve onay bekleniyor");
                                                        $logEkle=$this->m_tr_model->add_new(
                                                            array(
                                                                "user_id" => $us->id,
                                                                "user_email" => $us->email,
                                                                "status" => 1,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Stoklu İlan Güncellendi. Admin onayına gönderildi",
                                                                "description" => $kontrol->ad_name." adlı ilan kullanıcı tarafından güncellendi ve yönetici onayına gönderildi",
                                                                "befores" => json_encode($kontrol),
                                                                "afters" =>json_encode($kontrol2),
                                                            ),"ft_logs"
                                                        );
                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array("guncelleme_talep_at" => date("Y-m-d H:i:s"),"is_updated" => 1),array("id" => $kontrol->id));
                                                        echo json_encode(array("hata" => "yok", "message" => langS(104, 2, $gl)));
                                                    } else {
                                                        $us=getActiveUsers();
                                                        $kontrol2=getTableSingle("table_adverts",array("id" => $kontrol->id));

                                                        adminNot(getActiveUsers()->id,"ilan-guncelle/".$kontrol->id,"İlan Mağaza Tarafından Güncellendi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->ad_name." </b> adlı ilanını güncelledi. ");
                                                        $logEkle=$this->m_tr_model->add_new(
                                                            array(
                                                                "user_id" => $us->id,
                                                                "user_email" => $us->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Stoklu İlan Mağaza Tarafından Güncellendi.",
                                                                "advert_id" => $kontrol->id,
                                                                "befores" => json_encode($kontrol),
                                                                "afters" =>json_encode($kontrol2),
                                                                "status" => 1,
                                                                "description" => $kontrol->ad_name." adlı ilan kullanıcı tarafından güncellendi."
                                                            ),"ft_logs"
                                                        );
                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status" => 1,"guncelleme_talep_at" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                                                        echo json_encode(array("hata" => "yok", "message" => langS(105, 2, $gl)));
                                                    }
                                                } else {
                                                    echo json_encode(array("hata" => "var", "message" => langS(106, 2, $gl)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        } else {
                                            $this->form_validation->set_rules("fatimas", langS(103, 2, $gl), "required|trim", array(
                                                "required" => langS(103, 2, $gl)
                                            ));
                                        }

                                    } else {
                                        echo json_encode(array("hata" => "var", "type" => "valid", "message" => validation_errors()));

                                    }
                                }
                            }


                        }
                    }
                } else {
                    redirect(base_url("404"));
                }

            } else {
                // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                http_response_code(403);
                echo json_encode(['error' => 'İzin verilmeyen origin.']);
            }
        } else {
            // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
            http_response_code(403);
            echo json_encode(['error' => 'Doğrudan erişim yasak.']);
        }

    }





}