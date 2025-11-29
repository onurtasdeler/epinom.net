<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
    public $viewFile = "";
    public $viewFolder = "";
    public $uniqFolder = "";
    public $search = "";
    public $setting = "";
    public $general = "";
    public $giris = "";
    public $iletisim = "";
    public $kayit = "";
    public $balanceAdd = "";
    public $tema = "";
    public $pageTitle = "";
    public $pageDesc = "";
    public $pageKeywords = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");

        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
        contact_session();
        $this->general = getTableSingle("options_general", array("id" => 1));
        if ($this->uri->segment(1)) {
            if ($this->uri->segment(1) == "en") {
                $veri = strtoupper(htmlspecialchars($this->uri->segment(1)));
                $getLang = getTableSingle("table_langs", array("name_short" => $veri, "status" => 1));
                if ($getLang) {
                    $_SESSION["lang"] = $getLang->id;
                }
            } else {
                $this->session->set_userdata("lang", 1);
            }
        } else {
            $getLang = getTableSingle("table_langs", array("main" => 1, "status" => 1));
            if ($getLang) {
                $this->session->set_userdata("lang", $getLang->id);
                //redirect(base_url(strtolower($getLang->name_short)));
            }
        }

        if (!$_SESSION["general"]) {
            $this->general = getTableSingle("options_general", array("id" => 1));
            $_SESSION["general"] = $this->general;
        }

        $this->setting = getTableSingle("table_options", array("id" => 1));
        $_SESSION["setting"] = $this->setting;
        $this->iletisim = getTableSingle("table_contact", array("id" => 1));
        if (!isset($_SESSION["langOlusum"])) {
            $cek = getTableOrder("table_lang_static", array(), "order_id", "asc");
            $_SESSION["langOlusum"] = [];
            foreach ($cek as $item) {
                $_SESSION["langOlusum"][$item->order_id][$item->lang_id] = array("veri" => $item->value);
            }
        }
        if ($_SERVER["HTTP_USER_AGENT"] == "CyotekWebCopy/1.9 CyotekHTTP/6.3") {
            $this->load->view("yetki/content");
            exit;
        }
        $this->giris = getLangValue(25, "table_pages");
        $this->kayit = getLangValue(24, "table_pages");
        $this->tema = getTableSingle("table_theme_options", array("id" => 1));
        $this->balanceAdd = getLangValue(28, "table_pages");
    }
    private function checkThrottle($uniqueKey)
    {
        $this->load->library('session');
        $lastRequestTime = $this->session->userdata($uniqueKey . '_last_request_time');
        $requestCount = $this->session->userdata($uniqueKey . '_request_count');
        if (empty($lastRequestTime) || (time() - $lastRequestTime) > $this->config->item('throttle_time_interval')) {
            // Zaman aşımı veya ilk istek, sıfırla
            $this->session->set_userdata($uniqueKey . '_last_request_time', time());
            $this->session->set_userdata($uniqueKey . '_request_count', 1);
            return true;
        } elseif ($requestCount < $this->config->item('throttle_limit')) {
            // Limit aşılmadı, arttır ve işleme devam et
            $this->session->set_userdata($uniqueKey . '_request_count', $requestCount + 1);
            return true;
        }
        return false;
    }
    private function mainpageCreate()
    {
        $page = getTableSingle("table_pages", array("uniqname" => "mainpage"));
        if ($page) {
            $v = new stdClass();
            $v->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $v->l->sdesc;
            
            $this->pageKeywords = $v->l->skwords;
            $this->pageTitle = $v->l->stitle;
            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
            $v->pop = getTableOrder("table_advert_category", array("status" => 1, "parent_id" => 0, "top_id" => 0), "id", "", 10);
            $v->sliderlast = getTableOrder("table_slider", array("status" => 1, "types" => 2), "order_id", "asc", 6);
            $v->c = getTableOrder("table_advert_category", array("top_id" => 0, "parent_id" => 0, "anasayfa_view" => 1), "order_id", "asc");
            $v->slider = getTableOrder("table_slider", array("status" => 1, "types" => 1), "order_id", "asc");
            if ($this->tema->home_banner_slider_status == 1) {
                $v->benzerst = $this->m_tr_model->query("select * from table_adverts as s where  ((s.type=0 and (s.status=1)) or (s.type=1 and (s.status=1 or s.status=4))) and (  s.deleted=0 and s.is_delete=0) and is_doping=1 order by rand() limit 10 ");
            }
            if ($this->tema->home_populer_status == 1) {
                $v->kategoriinfo = $this->m_tr_model->getTableOrder("table_advert_category", array("status" => 1, "top_id" => 0, "parent_id" => 0, "is_populer" => 1), "order_id", "asc");
                if ($this->tema->home_populer_secim == 2) {
                    $v->pops = getTableOrder("table_advert_category", array("status" => 1, "is_populer" => 1, "parent_id" => 0, "top_id" => 0), "order_id", "asc", 4);
                }
            }
            if ($this->tema->home_magaza_status == 1) {
                $v->populerr = $this->m_tr_model->query("select  *,s.id as ssid  from table_users as s left join table_orders_adverts as o on s.id=o.sell_user_id where s.is_magaza=1 and o.status=3 and s.status=1 and s.banned=0 group by s.id ");
            }
            if ($this->tema->home_blog_status == 1) {
                $v->haberler = getTableOrder("table_blog", array("status" => 1, "is_slider" => 1), "order_id", "asc");
            }
            $v->kategorisr = $this->m_tr_model->query("select * from table_advert_category where status=1 and is_delete=0 and top_id=0 and parent_id=0 ");
            $v->ct = getTableOrder("table_advert_category", array("top_id" => 0, "parent_id" => 0, "is_populer" => 1), "order_id", "asc");
            $v->kategories = $this->m_tr_model->query("select * from table_advert_category  where status=1 and anasayfa_view=1 and top_id=0 and parent_id=0   order by order_id asc limit 7 ");
            $v->vitrin = $this->m_tr_model->query("select * from table_adverts as s where  s.is_doping=1 and ((s.type=0 and (s.status=1 )) or (s.type=1  and (s.status=1 or s.status=4))) and (  s.deleted=0 and s.is_delete=0)  order by s.created_at asc limit 18 ");
            $v->vitrin2 = $this->m_tr_model->query("select * from table_adverts as s where  ((s.type=0 and (s.status=1 )) or (s.type=1  and (s.status=1 or s.status=4))) and (  s.deleted=0 and s.is_delete=0)  order by s.created_at desc limit 18 ");
            $v->vitrin3 = $this->m_tr_model->query("select * from table_adverts as s where  ((s.type=0 and (s.status=1 )) or (s.type=1  and (s.status=1 or s.status=4))) and (  s.deleted=0 and s.is_delete=0)  order by s.views desc limit 18 ");
            $v->tum = getLangValue(34, "table_pages");
            $v->ma = getLangValue(44, "table_pages");
            if ($this->tema->home_populer_ust_status == 1) {
                $v->cat = getTableOrder("table_advert_category", array("top_id" => 0, "parent_id" => 0, "is_populer" => 1), "rand()", "", 6);
            }
            $v->kasalar = getTableOrder("epin_cases", array("is_anasayfa" => 1, "is_deleted" => 0, "status" => 1), "rand()", "", 6);
            $v->yayincilar = getTableOrder("streamer_users", array("is_anasayfa" => 1, "status" => 1), "rand()", "", 6);
            $v->ayar = $_SESSION["setting"];
            $this->load->view("page/home/content", $v);
        } else {
            redirect(base_url("404"));
        }
    }
    private function staticPageCreate($pagess)
    {
        $page = getTableSingle("table_pages", array("status" => 1, "id" => $pagess->id));
        if ($page) {
            $v = new stdClass();
            $v->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $v->l->sdesc;
            $this->pageTitle = $v->l->stitle;
            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
            $v->ayar = $_SESSION["setting"];
            $v->page = $page;
            $this->load->view("page/static/content", $v);
        } else {
            redirect(base_url("404"));
        }
    }
    private function postPageCreate($pagesub = "", $page_sub_sub = "", $page_sub_sub_sub = "")
    {
        $page = getTableSingle("table_pages", array("uniqname" => "posts"));
        if ($page) {
            $v = new stdClass();
            if (!$pagesub) {
                $v->l = getLangValue($page->id, "table_pages");
                $this->pageDesc = $v->l->sdesc;
                $this->pageTitle = $v->l->stitle;
                $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                $v->kategoriler = $this->m_tr_model->getTableOrder("table_advert_category", array("status" => 1, "top_id" => 0, "parent_id" => 0), "order_id", "asc");
                $v->sayfa = $v->l;
                $v->uniq = $page;
                $v->tum = getLangValue(34, "table_pages");
                $v->ma = getLangValue(44, "table_pages");
                $this->viewFolder = "advert/list";
                $v->ayar = $_SESSION["setting"];
                $this->load->view("page/advert/list/content", $v);
            } else {
                if ($page_sub_sub == "") {
                    $temizle = $this->security->xss_clean($pagesub);
                    if ($_SESSION["lang"] == 1) {
                        $kontrol = getTableSingle("table_advert_category", array("seflink_tr" => $temizle, "status" => 1, "is_delete" => 0));
                    } else {
                        $kontrol = getTableSingle("table_advert_category", array("seflink_en" => $temizle, "status" => 1, "is_delete" => 0));
                    }
                    if ($kontrol) {
                        $sub = $this->m_tr_model->query("select * from table_advert_category where (top_id=" . $kontrol->id . " or parent_id=" . $kontrol->id . " ) and is_delete=0 and status=1");
                        if ($sub) {
                            $this->viewFolder = "page/advert/category_detail/content";
                            $p = getLangValue($data->id, "table_advert_category");
                            $itemLang = getLangValue($kontVal->id, "table_advert_category");
                            $v->uniq = $kontrol;
                            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                            $v->altaltkategori = "a";
                            $v->altkategori = "a";
                            $v->altControl = getTableOrder("table_advert_category", array("top_id" => $kontrol->id, "parent_id" => 0, "status" => 1), "order_id", "asc");
                            $uniqlang = getLangValue($kontrol->id, "table_advert_category");
                            $v->uniqlang = $uniqlang;
                            $v->ilanlar = getLangValue(34, "table_pages");
                            $v->mainpage = getLangValue(11, "table_pages");
                            $this->pageDesc = $v->uniqlang->sdesc;
                            $this->pageTitle = $v->uniqlang->stitle;
                            $pages = getTableSingle("table_pages", array("id" => 81));
                            $this->load->view("page/advert/category_detail/content", $v);
                        } else {
                            $this->viewFolder = "page/advert/category_detail/content";
                            $p = getLangValue($data->id, "table_advert_category");
                            $itemLang = getLangValue($kontVal->id, "table_advert_category");
                            $v->uniq = $kontrol;
                            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                            $v->altaltkategori = "a";
                            $v->altkategori = "a";
                            $v->altControl = getTableOrder("table_advert_category", array("top_id" => $kontrol->id, "parent_id" => 0, "status" => 1), "order_id", "asc");
                            $uniqlang = getLangValue($kontrol->id, "table_advert_category");
                            $v->uniqlang = $uniqlang;
                            $v->ilanlar = getLangValue(34, "table_pages");
                            $v->mainpage = getLangValue(11, "table_pages");
                            $this->pageDesc = $v->uniqlang->sdesc;
                            $this->pageTitle = $v->uniqlang->stitle;
                            $pages = getTableSingle("table_pages", array("id" => 81));
                            $this->load->view("page/advert/category_detail/content", $v);
                        }
                    } else {
                        $temizle = strip_tags($this->security->xss_clean($pagesub));
                        $langs = getTableOrder("table_langs", array(), "id", "asc");
                        try {
                            $kontrol = $this->m_tr_model->query("SELECT * FROM table_adverts WHERE status!=0 and is_delete=0 and  JSON_EXTRACT(field_data, '$[0].lang_id') = " . $_SESSION["lang"] . " AND JSON_EXTRACT(field_data, '$[0].link') = '" . $temizle . "'");
                            if ($kontrol) {
                                $this->viewFolder = "page/advert/details";
                                $v->uniq = $kontrol[0];
                                $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                                $v->altaltkategori = "a";
                                $v->altkategori = "a";
                                $uniqlang = getLangValue($kontrol[0]->id, "table_adverts");
                                $v->uniqlang = $uniqlang;
                                $v->ilanlar = getLangValue(34, "table_pages");
                                $v->mainpage = getLangValue(11, "table_pages");
                                $this->pageDesc = $v->uniqlang->sdesc;
                                $this->pageTitle = $v->uniqlang->stitle;
                                $pages = getTableSingle("table_pages", array("id" => 81));
                                $this->load->view("page/advert/details/content", $v);
                            } else {
                                redirect(base_url("404"));
                            }
                        } catch (Exception $ex) {
                            echo "test";
                        }
                    }
                } else {
                    if ($page_sub_sub_sub == "") {
                        $temizleone = $this->security->xss_clean($pagesub);
                        $temizletwo = $this->security->xss_clean($page_sub_sub);
                        if ($_SESSION["lang"] == 1) {
                            $kontrolmain = getTableSingle("table_advert_category", array("seflink_tr" => $temizleone, "status" => 1, "is_delete" => 0));
                            $kontrol = getTableSingle("table_advert_category", array("seflink_tr" => $temizletwo, "status" => 1, "is_delete" => 0));
                        } else {
                            $kontrolmain = getTableSingle("table_advert_category", array("seflink_en" => $temizleone, "status" => 1, "is_delete" => 0));
                            $kontrol = getTableSingle("table_advert_category", array(
                                "seflink_en" =>
                                    $temizletwo,
                                "status" => 1,
                                "is_delete" => 0
                            ));
                        }
                        if ($kontrol && $kontrolmain) {
                            $this->viewFolder = "page/advert/category_detail/content";
                            $v->uniq = $kontrol;
                            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                            $v->altaltkategori = "a";
                            $v->altkategori = $kontrol;
                            $v->altControl = getTableOrder("table_advert_category", array("top_id" => $kontrol->id, "parent_id" => 0, "status" => 1), "order_id", "asc");
                            $uniqlang = getLangValue($kontrol->id, "table_advert_category");
                            $v->uniqlang = $uniqlang;
                            $v->ilanlar = getLangValue(34, "table_pages");
                            $v->mainpage = getLangValue(11, "table_pages");
                            $this->pageDesc = $v->uniqlang->sdesc;
                            $this->pageTitle = $v->uniqlang->stitle;
                            $pages = getTableSingle("table_pages", array("id" => 81));
                            $this->load->view("page/advert/category_detail/content", $v);
                        } else {
                            redirect(base_url("404"));
                        }
                    } else {
                        $temizleone = $this->security->xss_clean($pagesub);
                        $temizletwo = $this->security->xss_clean($page_sub_sub);
                        $temizletree = $this->security->xss_clean($page_sub_sub_sub);
                        if ($_SESSION["lang"] == 1) {
                            $kontrolmain = getTableSingle("table_advert_category", array("seflink_tr" => $temizleone, "status" => 1, "is_delete" => 0));
                            $kontroltop = getTableSingle("table_advert_category", array("seflink_tr" => $temizletwo, "status" => 1, "is_delete" => 0));
                            $kontrol = getTableSingle("table_advert_category", array("seflink_tr" => $temizletree, "status" => 1, "is_delete" => 0));
                        } else {
                            $kontrolmain = getTableSingle("table_advert_category", array("seflink_en" => $temizletwo, "status" => 1, "is_delete" => 0));
                            $kontroltop = getTableSingle("table_advert_category", array("seflink_en" => $temizletree, "status" => 1, "is_delete" => 0));
                            $kontrol = getTableSingle("table_advert_category", array("seflink_en" => $temizletree, "status" => 1, "is_delete" => 0));
                        }
                        if ($kontrol && $kontrolmain && $kontroltop) {
                            $this->viewFolder = "page/advert/category_detail/content";
                            $v->uniq = $kontrol;
                            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                            $v->altaltkategori = "a";
                            $v->altkategori = $kontrol;
                            $v->altControl = getTableOrder("table_advert_category", array("top_id" => $kontrolmain->id, "parent_id" => $kontroltop->id, "status" => 1), "order_id", "asc");
                            $uniqlang = getLangValue($kontrol->id, "table_advert_category");
                            $v->uniqlang = $uniqlang;
                            $v->ilanlar = getLangValue(34, "table_pages");
                            $v->mainpage = getLangValue(11, "table_pages");
                            $this->pageDesc = $v->uniqlang->sdesc;
                            $this->pageTitle = $v->uniqlang->stitle;
                            $pages = getTableSingle("table_pages", array("id" => 81));
                            $this->load->view("page/advert/category_detail/content", $v);
                        } else {
                            redirect(base_url("404"));
                        }
                    }
                }
            }
        } else {
            redirect(base_url("404"));
        }
    }
    private function profilPageCreate($page, $link)
    {
        $kontrol = getTableSingle("table_users", array("is_magaza" => 1, "magaza_link" => $link, "status" => 1, "banned" => 0));
        if ($kontrol) {
            $v = new stdClass();
            $v->uniq = $kontrol;
            $v->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $v->l->sdesc;
            $this->pageTitle = $v->l->stitle;
            $v->tum = getLangValue(34, "table_pages");
            $v->ma = getLangValue(44, "table_pages");
            $v->ayar = $_SESSION["setting"];
            $this->load->view("page/profile/content", $v);
        } else {
            redirect(base_url("404"));
        }
    }
    private function panelPageCreate($kontrol, $sub = "")
    {
        $this->viewFolder = $kontrol->folder;
        $this->uniqFolder = $kontrol->uniq_folder;
        $vi = new stdClass();
        $vi->uniq = $kontrol;
        $vi->lang = getLangValue($kontrol->id, "table_pages");
        $this->pageDesc = $vi->lang->sdesc;
        $this->pageTitle = $vi->lang->stitle;
        if ($kontrol->uniq_folder == "bakiye") {
            $vi->bakiye = getLangValue(28, "table_pages");
            $vi->doğrulama = getLangValue(42, "table_pages");
            $vi->ayarl = getTableSingle("table_options", array("id" => 1));
            $vi->ayarsms = getTableSingle("table_options_sms", array("id" => 1));
            $vi->paytr = getTableSingle("table_payment_methods", array("id" => 1));
            $vi->manuel = getTableSingle("table_payment_methods", array("id" => 2));
            $vi->vallet = getTableSingle("table_payment_methods", array("id" => 3));
            $vi->epinkopin = getTableSingle("table_payment_methods", array("id" => 6));
            $vi->payguru = getTableSingle("table_payment_methods", array("id" => 8));
            $vi->user = getActiveUsers();
            $vi->giris = getLangValue(24);
            //if (base_url() == "https://epinko.com/") {
                $vi->papara = getTableSingle("table_payment_methods", array("id" => 4));
                $vi->gpay = getTableSingle("table_payment_methods", array("id" => 5));
            //}
            $vi->shopier = getTableSingle("table_payment_methods", array("id"=>9));
            $vi->user = getActiveUsers();
            $vi->goster = 0;
            $vi->kisit = getTableSingle("table_onay_kisit", array("id" => 1));
            if ($_SESSION["lang"] == 1) {
                $vi->yontem = $this->uri->segment(2);
            } else {
                $vi->yontem = $this->uri->segment(3);
            }

            if ($vi->yontem == "havale") {
            } else if ($vi->yontem == "kart") {
            } else if ($vi->yontem == "manuel") {
            } else if ($vi->yontem == "mobil") {
            } else if ($vi->yontem == "epinkopin") {
            } else {
                redirect(base_url(gg() . $vi->bakiye->link . "/kart"));
            }
            $vi->r = explode("-", $vi->bakiye_yukleme);
            $this->load->view("user/profile/main_content", $vi);
        } else if ($kontrol->uniq_folder == "ilan_create" || $kontrol->uniq_folder == "ilan_create_stock") {
            if (getActiveUsers()->is_magaza == 1) {
                $this->load->view("user/profile/main_content", $vi);
            } else {
                redirect(base_url(gg() . getLangValue(95, "table_pages")->link));
            }
        } else if ($kontrol->uniq_folder == "ilan_sale_orders") {
            //İlan Satışlarım ve Satış Detay
            $kontrol = getTableSingle("table_orders_adverts", array("sipNo" => $sub, "sell_user_id" => getActiveUsers()->id));
            if ($kontrol) {
                $this->viewFolder = "user/profile";
                $this->uniqFolder = $this->uniqFolder . "/detail";
                $vi->uniq = $kontrol;
                $this->load->view("user/profile/main_content", $vi);
            } else {
                $this->load->view("user/profile/main_content", $vi);
            }
        } else if ($kontrol->uniq_folder == "ilan_orders") {
            //İlan Siparişlerim ve Sipariş Detay
            $kontrol = getTableSingle("table_orders_adverts", array("sipNo" => $sub, "user_id" => getActiveUsers()->id));
            if ($kontrol) {
                $this->viewFolder = "user/profile";
                $this->uniqFolder = $this->uniqFolder . "/detail";
                $vi->uniq = $kontrol;
                $this->load->view("user/profile/main_content", $vi);
            } else {
                $this->load->view("user/profile/main_content", $vi);
            }
        } else if ($kontrol->uniq_folder == "balance_with/list") {
            $this->load->view("user/profile/main_content", $vi);
        } else if ($kontrol->uniq_folder == "ilanlar") {
            if ($sub) {
                $kontrol = getTableSingle("table_adverts", array("ilanNo" => $sub));
                if ($kontrol) {
                    $this->viewFolder = "user/profile";
                    $this->uniqFolder = $this->uniqFolder . "/detail";
                    $vi->uniq = $kontrol;
                    $this->load->view("user/profile/main_content", $vi);
                } else {
                    $this->load->view("user/profile/main_content", $vi);
                }
            } else {
                $this->load->view("user/profile/main_content", $vi);
            }
        } else if ($kontrol->uniq_folder == "messages") {
            if ($sub) {
                $kontrols = $this->m_tr_model->query("select * from table_users_message_gr where islemNo='" . $sub . "' and ( user_id=" . getActiveUsers()->id . " or seller_id='" . getActiveUsers()->id . "') ");
                if ($kontrols) {
                    $this->viewFolder = "user/profile";
                    $this->uniqFolder = "messages/detail";
                    $vi->uniq = $kontrols[0];
                    $this->load->view("user/profile/main_content", $vi);
                } else {
                    $this->load->view("user/profile/main_content", $vi);
                }
            } else {
                $this->load->view("user/profile/main_content", $vi);
            }
        } else if ($kontrol->uniq_folder == "support") {
            if ($sub) {
                $kontrol = getTableSingle("table_talep", array("talepNo" => $sub, "user_id" => getActiveUsers()->id));
                if ($kontrol) {
                    $this->viewFolder = "user/profile";
                    $this->uniqFolder = $this->uniqFolder . "/detail";
                    $vi->uniq = $kontrol;
                    $this->load->view("user/profile/main_content", $vi);
                } else {
                    $this->load->view("user/profile/main_content", $vi);
                }
            } else {
                $this->load->view("user/profile/main_content", $vi);
            }
        } else if ($kontrol->uniq_folder == "cekilis_sistemi") {
            $vi->urunler = getTableOrder("table_products", array("status" => 1, "is_delete" => 0, "cekilis_urunu" => 1), "order_id", "asc");
            $this->load->view("user/profile/main_content", $vi);
        } else {
            $this->load->view("user/profile/main_content", $vi);
        }
    }
    private function magazaPageCreate()
    {
        if (getActiveUsers()) {
            $page = getTableSingle("table_pages", array("uniqname" => "store-app"));
            if ($page) {
                $vi = new stdClass();
                $vi->l = getLangValue($page->id, "table_pages");
                $this->pageDesc = $vi->l->sdesc;
                $this->pageTitle = $vi->l->stitle;
                $this->viewFolder = "user/profile";
                $this->uniqFolder = $page->uniq_folder;
                $vi->uniq = getActiveUsers();
                $this->load->view("user/profile/main_content", $vi);
            } else {
                redirect(base_url("404"));
            }
        } else {
        }
    }
    private function allpostPage()
    {
        $page = getTableSingle("table_pages", array("uniqname" => "allpost"));
        if ($page) {
            $vi = new stdClass();
            $vi->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $vi->l->sdesc;
            $this->pageTitle = $vi->l->stitle;
            $vi->page = $page;
            $this->viewFolder = "user/profile";
            $this->uniqFolder = $page->uniq_folder;
            $vi->ilanlar = getLangValue(34, "table_pages");
            $vi->mainpage = getLangValue(11, "table_pages");
            $this->load->view("page/advert/list_main/content", $vi);
        } else {
            redirect(base_url("404"));
        }
    }
    private function firsatPage()
    {
        $page = getTableSingle("table_pages", array("uniqname" => "firsat"));
        if ($page) {
            $vi = new stdClass();
            $vi->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $vi->l->sdesc;
            $this->pageTitle = $vi->l->stitle;
            $vi->page = $page;
            $this->viewFolder = "user/profile";
            $this->uniqFolder = $page->uniq_folder;
            $vi->ilanlar = getLangValue(34, "table_pages");
            $vi->mainpage = getLangValue(11, "table_pages");
            $vi->kategoriinfo = $this->m_tr_model->getTableOrder("table_advert_category", array("status" => 1, "top_id" => 0, "parent_id" => 0, "is_populer" => 1), "order_id", "asc");
            $vi->tum = getLangValue(34, "table_pages");
            $vi->lists = getTableOrder("table_products", array("status" => 1, "is_delete" => 0, "is_deal" => 1), "rand()", "");
            $this->load->view("page/deals/list/content", $vi);
        } else {
            redirect(base_url("404"));
        }
    }
    private function onayPageControl($kon)
    {
        if ($this->input->get("token")) {
            $page = getTableSingle("table_pages", array("uniqname" => "onay"));
            if ($page) {
                $vi = new stdClass();
                $vi->l = getLangValue($page->id, "table_pages");
                $this->pageDesc = $vi->l->sdesc;
                $this->pageTitle = $vi->l->stitle;
                $this->viewFolder = "user/profile";
                $this->uniqFolder = $page->uniq_folder;
                $vi->uniq = getActiveUsers();
                $this->load->view("user/onay_page", $vi);
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url(gg()));
        }
    }
    private function basketPageCreate($kontrol)
    {

        $page = getTableSingle("table_pages", array("uniqname" => "sepet"));
        if ($page) {
            $vi = new stdClass();
            $vi->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $vi->l->sdesc;
            $this->pageTitle = $vi->l->stitle;
            $this->viewFolder = "page/basket";
            $vi->tum = getLangValue(34, "table_pages");
            $vi->login = getLangValue(25, "table_pages");
            $vi->register = getLangValue(24, "table_pages");
            $vi->random = $this->m_tr_model->query("select * from table_adverts where status=1 and is_delete=0 order by rand() limit 4");
            $vi->random2 = $this->m_tr_model->query("select * from table_products where status=1 and is_delete=0 order by rand() limit 4");
            $this->uniqFolder = $page->uniq_folder;
            $vi->uniq = getActiveUsers();
            $this->load->view("page/basket/content", $vi);
        } else {
            redirect(base_url("404"));
        }
    }
    private function searchPageControl($kontrol)
    {
        if ($_POST) {
            if ($this->input->post("token") && $this->input->post("token") == md5("45710925")) {
                $page = getTableSingle("table_pages", array("uniqname" => "search"));
                if ($page) {
                    $vi = new stdClass();
                    $vi->l = getLangValue($page->id, "table_pages");
                    $this->pageDesc = $vi->l->sdesc;
                    $this->pageTitle = $vi->l->stitle;
                    $this->viewFolder = "page/basket";
                    $vi->tum = getLangValue(34, "table_pages");
                    $vi->login = getLangValue(25, "table_pages");
                    $vi->register = getLangValue(24, "table_pages");
                    $vi->random = $this->m_tr_model->query("select * from table_adverts where status=1 and is_delete=0 order by rand() limit 4");
                    $vi->random2 = $this->m_tr_model->query("select * from table_products where status=1 and is_delete=0 order by rand() limit 4");
                    $this->uniqFolder = $page->uniq_folder;
                    $vi->uniq = getActiveUsers();
                    $this->load->view("search/content", $vi);
                } else {
                    redirect(base_url("404"));
                }
            }
        } else {
            redirect(base_url());
        }
    }
    private function sellToUsOrderDetailPageCreate($kontrol, $sub = "")
    {
        $page = getTableSingle("table_pages", array("uniqname" => $kontrol->uniqname));
        $order = getTableSingle("selltous_orders", array("order_no" => $sub));
        if ($page && $order) {
            $vi = new stdClass();
            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
            $vi->l = getLangValue($page->id, "table_pages");
            $this->pageDesc = $vi->l->sdesc;
            $this->pageTitle = $vi->l->stitle;
            $this->page = $page;
            $this->viewFolder = "page/selltous/detail";
            $vi->sayfa = $vi->l;
            $vi->siparis = $order;
            $this->uniqFolder = $page->uniq_folder;
            $vi->uniq = getActiveUsers();
            $this->load->view("page/selltous/detail/content", $vi);
        } else {
            redirect(base_url("404"));
        }
    }
    private function streamerPageCreate($kontrol, $sub = "")
    {
        if (empty($sub)) {
            $page = getTableSingle("table_pages", array("uniqname" => $kontrol->uniqname));
            if ($page) {
                $vi = new stdClass();
                $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                $vi->l = getLangValue($page->id, "table_pages");
                $this->pageDesc = $vi->l->sdesc;
                $this->pageTitle = $vi->l->stitle;
                $this->page = $page;
                $this->viewFolder = "page/streamers";
                $vi->sayfa = $vi->l;
                $vi->yayincilar = getTableOrder("streamer_users", array("status" => 1), "id", "asc");
                $this->uniqFolder = $page->uniq_folder;
                $vi->uniq = getActiveUsers();
                $this->load->view("page/streamers/content", $vi);
            } else {
                redirect(base_url("404"));
            }
        } else {
            $page = getTableSingle("table_pages", array("uniqname" => $kontrol->uniqname));
            $streamer = getTableSingle("streamer_users", array("status" => 1, "username" => $sub));
            if ($page && $streamer) {
                $vi = new stdClass();
                $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                $vi->l = getLangValue($page->id, "table_pages");
                $this->pageDesc = $vi->l->sdesc;
                $this->pageTitle = $vi->l->stitle;
                $this->page = $page;
                $this->viewFolder = "page/streamers/detail";
                $vi->sayfa = $vi->l;
                $vi->yayinci = $streamer;
                $this->uniqFolder = $page->uniq_folder;
                $vi->uniq = getActiveUsers();
                $this->load->view("page/streamers/detail/content", $vi);
            } else {
                redirect(base_url("404"));
            }
        }
    }
    private function rafflePageCreate($kontrol, $sub = "")
    {
        $raffleSettings = getTableSingle("table_raffle_settings", array("id" => 1));
        if ($raffleSettings->is_active == 0) {
            redirect(base_url("404"));
        } else {
            if (empty($sub)) {
                $page = getTableSingle("table_pages", array("uniqname" => $kontrol->uniqname));
                if ($page) {
                    $vi = new stdClass();
                    $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                    $vi->l = getLangValue($page->id, "table_pages");
                    $this->pageDesc = $vi->l->sdesc;
                    $this->pageTitle = $vi->l->stitle;
                    $this->page = $page;
                    $this->viewFolder = "page/raffles";
                    $vi->sayfa = $vi->l;
                    $vi->cekilisler = getTableOrder("table_raffles", array(), "id", "asc");
                    $this->uniqFolder = $page->uniq_folder;
                    $vi->uniq = getActiveUsers();
                    $this->load->view("page/raffles/content", $vi);
                } else {
                    redirect(base_url("404"));
                }
            } else {
                $page = getTableSingle("table_pages", array("uniqname" => $kontrol->uniqname));
                $explodeSefLink = explode("-",$sub);
                $raffleId = array_pop($explodeSefLink);
                $raffleSefLink = implode("-",$explodeSefLink);
                $cekilis = getTableSingle("table_raffles", array("id" => $raffleId,"sef_link"=>$raffleSefLink));
                if ($page && $cekilis) {
                    $vi = new stdClass();
                    $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                    $vi->l = getLangValue($page->id, "table_pages");
                    $this->pageDesc = $vi->l->sdesc;
                    $this->pageTitle = $vi->l->stitle;
                    $this->page = $page;
                    $this->viewFolder = "page/raffles/detail";
                    $vi->sayfa = $vi->l;
                    $vi->cekilis = $cekilis;
                    $this->uniqFolder = $page->uniq_folder;
                    $vi->uniq = getActiveUsers();
                    $this->load->view("page/raffles/detail/content", $vi);
                } else {
                    redirect(base_url("404"));
                }
            }
        }
    }
    private function pvpServerPageCreate($kontrol)
    {
        
                $page = getTableSingle("table_pages", array("uniqname" => $kontrol->uniqname));
                if ($page) {
                    $vi = new stdClass();
                    $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                    $vi->l = getLangValue($page->id, "table_pages");
                    $this->pageDesc = $vi->l->sdesc;
                    $this->pageTitle = $vi->l->stitle;
                    $this->page = $page;
                    $this->viewFolder = "page/pvpservers";
                    $vi->sayfa = $vi->l;
                    $vi->serverlar = getTableOrder("pvp_serverlar", array(), "id", "asc");
                    $this->uniqFolder = $page->uniq_folder;
                    $vi->uniq = getActiveUsers();
                    $this->load->view("page/pvpservers/content", $vi);
                } else {
                    redirect(base_url("404"));
                }
    }
    private function gamespageCreate($kontrol, $sub = "", $subsub = "")
    {
        $page = getTableSingle("table_pages", array("uniqname" => "gamescategory"));
        if ($page) {
            $vi = new stdClass();
            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
            $vi->l = getLangValue($page->id, "table_pages");
            $vi->detay = getLangValue(105, "table_pages");
            if ($sub) {
                if ($_SESSION["lang"] == 1) {
                    $kont = getTableSingle("table_products_category", array("seflink_tr" => $sub, "status" => 1));
                } else {
                    $kont = getTableSingle("table_products_category", array("seflink_en" => $sub, "status" => 1));
                }


                if ($kont) {
                    if ($subsub) {
                        if ($_SESSION["lang"] == 1) {
                            $kontsub = getTableSingle("table_products_category", array("seflink_tr" => $subsub, "parent_id" => $kont->id, "status" => 1));
                        } else {
                            $kontsub = getTableSingle("table_products_category", array("seflink_en" => $subsub, "parent_id" => $kont->id, "status" => 1));
                        }

                        if ($kontsub) {
                            $kontlang = getLangValue($kont->id, "table_products_category");
                            $sublang = getLangValue($kontsub->id, "table_products_category");
                            $this->pageDesc = $sublang->sdesc;
                            $this->pageTitle = $sublang->stitle;
                            $vi->sub = $kont;
                            $vi->subsub = $kontsub;
                            $vi->sublang = $kontlang;
                            $vi->subsublang = $sublang;
                            if ($kontsub->is_bizesat == 0)
                                $this->viewFolder = "page/category/detail";
                            else
                                $this->viewFolder = "page/category/selltous_detail";
                            $this->page = $page;
                            $vi->sayfa = $vi->l;
                            $vi->kategoriler = getTableOrder("table_products_category", array("status" => 1, "parent_id" => $kont->id), "order_id", "asc");
                            $vi->urunler = getTableOrder("table_products", array("status" => 1, "is_delete" => 0, "category_main_id" => $kont->id, "category_id" => $kontsub->id), "order_id", "asc");
                            $iliskiliUrunler = getTableOrder("table_products",array("status"=>1,"is_delete"=>0,"related_categories LIKE"=> "%\"$kontsub->id\"%"),"order_id","asc");
                            array_push($vi->urunler,...$iliskiliUrunler);
                            $this->uniqFolder = $page->uniq_folder;
                            $vi->uniq = getActiveUsers();
                            if ($kontsub->is_bizesat == 0)
                                $this->load->view("page/category/detail/content", $vi);
                            else
                                $this->load->view("page/category/selltous_detail/content", $vi);
                        } else {
                            //product detail
                            if ($_SESSION["lang"] == 1) {
                                $kontsub = getTableSingle("table_products", array("p_seflink_tr" => $subsub, "status" => 1));
                            } else {
                                $kontsub = getTableSingle("table_products", array("p_seflink_en" => $subsub, "status" => 1));
                            }
                            if ($kontsub) {

                                if ($kontsub->category_main_id == 0) {
                                    if ($kontsub->category_id == $kont->id) {
                                        $vi->product = $kontsub;
                                        $vi->prlang = getLangValue($kontsub->id, "table_products");
                                        $kontlang = getLangValue($kont->id, "table_products_category");
                                        $vi->sublang = $kontlang;
                                        $this->pageDesc = $vi->prlang->sdesc;
                                        $this->pageTitle = $vi->prlang->stitle;
                                        $vi->subss = $kont;
                                        $vi->tum = getLangValue(34, "table_pages");
                                        $vi->ma = getLangValue(44, "table_pages");
                                        if ($kont->is_bizesat == 0)
                                            $this->viewFolder = "page/category/product_detail";
                                        else
                                            $this->viewFolder = "page/category/selltous_product_detail";
                                        $vi->uniq = getActiveUsers();
                                        $vi->urunler = getTableOrder("table_products", array("status" => 1, "category_main_id" => $kont->id, "id !=" => $kontsub->id), "order_id", "asc", 3);
                                        if ($kont->is_bizesat == 0)
                                            $this->load->view("page/category/product_detail/content", $vi);
                                        else
                                            $this->load->view("page/category/selltous_product_detail/content", $vi);
                                    } else {
                                        redirect(base_url());
                                    }
                                } else {

                                    if ($kontsub->category_main_id == $kont->id) {
                                        $productParentCat = getTableSingle("table_products_category", array("id" => $kontsub->category_id));
                                        $vi->product = $kontsub;
                                        $vi->prlang = getLangValue($kontsub->id, "table_products");
                                        $kontlang = getLangValue($kont->id, "table_products_category");
                                        $vi->sublang = $kontlang;
                                        $this->pageDesc = $vi->prlang->sdesc;
                                        $this->pageTitle = $vi->prlang->stitle;
                                        $vi->subss = $kont;
                                        $vi->tum = getLangValue(34, "table_pages");
                                        $vi->ma = getLangValue(44, "table_pages");
                                        if ($productParentCat->is_bizesat == 0)
                                            $this->viewFolder = "page/category/product_detail";
                                        else
                                            $this->viewFolder = "page/category/selltous_product_detail";
                                        $vi->uniq = getActiveUsers();
                                        $vi->urunler = getTableOrder("table_products", array("status" => 1, "category_main_id" => $kont->id, "id !=" => $kontsub->id), "order_id", "asc", 3);
                                        if ($productParentCat->is_bizesat == 0)
                                            $this->load->view("page/category/product_detail/content", $vi);
                                        else
                                            $this->load->view("page/category/selltous_product_detail/content", $vi);
                                    } else {
                                        redirect(base_url());
                                    }
                                }
                            } else {
                                if ($subsub) {
                                    if ($_SESSION["lang"] == 1) {
                                        $kontsub = getTableSingle("table_products", array("p_seflink_tr" => $subsub, "status" => 1));
                                    } else {
                                        $kontsub = getTableSingle("table_products", array("p_seflink_en" => $subsub, "status" => 1));
                                    }
                                }
                                $vi->product = $kont;
                                $vi->prlang = getLangValue($kontsub->id, "table_products");
                                $kontlang = getLangValue($kont->id, "table_products_category");
                                $vi->sublang = $kontlang;
                                $this->pageDesc = $vi->prlang->sdesc;
                                $this->pageTitle = $vi->prlang->stitle;
                                $vi->subss = $kont;
                                $vi->tum = getLangValue(34, "table_pages");
                                $vi->ma = getLangValue(44, "table_pages");
                                if ($kont->is_bizesat == 0)
                                    $this->viewFolder = "page/category/product_detail";
                                else
                                    $this->viewFolder = "page/category/selltous_product_detail";
                                $vi->uniq = getActiveUsers();
                                $vi->urunler = getTableOrder("table_products", array("status" => 1, "category_main_id" => $kont->id, "id !=" => $kontsub->id), "order_id", "asc", 3);
                                if ($kont->is_bizesat == 0)
                                    $this->load->view("page/category/product_detail/content", $vi);
                                else
                                    $this->load->view("page/category/selltous_product_detail/content", $vi);
                            }
                        }
                    } else {
                        $kontlang = getLangValue($kont->id, "table_products_category");
                        $this->pageDesc = $kontlang->sdesc;
                        $this->pageTitle = $kontlang->stitle;
                        $vi->sub = $kont;
                        $vi->subsub = $kont;
                        $vi->sublang = $kontlang;
                        $this->viewFolder = "page/category";
                        $this->page = $page;
                        $vi->sayfa = $vi->l;
                        $vi->kategoriler = getTableOrder("table_products_category", array("status" => 1, "parent_id" => $kont->id), "order_id", "asc");
                        if ($vi->kategoriler) {
                            $vi->ilankategoriler = getTableSingle("table_advert_category", array("status" => 1, "is_delete" => 0, "id" => $kont->ilan_kategori));
                            $vi->tum = getLangValue(34, "table_pages");
                            $this->uniqFolder = $page->uniq_folder;
                            $vi->uniq = getActiveUsers();
                            $this->load->view("page/category/content", $vi);
                        } else {
                            if ($kont->is_bizesat == 0)
                                $this->viewFolder = "page/category/detail";
                            else
                                $this->viewFolder = "page/category/selltous_detail";
                            $this->page = $page;
                            $vi->sayfa = $vi->l;
                            $vi->urunler = getTableOrder("table_products", array("status" => 1, "is_delete" => 0, "category_id" => $kont->id), "order_id", "asc");
                            $this->uniqFolder = $page->uniq_folder;
                            $vi->uniq = getActiveUsers();
                            if ($kont->is_bizesat == 0)
                                $this->load->view("page/category/detail/content", $vi);
                            else
                                $this->load->view("page/category/selltous_detail/content", $vi);
                        }
                    }
                } else {
                    redirect(base_url("404"));
                }
            } else {
                $this->pageDesc = $vi->l->sdesc;
                $this->pageTitle = $vi->l->stitle;
                $this->page = $page;
                $this->viewFolder = "page/category";
                $vi->sayfa = $vi->l;
                $vi->kategoriler = getTableOrder("table_products_category", array("status" => 1, "parent_id" => 0), "order_id", "asc");
                $this->uniqFolder = $page->uniq_folder;
                $vi->uniq = getActiveUsers();
                $this->load->view("page/category/content", $vi);
            }
        } else {
            redirect(base_url("404"));
        }
    }
    private function casesPageCreate($kontrol, $sub = "", $subsub = "")
    {
        $page = getTableSingle("table_pages", array("uniqname" => "cases"));
        if ($page) {
            $vi = new stdClass();
            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
            $vi->l = getLangValue($page->id, "table_pages");
            $detailPage = getTableSingle("table_pages", array("uniqname" => "case_detail"));
            $vi->detay = getLangValue($detailPage->id, "table_pages");
            $this->pageDesc = $vi->l->sdesc;
            $this->pageTitle = $vi->l->stitle;
            $this->page = $page;
            $this->viewFolder = "page/cases";
            $vi->sayfa = $vi->l;
            $vi->kasalar = getTableOrder("epin_cases", array("status" => 1), "order_id", "asc");
            $this->uniqFolder = $page->uniq_folder;
            $vi->uniq = getActiveUsers();
            $this->load->view("page/cases/content", $vi);
        } else {
            redirect(base_url("404"));
        }
    }
    private function caseDetailPageCreate($kontrol, $sub = "")
    {
        $page = getTableSingle("table_pages", array("uniqname" => "case_detail"));
        if ($page) {
            $vi = new stdClass();
            $v->tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
            $vi->l = getLangValue($page->id, "table_pages");
            if ($sub) {
                if ($_SESSION["lang"] == 1) {
                    $kont = getTableSingle("epin_cases", array("p_seflink_tr" => $sub, "status" => 1));
                } else {
                    $kont = getTableSingle("epin_cases", array("p_seflink_en" => $sub, "status" => 1));
                }
                if ($kont) {
                    $kontlang = getLangValue($kont->id, "epin_cases");
                    $this->pageDesc = $kontlang->sdesc;
                    $this->pageTitle = $kontlang->stitle;
                    $vi->kasa = $kont;
                    $vi->kasalang = $kontlang;
                    $this->viewFolder = "page/cases/case_detail";
                    $this->page = $page;
                    $vi->sayfa = $vi->l;
                    $vi->urunler = getTableOrder("case_products", array("case_id" => $kont->id), "id", "asc");
                    if ($vi->urunler) {
                        $this->uniqFolder = $page->uniq_folder;
                        $vi->uniq = getActiveUsers();
                        $this->load->view("page/cases/case_detail/content", $vi);
                    } else {
                        redirect(base_url("404"));
                    }
                } else {
                    redirect(base_url("404"));
                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }
    public function index($lang = "", $page = "", $page_sub = "", $page_sub_sub = "", $page_sub_sub_sub = "")
    {
        if ($this->setting->bakim_modu == 1) {
            $this->load->view("errors/bakim");
        } else {
            if ($lang == "") {
                //mainpage
                $this->mainpageCreate();
            } else {
                $clear = strip_tags($this->security->xss_clean($lang));
                if ($lang == "en") {
                    $lang = $lang;
                    if ($page == "") {
                        $this->mainpageCreate();
                    } else {
                        if ($page_sub != "") {
                            if ($page_sub_sub == "") {
                                $clearTwo = strip_tags($this->security->xss_clean($page));
                                $clearThree = strip_tags($this->security->xss_clean($page_sub));
                                $kontrol = getTableSingle("table_pages", array("seflink_en" => $clearTwo));
                                if ($kontrol) {
                                    if ($kontrol->uniqname == "posts") {
                                        $this->postPageCreate($clearThree);
                                    } else if ($kontrol->uniqname == "panel") {
                                        $this->panelPageCreate($kontrol, $clearThree);
                                    } else if ($kontrol->uniqname == "games") {
                                        $this->gamespageCreate($kontrol, $clearThree);
                                    } else if ($kontrol->uniqname == "onay") {
                                        $this->onayPageControl($kontrol);
                                    } else if ($kontrol->uniqname == "search") {
                                        $this->searchPageControl($kontrol);
                                    }
                                } else {
                                    redirect(base_url(gg()));
                                }
                            } else {
                                $clearTwo = strip_tags($this->security->xss_clean($page));
                                $clearThree = strip_tags($this->security->xss_clean($page_sub));
                                $clearFour = strip_tags($this->security->xss_clean($page_sub_sub));
                                $clearFive = strip_tags($this->security->xss_clean($page_sub_sub_sub));
                                $kontrol = getTableSingle("table_pages", array("seflink_en" => $clearTwo));
                                if ($kontrol) {
                                    if ($kontrol->uniqname == "posts") {
                                        $this->postPageCreate($clearThree, $clearFour, $clearFive);
                                    } else if ($kontrol->uniqname == "search") {
                                        $this->searchPageControl($kontrol);
                                    } else if ($kontrol->uniqname == "games") {
                                        $this->gamespageCreate($kontrol, $clearThree, $clearFour);
                                    } else if ($kontrol->uniqname == "panel") {
                                        $this->panelPageCreate($kontrol, $clearThree);
                                    }
                                } else {
                                    redirect(base_url(gg()));
                                }
                            }
                        } else {
                            $clearTwo = strip_tags($this->security->xss_clean($page));
                            $kontrol = getTableSingle("table_pages", array("seflink_en" => $clearTwo));
                            if ($kontrol) {
                                if ($kontrol->uniqname == "posts") {
                                    $this->postPageCreate();
                                } else if ($kontrol->uniqname == "panel") {
                                    $this->panelPageCreate($kontrol, $page);
                                } else if ($kontrol->uniqname == "magaza") {
                                    $this->profilPageCreate($kontrol, $clearTwo);
                                } else if ($kontrol->uniqname == "search") {
                                    $this->searchPageControl($kontrol);
                                } else if ($kontrol->uniqname == "games") {
                                    $this->gamespageCreate($kontrol, $clearTwo);
                                } else if ($kontrol->uniqname == "gamescategory") {
                                    $this->gamespageCreate($kontrol);
                                } else if ($kontrol->uniqname == "onay") {
                                    $this->onayPageControl($kontrol);
                                }
                            } else {
                                redirect(base_url(gg()));
                            }
                        }
                    }
                } else {
                    if ($page == "") {
                        //only page
                        if (lac() == 1) {
                            $kontrol = getTableSingle("table_pages", array("seflink_tr" => $clear));
                            if ($kontrol) {
                                if ($kontrol->uniqname == "posts") {
                                    $this->postPageCreate();
                                } else if ($kontrol->uniqname == "login") {
                                } else if ($kontrol->uniqname == "sepet") {
                                    $this->basketPageCreate($kontrol);
                                } else if ($kontrol->uniqname == "onay") {
                                    $this->onayPageControl($kontrol);
                                } else if ($kontrol->uniqname == "search") {
                                    $this->searchPageControl($kontrol);
                                } else if ($kontrol->uniqname == "panel") {
                                    $this->panelPageCreate($kontrol);
                                } else if ($kontrol->uniqname == "games") {
                                    $this->gamespageCreate($kontrol);
                                } else if ($kontrol->uniqname == "gamescategory") {
                                    $this->gamespageCreate($kontrol);
                                } else if ($kontrol->uniqname == "allpost") {
                                    $this->allpostPage($kontrol);
                                } else if ($kontrol->uniqname == "firsat") {
                                    $this->firsatPage();
                                } else if ($kontrol->uniqname == "cases") {
                                    $this->casesPageCreate($kontrol);
                                } else if ($kontrol->uniqname == "streamerslist") {
                                    $this->streamerPageCreate($kontrol);
                                } else if ($kontrol->uniqname == "raffleslist") {
                                    $this->rafflePageCreate($kontrol);
                                } else if ($kontrol->uniqname == "pvpserverlist") {
                                    $this->pvpServerPageCreate($kontrol);
                                } else {
                                    $this->staticPageCreate($kontrol);
                                }
                            } else {
                                redirect(base_url(gg()));
                            }
                        } else {
                        }
                    } else {
                        //subpage
                        if ($page_sub != "") {
                            if ($page_sub_sub == "") {
                                $clearTwo = strip_tags($this->security->xss_clean($page));
                                $clearThree = strip_tags($this->security->xss_clean($page_sub));
                                $kontrol = getTableSingle("table_pages", array("seflink_tr" => $clear));
                                if ($kontrol) {
                                    if ($kontrol->uniqname == "posts") {
                                        $this->postPageCreate($clearTwo, $clearThree);
                                    } else if ($kontrol->uniqname == "panel") {
                                        $this->panelPageCreate($kontrol, $page_sub);
                                    } else if ($kontrol->uniqname == "games") {
                                        $this->gamespageCreate($kontrol, $clearTwo, $clearThree);
                                    } else if ($kontrol->uniqname == "onay") {
                                        $this->onayPageControl($kontrol);
                                    } else if ($kontrol->uniqname == "search") {
                                        $this->searchPageControl($kontrol);
                                    }
                                } else {
                                    redirect(base_url(gg()));
                                }
                            } else {
                                $clearTwo = strip_tags($this->security->xss_clean($page));
                                $clearThree = strip_tags($this->security->xss_clean($page_sub));
                                $clearFour = strip_tags($this->security->xss_clean($page_sub_sub));
                                $kontrol = getTableSingle("table_pages", array("seflink_tr" => $clear));
                                if ($kontrol) {
                                    if ($kontrol->uniqname == "posts") {
                                        $this->postPageCreate($clearTwo, $clearThree, $clearFour);
                                    } else if ($kontrol->uniqname == "search") {
                                        $this->searchPageControl($kontrol);
                                    } else if ($kontrol->uniqname == "games") {
                                        $this->gamespageCreate($kontrol, $clearTwo);
                                    }
                                } else {
                                    redirect(base_url(gg()));
                                }
                            }
                        } else {
                            $clearTwo = strip_tags($this->security->xss_clean($page));
                            $kontrol = getTableSingle("table_pages", array("seflink_tr" => $clear));
                            if ($kontrol) {
                                if ($kontrol->uniqname == "posts") {
                                    $this->postPageCreate($clearTwo);
                                } else if ($kontrol->uniqname == "panel") {
                                    $this->panelPageCreate($kontrol, $page);
                                } else if ($kontrol->uniqname == "magaza") {
                                    $this->profilPageCreate($kontrol, $clearTwo);
                                } else if ($kontrol->uniqname == "search") {
                                    $this->searchPageControl($kontrol);
                                } else if ($kontrol->uniqname == "games") {
                                    $this->gamespageCreate($kontrol, $clearTwo);
                                } else if ($kontrol->uniqname == "case_detail") {
                                    $this->caseDetailPageCreate($kontrol, $page);
                                } else if ($kontrol->uniqname == "streamerslist") {
                                    $this->streamerPageCreate($kontrol, $page);
                                } else if ($kontrol->uniqname == "raffleslist") {
                                    $this->rafflePageCreate($kontrol, $page);
                                } else if ($kontrol->uniqname == "selltous-detail") {
                                    $this->sellToUsOrderDetailPageCreate($kontrol, $page);
                                } else if ($kontrol->uniqname == "onay") {
                                    $this->onayPageControl($kontrol);
                                }
                            } else {
                                redirect(base_url(gg()));
                            }
                        }
                    }
                }
            }
        }
    }
    public function republishAdvert($advert_id)
    {
        $advert = getTableSingle("table_adverts", array("id" => $advert_id, "user_id" => getActiveUsers()->id));
        if ($advert) {
            $this->m_tr_model->updateTable("table_adverts", array("remaning" => date("Y-m-d H:i:s")), array("id" => $advert_id));
            $this->session->set_flashdata("alert", array("title" => "İşlem Başarılı", "text" => "İlanınız tekrar yayına alındı.", "type" => "success"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->session->set_flashdata("alert", array("title" => "İşlem Başarısız", "text" => "İlanınız bulunamadı.", "type" => "error"));
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
}
