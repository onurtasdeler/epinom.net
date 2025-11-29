<?php



class Outgoings extends CI_Controller

{




    function __construct()
    {
        parent::__construct();
        $this->load->model("outgoings_model");
        if (!getActiveUser()) {
            redirect("login");
            exit;
        }
    }

    function Index()
    {
        $this->load->view("pages/outgoings/list");
        return;
    }

    function edit($outgoingId)
    {
        $outgoing = $this->outgoings_model->getOne([
            "id" => $outgoingId
        ]);

        if (!isset($outgoing->id)) {
            redirect("outgoings");
            return;
        }

        $viewData = [
            "outgoing" => $outgoing
        ];

        if (isset($_GET["delete"])) :
            $this->outgoings_model->deleteOutgoings([
                "id" => $outgoingId
            ]);
            redirect("outgoings");
            return;
        endif;

        if (isset($_POST["submitForm"])) :
            $form_rules = [
                [
                    'field' => 'name',
                    'label' => 'Gider',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'date',
                    'label' => 'Tarih',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'price',
                    'label' => 'Tutar',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'type',
                    'label' => 'Tipi',
                    'rules' => 'required|trim'
                ]
            ];

            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE) {
                //update
                $data = [
                    "name" => $this->input->post("name", TRUE),
                    "date" => $this->input->post("date"),
                    "price" => $this->input->post("price", TRUE),
                    "type" => $this->input->post("type", TRUE),
                ];
                $this->outgoings_model->updateOutgoings($data, [
                    "id" => $outgoing->id
                ]);
                if ($this->db->affected_rows()) {
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi."
                    ];
                    header("Refresh:2;url=" . base_url("outgoings"));
                } else {
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Kaydetme başarısız."
                    ];
                }
            } else {
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/outgoings/edit", (object)$viewData);
    }
    function showOutgoings()
    {
        $firstDayUTS = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime(0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = !isset($_COOKIE["startDate"]) ? date("Y-m-d H:i:s", $firstDayUTS) : date("Y-m-d H:i:s", $_COOKIE["startDate"] / 1000);
        $lastDay = !isset($_COOKIE["endDate"]) ? date("Y-m-d H:i:s", $lastDayUTS) : date("Y-m-d H:i:s", $_COOKIE["endDate"] / 1000);
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $_POST["search"]["value"];

        $outgoings = array();
        if (empty($search)) {
            $this->db->order_by("date", "desc");
            $this->db->where('date >=', $firstDay);
            $this->db->where('date <=', $lastDay);
            $this->db->where('type', 0);
            $outgoings = $this->db->limit($length, $start)->get("outgoings")->result();
            $total_outgoings = $this->outgoings_model->totalOutgoings("-1");
        } else {
            $searchResults = $this->outgoings_model->searchOutgoings($search);
            if (!empty($searchResults)) {
                $searchResultsID = array_column($searchResults, 'id');
                $total_outgoings = $this->outgoings_model->totalOutgoings($searchResultsID);
                $this->db->where('type', 0);
                $this->db->where_in('id', $searchResultsID);
                $this->db->order_by("date", "desc");
                $this->db->where('date >=', $firstDay);
                $this->db->where('date <=', $lastDay);
                $outgoings = $this->db->get("outgoings")->result();
            }
        }
        $data = array();
        $totalOutgoingPrice = 0;
        foreach ($outgoings as $rows) {
            $outgoingName = $rows->name;
            $totalOutgoingPrice += $rows->price;
            $outgoingPrice = '<span class="text-danger">- ' . $rows->price . " AZN</span>";

            $editLink = base_url("outgoings/edit/" . $rows->id);
            $deleteLink = base_url("outgoings/edit/" . $rows->id . "?delete");

            $actions = '<div class="btn-group">
                            <a href="' . $editLink . '" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Düzenle
                            </a>
                            <a href="' . $deleteLink . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal' . $rows->id . '">
                                <i class="fas fa-trash-alt"></i> Sil
                            </a>
                            <div class="modal fade" id="deleteModal' . $rows->id . '" tabindex="-1" role="dialog" aria-labelledby="deleteModal' . $rows->id . '" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Silme İşlemi</h5>
                                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bunu yapmak istediğinize emin misiniz?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" class="btn btn-dark" data-dismiss="modal">Vazgeç</a>
                                            <a href="' . $deleteLink . '" class="btn btn-danger">Sil</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';


            $data[] = array(
                $outgoingName,
                date("d/m/Y H:i", strtotime($rows->date)),
                $outgoingPrice,
                $actions
            );
        }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_outgoings,
            "recordsFiltered" => $total_outgoings,
            "totalOutgoingPrice" => $totalOutgoingPrice,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
    function Add()
    {
        $viewData = [];
        if (isset($_POST["submitForm"])) :
            $form_rules = [
                [
                    'field' => 'name',
                    'label' => 'Gider',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'date',
                    'label' => 'Tarih',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'price',
                    'label' => 'Tutar',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'type',
                    'label' => 'Tipi',
                    'rules' => 'required|trim'
                ]
            ];
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE) {
                $this->outgoings_model->insertOutgoings([
                    'name' => $_POST['name'],
                    'date' => $_POST['date'],
                    'price' => $_POST['price'],
                    'type' => $_POST['type']
                ]);
                if ($this->db->insert_id()) {
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => 'Başarıyla eklendi. Yönlendiriliyorsunuz...'
                    ];
                    header("Refresh:2;url=" . base_url('outgoings'));
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Gider eklenemedi.'
                    ];
                }
            } else {
                $viewData['form_error'] = TRUE;
            }
        endif;
        $this->load->view("pages/outgoings/add", (object)$viewData);
        return;
    }
}
