<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Adverts extends CI_Controller

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

        $this->load->helper("user_helper");

    }



    public function getCategoryDefaultImages(){

        if ($_POST) {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {

                header('Content-Type: application/json');



                $images = getTable("table_advert_category_images", array("category_id" => $this->input->post("catId")));

                if ($images){

                    echo json_encode($images);

                }else{

                    echo json_encode([]);

                }

            }

        }

    }



    //using

    public function getCategoryTopList()

    {

        if ($_POST) {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {

                header('Content-Type: application/json');

                if ($this->input->post("veri", true)) {

                    if ($this->input->get("t")) {

                        $str = "";

                        //üst kategori seçim

                        $kontrol = getTableSingle("table_advert_category", array("id" => $this->input->post("veri")));

                        $cektop = getTableOrder("table_advert_category", array("top_id" => $kontrol->top_id, "status" => 1, "parent_id" => $kontrol->id, "is_delete" => 0), "name", "asc");

                        if ($cektop) {

                            $str .= "<option value=''>Seçiniz</option>";

                            foreach ($cektop as $item) {

                                if ($this->input->post("t") == 1) {

                                    $ll = getLangValue($item->id, "table_advert_category", $this->input->post("lang"));

                                    $str .= '<option value="' . $item->id . '">' . $ll->name . " (Komisyon: %" . $item->commission_stoksuz . ")" . '</option>';

                                } else {

                                    $ll = getLangValue($item->id, "table_advert_category", $this->input->post("lang"));

                                    $str .= '<option value="' . $item->id . '">' . $ll->name . " (Komisyon: %" . $item->commission . ")" . '</option>';

                                }

                            }

                            $special = $this->getCategorySpecial($kontrol, $cektop, $this->input->post("lang"));

                            if ($special) {

                                echo json_encode(array("veri" => $str, "spe" => $special));

                            } else {

                                echo json_encode(array("veri" => $str));

                            }

                        } else {

                            $special = $this->getCategorySpecial($kontrol, $cektop, $this->input->post("lang"));

                            if ($special) {

                                echo json_encode(array("veri" => "yok", "spe" => $special));

                            } else {

                                echo json_encode(array("veri" => "yok"));

                            }

                        }

                    } else {

                        $str = "";

                        $kontrol = getTableSingle("table_advert_category", array("id" => $this->input->post("veri")));

                        //ana kategori seçim

                        $cektop = getTableOrder("table_advert_category", array("top_id" => $this->input->post("veri"), "status" => 1, "parent_id" => 0, "is_delete" => 0), "name", "asc");

                        if ($cektop) {

                            $str .= "<option value=''>Seçiniz</option>";

                            foreach ($cektop as $item) {

                                if ($this->input->post("t") == 1) {

                                    $ll = getLangValue($item->id, "table_advert_category", $this->input->post("lang"));

                                    $str .= '<option value="' . $item->id . '">' . $ll->name . " (Komisyon: %" . $item->commission_stoksuz . ")" . '</option>';

                                } else {

                                    $ll = getLangValue($item->id, "table_advert_category", $this->input->post("lang"));

                                    $str .= '<option value="' . $item->id . '">' . $ll->name . " (Komisyon: %" . $item->commission . ")" . '</option>';

                                }

                            }

                            $special = $this->getCategorySpecial($kontrol, $cektop, $this->input->post("lang"));

                            if ($special) {

                                echo json_encode(array("veri" => $str, "spe" => $special));

                            } else {

                                echo json_encode(array("veri" => $str));

                            }

                        } else {

                            $special = $this->getCategorySpecial($kontrol, 0, $this->input->post("lang"));

                            if ($special) {

                                echo json_encode(array("veri" => "yok", "spe" => $special));

                            } else {

                                echo json_encode(array("veri" => "yok"));

                            }

                        }

                    }

                } else {

                    echo json_encode(array("veri" => "yok"));

                }

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }

    //ads special field Create

    private function getCategorySpecial($top, $main, $lang = 1)

    {

        if ($main) {

            $sp = getTableOrder("table_adverts_category_special", array("p_id" => $top->id), "order_id", "asc");

            if ($sp) {

                $strs = '';

                foreach ($sp as $item) {

                    if ($item->type == 2) {

                        //secenek

                        $r = "";

                        if ($lang == 1) {

                            if ($item->is_required == 1) {

                                $r = "required data-msg='" . langS(8, 2) . "'";

                            }

                            $strs .= '<div class="col-lg-4 mt-3" style="">

                                        <div class="input-box pb--20">

                                        <label for="name" class="form-label">' . $item->name_tr . '</label>

                                        <select ' . $r . ' class="form-control selectss" name="sp' . $item->id . '" >

                                        <option value="">' . langS(86, 2, $lang) . "</option>";

                            $sec = explode(",", $item->secenek_tr);

                            $order = 0;

                            foreach ($sec as $s) {

                                $strs .= '<option value="' . $order . '">' . $s . '</option>';

                                $order++;

                            }

                            $strs .= '</select></div></div>';

                        } else {

                            $strs .= '<div class="input-box pb--20">

                                    <label for="name" class="form-label">' . $item->name_en . '</label>';

                        }

                    }

                }

                if ($strs != "") {

                    return $strs;

                } else {

                    return false;

                }

            }

        } else {

            $sp = getTableOrder("table_adverts_category_special", array("p_id" => $top->id), "order_id", "asc");

            if ($sp) {

                $strs = '';

                foreach ($sp as $item) {

                    if ($item->type == 2) {

                        //secenek

                        $r = "";

                        if ($lang == 1) {

                            if ($item->is_required == 1) {

                                $r = "required data-msg='" . langS(8, 2) . "'";

                            }

                            $strs .= '<div class="col-lg-4 mt-3">

                                        <div class="input-box pb--20">

                                        <label for="name" class="form-label">' . $item->name_tr . '</label>

                                        <select ' . $r . ' class="form-control selectss" name="sp' . $item->id . '" >

                                        <option value="">' . langS(86, 2, $lang) . "</option>";

                            $sec = explode(",", $item->secenek_tr);

                            $order = 0;

                            foreach ($sec as $s) {

                                $strs .= '<option value="' . $order . '">' . $s . '</option>';

                                $order++;

                            }

                            $strs .= '</select></div></div>';

                        } else {

                            $strs .= '<div class="input-box pb--20">

                                    <label for="name" class="form-label">' . $item->name_en . '</label>';

                        }

                    }

                }

                if ($strs != "") {

                    return $strs;

                } else {

                    return false;

                }

            }

        }

    }

    public function validate_length($str)

    {

        $str = strip_tags($str); // HTML etiketlerini temizle

        $length = strlen($str);

        if ($length < 20) {

            $this->form_validation->set_message('validate_length', 'The {field} field must be at least 20 characters long.');

            return false;

        } elseif ($length > 2000) {

            $this->form_validation->set_message('validate_length', 'The {field} field must not exceed 2000 characters.');

            return false;

        }

        return true;

    }

    //using

    public function setCreateAdNStock()

    {
        if ($_POST) {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {

                header('Content-Type: application/json');

                $user = getActiveUsers();

                if ($user) {

                    $countUserAdverts = getTableOrder("table_adverts", array("user_id" => $user->id, "status" => 1), "id", "desc");

                    if ($countUserAdverts && count($countUserAdverts) >= $user->advert_limit) {

                        echo json_encode(array("hata" => "var", "type" => "limit"));

                        exit();

                    }

                    if ($user->is_magaza == 1) {

                        $gl = $this->input->post("lang");

                        $this->load->library("form_validation");

                        $this->form_validation->set_rules(

                            "nametr",

                            str_replace("\r\n", "", langS(79, 2, $gl)),

                            "required|trim|min_length[20]|max_length[100]",

                            array(

                                "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),

                                "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "100", langS(60, 2, $gl)))

                            )

                        );

                        $this->form_validation->set_rules("icerik_tr", str_replace("\r\n", "", langS(80, 2, $gl)), "required|trim|callback_validate_length", array(

                            "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),

                            "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "2000", langS(60, 2, $gl)))

                        ));

                        //Kategori bilgileri ve özel alan kontrolü

                        $this->form_validation->set_rules("mainCat", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim");

                        $mainCat = getTableSingle("table_advert_category", array("id" => $this->input->post("mainCat")));

                        if ($mainCat) {

                            $topCont = getTableSingle("table_advert_category", array("top_id" => $mainCat->id, "parent_id" => 0, "status" => 1));

                            if ($topCont) {

                                $this->form_validation->set_rules("topCategory", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim");

                                if ($this->input->post("topCategory")) {

                                    $subCont = getTableSingle("table_advert_category", array("top_id" => $mainCat->id, "parent_id" => $this->input->post("topCategory"), "status" => 1));

                                    if ($subCont) {

                                        $this->form_validation->set_rules("subCategory", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim");

                                    }

                                }

                            }

                        }

                        if ($this->input->post("topCategory")) {

                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("topCategory"), "status" => 1, "is_required" => 1), "id", "asc");

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

                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("mainCat"), "status" => 1, "is_required" => 1), "id", "asc");

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

                        $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(84, 2, $gl)), "required|trim");

                        $this->form_validation->set_rules("times", str_replace("\r\n", "", langS(85, 2, $gl)), "required|trim");

                        $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim", array(

                            "required" => langS(102, 2, $gl)

                        ));



                        if ($this->input->post("selected_default_image") == 0){

                            if ($_FILES["fatima"]["tmp_name"] != "" || $_FILES["fatima2"]["tmp_name"] != "" || $_FILES["fatima3"]["tmp_name"] != "") {

                            } else {

                                $this->form_validation->set_rules("fatimas", langS(103, 2, $gl), "required|trim", array(

                                    "required" => langS(103, 2, $gl)

                                ));

                            }

                        }



                        $this->form_validation->set_message(array(

                            "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $gl))

                        ));

                        $val = $this->form_validation->run();

                        if ($val) {

                            $up = "";

                            $up2 = "";

                            $up3 = "";

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

                                    $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);

                                    $up = img_upload($_FILES["fatima"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");

                                }

                                if ($_FILES["fatima2"]["tmp_name"] != "") {

                                    $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);

                                    $up2 = img_upload($_FILES["fatima2"], $nametr . "-2-" . rand(1, 234508), "ilanlar", "", "", "");

                                }

                                if ($_FILES["fatima3"]["tmp_name"] != "") {

                                    $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);

                                    $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");

                                }

                            } else {

                                if ($_FILES["fatima2"]["tmp_name"] != "") {

                                    $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);

                                    $up1 = img_upload($_FILES["fatima2"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");

                                    if ($_FILES["fatima3"]["tmp_name"] != "") {

                                        $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);

                                        $up2 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");

                                    }

                                } else {

                                    if ($_FILES["fatima3"]["tmp_name"] != "") {

                                        $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);

                                        $up = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");

                                    }

                                }

                            }



                            if ($this->input->post("selected_default_image") !== 0){

                                $image = getTableSingle("table_advert_category_images", [

                                    'id'    =>  $this->input->post("selected_default_image")

                                ]);

                                $up = "default/" . $image->image;

                                $up2 = "";

                                $up3 = "";

                            }



                            $token = tokengenerator(9, 2);

                            $token = $this->getTokenControlAds($token);

                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") > $opt->ilan_min_amount) {

                                $this->db->where('max_price >=', $this->input->post("price"));

                                $this->db->order_by('max_price', 'ASC');

                                $query = $this->db->get('advert_price_comission');

                                if ($query->num_rows() > 0) {

                                    $comission = $query->row();

                                    $komisyon_oran = $comission->comission;

                                    $komisyon = $comission->comission;

                                    $kazanc = $this->input->post("price") - $komisyon;

                                } else {

                                    if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                        $komisyon_oran = $user->magaza_ozel_komisyon;

                                        $komisyon = ($this->input->post("price") * $user->magaza_ozel_komisyon) / 100;

                                        $kazanc = $this->input->post("price") - $komisyon;

                                    } else {

                                        if ($this->input->post("topCategory")) {

                                            if ($this->input->post("subCategory")) {

                                                $sub = getTableSingle("table_advert_category", array("id" => $this->input->post("subCategory")));

                                                if ($sub) {

                                                    $komisyon_oran = $sub->commission_stoksuz;

                                                    $komisyon = ($this->input->post("price") * $sub->commission_stoksuz) / 100;

                                                    $kazanc = $this->input->post("price") - $komisyon;

                                                }

                                            } else {

                                                $top = getTableSingle("table_advert_category", array("id" => $this->input->post("topCategory")));

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

                                }

                                $ayar = getTableSingle("table_options", array("id" => 1));

                                if ($ayar->admin_onay == 1) {

                                    $status = 0;

                                } else {

                                    $status = 1;

                                }

                                $kaydet = $this->m_tr_model->add_new(array(

                                    "ad_name" => $nametr,

                                    "cat_name" => $mainCat->name,

                                    "ad_name_en" => $nameen,

                                    "user_id" => $user->id,

                                    "type" => 0,

                                    "ilanNo" => $token,

                                    "category_main_id" => $mainCat->id,

                                    "category_top_id" => $this->input->post("topCategory"),

                                    "category_parent_id" => $this->input->post("subCategory"),

                                    "delivery_time" => $this->input->post("times"),

                                    "price" => $this->input->post("price"),

                                    "sell_price" => $kazanc,

                                    "commission" => $komisyon,

                                    "commission_oran" => $komisyon_oran,

                                    "status" => $status,

                                    "created_at" => date("Y-m-d H:i:s"),

                                    "img_1" => $up,

                                    "img_2" => $up2,

                                    "img_3" => $up3,

                                    "desc_en" => $descen,

                                    "desc_tr" => $desctr,

                                    "field_data" => $enc,

                                    "adet"=>$this->input->post("stock"),

                                    "kalan_adet"=>$this->input->post("stock"),

                                    "special_fields" => $this->input->post("special_field") ? json_encode($this->input->post("special_field")):"[]"

                                ), "table_adverts");

                                if ($kaydet) {

                                    if ($this->input->post("topCategory")) {

                                        $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("topCategory"), "status" => 1), "id", "asc");

                                        if ($ozel) {

                                            $order = 0;

                                            foreach ($ozel as $oz) {

                                                $kaydetspe = $this->m_tr_model->add_new(array(

                                                    "ads_id" => $kaydet,

                                                    "spe_id" => $oz->id,

                                                    "value" => $this->input->post("sp" . $oz->id),

                                                    "created_at" => date("Y-m-d H:i:s")

                                                ), "table_adverts_spe_field");

                                                $order++;

                                            }

                                        }

                                    } else {

                                        $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("mainCat"), "status" => 1), "id", "asc");

                                        if ($ozel) {

                                            $order = 0;

                                            foreach ($ozel as $oz) {

                                                $kaydetspe = $this->m_tr_model->add_new(array(

                                                    "ads_id" => $kaydet,

                                                    "spe_id" => $oz->id,

                                                    "value" => $this->input->post("sp" . $oz->id),

                                                    "created_at" => date("Y-m-d H:i:s")

                                                ), "table_adverts_spe_field");

                                            }

                                        }

                                    }

                                    if ($status == 1) {

                                        echo json_encode(array("hata" => "yok", "message" => langS(104, 2, $gl)));

                                    } else {

                                        adminNot(getActiveUsers()->id, "ilan-guncelle/" . $kaydet, "Yeni İlan Oluşturuldu", "#" . $token . " No'lu <b>" . $nametr . "</b> adlı yeni ilan oluşturuldu. Tarafınızdan onay bekleniyor ");

                                        echo json_encode(array("hata" => "yok", "message" => langS(105, 2, $gl)));

                                    }

                                } else {

                                    echo json_encode(array("hata" => "var", "message" => langS(106, 2, $gl)));

                                }

                            } else {

                                echo json_encode(array("hata" => "var", "type" => "oturum"));

                            }

                        } else {

                            echo json_encode(array("hata" => "var", "type" => "valid", "message" => validation_errors()));

                        }

                    } else {

                        echo json_encode(array("hata" => "var", "type" => "oturum"));

                    }

                } else {

                    echo json_encode(array("hata" => "var", "type" => "oturum"));

                }

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }

    public function setCreateAdStock()

    {

        if ($_POST) {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {

                header('Content-Type: application/json');

                $user = getActiveUsers();

                if ($user) {

                    $countUserAdverts = getTableOrder("table_adverts", array("user_id" => $user->id, "status" => 1), "id", "desc");

                    if (count($countUserAdverts) >= $user->advert_limit) {

                        echo json_encode(array("hata" => "var", "type" => "limit"));

                        exit();

                    }

                    if ($user->is_magaza == 1) {

                        $gl = $this->input->post("lang");

                        $this->load->library("form_validation");

                        $this->form_validation->set_rules(

                            "nametr",

                            str_replace("\r\n", "", langS(79, 2, $gl)),

                            "required|trim|min_length[20]|max_length[100]",

                            array(

                                "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),

                                "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "100", langS(60, 2, $gl)))

                            )

                        );

                        $this->form_validation->set_rules("icerik_tr", str_replace("\r\n", "", langS(80, 2, $gl)), "required|trim|callback_validate_length", array(

                            "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),

                            "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "2000", langS(60, 2, $gl)))

                        ));

                        //Kategori bilgileri ve özel alan kontrolü

                        $this->form_validation->set_rules("mainCat", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim");

                        $mainCat = getTableSingle("table_advert_category", array("id" => $this->input->post("mainCat")));

                        if ($mainCat) {

                            $topCont = getTableSingle("table_advert_category", array("top_id" => $mainCat->id, "parent_id" => 0, "status" => 1));

                            if ($topCont) {

                                $this->form_validation->set_rules("topCategory", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim");

                                if ($this->input->post("topCategory")) {

                                    $subCont = getTableSingle("table_advert_category", array("top_id" => $mainCat->id, "parent_id" => $this->input->post("topCategory"), "status" => 1));

                                    if ($subCont) {

                                        $this->form_validation->set_rules("subCategory", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim");

                                    }

                                }

                            }

                        }

                        if ($this->input->post("topCategory")) {

                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("topCategory"), "status" => 1, "is_required" => 1), "id", "asc");

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

                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("mainCat"), "status" => 1, "is_required" => 1), "id", "asc");

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

                        $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(84, 2, $gl)), "required|trim");

                        $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(99, 2, $gl)), "required|trim", array(

                            "required" => langS(102, 2, $gl)

                        ));

                        if ($_FILES["fatima"]["tmp_name"] != "" || $_FILES["fatima2"]["tmp_name"] != "" || $_FILES["fatima3"]["tmp_name"] != "") {

                        } else {

                            $this->form_validation->set_rules("fatimas", langS(103, 2, $gl), "required|trim", array(

                                "required" => langS(103, 2, $gl)

                            ));

                        }

                        $this->form_validation->set_message(array(

                            "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $gl))

                        ));

                        $val = $this->form_validation->run();

                        if ($val) {

                            $up = "";

                            $up2 = "";

                            $up3 = "";

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

                                    $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);

                                    $up = img_upload($_FILES["fatima"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");

                                }

                                if ($_FILES["fatima2"]["tmp_name"] != "") {

                                    $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);

                                    $up2 = img_upload($_FILES["fatima2"], $nametr . "-2-" . rand(1, 234508), "ilanlar", "", "", "");

                                }

                                if ($_FILES["fatima3"]["tmp_name"] != "") {

                                    $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);

                                    $up3 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");

                                }

                            } else {

                                if ($_FILES["fatima2"]["tmp_name"] != "") {

                                    $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);

                                    $up1 = img_upload($_FILES["fatima2"], $nametr . "-1-" . rand(1, 234508), "ilanlar", "", "", "");

                                    if ($_FILES["fatima3"]["tmp_name"] != "") {

                                        $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);

                                        $up2 = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");

                                    }

                                } else {

                                    if ($_FILES["fatima3"]["tmp_name"] != "") {

                                        $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);

                                        $up = img_upload($_FILES["fatima3"], $nametr . "-3-" . rand(1, 234508), "ilanlar", "", "", "");

                                    }

                                }

                            }

                            $token = tokengenerator(9, 2);

                            $token = $this->getTokenControlAds($token);

                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") > $opt->ilan_min_amount) {

                                $this->db->where('max_price >=', $this->input->post("price"));

                                $this->db->order_by('max_price', 'ASC');

                                $query = $this->db->get('advert_price_comission');

                                if ($query->num_rows() > 0) {

                                    $comission = $query->row();

                                    $komisyon_oran = $comission->comission;

                                    $komisyon = $comission->comission;

                                    $kazanc = $this->input->post("price") - $komisyon;

                                } else {

                                    if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                        $komisyon_oran = $user->magaza_ozel_komisyon;

                                        $komisyon = ($this->input->post("price") * $user->magaza_ozel_komisyon) / 100;

                                        $kazanc = $this->input->post("price") - $komisyon;

                                    } else {

                                        if ($this->input->post("topCategory")) {

                                            if ($this->input->post("subCategory")) {

                                                $sub = getTableSingle("table_advert_category", array("id" => $this->input->post("subCategory")));

                                                if ($sub) {

                                                    $komisyon_oran = $sub->commission;

                                                    $komisyon = ($this->input->post("price") * $sub->commission) / 100;

                                                    $kazanc = $this->input->post("price") - $komisyon;

                                                }

                                            } else {

                                                $top = getTableSingle("table_advert_category", array("id" => $this->input->post("topCategory")));

                                                if ($top) {

                                                    $komisyon_oran = $top->commission;

                                                    $komisyon = ($this->input->post("price") * $top->commission) / 100;

                                                    $kazanc = $this->input->post("price") - $komisyon;

                                                }

                                            }

                                        } else {

                                            $komisyon_oran = $mainCat->commission;

                                            $komisyon = ($this->input->post("price") * $mainCat->commission) / 100;

                                            $kazanc = $this->input->post("price") - $komisyon;

                                        }

                                    }

                                }

                                $ayar = getTableSingle("table_options", array("id" => 1));

                                if ($ayar->admin_onay == 1) {

                                    $status = 0;

                                } else {

                                    $status = 1;

                                }

                                $kaydet = $this->m_tr_model->add_new(array(

                                    "ad_name" => $nametr,

                                    "cat_name" => $mainCat->name,

                                    "ad_name_en" => $nameen,

                                    "user_id" => $user->id,

                                    "type" => 1,

                                    "ilanNo" => $token,

                                    "category_main_id" => $mainCat->id,

                                    "category_top_id" => $this->input->post("topCategory", true),

                                    "category_parent_id" => $this->input->post("subCategory", true),

                                    "delivery_time" => $this->input->post("times", true),

                                    "price" => str_replace(",", ".", $this->input->post("price", true)),

                                    "sell_price" => $kazanc,

                                    "commission" => $komisyon,

                                    "commission_oran" => $komisyon_oran,

                                    "status" => $status,

                                    "created_at" => date("Y-m-d H:i:s"),

                                    "img_1" => $up,

                                    "img_2" => $up2,

                                    "img_3" => $up3,

                                    "desc_en" => $descen,

                                    "desc_tr" => $desctr,

                                    "field_data" => $enc,

                                    "special_fields" => $this->input->post("special_field") ? json_encode($this->input->post("special_field")):"[]"

                                ), "table_adverts");

                                if ($kaydet) {

                                    if ($this->input->post("stok")) {

                                        $say = 0;

                                        foreach ($this->input->post("stok") as $item) {

                                            $kaydetStok = $this->m_tr_model->add_new(array(

                                                "ads_id" => $kaydet,

                                                "code" => $item,

                                                "status" => 0,

                                                "created_at" => date("Y-m-d H:i:s"),

                                                "price" => str_replace(",", ".", $this->input->post("price", true)),

                                                "komisyon" => $komisyon,

                                                "cash" => $kazanc

                                            ), "table_adverts_stock");

                                            $say++;

                                        }

                                        $gun = $this->m_tr_model->updateTable("table_adverts", array("adet" => $say,"kalan_adet"=>$say), array("id" => $kaydet));

                                        if ($this->input->post("topCategory")) {

                                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("topCategory"), "status" => 1), "id", "asc");

                                            if ($ozel) {

                                                $order = 0;

                                                foreach ($ozel as $oz) {

                                                    $kaydetspe = $this->m_tr_model->add_new(array(

                                                        "ads_id" => $kaydet,

                                                        "spe_id" => $oz->id,

                                                        "value" => $this->input->post("sp" . $oz->id),

                                                        "created_at" => date("Y-m-d H:i:s")

                                                    ), "table_adverts_spe_field");

                                                    $order++;

                                                }

                                            }

                                        } else {

                                            $ozel = getTableOrder("table_adverts_category_special", array("p_id" => $this->input->post("mainCat"), "status" => 1), "id", "asc");

                                            if ($ozel) {

                                                $order = 0;

                                                foreach ($ozel as $oz) {

                                                    $kaydetspe = $this->m_tr_model->add_new(array(

                                                        "ads_id" => $kaydet,

                                                        "spe_id" => $oz->id,

                                                        "value" => $this->input->post("sp" . $oz->id),

                                                        "created_at" => date("Y-m-d H:i:s")

                                                    ), "table_adverts_spe_field");

                                                }

                                            }

                                        }

                                        if ($status == 1) {

                                            echo json_encode(array("hata" => "yok", "message" => langS(104, 2, $gl)));

                                        } else {

                                            adminNot(getActiveUsers()->id, "ilan-guncelle/" . $kaydet, "Yeni İlan Oluşturuldu", "#" . $token . " No'lu <b>" . $nametr . "</b> adlı yeni ilan oluşturuldu. Tarafınızdan onay bekleniyor ");

                                            echo json_encode(array("hata" => "yok", "message" => langS(105, 2, $gl)));

                                        }

                                    } else {

                                        echo json_encode(array("hata" => "var", "message" => "Stok Ekleyiniz"));

                                    }

                                } else {

                                    echo json_encode(array("hata" => "var", "message" => langS(106, 2, $gl)));

                                }

                            } else {

                                echo json_encode(array("hata" => "var", "type" => "oturum"));

                            }

                        } else {

                            echo json_encode(array("hata" => "var", "type" => "valid", "message" => validation_errors()));

                        }

                    } else {

                        echo json_encode(array("hata" => "var", "type" => "oturum"));

                    }

                } else {

                    echo json_encode(array("hata" => "var", "type" => "oturum"));

                }

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }

    private function getTokenControlAds($token)

    {

        $cont = getTableSingle("table_adverts", array("ilanNo" => $token));

        if ($cont) {

            $token = $this->getTokenControlAds(tokengenerator(9, 2));

        } else {

            return $token;

        }

    }

    //using

    public function getPriceNStockCom()

    {

        if ($_POST) {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {

                header('Content-Type: application/json');

                $user = getActiveUsers();

                $opt = getTableSingle("options_general", array("id" => 1));

                if ($user) {

                    if ($user->is_magaza == 1) {

                        $gl = $this->input->post("lang");

                        if ($this->input->post("price")) {

                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") > $opt->ilan_min_amount) {

                                $this->db->where('max_price >=', $this->input->post("price"));

                                $this->db->order_by('max_price', 'ASC');

                                $query = $this->db->get('advert_price_comission');

                                if ($query->num_rows() > 0) {

                                    $comission = $query->row();

                                    echo json_encode(array(

                                        "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                        "komisyon" => number_format($comission->comission, 2) . " " . getcur(),

                                        "komisyon_oran" => getcur() . $comission->comission,

                                        "cash" => number_format(($this->input->post("price") - $comission->comission), 2) . " " . getcur()

                                    ));

                                } else {

                                    if ($this->input->post("t") == 1) {

                                        if ($this->input->post("main")) {

                                            if ($this->input->post("sub")) {

                                                $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("sub"), "status" => 1));

                                                if ($user->magaza_ozel_komisyon != 0) {

                                                    $hesapla = ($this->input->post("price") * $user->magaza_ozel_komisyon) / 100;

                                                    echo json_encode(array(

                                                        "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                                        "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                        "komisyon_oran" => "%" . $user->magaza_ozel_komisyon,

                                                        "cash" => number_format(($this->input->post("price") - $hesapla), 2) . " " . getcur()

                                                    ));

                                                } else {

                                                    $hesapla = ($this->input->post("price") * $cek->commission_stoksuz) / 100;

                                                    echo json_encode(array(

                                                        "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                                        "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                        "komisyon_oran" => "%" . $cek->commission_stoksuz,

                                                        "cash" => number_format(($this->input->post("price") - $hesapla), 2) . " " . getcur()

                                                    ));

                                                }

                                            } else {

                                                if ($this->input->post("top")) {

                                                    $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("top"), "status" => 1));

                                                    if ($cek) {

                                                        if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                                            $hesapla = ($this->input->post("price") * $user->magaza_ozel_komisyon) / 100;

                                                            echo json_encode(array(

                                                                "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                                                "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                                "komisyon_oran" => "%" . $user->magaza_ozel_komisyon,

                                                                "cash" => number_format(($this->input->post("price") - $hesapla), 2) . " " . getcur()

                                                            ));

                                                        } else {

                                                            $hesapla = ($this->input->post("price") * $cek->commission_stoksuz) / 100;

                                                            echo json_encode(array(

                                                                "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                                                "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                                "komisyon_oran" => "%" . $cek->commission_stoksuz,

                                                                "cash" => number_format(($this->input->post("price") - $hesapla), 2) . " " . getcur()

                                                            ));

                                                        }

                                                    } else {

                                                        //hata

                                                    }

                                                } else {

                                                    $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("main"), "status" => 1));

                                                    if ($cek) {

                                                        if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                                            $hesapla = ($this->input->post("price") * $user->magaza_ozel_komisyon) / 100;

                                                            echo json_encode(array(

                                                                "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                                                "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                                "komisyon_oran" => "%" . $user->magaza_ozel_komisyon,

                                                                "cash" => number_format(($this->input->post("price") - $hesapla), 2) . " " . getcur()

                                                            ));

                                                        } else {

                                                            $hesapla = ($this->input->post("price") * $cek->commission_stoksuz) / 100;

                                                            echo json_encode(array(

                                                                "unit" => number_format($this->input->post("price"), 2) . " " . getcur(),

                                                                "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                                "komisyon_oran" => "%" . $cek->commission_stoksuz,

                                                                "cash" => number_format(($this->input->post("price") - $hesapla), 2) . " " . getcur()

                                                            ));

                                                        }

                                                    } else {

                                                        //hata

                                                    }

                                                }

                                            }

                                        } else {

                                            //hata

                                        }

                                    } else {

                                        if ($this->input->post("main")) {

                                            if ($this->input->post("sub")) {

                                                $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("sub"), "status" => 1));

                                                if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                                    $hesapla2 = (($this->input->post("price", true) * $user->magaza_ozel_komisyon) / 100);

                                                    $hesapla = (($this->input->post("price", true) * $user->magaza_ozel_komisyon) / 100) * $this->input->post("stok");

                                                    echo json_encode(array(

                                                        "stok" => $this->input->post("stok", true),

                                                        "unit" => number_format($this->input->post("price", true), 2) . " " . getcur(),

                                                        "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                        "komisyon_oran" => "%" . $user->magaza_ozel_komisyon,

                                                        "unit_cash" => number_format(($this->input->post("price") - $hesapla2), 2) . " " . getcur(),

                                                        "cash" => number_format((($this->input->post("price") * $this->input->post("stok")) - $hesapla), 2) . " " . getcur()

                                                    ));

                                                } else {

                                                    $hesapla2 = (($this->input->post("price", true) * $cek->commission) / 100);

                                                    $hesapla = (($this->input->post("price", true) * $cek->commission) / 100) * $this->input->post("stok");

                                                    echo json_encode(array(

                                                        "stok" => $this->input->post("stok", true),

                                                        "unit" => number_format($this->input->post("price", true), 2) . " " . getcur(),

                                                        "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                        "komisyon_oran" => "%" . $cek->commission,

                                                        "unit_cash" => number_format(($this->input->post("price") - $hesapla2), 2) . " " . getcur(),

                                                        "cash" => number_format((($this->input->post("price") * $this->input->post("stok")) - $hesapla), 2) . " " . getcur()

                                                    ));

                                                }

                                            } else {

                                                if ($this->input->post("top")) {

                                                    $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("top"), "status" => 1));

                                                    if ($cek) {

                                                        if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                                            $hesapla2 = (($this->input->post("price", true) * $user->magaza_ozel_komisyon) / 100);

                                                            $hesapla = (($this->input->post("price", true) * $user->magaza_ozel_komisyon) / 100) * $this->input->post("stok");

                                                            echo json_encode(array(

                                                                "stok" => $this->input->post("stok", true),

                                                                "unit" => number_format($this->input->post("price", true), 2) . " " . getcur(),

                                                                "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                                "komisyon_oran" => "%" . $user->magaza_ozel_komisyon,

                                                                "unit_cash" => number_format(($this->input->post("price") - $hesapla2), 2) . " " . getcur(),

                                                                "cash" => number_format((($this->input->post("price") * $this->input->post("stok")) - $hesapla), 2) . " " . getcur()

                                                            ));

                                                        } else {

                                                            $hesapla2 = (($this->input->post("price", true) * $cek->commission) / 100);

                                                            $hesapla = (($this->input->post("price", true) * $cek->commission) / 100) * $this->input->post("stok");

                                                            echo json_encode(array(

                                                                "stok" => $this->input->post("stok", true),

                                                                "unit" => number_format($this->input->post("price", true), 2) . " " . getcur(),

                                                                "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                                "komisyon_oran" => "%" . $cek->commission,

                                                                "unit_cash" => number_format(($this->input->post("price") - $hesapla2), 2) . " " . getcur(),

                                                                "cash" => number_format((($this->input->post("price") * $this->input->post("stok")) - $hesapla), 2) . " " . getcur()

                                                            ));

                                                        }

                                                    } else {

                                                        //hata

                                                    }

                                                } else {

                                                    $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("main"), "status" => 1));

                                                    if ($user->magaza_ozel_komisyon != 0 && $user->magaza_ozel_komisyon != "") {

                                                        $hesapla2 = (($this->input->post("price", true) * $user->magaza_ozel_komisyon) / 100);

                                                        $hesapla = (($this->input->post("price", true) * $user->magaza_ozel_komisyon) / 100) * $this->input->post("stok");

                                                        echo json_encode(array(

                                                            "stok" => $this->input->post("stok", true),

                                                            "unit" => number_format($this->input->post("price", true), 2) . " " . getcur(),

                                                            "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                            "komisyon_oran" => "%" . $user->magaza_ozel_komisyon,

                                                            "unit_cash" => number_format(($this->input->post("price") - $hesapla2), 2) . " " . getcur(),

                                                            "cash" => number_format((($this->input->post("price") * $this->input->post("stok")) - $hesapla), 2) . " " . getcur()

                                                        ));

                                                    } else {

                                                        $hesapla2 = (($this->input->post("price", true) * $cek->commission) / 100);

                                                        $hesapla = (($this->input->post("price", true) * $cek->commission) / 100) * $this->input->post("stok");

                                                        echo json_encode(array(

                                                            "stok" => $this->input->post("stok", true),

                                                            "unit" => number_format($this->input->post("price", true), 2) . " " . getcur(),

                                                            "komisyon" => number_format($hesapla, 2) . " " . getcur(),

                                                            "komisyon_oran" => "%" . $cek->commission,

                                                            "unit_cash" => number_format(($this->input->post("price") - $hesapla2), 2) . " " . getcur(),

                                                            "cash" => number_format((($this->input->post("price") * $this->input->post("stok")) - $hesapla), 2) . " " . getcur()

                                                        ));

                                                    }

                                                }

                                            }

                                        } else {

                                            //hata

                                        }

                                    }

                                }

                            } else {

                                //hata

                            }

                        } else {

                            //hata

                        }

                    } else {

                        echo json_encode(array("hata" => "var", "type" => "oturum"));

                    }

                } else {

                    echo json_encode(array("hata" => "var", "type" => "oturum"));

                }

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }

    public function myAdvertsList()

    {

        if (!getActiveUsers()) {

            redirect(base_url("404"));

            exit;

        } else {

            if ($_POST) {

                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {

                    $w = " s.user_id=" . getActiveUsers()->id . " and s.status!=8 and is_delete=0  ";

                    $join = "   ";

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from table_adverts as s " . $join . " where " . $w);

                    $sql = "select s.id as ssid,

                        s.ilanNo  ,

                        s.ad_name as ilanAdi ,

                        s.type as ilanType ,

                        s.is_doping as dop,

                        s.red_nedeni as redNedeni ,

                        s.price as ilanFiyat ,

                        s.img_1 as ilanResim ,

                        s.is_doping as ilanDoping ,

                        s.adet as stokAdet ,

                        s.kalan_adet as satAdet,

                        s.status as ilanDurum,

                        s.created_at as ilanTarih 

                        from table_adverts as s " . $join;

                    $where = [];

                    $order = ['name', 'asc'];

                    $column = $_POST['order'][0]['column'];

                    $columnName = $_POST['columns'][$column]['data'];

                    $columnOrder = $_POST['order'][0]['dir'];

                    if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                        $order[0] = $columnName;

                        $order[1] = $columnOrder;

                    }

                    if (!empty($_POST['search']['value'])) {

                        foreach ($_POST['columns'] as $column) {

                            if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "cdate" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {

                                if (!empty($column['search']['value'])) {

                                    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';

                                } else {

                                    if ($column["data"] == "stat") {

                                        $where[] = 'hizmet.name LIKE "%' . $_POST['search']['value'] . '%" ';

                                    } else if ($column["data"] == "sname") {

                                        $where[] = 'u.name LIKE "%' . $_POST['search']['value'] . '%" ';

                                    } else {

                                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';

                                    }

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

                        $sql .= ' WHERE ' . $w . ' and (   ' . implode(' or ', $where) . "  )";

                        $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                        $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                    } else {

                        $sql .= " where " . $w . " order by " . $order[0] . " " . $order[1] . " ";

                        $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                    }

                    $veriler = $this->m_tr_model->query($sql);

                    $response = [];

                    $response["data"] = [];

                    $response["recordsTotal"] = $toplam[0]->sayi;

                    if (count($where) > 0) {

                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_adverts as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' where  ' . $w) . "  ) ");

                    } else {

                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_adverts as s " . $join . " where  " . $w);

                    }

                    $response["recordsFiltered"] = $filter[0]->toplam;

                    $iliski = "";

                    foreach ($veriler as $veri) {

                        $end = "";

                        $sips = 0;

                        $sip = getTable("table_orders_adverts", array("advert_id" => $veri->ssid, "sell_user_id" => getActiveUsers()->id, "is_delete" => 0, "status !=" => 4));

                        if ($sip) {

                            $sips = 1;

                        }

                        if ($veri->dop == 1) {

                            $cek = $this->m_tr_model->getTableSingle("table_adverts_dopings_users", array("advert_id" => $veri->ssid));

                            if ($cek) {

                                $end = date("d-m-Y H:i", strtotime($cek->end_date));

                            }

                        } else {

                            $end = "";

                        }

                        $link = getLangValue($veri->ssid, "table_adverts");

                        $response["data"][] = [

                            'id'    =>  $veri->ssid,

                            'ilanTarih'  => $veri->ilanTarih,

                            "ilanNo" => $veri->ilanNo,

                            "ilanAdi" => $veri->ilanAdi,

                            "ilanType" => $veri->ilanType,

                            "sip" => $sips,

                            "dop" => $veri->is_doping,

                            "ilanFiyat" => $veri->ilanFiyat,

                            "redNedeni" => $veri->redNedeni,

                            "ilanResim" => $veri->ilanResim,

                            "ilanDoping" => $veri->ilanDoping,

                            "dopEnd" => $end,

                            "satAdet" => $veri->satAdet,

                            "ilanLink" => $link->link,

                            "stokAdet" => $veri->stokAdet,

                            "ilanDurum" => $veri->ilanDurum,

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

            } else {

            }

        }

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

                            $orderr = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "is_delete" => 0, "status !=" => 4));

                            if ($kontrol->is_updated == 1) {

                            } else {

                                //sipariş içermiyor

                                $this->load->library("form_validation");

                                $gl = $_SESSION["lang"];

                                $this->form_validation->set_rules(

                                    "nametr",

                                    str_replace("\r\n", "", langS(79, 2, $gl)),

                                    "required|trim|min_length[20]|max_length[100]",

                                    array(

                                        "min_length" => str_replace("[field]", "{field}", str_replace("[s]", "20", langS(59, 2, $gl))),

                                        "max_length" => str_replace("[field]", "{field}", str_replace("[s]", "100", langS(60, 2, $gl)))

                                    )

                                );

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

                                    "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $gl))

                                ));

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

                                        if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0 && $this->input->post("price") < 1000000 && $this->input->post("price") > $opt->ilan_min_amount) {

                                            $this->db->where('max_price >=', $this->input->post("price"));

                                            $this->db->order_by('max_price', 'ASC');

                                            $query = $this->db->get('advert_price_comission');

                                            if ($query->num_rows() > 0) {

                                                $comission = $query->row();

                                                $komisyon_oran = $comission->comission;

                                                $komisyon = $comission->comission;

                                                $kazanc = $this->input->post("price") - $komisyon;

                                            } else {

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

                                                if ($kontrol->category_top_id != 0) {

                                                    $getSpecial = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_top_id, "status" => 1), "name", "asc");

                                                    if ($getSpecial) {

                                                        $yt = 1;

                                                        foreach ($getSpecial as $item) {

                                                            $cekozel = getTableSingle("table_adverts_spe_field", array("spe_id" => $item->id, "ads_id" => $kontrol->id));

                                                            if ($cekozel) {

                                                                if ($this->input->post("sp" . $item->id)) {

                                                                    $guncelle = $this->m_tr_model->updateTable("table_adverts_spe_field", array(

                                                                        "value" =>  $this->input->post("sp" . $item->id)

                                                                    ), array("id" => $cekozel->id));

                                                                } else {

                                                                    if ($this->input->post("sp" . $item->id) == "0") {

                                                                        $guncelle = $this->m_tr_model->updateTable("table_adverts_spe_field", array(

                                                                            "value" =>  $this->input->post("sp" . $item->id)

                                                                        ), array("id" => $cekozel->id));

                                                                    } else {

                                                                        $sil = $this->m_tr_model->delete("table_adverts_spe_field", array("id" => $item->id));

                                                                    }

                                                                }

                                                            } else {

                                                                if ($this->input->post("sp" . $item->id)) {

                                                                    $guncelle = $this->m_tr_model->add_new(array(

                                                                        "spe_id" => $item->id,

                                                                        "created_at" => date("Y-m-d H:i:s"),

                                                                        "ads_id" => $kontrol->id,

                                                                        "value" =>  $this->input->post("sp_" . $item->id)

                                                                    ), "table_adverts_spe_field");

                                                                } else {

                                                                    if ($this->input->post("sp" . $item->id) == 0) {

                                                                        $guncelle = $this->m_tr_model->add_new(array(

                                                                            "spe_id" => $item->id,

                                                                            "created_at" => date("Y-m-d H:i:s"),

                                                                            "ads_id" => $kontrol->id,

                                                                            "value" =>  $this->input->post("sp" . $item->id)

                                                                        ), "table_adverts_spe_field");

                                                                    }

                                                                }

                                                            }

                                                            $yt++;

                                                        }

                                                    }

                                                } else {

                                                    $getSpecial = getTableOrder("table_adverts_category_special", array("p_id" => $kontrol->category_main_id, "status" => 1), "name", "asc");

                                                    if ($getSpecial) {

                                                        $yt = 1;

                                                        foreach ($getSpecial as $item) {

                                                            $cekozel = getTableSingle("table_adverts_spe_field", array("spe_id" => $item->id, "ads_id" => $kontrol->id));

                                                            if ($cekozel) {

                                                                if ($this->input->post("sp" . $item->id)) {

                                                                    $guncelle = $this->m_tr_model->updateTable("table_adverts_spe_field", array(

                                                                        "value" =>  $this->input->post("sp" . $item->id)

                                                                    ), array("id" => $cekozel->id));

                                                                } else {

                                                                    if ($this->input->post("sp" . $item->id) == "0") {

                                                                        $guncelle = $this->m_tr_model->updateTable("table_adverts_spe_field", array(

                                                                            "value" =>  $this->input->post("sp" . $item->id)

                                                                        ), array("id" => $cekozel->id));

                                                                    } else {

                                                                        $sil = $this->m_tr_model->delete("table_adverts_spe_field", array("id" => $item->id));

                                                                    }

                                                                }

                                                            } else {

                                                                if ($this->input->post("sp" . $item->id)) {

                                                                    $guncelle = $this->m_tr_model->add_new(array(

                                                                        "spe_id" => $item->id,

                                                                        "created_at" => date("Y-m-d H:i:s"),

                                                                        "ads_id" => $kontrol->id,

                                                                        "value" =>  $this->input->post("sp" . $item->id)

                                                                    ), "table_adverts_spe_field");

                                                                } else {

                                                                    if ($this->input->post("sp" . $item->id) == 0) {

                                                                        $guncelle = $this->m_tr_model->add_new(array(

                                                                            "spe_id" => $item->id,

                                                                            "created_at" => date("Y-m-d H:i:s"),

                                                                            "ads_id" => $kontrol->id,

                                                                            "value" =>  $this->input->post("sp" . $item->id)

                                                                        ), "table_adverts_spe_field");

                                                                    }

                                                                }

                                                            }

                                                            $yt++;

                                                        }

                                                    }

                                                }

                                                if ($status == 0) {

                                                    $us = getActiveUsers();

                                                    $kontrol2 = getTableSingle("table_adverts", array("id" => $kontrol->id));

                                                    adminNot(getActiveUsers()->id, "ilan-guncelle/" . $kontrol->id, "İlan Mağaza Tarafından Güncellendi.", getActiveUsers()->email . " Adlı Üye <b>" . $kontrol->ad_name . " </b> adlı ilanını güncelledi. Tarafınızdan inceleme ve onay bekleniyor");

                                                    $logEkle = $this->m_tr_model->add_new(

                                                        array(

                                                            "user_id" => $us->id,

                                                            "user_email" => $us->email,

                                                            "status" => 1,

                                                            "ip" => $_SERVER["REMOTE_ADDR"],

                                                            "title" => "İlan Güncellendi. Admin onayına gönderildi",

                                                            "description" => $kontrol->ad_name . " adlı ilan kullanıcı tarafından güncellendi ve yönetici onayına gönderildi",

                                                            "befores" => json_encode($kontrol),

                                                            "afters" => json_encode($kontrol2),

                                                        ),

                                                        "ft_logs"

                                                    );

                                                    $guncelle = $this->m_tr_model->updateTable("table_adverts", array("guncelleme_talep_at" => date("Y-m-d H:i:s"), "is_updated" => 1), array("id" => $kontrol->id));

                                                    echo json_encode(array("hata" => "yok", "message" => langS(104, 2, $gl)));

                                                } else {

                                                    $us = getActiveUsers();

                                                    $kontrol2 = getTableSingle("table_adverts", array("id" => $kontrol->id));

                                                    adminNot(getActiveUsers()->id, "ilan-guncelle/" . $kontrol->id, "İlan Mağaza Tarafından Güncellendi.", getActiveUsers()->email . " Adlı Üye <b>" . $kontrol->ad_name . " </b> adlı ilanını güncelledi. ");

                                                    $logEkle = $this->m_tr_model->add_new(

                                                        array(

                                                            "user_id" => $us->id,

                                                            "user_email" => $us->email,

                                                            "ip" => $_SERVER["REMOTE_ADDR"],

                                                            "title" => "İlan Mağaza Tarafından Güncellendi.",

                                                            "advert_id" => $kontrol->id,

                                                            "befores" => json_encode($kontrol),

                                                            "afters" => json_encode($kontrol2),

                                                            "status" => 1,

                                                            "description" => $kontrol->ad_name . " adlı ilan kullanıcı tarafından güncellendi."

                                                        ),

                                                        "ft_logs"

                                                    );

                                                    $guncelle = $this->m_tr_model->updateTable("table_adverts", array("status" => 1, "guncelleme_talep_at" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));

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

    public function proImageDelete($id = "")

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

                    $user = getActiveUsers();

                    if ($user) {

                        $temizle = strip_tags($id);

                        $kont = getTableSingle("table_adverts", array("ilanNo" => $temizle, "user_id" => $user->id));

                        if ($kont) {

                            if (is_numeric($this->input->post("data", true)) && ($this->input->post("data", true) == 1 || $this->input->post("data", true) == 2 || $this->input->post("data", true) == 3)) {

                                if ($this->input->post("data") == 2) {

                                    if ($kont->img_1 == "" && $kont->img_3 == "") {

                                        echo json_encode(array('hata' => 'var', "message" => langS(352, 2)));

                                    } else {

                                        if ($kont->img_2 != "") {

                                            unlink("upload/ilanlar/" . $kont->img_2);

                                            $guncelle = $this->m_tr_model->updateTable("table_adverts", array("img_2" => ""), array("id" => $kont->id));

                                            if ($guncelle) {

                                                echo json_encode(array('hata' => 'yok', "message" => langS(263, 2)));

                                            } else {

                                                echo json_encode(array('hata' => 'var', "message" => langS(22, 2)));

                                            }

                                        }

                                    }

                                } else if ($this->input->post("data") == 1) {

                                    if ($kont->img_2 == "" && $kont->img_3 == "") {

                                        echo json_encode(array('hata' => 'var', "message" => langS(352, 2)));

                                    } else {

                                        if ($kont->img_1 != "") {

                                            unlink("upload/ilanlar/" . $kont->img_1);

                                            $guncelle = $this->m_tr_model->updateTable("table_adverts", array("img_1" => ""), array("id" => $kont->id));

                                            if ($guncelle) {

                                                echo json_encode(array('hata' => 'yok', "message" => langS(263, 2)));

                                            } else {

                                                echo json_encode(array('hata' => 'var', "message" => langS(22, 2)));

                                            }

                                        }

                                    }

                                } else if ($this->input->post("data") == 3) {

                                    if ($kont->img_2 == "" && $kont->img_1 == "") {

                                        echo json_encode(array('hata' => 'var', "message" => langS(352, 2)));

                                    } else {

                                        if ($kont->img_3 != "") {

                                            unlink("upload/ilanlar/" . $kont->img_3);

                                            $guncelle = $this->m_tr_model->updateTable("table_adverts", array("img_3" => ""), array("id" => $kont->id));

                                            if ($guncelle) {

                                                echo json_encode(array('hata' => 'yok', "message" => langS(263, 2)));

                                            } else {

                                                echo json_encode(array('hata' => 'var', "message" => langS(22, 2)));

                                            }

                                        }

                                    }

                                }

                            }

                        } else {

                            http_response_code(403);

                            echo json_encode(['error' => 'İzin verilmeyen origin.']);

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

    public function upMyAdvert() {

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

                    $user = getActiveUsers();

                    if ($user) {

                        $temizle = strip_tags($this->input->post("id"));

                        $kont = getTableSingle("table_adverts", array("ilanNo" => $temizle, "user_id" => $user->id));

                        if ($kont) {

                            $opt = getTableSingle("table_options", array("id" => 1));

                            if(time() < (strtotime($user->magaza_son_tasima_tarihi) + (3600*$opt->ilan_tasima_saati))) {

                                echo json_encode(array('hata' => 'var', "message" => "İlanlarınızı " . $opt->ilan_tasima_saati . " saatte bir üste taşıma yapabilirsiniz. Bir sonraki taşıma için " . date('d.m.Y H:i:s',(strtotime($user->magaza_son_tasima_tarihi)+(3600*$opt->ilan_tasima_saati))) . "'den sonra tekrar deneyebilirsiniz."));

                            } else {

                                $adverts = getTableOrder("table_adverts",array("ilanNo!="=>$temizle),"order_no","asc");

                                $this->m_tr_model->updateTable("table_adverts",array("order_no"=>1),array("id"=>$kont->id));

                                $order = 2;

                                foreach($adverts as $item):

                                    $this->m_tr_model->updateTable("table_adverts",array("order_no"=>$order),array("id"=>$item->id));

                                    $order++;

                                endforeach;

                                $this->m_tr_model->updateTable("table_users",array("magaza_son_tasima_tarihi"=>date('Y-m-d H:i:s')),array("id"=>$user->id));

                                echo json_encode(array('hata' => 'yok', "message" => "İlanınız başarı ile üste taşındı."));

                            }

                        } else {

                            echo json_encode(array('hata'=>'var','message'=>'İlan bulunamadı.'));

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

    public function myAdvertsDelete()

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

                    $user = getActiveUsers();

                    if ($user) {

                        $temizle = strip_tags($this->input->post("veri"));

                        $kont = getTableSingle("table_adverts", array("ilanNo" => $temizle, "user_id" => $user->id));

                        if ($kont) {

                            $order = getTable("table_orders_adverts", array("id" => $kont->id, "status !=" => 4, "is_delete" => 0));

                            if ($order) {

                            } else {

                                $sil = $this->m_tr_model->updateTable("table_adverts", array("status" => 8, "delete_date" => date("Y-m-d H:i:s")), array("id" => $kont->id));

                                if ($sil) {

                                    adminNot(getActiveUsers()->id, "ilan-guncelle/" . $kont->id, "İlan Mağaza Tarafından Silindi.", getActiveUsers()->email . " Adlı Üye <b>" . $kont->ad_name . " </b> adlı ilanını sildi. ");

                                    $logEkle = $this->m_tr_model->add_new(

                                        array(

                                            "user_id" => getActiveUsers()->id,

                                            "user_email" => getActiveUsers()->email,

                                            "ip" => $_SERVER["REMOTE_ADDR"],

                                            "title" => "İlan Silindi. ",

                                            "description" => $kont->ad_name . " adlı ilan kullanıcı tarafından silindi",

                                        ),

                                        "ft_logs"

                                    );

                                    echo json_encode(array("hata" => "yok", "message" => langS(356, 2)));

                                } else {

                                    echo json_encode(array("hata" => "yok", "message" => langS(22, 2)));

                                }

                            }

                        } else {

                            http_response_code(403);

                            echo json_encode(['error' => 'İzin verilmeyen origin.']);

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

