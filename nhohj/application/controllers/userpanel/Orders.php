<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
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

    //using


    public function getListMyOrders(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST){

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
                            $w = " s.user_id=".getActiveUsers()->id." ";
                            $join = "   ";
                            $toplam = $this->m_tr_model->query("select count(*) as sayi from table_adverts as s " . $join . " where " . $w);
                            $sql = "select s.id as ssid,
                        s.ilanNo  ,
                        s.ad_name as ilanAdi ,
                        s.type as ilanType ,
                        s.red_nedeni as redNedeni ,
                        s.price as ilanFiyat ,
                        s.img_1 as ilanResim ,
                        s.is_doping as ilanDoping ,
                        s.adet as stokAdet ,
                        s.kalan_adet as satAdet,
                        s.status as ilanDurum from table_adverts as s " . $join;
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
                                $filter = $this->m_tr_model->query("select count(*) as toplam from table_adverts as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                            } else {
                                $filter = $this->m_tr_model->query("select count(*) as toplam from table_adverts as s " . $join . " where  " . $w);
                            }

                            $response["recordsFiltered"] = $filter[0]->toplam;
                            $iliski = "";
                            foreach ($veriler as $veri) {
                                $end="";
                                /* if($veri->ilanDoping==1){
                                     $cek=$this->m_tr_model->getTableSingle("new_ilan_vitrin_user",array("ads_id" => $veri->ssid));
                                     if($cek){
                                         $end=date("d-m-Y H:i",strtotime($cek->end_date));
                                     }
                                 }else {
                                     $end="";
                                 }*/
                                $link=getLangValue($veri->ssid,"table_adverts");

                                $response["data"][] = [
                                    "ilanNo" => $veri->ilanNo,
                                    "ilanAdi" => $veri->ilanAdi,
                                    "ilanType" => $veri->ilanType,
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
                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                        http_response_code(403);
                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                    }
                } else {
                    // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
                    http_response_code(403);
                    echo json_encode(['error' => 'Doğrudan erişim yasak.']);
                }


            }else{

            }
        }
    }
}


