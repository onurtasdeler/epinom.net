<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InvoiceController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
    }

    public function update()
    {
        header("Content-Type: application/json");
        try {
            if ($this->input->post()) {
                $user = getActiveUsers();

                $invoiceInfo = $this->db->select("*")
                    ->from("invoice_infos")
                    ->where("user_id", $user->id)
                    ->get()
                    ->row();

                $datas = [
                    'user_id' => $user->id,
                    'company_name' => $this->input->post("company_name"),
                    'tax_office' => $this->input->post("tax_office"),
                    'tax_number' => $this->input->post("tax_number"),
                    'country' => 'Türkiye',
                    'province' => $this->input->post("province"),
                    'district' => $this->input->post("district"),
                    'address' => $this->input->post("address"),
                    'company_owner' => $this->input->post("company_owner"),
                    'phone_one' => $this->input->post("phone_one"),
                    'phone_two' => $this->input->post("phone_two"),
                ];

                if ($invoiceInfo) {
                    $datas['updated_at'] = date("Y-m-d H:i:s");
                    $this->db->where("user_id", $user->id)->update("invoice_infos", $datas);
                } else {
                    $datas['created_at'] = date("Y-m-d H:i:s");
                    $this->db->insert("invoice_infos", $datas);
                }

                echo json_encode([
                    'status' => true,
                    'message' => langS(412, 2)
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => langS(344, 2)
                ]);
            }
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => langS(344, 2)
            ]);
        }
    }
}
