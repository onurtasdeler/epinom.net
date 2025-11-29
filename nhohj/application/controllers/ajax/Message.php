<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message extends CI_Controller
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










    //siparişler ajax liste
    public function adsNewmessage()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            $this->load->helper("security");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                if ($this->input->post("user", true) && $this->input->post("token", true) && $this->input->post("mesaj", true)) {
                    $token = getActiveUsers();
                    if (!$token) {
                        echo json_encode(array("err" => "oturum"));
                    } else {
                        $temizle = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj", true))));
                        $tokens = strrev(htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("token", true)))));
                        $sorgula = getTableSingle("table_adverts", array("ilanNo" => $tokens));
                        if ($sorgula) {
                            if (!ClearText($temizle)) {
                                $islemNo = tokengenerator(8, 2);
                                $kaydet = $this->m_tr_model->add_new(array(
                                    "user_id" => $token->id,
                                    "advert_id" => $sorgula->id,
                                    "seller_id" => $sorgula->user_id,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "islemNo" => $islemNo
                                ), "table_users_message_gr");
                                if ($kaydet) {
                                    $kaydet2 = $this->m_tr_model->add_new(array(
                                        "user_id" => $token->id,
                                        "gr_id" => $kaydet,
                                        "seller_id" => $sorgula->user_id,
                                        "advert_id" => $sorgula->id,
                                        "type" => 0,
                                        "message" => $temizle,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "islemNo" => $islemNo
                                    ), "table_users_message");
                                    //bildirim ve email gönderilecek
                                    $bildirimEkle = $this->m_tr_model->add_new(array(
                                        "user_id" => $sorgula->user_id,
                                        "noti_id" => 25,
                                        "type" => 1,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "status" => 1,
                                        "mesaj_id" => $kaydet,
                                        "advert_id" => $sorgula->id
                                    ), "table_notifications_user");
                                    $satici = getTableSingle("table_users", array("id" => $sorgula->user_id));
                                    if ($satici) {
                                        $mailGonder = email_gonder($satici->email, ucfirst($token->nick_name) . " Adlı Kullanıcıdan Yeni Mesajınız Var.", "", "", 1, base_url("temp-mail/17/test/" . $token->id . "/" . $sorgula->id));
                                    }
                                    $logEkle = $this->m_tr_model->add_new(array(
                                        "status" => 1,
                                        "user_id" => $token->id,
                                        "user_email" => $token->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "Üye Yeni Mesaj Oluşturdu",
                                        "description" => $token->nick_name . " adlı üye " . $sorgula->ad_name . " adlı ilan için yeni sohbet oluşturdu.",
                                        "date" => date("Y-m-d H:i:s"),
                                        "advert_id" => $sorgula->id
                                    ), "ft_logs");
                                    echo json_encode(array("err" => false, "message" => langS(421, 2, $this->input->post("lang"))));
                                } else {
                                    $logEkle = $this->m_tr_model->add_new(array(
                                        "status" => 2,
                                        "user_id" => $token->id,
                                        "user_email" => $token->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "Üye Mesaj Oluşturma Hata",
                                        "description" => $token->nick_name . " adlı üye " . $sorgula->ad_name . " adlı ilana mesaj oluştururken beklenmedik bir hata meydana geldi",
                                        "date" => date("Y-m-d H:i:s"),
                                        "advert_id" => $sorgula->id
                                    ), "ft_logs");
                                    echo json_encode(array("err" => true, "message" => langS(59, 2, $this->input->post("lang"))));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => langS(346, 2, $this->input->post("lang"))));
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => langS(59, 2, $this->input->post("lang")), "tr" => 1));
                        }
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "adsNEWmessage kontrolSession", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", "adsNEWmessage kontrolSession ", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "adsNEWmessage POST Liste", 3);
        }

    }



    ///silinecek
    public function addAdsmessage()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();

                if ($user) {
                    if ($this->input->post("types")) {
                        if ($this->input->post("talep")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $kkontrol = $this->m_tr_model->getTableSingle("table_users_message", array("islemNo" => $talep));
                            if ($kkontrol) {
                                header('Content-Type: application/json');
                                $cekSohbet = getTableOrder("table_users_message", array("islemNo" => $talep), "created_at", "asc");
                                if ($cekSohbet) {
                                    $cekm = $this->m_tr_model->getTable("table_users_message", array("user_id <>" => $user->id, "is_read" => 0, "islemNo" => $talep));
                                    if ($cekm) {
                                        foreach ($cekm as $itemM) {
                                            $guncelle = $this->m_tr_model->updateTable("table_users_message", array("is_read" => 1), array("id" => $itemM->id));
                                        }
                                    }
                                    //$satici=getTableSingle("table_adverts",array("id" => $cekSohbet->advert_id));
                                    foreach ($cekSohbet as $item) {
                                        $satici = $this->m_tr_model->getTableSingle("table_users", array("id" => $item->seller_id));
                                        $alici = $this->m_tr_model->getTableSingle("table_users", array("id" => $item->user_id));
                                        $tarih1 = new DateTime($item->created_at);
                                        $tarih2 = new DateTime();
                                        $interval = $tarih2->diff($tarih1);
                                        $fark = "";
                                        if ($interval->format('%a') > 0) {
                                            $fark = " - " . $interval->format('%a ' . langS(93, 2, $this->input->post("lang")) . " " . langS(274, 2, $this->input->post("lang")));
                                        } else {
                                            $fark = " - " . langS(275, 2, $this->input->post("lang"));
                                        }


                                        if ($item->seller_id == $user->id) {
                                            if ($item->type == 1) {
                                                if ($satici->image == "") {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                } else {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("upload/users/" . $satici->image) . '" alt="avatar">';
                                                }
                                                $str .= '<li class="clearfix">
                                                <div class="message-data text-right">
                                                   
                                                    <span class="message-data-time ">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                     ' . $im . '
                                                </div>';
                                                if ($item->is_deleted == 1) {
                                                    $str .= '<div  class="bg-danger message other-message float-right">' . langS(346, 2, $this->input->post("lang")) . '</div>
                                            </li>';
                                                } else {
                                                    if ($item->is_read == 1) {
                                                        $str .= '<div style="position:relative" class="message other-message float-right ">
            <div class="after"><i class="mdi mdi-check-all text-success"></i></div>
' . $item->message . '</div>
                                            </li>';
                                                    } else {
                                                        $str .= '<div style="position:relative" class="message other-message float-right ">
            <div class="after"><i class="mdi mdi-check-all "></i></div>
' . $item->message . '</div>
                                            </li>';
                                                    }

                                                }


                                            } else {
                                                if ($alici->image == "") {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                } else {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("upload/users/" . $alici->image) . '" alt="avatar">';
                                                }

                                                $str .= '<li class="clearfix">
                                                <div class="message-data ">
                                                ' . $im . '
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                   
                                                </div>';
                                                if ($item->is_deleted == 1) {
                                                    $str .= '<div class=" bg-danger  message  my-message">' . langS(346, 2, $this->input->post("lang")) . '</div>
                                            </li>';
                                                } else {
                                                    $str .= '<div class="message  my-message" style="position:relative">' . $item->message . '</div>
                                            </li>';
                                                }
                                            }
                                        } else {
                                            if ($item->type == 1) {
                                                if ($satici->image == "") {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                } else {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("upload/users/" . $satici->image) . '" alt="avatar">';
                                                }
                                                $str .= '<li class="clearfix">
                                                <div class="message-data">
                                                    ' . $im . '
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                </div>';
                                                if ($item->is_deleted == 1) {
                                                    $str .= '<div class=" bg-danger  message my-message">' . langS(346, 2, $this->input->post("lang")) . '</div>
                                            </li>';
                                                } else {
                                                    $str .= '<div class="message my-message" style="position:relative">' . $item->message . '</div>
                                            </li>';
                                                }


                                            } else {
                                                if ($user->image == "") {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                } else {
                                                    $im = ' <img width="40" height="40" style="border-radius:3px !important" src="' . base_url("upload/users/" . $user->image) . '" alt="avatar">';
                                                }

                                                $str .= '<li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                   ' . $im . '
                                                </div>';
                                                if ($item->is_deleted == 1) {
                                                    $str .= '<div class="bg-danger  message other-message float-right">' . langS(346, 2, $this->input->post("lang")) . '</div>
                                            </li>';
                                                } else {
                                                    if ($item->is_read == 1) {
                                                        $str .= '<div class="message other-message float-right" style="position:relative"><div class="after"><i class="mdi mdi-check-all text-success"></i></div>' . $item->message . '</div>
</li>';
                                                    } else {
                                                        $str .= '<div class="message other-message float-right" style="position:relative"><div class="after"><i class="mdi mdi-check-all "></i></div>' . $item->message . '</div>
</li>';
                                                    }

                                                }
                                            }
                                        }


                                    }
                                    echo json_encode(array("veri" => $str, "status" => $kkontrol->status));
                                } else {

                                }
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => "oturum"));
                        }
                    } else {
                        header('Content-Type: application/json');
                        if ($this->input->post("talep") && $this->input->post("mesaj")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $mesaj = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj"))));
                            $kkontrol = $this->m_tr_model->getTableSingle("table_users_message", array("islemNo" => $talep));
                            $kkontrolss = $this->m_tr_model->getTableSingle("table_users_message_gr", array("islemNo" => $talep));
                            if ($kkontrol) {
                                $advert = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $kkontrol->advert_id));
                                $sorgula = $this->m_tr_model->getTableOrder("table_users_message", array("islemNo" => $talep), "id", "desc",3);
                                $ss = "";
                                foreach ($sorgula as $item) {
                                    if ($item->user_id == $user->id) {
                                        $ss++;
                                    }
                                }

                                if ($ss >= 3) {
                                    echo json_encode(array("err" => true, "message" => langS(345, 2, $this->input->post("lang"))));
                                } else {
                                    $yasakli = 0;
                                    if (ClearText($mesaj) == true) {
                                        $yasakli = 1;
                                    } else {
                                        $yasakli = 0;
                                    }
                                    $t = "";
                                    if ($advert->user_id == $user->id) {
                                        $t = 1;
                                    } else {
                                        $t = 0;
                                    }
                                    $kaydet = $this->m_tr_model->add_new(array(
                                        "advert_id" => $kkontrol->advert_id,
                                        "type" => $t,
                                        "message" => $mesaj,
                                        "gr_id" => $kkontrolss->id,
                                        "status" => 1,
                                        "seller_id" => $advert->user_id,
                                        "user_id" => $user->id,
                                        "is_deleted" => $yasakli,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "islemNo" => $kkontrol->islemNo
                                    ), "table_users_message");
                                    if ($kaydet) {
                                        if ($yasakli == 0) {
                                            echo json_encode(array("err" => false, "message" => langS(278, 2, $this->input->post("lang"))));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(346, 2, $this->input->post("lang"))));
                                        }
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(38, 2, $this->input->post("lang"))));
                                    }
                                }


                            } else {
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        }
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "addAdsmessage formcontrol", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "addAdsmessage post", 3);
        }
    }

    public function getSelectedMessage()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                if ($user) {
                    header('Content-Type: application/json');
                    if ($this->input->post("token")) {
                        $kontrol = strrev($this->input->post("token"));
                        $cek = $this->m_tr_model->getTableSingle("table_users", array("token" => $kontrol));
                        if ($cek) {
                            $cekBenim = $this->m_tr_model->query("select * from table_users_message_gr where user_id=" . $user->id . " or  seller_id=" . $user->id);
                            $bulunanlarislem[] = "";
                            foreach ($cekBenim as $cc) {
                                if ($cc->user_id != $user->id) {
                                    $bulunanlarislem[] = $cc->islemNo;
                                }
                                if ($cc->seller_id != $user->id) {
                                    $bulunanlarislem[] = $cc->islemNo;
                                }
                            }

                            $bulunanlarislem = array_filter(array_unique($bulunanlarislem));
                            $strb = "";
                            foreach ($bulunanlarislem as $bul) {
                                $strb .= "'" . $bul . "',";
                            }

                            $strb = ltrim(rtrim(ltrim($strb, ","), ","), '"');
                            $uyepage = getLangValue(44, "table_pages", $this->input->post("lang"));
                            $ilanPage = getLangValue(34, "table_pages", $this->input->post("lang"));
                            $mesajPage = getLangValue(38, "table_pages", $this->input->post("lang"));
                            $sorgu = $this->m_tr_model->query("select * from table_users_message where islemNo in(" . $strb . ") group by islemNo order by id desc ");
                            foreach ($sorgu as $item) {
                                if (($item->user_id == $user->id || $item->seller_id == $user->id) and ($item->user_id == $cek->id || $item->seller_id == $cek->id)) {
                                    $ilanManuel = getTableSingle("table_adverts", array("id" => $item->advert_id));
                                    $resim = getTableSingle("table_adverts_image", array("id" => $ilanManuel->selected_image, "status" => 1));
                                    $ilan = getLangValue($ilanManuel->id, "table_adverts", $this->input->post("lang"));
                                    if ($item->user_id == $user->id) {
                                        $users = getTableSingle("table_users", array("id" => $item->seller_id));
                                    } else {
                                        $users = getTableSingle("table_users", array("id" => $item->user_id));
                                    }

                                    $ad = "";
                                    if ($ilan->name == "") {
                                        $ad = $item->ad_name;
                                    } else {
                                        $ad = $ilan->name;
                                    }
                                    $sonmesaj = $this->m_tr_model->queryRow("select * from table_users_message where islemNo='" . $item->islemNo . "' order by id desc limit 1");
                                    $okunmamis = $this->m_tr_model->query("select count(*) as say from table_users_message where gr_id=" . $item->gr_id . " and is_read=0");

                                    $str .= '<div class="col-lg-12">
                                           <div class="box">
                                               <div class="row">
                                                   <div class="col-lg-2 col-4" style="padding-right: 0px !important;">
                                                       <img  style="width:100% !important;" src="' . base_url("upload/ilanlar/default/" . $resim->image) . '" alt="">
                                                   </div>
                                                       <div class="col-lg-6 col-8" style="padding-left: 8px !important;">
                                                           <h5><a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . $ilan->link) . '">' . kisalt($ad, 35) . '</a></h5>
                                                           <p class="sMesaj">' . langS(431, 2, $this->input->post("lang")) . ' ' . date("Y-m-d H:i", strtotime($sonmesaj->created_at)) . '</p>';
                                    $v = "";
                                    $v1 = "";
                                    if ($okunmamis) {
                                        if ($okunmamis[0]->say > 0) {
                                            $v1 = "online";
                                            $v = str_replace("{sayi}", $okunmamis[0]->say, langS(432, 2, $this->input->post("lang")));
                                        } else {
                                            $v1 = "offline";
                                            $v = langS(433, 2, $this->input->post("lang"));
                                        }
                                    } else {
                                        $v1 = "offline";
                                        $v = langS(433, 2, $this->input->post("lang"));
                                    }
                                    $str .= '<div class="status" ><i class="mdi mdi-circle ' . $v1 . '"></i>
                                                               ' . $v . '
                                                           </div>
                                                       </div>
                                                       <div class="col-lg-4 col-12 bord">
                                                           <div class="row ">
                                                               <div class="col-lg-3 col-3">';
                                    if ($users->image == "") {
                                        $str .= '<img style="" src="' . base_url("assets/images/profilepic.png") . '" alt="">';

                                    } else {
                                        $str .= '<img style="" src="' . base_url("upload/users/" . $users->image) . '" alt="">';
                                    }

                                    $str .= '</div>
                                                               <div class="col-lg-9 col-9 nick">
                                                                   <a href="' . base_url(gg($this->input->post("lang")) . $uyepage->link . "/" . $users->sef_link) . '">' . $users->nick_name . '</a>
                                                                   <p>';

                                    $islem = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where sell_user_id=" . $ilanManuel->user_id . " and status=3");
                                    if ($islem) {
                                        if ($islem[0]->say > 0) {
                                            $str .= str_replace("{sayi}", $islem[0]->say, langS(424, 2, $this->input->post("lang")));
                                        } else {
                                            $str .= langS(423, 2, $this->input->post("lang"));
                                        }
                                    } else {
                                        $str .= langS(423, 2, $this->input->post("lang"));
                                    }
                                    $str .= '</p>
                                                               </div>
                                                           </div>
                                                           <div class="row">
                                                               <div class="col-lg-12 detail">
                                                                   <a href="' . base_url(gg($this->input->post("lang")) . $mesajPage->link . "?token=" . $item->islemNo) . '">
                                                                       <i class="mdi mdi-message"></i>
                                                                       ' . langS(422, 2, $this->input->post("lang")) . '</a>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>';


                                }

                            }
                            echo json_encode(array("veri" => $str));
                        }
                    } else {
                        addLog("Saldırı Uygulandı.", "getSelectedMessage token", 3);
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "getSelectedMessage formcontrol", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "getSelectedMessage post", 3);
        }
    }

    public function sendUserSMS()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                header('Content-Type: application/json');
                if ($user) {
                    if ($user->status = 1) {
                        $ayar1 = $this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                        $ayar2 = $this->m_tr_model->getTableSingle("table_options_sms", array("id" => 1));
                        if ($ayar2->modul_aktif == 1) {
                            if ( $user->balance > $ayar1->sms_gonderim_ucreti) {
                                $kontrol = strrev($this->input->post("data", true));
                                $kontrol = explode("&", $kontrol);
                                $cek = $this->m_tr_model->getTableSingle("table_adverts", array("ilanNo" => $kontrol[0]));
                                if ($cek) {
                                    $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $cek->user_id));
                                    $smsKontrol=$this->m_tr_model->query("SELECT count(*) as say FROM table_user_send_sms WHERE created_at >= NOW() - INTERVAL 1 day and user_id=".$user->id." and sell_user_id=".$uye->id." and advert_id =".$cek->id );
                                    $blok=0;
                                    if($smsKontrol){
                                        if($smsKontrol[0]->say>3){
                                            $blok=1;
                                        }
                                    }
                                    if($blok==1){
                                        echo json_encode(array("err" => true, "message" => langS(473, 2),"t" => 1));
                                    }else{

                                        if ($uye && $uye->status == 1) {
                                            $tokens = tokengenerator(8, 2);
                                            $veri = 0;
                                            $mesajCek = $this->m_tr_model->getTableSingle("table_user_sms_task", array("id" => $this->input->post("sms")));
                                            if ($mesajCek) {
                                                try {
                                                    $this->load->helper("netgsm_helper");
                                                    $mesaj = $user->nick_name . " adlı üye " . $cek->ad_name . " ilanınız için '" . $mesajCek->name . " ' talebinde bulundu.";
                                                    $veri = smsGonder($uye->phone, $mesaj);
                                                    if ($veri) {
                                                        $par = explode(" ", $veri);
                                                        if ($par[0] == "00" || $par[0] == "02") {
                                                            $veri = 1;
                                                        } else {
                                                            $veri = 2;
                                                        }
                                                    } else {
                                                        $veri = 2;
                                                    }
                                                } catch (Exception $ex) {
                                                    $veri = 3;
                                                    die();
                                                }

                                                if ($veri == 1) {
                                                    $kaydet = $this->m_tr_model->add_new(array(
                                                        "user_id" => $user->id,
                                                        "sell_user_id" => $uye->id,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "advert_id" => $cek->id,
                                                        "mesaj_id" => $mesajCek->id,
                                                        "status" => 1,
                                                        "islemNo" => $tokens,
                                                        "price" => $ayar1->sms_gonderim_ucreti
                                                    ), "table_user_send_sms");
                                                    if ($kaydet) {
                                                        $tokens = tokengenerator(8, 2);
                                                        $islem = $user->balance - $ayar1->sms_gonderim_ucreti;
                                                        $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $user->id));
                                                        if ($guncelle) {
                                                            $bakiyeDus = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "type" => 0,
                                                                "advert_id" =>$cek->id,
                                                                "quantity" => $ayar1->sms_gonderim_ucreti,
                                                                "qty" => 1,
                                                                "description" => $ayar1->sms_gonderim_ucreti . " " . getcur() . " tutarlı sms gönderim ücereti düşüldü. İşlem No : " . $tokens,
                                                                "sms_id" => $kaydet,
                                                                "islemNo" => $tokens,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "status" => 2
                                                            ), "table_users_balance_history");
                                                            if ($bakiyeDus) {
                                                                $logEkle = $this->m_tr_model->add_new(array(
                                                                    "user_id" => $user->id,
                                                                    "user_email" => $user->email,
                                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                                    "title" => "SMS Gönderim Ücreti Düşüldü",
                                                                    "description" => $ayar1->sms_gonderim_ucreti . " " . getcur() . " tutarı " . $user->nick_name . " adlı üyenin bakiyesinden düşüldü. Yeni
                                                            bakiye: " . $islem . " " . getcur() . ". Gönderilen Üye:".$uye->nick_name,
                                                                    "date" => date("Y-m-d H:i:s"),
                                                                    "status" => 1,
                                                                    "sms_id" => $kaydet
                                                                ), "ft_logs");
                                                                echo json_encode(array("err" => false, "message" => langS(472, 2)));
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                                }
                                            } else {
                                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                            }
                                        }
                                    }


                                } else {
                                    echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                }
                            } else {
                                if ($user->tel_onay == 0) {
                                    echo json_encode(array("err" => true, "message" => "2"));
                                } else {
                                    echo json_encode(array("err" => true, "message" => "1"));
                                }
                            }
                        } else {
                            header('Content-Type: application/json');
                            echo json_encode(array("err" => true, "message" => "oturum"));
                        }
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "sendUserSMS formcontrol", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "sendUserSMS post", 3);
        }
    }
}


