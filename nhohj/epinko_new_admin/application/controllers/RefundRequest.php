<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RefundRequest extends CI_Controller
{

    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "refund";
    public $viewFile = "blank";
    public $tables = "refund_requests";
    public $baseLink = "iade-bildirimleri";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(63);
        $this->settings = getSettings();
    }

    public function index()
    {
        $view = [
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolder . "/list",
            "viewFolderSafe" => $this->viewFolder
        ];
        $page = [
            "pageTitle" => "İade Bildirimleri - " . $this->settings->site_name,
            "subHeader" => "<a href='" . base_url("iade-bildirimleri") . "'>İade Bildirimleri</a>",
            "h3" => "İade Bildirimleri",
            "btnText" => "",
            "btnLink" => base_url("urun-ekle")
        ];

        $data = getTable($this->tables, []);
        pageCreate($view, $data, $page, []);
    }

    public function dataTableApi()
    {
        header('Content-Type: application/json');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'];

        $totalRecords = $this->db->count_all('refund_requests');

        $this->db->select("refund_requests.id, 
                       CONCAT(table_users.name, ' ', table_users.surname) AS user_name,
                       table_users.id AS user_id,
                       table_users.nick_name AS user_username,
                       table_users.email AS user_email,
                       table_payment_log.payment_method, 
                       table_payment_log.amount AS paid_amount, 
                       refund_requests.reason AS refund_reason, 
                       refund_requests.status AS refund_status, 
                       refund_requests.created_at AS payment_date")
            ->from("refund_requests")
            ->join("table_users", "table_users.id = refund_requests.user_id")
            ->join("table_payment_log", "table_payment_log.id = refund_requests.payment_id");

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('table_users.name', $search);
            $this->db->or_like('table_users.surname', $search);
            $this->db->or_like('refund_requests.reason', $search);
            $this->db->or_like('table_payment_log.amount', $search);
            $this->db->or_like('table_payment_log.payment_method', $search);
            $this->db->or_like('refund_requests.status', $search);
            $this->db->group_end();
        }

        $filteredRecords = $this->db->count_all_results('', false);

        $this->db->limit($length ?? 20, $start ?? 0);

        $requests = $this->db->get()->result();

        if (empty($requests)) {
            echo json_encode([
                "draw" => $draw,
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $filteredRecords,
                "data" => [],
                "message" => "No data found or an error occurred in the query."
            ]);
            return;
        }

        $data = [];
        foreach ($requests as $request) {
            $data[] = [
                'id' => $request->id,
                'user_id' => $request->user_id,
                'user_name' => $request->user_email,
                'user_username' => $request->user_username,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->paid_amount,
                'refund_reason' => $request->refund_reason,
                'refund_status' => $request->refund_status,
                'payment_date' => $request->payment_date,
                'action' => '<a href="' . base_url('iade-bildirim-guncelle/' . $request->id) . '" class="btn btn-sm btn-clean btn-icon" title="Bildirim Güncelle"><i class="la la-arrow-right text-info"></i></a>'
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data
        ]);
    }

    public function detail($id)
    {
        $refundInfo = $this->db->select('*')
            ->from('refund_requests')
            ->where('id', $id)
            ->get()
            ->row();

        if (empty($refundInfo)) {
            redirect(base_url('iade-bildirimleri'));
        }

        $view = [
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolder . "/update",
            "viewFolderSafe" => $this->viewFolder
        ];
        $page = [
            "pageTitle" => "İade Bildirimi Güncelle - " . $this->settings->site_name,
            "subHeader" => "<a href='" . base_url("iade-bildirimleri") . "'>İade Bildirimleri</a> / İade Bildirimi Güncelle",
            "h3" => "İade Bildirimi Güncelle",
            "btnText" => "",
            "btnLink" => base_url("urun-ekle")
        ];

        $paymentLog = $this->db->select('*')
            ->from('table_payment_log')
            ->where('id', $refundInfo->payment_id)
            ->get()
            ->row();

        $data = [
            "refundInfo" => $refundInfo,
            "paymentLog" => $paymentLog
        ];

        pageCreate($view, $data, $page, []);
    }

    public function changeStatus()
    {
        header('Content-Type: application/json');
        $refundId = $this->input->post('id');
        $status = $this->input->post('status');

        if (empty($refundId) || empty($status)) {
            echo json_encode([
                'status' => false,
                'message' => 'ID ve durum bilgisi boş olamaz.'
            ]);
            return;
        }

        $refundInfo = $this->db->select('*')
            ->from('refund_requests')
            ->where('id', $refundId)
            ->get()
            ->row();

        if (empty($refundInfo)) {
            echo json_encode([
                'status' => false,
                'message' => 'İade bildirimi bulunamadı.'
            ]);
            return;
        }

        $paymentLog = $this->db->select('*')
            ->from('table_payment_log')
            ->where('id', $refundInfo->payment_id)
            ->get()
            ->row();

        if (empty($paymentLog)) {
            echo json_encode([
                'status' => false,
                'message' => 'Ödeme bilgisi bulunamadı.'
            ]);
            return;
        }

        $userInfo = $this->db->select('*')
            ->from('table_users')
            ->where('id', $paymentLog->user_id)
            ->get()
            ->row();

        if (empty($userInfo)) {
            echo json_encode([
                'status' => false,
                'message' => 'Kullanıcı bilgisi bulunamadı.'
            ]);
            return;
        }

        if ($status == 3) {
            $this->db->update('table_users', ['balance' => $userInfo->balance + $paymentLog->amount], ['id' => $paymentLog->user_id]);
        }

        switch ($status) {
            case 3:
                $this->db->update(
                    'table_payment_log',
                    ['status' => 1, 'update_at' => date('Y-m-d H:i:s')],
                    ['id' => $paymentLog->id]
                );
                $this->db->update('refund_requests', ['status' => 'rejected', 'update_at' => date('Y-m-d H:i:s')], ['id' => $refundInfo->id]);
                break;
            case 1:
                $this->db->update(
                    'table_payment_log',
                    ['status' => 0, 'update_at' => date('Y-m-d H:i:s')],
                    ['id' => $paymentLog->id]
                );
                $this->db->update('refund_requests', ['status' => 'process', 'update_at' => date('Y-m-d H:i:s')], ['id' => $refundInfo->id]);
                break;
            case 2:
                $this->db->update(
                    'table_payment_log',
                    ['status' => 3, 'update_at' => date('Y-m-d H:i:s')],
                    ['id' => $paymentLog->id]
                );
                $this->db->update('refund_requests', ['status' => 'approved', 'update_at' => date('Y-m-d H:i:s')], ['id' => $refundInfo->id]);
                break;
            default:
                $this->db->update('refund_requests', ['status' => 'pending', 'update_at' => date('Y-m-d H:i:s')], ['id' => $refundInfo->id]);
                return;
        }

        $sendMail = sendMails($userInfo->email, 1, 37, $userInfo, ['refundInfo' => $refundInfo, 'paymentLog' => $paymentLog, 'status' => $status]);
        if ($sendMail) {
            $logData = [
                'user_id' => $userInfo->id,
                'user_email' => $userInfo->email,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'title' => 'İade Bildirimi Maili Başarılı Şekilde Gönderildi',
                'description' => $userInfo->nick_name . ' adlı kullanıcıya iade bildirimi maili başarılı şekilde gönderildi.',
                'date' => date('Y-m-d H:i:s'),
                'status' => 1
            ];
            $this->db->insert('ft_logs', $logData);
        }

        echo json_encode([
            'status' => true,
            'message' => 'İade bildirimi durumu başarıyla güncellendi.'
        ]);
    }
}
