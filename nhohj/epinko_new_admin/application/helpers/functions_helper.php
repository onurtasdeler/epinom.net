<?php

//login control

function custom_number_format($number, $decimals = 2, $dec_point = '.', $thousands_sep = '')

{

    $formatted_number = number_format($number, $decimals, $dec_point, $thousands_sep);



    // Eğer noktadan sonra sadece bir basamak varsa, bir sıfır ekleyin

    if (strpos($formatted_number, $dec_point) !== false && strlen(substr($formatted_number, strpos($formatted_number, $dec_point) + 1)) == 1) {

        $formatted_number .= '0';

    }



    // Eğer sayı tamsayı ise nokta ve ondalık kısmı ekle

    if ($decimals > 0 && strpos($formatted_number, $dec_point) === false) {

        $formatted_number .= $dec_point . str_repeat('0', $decimals);

    }



    return $formatted_number;

}

function loginControl($modul = 1)

{

    $t = &get_instance();

    if ($t->session->userdata("user1")) {

        $t->load->model("m_tr_model");



        if ($_SESSION["user1"]["type"] == 2) {

            if ($modul != -1) {

                $menu = getTableSingle("bk_menu", array("id" => $modul));



                if ($menu) {

                    if ($menu->urun == 1) {

                        $moduller = getTableSingle("table_moduller", array("id" => 1));

                        if ($moduller->status == 1) {

                        } else {

                            redirect(base_url("yetki-yok"));

                        }

                    } else {

                    }

                }

            }

        } else {

            if ($modul != -1) {



                $kontrol = getTableSingle("ft_users_yetki", array("modul_id" => $modul, "user_id" => $_SESSION["user1"]["id"]));

                if ($kontrol) {

                    $menu = getTableSingle("bk_menu", array("id" => $modul));

                    if ($menu) {

                        if ($menu->urun == 1) {

                            $moduller = getTableSingle("table_moduller", array("id" => 1));

                            if ($moduller->status == 1) {

                            } else {

                                redirect(base_url("yetki-yok"));

                            }

                        } else {

                        }

                    }

                } else {

                    redirect(base_url("yetki-yok"));

                }

            }

        }





        $t->formControl = uniqid("user_");

        setSession2("formCheck", $t->formControl);

    } else {

        redirect(base_url("login"));

    }

}



//get settings

function getSettings()

{

    return getTableSingle("options_general", array("id" => 1));

}



//get module

function getModule($id)

{

    return getTableSingle("module", array("id" => $id));

}





//---------------- ADVERTS ----------------------//

function addBalancePay($user_id, $type, $price, $desc, $ilan_id = 0, $pro_id = 0, $dop_id)

{

    $t = &get_instance();

    $t->load->model("m_tr_model");

    $cek = $t->m_tr_model->getTableSingle("table_users", array("id" => $user_id, "status" => 1, "banned" => 0));

    if ($cek) {

        $kaydet = $t->m_tr_model->add_new(array(

            "user_id" => $user_id,

            "type" => $type,

            "quantity" => $price,

            "description" => $desc,

            "ilan_id" => $ilan_id,

            "created_at" => date("Y-m-d H:i:s"),

            "product_id" => $pro_id,

            "doping_id" => $dop_id

        ), "table_users_balance_history");

        if ($kaydet) {

            if ($type == 1) {

                $guncelle = $t->m_tr_model->updateTable("table_users", array("balance" => ($cek->balance + $price)), array("id" => $cek->id));

            } else {

                $guncelle = $t->m_tr_model->updateTable("table_users", array("balance" => ($cek->balance - $price)), array("id" => $cek->id));

            }

            if ($guncelle) {

                return 1;

            } else {

                return 2;

            }

        } else {

            return 2;

        }

    }

}



function addNoti($user_id, $type, $noti_id, $advert_id = 0, $order_id = 0, $com = 0, $talep = 0)

{

    $t = &get_instance();

    $t->load->model("m_tr_model");

    $kaydet = $t->m_tr_model->add_new(array(

        "user_id" => $user_id,

        "type" => $type,

        "noti_id" => $noti_id,

        "advert_id" => $advert_id,

        "order_id" => $order_id,

        "comment_id" => $com,

        "created_at" => date("Y-m-d H:i:s"),

        "talep_id" => $talep

    ), "table_notifications_user");

}



//page create

function pageCreate($view, $data, $page, $postData)

{

    try {

        $t = &get_instance();

        if ($data["err"] == true) {

            $viewData = array(

                'view' => $view,

                'page' => $page,

                'data' => $data,

                'postData' => $postData

            );

        } else {

            $viewData = array(

                'view' => $view,

                'page' => $page,

                'data' => $data,

                'postData' => $postData

            );

        }

        $t->load->view("blank", $viewData);

    } catch (Exception $ex) {

        return $ex;

    }

}



//alert popup model

function createModal($title, $desc, $quitSelect, $mainButton, $id = "menu", $text = "")

{

?>

    <div class="modal" id="<?= $id ?>">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title"><?= $title ?></h5>

                    <button type="button" class="close" data-dismiss="modal"><span>×</span>

                    </button>

                </div>

                <div class="modal-body">

                    <p class="text-center text-dark">

                        <strong id="makaleId<?= ($id == "menu") ? "" : $id ?>"></strong>

                        <input type="hidden" id="silinecek<?= ($id == "menu") ? "" : $id ?>">

                        <input type="hidden" id="tur<?= ($id == "menu") ? "" : $id ?>">

                    </p>

                    <p class="text-center text-dark"><?= $desc ?></p>

                    <?php

                    if ($text != "") {

                    ?>

                        <input type="text" class="form-control" name="<?= $text["name"] ?>" id="<?= $text["name"] ?>" placeholder="<?= $text["place"] ?>">

                    <?php

                    }

                    ?>

                </div>

                <div class="modal-footer">

                    <?php

                    if ($quitSelect == 1) {

                    ?>

                        <button type="button" class="btn btn-warning light" data-dismiss="modal">Vazgeç</button>

                    <?php

                    }

                    ?>

                    <a class="btn <?= $mainButton[2] ?> light menu_sil" onclick="<?= $mainButton[1] ?>"> <i class="fa <?= $mainButton[3] ?>"></i><?= $mainButton[0] ?></a>

                </div>

            </div>

        </div>

    </div>

    <?php

}

function email_gonder($sTo, $sSubject, $sMessage, $id, $tur, $template)

{



    try {



        $t = &get_instance();

        $t->load->library('phpmailer_lib');

        $mail = $t->phpmailer_lib->load();

        $t->load->model("m_tr_model");

        $cek = $t->m_tr_model->getTableSingle("table_contact", array("id" => 1));

        // SMTP configuration

        $mail->isSMTP();

        $mail->SMTPAuth = true;

        $mail->SMTPSecure = "ssl";

        $mail->Host     = $cek->smtphost;

        $mail->Username = $cek->smtpuser;

        $mail->Password =  $cek->smtppass;

        $mail->Port     = $cek->smtpport;

        $mail->setFrom($cek->mmail, $cek->mad);

        $mail->addReplyTo($cek->mmail, $cek->mad);



        // Add a recipient

        $mail->addAddress($sTo);



        // Email subject

        $mail->Subject = $sSubject;

        $mail->CharSet = 'UTF-8';



        // Set email format to HTML



        $mail->isHTML(true);



        //$site=file_get_contents($template);

        // Email body content

        $arrContextOptions = array(

            "ssl" => array(

                "verify_peer" => false,

                "verify_peer_name" => false,

            ),

        );



        $veri = file_get_contents($template, false, stream_context_create($arrContextOptions));

        $mail->msgHTML($veri);

        // Send email

        if (!$mail->send()) {

            //echo $mail->ErrorInfo;

            return false;

        } else {

            return true;

        }

    } catch (phpmailerException $e) {

        return false;

    }

}





function sendMails($sTo, $lang = 1, $tur = 1, $uye = 0,$extra="")

{

    $t = &get_instance();

    $t->load->library('phpmailer_lib');

    $mail = $t->phpmailer_lib->load();

    $t->load->model("m_tr_model");

    $cek = $t->m_tr_model->getTableSingle("table_contact", array("id" => 1));

    // SMTP configuration

    $mail->isSMTP();

    $mail->SMTPAuth = true;

    $mail->SMTPSecure = "ssl";



    $mail->Host     = $cek->smtphost;

    $mail->Username = $cek->smtpuser;

    $mail->Password =  $cek->smtppass;

    $mail->Port     = $cek->smtpport;

    $mail->setFrom($cek->mmail, $cek->mad);

    $mail->addReplyTo($cek->mmail, $cek->mad);

    // Add a recipient

    if ($sTo == "admin") {

        $mail->addAddress($cek->mmail);

    } else {

        $mail->addAddress($sTo);

    }



    $sablon = email_sablon_getir($tur, $uye, $lang, $extra);

    // Email subject

    if ($sablon) {

        $mail->Subject = $sablon["subject"];

        $mail->CharSet = 'UTF-8';

        // Set email format to HTML

        $mail->isHTML(true);

        $mail->msgHTML($sablon["content"]);

        // Send email

        if (!$mail->send()) {

            echo $mail->ErrorInfo;

            return false;

        } else {

            return true;

        }

    }

}



function email_sablon_getir($id = 1, $uye = 0, $lang = 1, $extra = "")

{

    $t = &get_instance();

    $t->load->model("m_tr_model");

    $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

    if ($id == 1) {

        //şifre güncellme

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $sifre = getLangValue(27, "table_pages", $lang);

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[kullanici]", $uye->name_surname, $veri);

            $veri = str_replace("[link]", base_url(gg($lang) . $sifre->link . "?token=" . $uye->pass_update_uniq), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 2) {

        //üyelik onayı

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $sifre = getTableSingle("table_pages", array("id" => 94));

            $ex = json_decode($sifre->field_data);

            foreach ($ex as $s) {

                if ($s->lang_id == 1) {

                    $link = $s->link;

                    break;

                }

            }



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[kullanici]", $uye->name_surname, $veri);

            $veri = str_replace("[link]", $cek->site_link . "/" . $link . "?token=" . $uye->email_onay_kod, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 3) {

        //ilan sipariş teslimat satıcı

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $uye = getTableSingle("table_orders_adverts", array("id" => $uye->id));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $veri = str_replace("[price]", number_format($uye->price_total, 2) . " " . getcur(), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 4) {

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $magaza = getTableSingle("table_users", array("id" => $uye->user_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->admin_onay_at)), $veri);

            $veri = str_replace("[ilan_adi]", $uye->ad_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 6) {

        //talep beklemede admin

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == 2) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $uyes = getTableSingle("table_users", array("id" => $uye->user_id));

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $sifre = getLangValue(35, "table_pages", $lang);

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[tarih]", $uye->created_at, $veri);

            $veri = str_replace("[adsoyad]", $uyes->name_surname, $veri);

            $veri = str_replace("[email]", $uyes->email, $veri);

            $veri = str_replace("[ulke]", $uyes->country_name, $veri);

            $veri = str_replace("[talepno]", "#" . $uye->request_no, $veri);

            $veri = str_replace("[talepadi]", $uye->title, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 10) {

        //üyeden markaya manuel talep

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == 2) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[uyeadi]", $uye->name_surname, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 5) {

        //ilan sipariş teslimat alici

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $uye = getTableSingle("table_orders_adverts", array("id" => $uye->id));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $magaza = getTableSingle("table_users", array("id" => $uye->sell_user_id));

            $kod = getTableSingle("table_adverts_stock", array("order_id" => $uye->id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[magaza]", $magaza->magaza_name, $veri);

            $veri = str_replace("[code]", $kod->code, $veri);

            $veri = str_replace("[price]", number_format($uye->price_total, 2) . " " . getcur(), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 8) {

        //Yeni Mesaj Satıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $mesaj = getTableSingle("table_users_message", array("id" => $uye));

            $satici = getTableSingle("table_users", array("id" => $mesaj->seller_id));

            $alici = getTableSingle("table_users", array("id" => $mesaj->user_id));

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($mesaj->created_at)), $veri);

            $veri = str_replace("[uyeadi]", $alici->nick_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 16) {

        //Yeni Mesaj Alıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $mesaj = getTableSingle("table_users_message", array("id" => $uye));

            $satici = getTableSingle("table_users", array("id" => $mesaj->seller_id));

            $alici = getTableSingle("table_users", array("id" => $mesaj->user_id));

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($mesaj->created_at)), $veri);

            $veri = str_replace("[uyeadi]", $satici->magaza_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 9) {

        //üyeden markaya yanıt verildiğinde

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $uyes = getTableSingle("table_users", array("id" => $uye->user_id));

            $taleps = getTableSingle("table_request", array("id" => $uye->r_id));

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[resimyol]", base_url("assets/img/mail/yenimesaj.png"), $veri);

            $veri = str_replace("[talepno]", "#" . $taleps->request_no, $veri);

            $veri = str_replace("[talepadi]", $taleps->title, $veri);

            $veri = str_replace("[markaadi]", $uyes->company_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 11) {

        //markadan üyeye manuel yanıt

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $uyes = getTableSingle("table_users", array("id" => $_SESSION["userUser"]["users"]));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[resimyol]", base_url("assets/img/mail/yenimesaj.png"), $veri);

            $veri = str_replace("[markaadi]", $uyes->company_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 12) {

        //markadan üyeye manuel yanıt

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $uyes = getTableSingle("table_users", array("id" => $_SESSION["userUser"]["users"]));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[resimyol]", base_url("assets/img/mail/yenimesaj.png"), $veri);

            $veri = str_replace("[uyeadi]", $uyes->name_surname, $veri);

            $veri = str_replace("[talepno]", "#45" . $uye->id, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 13) {

        //ilan sipariş teslimat bekleniyor satıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $veri = str_replace("[price]", number_format($uye->price_total, 2) . " " . getcur(), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 14) {

        //ilan sipariş teslimat bekleniyor alıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_seller_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[magaza]", $alici->magaza_name, $veri);

            $veri = str_replace("[price]", number_format($uye->price_total, 2) . " " . getcur(), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 17) {

        //ilan sipariş teslimat onayı bilgilendirme alıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->sell_user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[magaza]", $alici->magaza_name, $veri);

            $veri = str_replace("[price]", number_format($uye->price_total, 2) . " " . getcur(), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 18) {

        //ilan sipariş mağazadan alıcıya canlı sohbet üzerinden mesaj

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veriler = $t->m_tr_model->getTableSingle("table_orders_adverts_message", array("id" => $uye));

            $order = $t->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $veriler->order_idd));





            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $order->sell_user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $veriler->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($veriler->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $order->sipNo, $veri);

            $veri = str_replace("[magaza]", $alici->magaza_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 19) {

        //ilan sipariş mağazadan alıcıya canlı sohbet üzerinden mesaj

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veriler = $t->m_tr_model->getTableSingle("table_orders_adverts_message", array("id" => $uye));

            $order = $t->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $veriler->order_idd));





            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $order->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $veriler->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($veriler->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $order->sipNo, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 20) {

        //ilan sipariş alıcı teslimat onayı yönetici onayı olacağı durumda satıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->created_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $sure = $ay->ads_balance_send_time . " Saat";

            $veri = str_replace("[time]", $sure, $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 21) {

        //ilan sipariş alıcı tarafında iptal edildi

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->kullanici_iptal_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $veri = str_replace("[sebep]", $alici->red_nedeni, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 22) {

        //ilan sipariş yönetici tarafında onaylandı alıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->sell_user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->admin_onay_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[magaza]", $alici->magaza_name, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 23) {

        //ilan sipariş yönetici tarafında onaylandı satıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->admin_onay_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 24) {

        //ilan sipariş yönetici tarafında reddedildi satıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->admin_red_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[sebep]", "#" . $uye->red_nedeni, $veri);

            $veri = str_replace("[alici]", $alici->nick_name, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 25) {

        //ilan sipariş yönetici tarafında reddedildi alıcıya

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));



            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $alici = getTableSingle("table_users", array("id" => $uye->sell_user_id));

            $ilan = getTableSingle("table_adverts", array("id" => $uye->advert_id));

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->admin_red_at)), $veri);

            $veri = str_replace("[ilanadi]", $ilan->ad_name, $veri);

            $veri = str_replace("[sipno]", "#" . $uye->sipNo, $veri);

            $veri = str_replace("[sebep]", "#" . $uye->red_nedeni, $veri);

            $veri = str_replace("[magaza]", $alici->magaza_name, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 27) {

        //mağaza onay bildirimi

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[resimyol]", $cek->site_link . "/assets/img/mail/check.png", $veri);

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->magaza_onay_date)), $veri);

            $veri = str_replace("[magaza_adi]", "#" . $uye->magaza_name, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else  if ($id == 28) {

        //mağaza red bildirimi

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }

            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[resimyol]", $cek->site_link . "/assets/img/mail/settings.png", $veri);

            $veri = str_replace("[tarih]", date("d-m-Y H:i", strtotime($uye->magaza_red_at)), $veri);

            $veri = str_replace("[magaza_adi]", "#" . $uye->magaza_name, $veri);

            $veri = str_replace("[sebep]", "#" . $uye->magaza_red_nedeni, $veri);

            $ay = getTableSingle("table_options", array("id" => 1));

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    } else if ($id == 37) {

        //bakiye iade talebi

        $content = "";

        $subject = "";

        $ceks = getTableSingle("table_mail_templates", array("id" => $id));

        if ($ceks->field_data) {

            $par = json_decode($ceks->field_data);

            foreach ($par as $item) {

                if ($item->lang_id == $lang) {

                    $content = $item->content;

                    $subject = $item->konu;

                }

            }



            $statusText = 'İşlemde';

            $amount = 0;

            if ($extra['status'] == 2) {

                $statusText = 'Onaylandı';

                $amount = $extra['paymentLog']->amount + $extra['paymentLog']->komisyon;

            } else if ($extra['status'] == 3) {

                $statusText = 'Reddedildi';

                $amount = $extra['paymentLog']->amount + $extra['paymentLog']->komisyon;

            }



            $cek = $t->m_tr_model->getTableSingle("options_general", array("id" => 1));

            $veri = str_replace("[logo]", "<img width='200px' style='width:200px' src='" . $cek->site_link . "/upload/logo/" . $cek->site_logo_light . "'>", $content);

            $veri = str_replace("[reqno]", $extra['refundInfo']->id, $veri);

            $veri = str_replace("[status]", $statusText, $veri);

            $veri = str_replace("[amount]", number_format($amount, 2) . " " . getcur(), $veri);

            $veri = str_replace("[balance]", number_format($uye->balance, 2) . " " . getcur(), $veri);

            $veri = $ceks->top . $veri . $ceks->bottom;

            return array("content" => $veri, "subject" => $subject);

        }

    }

}







//module create Form

function getModuleForm($name, $data = null, $type)

{

    $t = &get_instance();

    $getRow = getTableSingle("module", array("name" => $name, "status" => 1));

    if ($getRow) {

        $expName = explode(",", $getRow->form_field);

        $expType = explode(",", $getRow->form_field_type);

        $expText = explode(",", $getRow->form_text);

        $expCol = explode(",", $getRow->form_field_col);

        $expRequired = explode(",", $getRow->form_field_required);

        $sayac = 0;



        if ($expName) {

            foreach ($expName as $item) {

    ?>

                <div class="form-group row">

                    <label class="col-lg-<?= (12 - $expCol[$sayac]) ?> col-form-label"><strong><?= $expText[$sayac] ?>:</strong>

                    </label>

                    <div class="col-lg-<?= $expCol[$sayac] ?>">

                        <?php

                        //select box



                        $arama_sonucu = strstr($expType[$sayac], "select");

                        if ($arama_sonucu !== FALSE) {

                            $expSelect = explode("/", $expType[$sayac]);

                            if ($expSelect[1] == "status") {

                                if ($type == "upd") {

                                    if ($data->$item == 1) {

                        ?>

                                        <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">

                                            <option value="0">Pasif</option>

                                            <option value="1" selected>Aktif</option>

                                        </select>

                                    <?php

                                    } else {

                                    ?>

                                        <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">

                                            <option value="0" selected>Pasif</option>

                                            <option value="1">Aktif</option>

                                        </select>

                                    <?php

                                    }

                                } else {

                                    ?>

                                    <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">

                                        <option value="0">Pasif</option>

                                        <option value="1" selected>Aktif</option>

                                    </select>

                                <?php

                                }

                            } else {

                                $getResult = getTableOrder($expSelect[1], array("status" => 1), "id", "asc");

                                if ($getResult) {

                                ?>

                                    <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">

                                        <option value="">Seçiniz</option>

                                        <?php

                                        foreach ($getResult as $item2) {

                                            if ($type == "upd") {

                                                if ($item2->id == $data->$item) {

                                        ?>

                                                    <option selected value="<?= $item2->id ?>"><?= $item2->name ?></option>

                                                <?php

                                                } else {

                                                ?>

                                                    <option value="<?= $item2->id ?>"><?= $item2->name ?></option>

                                                <?php

                                                }

                                            } else {

                                                ?>

                                                <option value="<?= $item2->id ?>"><?= $item2->name ?></option>

                                        <?php

                                            }

                                        }

                                        ?>

                                    </select>

                                <?php

                                }

                            }

                        } else {

                            if ($type == "upd") {

                                ?> <input type="<?= $expType[$sayac] ?>" name="<?= $item ?>" value="<?php if (!is_null($data)) {

                                                                                                        echo $data->$item;

                                                                                                    } ?>" id="<?= $item ?>" class="form-control" autocomplete="off"> <?php

                                                                                                                                                                                                                } else {

                                                                                                                                                                                                                    ?> <input type="<?= $expType[$sayac] ?>" name="<?= $item ?>" value="<?php if (!is_null($data)) {

                                                                                                                                                                                                                        echo $data[$item];

                                                                                                                                                                                                                    } ?>" id="<?= $item ?>" class="form-control" autocomplete="off"> <?php

                                                                                                                                                                                                                }

                                                                                                                                                                                                            }

                                                                                                                                                                                                                    ?>

                    </div>

                </div>

    <?php

                $sayac++;

            }

        }

    }

}



//module form validation control

function getModuleFormValidation($form, $module)

{

    try {

        $t = &get_instance();

        if ($form) {

            $t->load->library('form_validation');

            $getModule = getModule($module);

            if ($getModule) {

                $t->load->library('form_validation');

                $exp = explode(",", $getModule->form_field);

                $expText = explode(",", $getModule->form_text);

                $expRequired = explode(",", $getModule->form_field_required);

                $co = 0;

                foreach ($exp as $item) {

                    if ($expRequired[$co] == 1) {

                        $t->form_validation->set_rules($item, $expText[$co], 'trim|required');

                    }

                    $co++;

                }

                $t->form_validation->set_message(array(

                    "required"    =>    "{field} alanı boş geçilemez."

                ));

                if ($t->form_validation->run() != FALSE) {

                    return array("err" => false, "message" => "");

                } else {

                    return array("err" => true, "type" => 1, "message" => validation_errors());

                }

            } else {

                return array("err" => true, "type" => 1, "message" => "Böyle bir modül bulunmamaktadır.");

            }

        }

    } catch (Exception $e) {

        return $e->getMessage();

    }

}



//form validate alert

function formValidateAlert($type, $message, $icon)

{

    ?>



    <div class="alert alert-custom alert-outline-<?= $type ?> fade show mb-5" role="alert">

        <div class="alert-icon"><i class="<?= $icon ?>"></i></div>

        <div class="alert-text"><?= $message ?></div>

        <div class="alert-close">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true"><i class="ki ki-close"></i></span>

            </button>

        </div>

    </div>

<?php

}



//img upload

function img_upload($file, $filename, $folder, $sil = "", $path, $uzanti)

{

    try {

        $t = &get_instance();

        if ($sil != "") {

            if (file_exists($path . $sil)) {

                unlink($path . $sil);

            }

        }

        $dosya        =    $file['name']; // dosya ismini aldık

        $f1 = "";

        $target_dir = "../upload/" . $folder . "/";

        $target_file = $target_dir . basename($file["name"]);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $ayarlar = getTableSingle("options_general", array("id" => 1));

        $newfilename = permalink($ayarlar->site_name . "-" . $filename . "-" . uniqid(rand(1, 1000))) . "." . $imageFileType;

        if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "webp" || $imageFileType == "svg" || $imageFileType == "gif"  || $imageFileType == "GIF") {

            if ($uzanti) {

                if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {

                    $f1 = $newfilename;

                }

            } else {

                if ($imageFileType == "gif"  || $imageFileType == "GIF") {

                    if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {

                        $f1 = $newfilename;

                    }

                } else {

                    $newfilename = permalink($ayarlar->site_name . "-" . $filename . "-" . uniqid(rand(1, 1000)));

                    $image_f = upload_picture($file, $folder, $newfilename, "");

                    $f1 = $image_f . ".webp";

                }

            }

            return  $f1;

        } else {

            return 1;

        }

    } catch (Exception $ex) {

        return "error";

    }

}



function img_upload_category($file, $filename, $folder, $sil = "", $path, $uzanti)

{

    try {

        $t = &get_instance();

        if ($sil != "") {

            if (file_exists($path . $sil)) {

                unlink($path . $sil);

            }

        }

        $dosya        =    $file['name']; // dosya ismini aldık

        $f1 = "";

        $target_dir = "../upload/" . $folder . "/";

        $target_file = $target_dir . basename($file["name"]);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $ayarlar = getTableSingle("options_general", array("id" => 1));

        $newfilename = permalink($ayarlar->site_name . "-" . $filename . "-" . uniqid(rand(1, 1000))) . "." . $imageFileType;

        if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "webp" || $imageFileType == "svg" || $imageFileType == "gif"  || $imageFileType == "GIF") {

            if ($uzanti) {

                if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {

                    $f1 = $newfilename;

                }

            } else {

                $newfilename = permalink($ayarlar->site_name . "-" . $filename . "-" . uniqid(rand(1, 1000)));

                $image_f = upload_picture_category($file, $folder, $newfilename, "");

                $f1 = $image_f . ".webp";

            }

            return  $f1;

        } else {

            return 1;

        }

    } catch (Exception $ex) {

        return "error";

    }

}



//get words count





function tokengenerator($uzunluk, $tur = 1)

{

    if ($tur == 1) {

        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" . "abcdefghijklmnopqrstuvwxyz" . "0123456789";

    } else if ($tur == 2) {

        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" . "0123456789";

    } else {

        $char =  "0123456789";

    }

    $str  = "";

    while (strlen($str) < $uzunluk) {

        $str .= substr($char, (rand() % strlen($char)), 1);

    }

    return ($str);

}



function IsNullOrEmptyString($str)

{

    return ($str === null || trim($str) === '');

}



function turkishcharacters($string)

{

    $string = str_replace('&ccedil;', 'ç', $string);

    $string = str_replace('&yacute;', 'ı', $string);

    $string = str_replace('&Ccedil;', 'Ç', $string);

    $string = str_replace('&Ouml;', 'Ö', $string);

    $string = str_replace('&Yacute;', 'Ü', $string);

    $string = str_replace('&ETH;', 'Ğ', $string);

    $string = str_replace('&THORN;', 'Ş', $string);

    $string = str_replace('&Yacute;', 'İ', $string);

    $string = str_replace('&ouml;', 'ö', $string);

    $string = str_replace('&thorn;', 'ş', $string);

    $string = str_replace('&eth;', 'ğ', $string);

    $string = str_replace('&uuml;', 'ü', $string);

    $string = str_replace('&yacute;', 'ı', $string);

    $string = str_replace('&amp;', '&', $string);



    return $string;

}



function ucwords_tr($str)

{

    return ltrim(mb_convert_case(str_replace(array('i', 'I'), array('İ', 'ı'), mb_strtolower($str)), MB_CASE_TITLE, 'UTF-8'));

}



function trtekkelime($gelen)

{

    $uzunluk = strlen($gelen);

    $ilkharf = mb_substr($gelen, 0, 1, "UTF-8");

    $sonrakiharfler = mb_substr($gelen, 1, $uzunluk, "UTF-8");

    $bir = array("ö", "ç", "i", "ş", "ğ", "ü");

    $iki = array("Ö", "Ç", "İ", "Ş", "Ğ", "Ü");

    $buyumus = str_replace($bir, $iki, $ilkharf);

    return ucwords($buyumus) . $sonrakiharfler;

}



/// İmage Delete

function img_delete($url)

{

    if (file_exists("../upload/" . $url)) {

        unlink("../upload/" . $url);

    }

}



function getcur()

{

    $t = &get_instance();

    $t->load->model("m_tr_model");

    $tt = $t->m_tr_model->getTableSingle("kurlar", array("is_main" => 1));

    if ($tt) {

        return $tt->name_short;

    }

}

