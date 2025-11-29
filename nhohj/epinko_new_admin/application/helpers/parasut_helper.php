<?php

class Accounts
{
    public $connector;

    /**
     * Accounts constructor.
     * @param Authorization $connector
     */
    public function __construct(Authorization $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param int $page
     * @param int $size
     * @return array|\stdClass
     */
    public function list_accounts($page = 1, $size = 25)
    {
        return $this->connector->request(
            "accounts?page[number]=$page&page[size]=$size",
            [],
            "GET"
        );
    }

    /**
     * @param $account_id
     * @return array|\stdClass
     */
    public function show($account_id)
    {
        return $this->connector->request(
            'accounts/' . $account_id,
            [],
            "GET"
        );
    }

    /**
     * @param array $data
     * @return array|\stdClass
     */
    public function search($data)
    {
        $filter = null;
        foreach ($data as $key => $value)
        {
            if (end($data) == $value)
                $filter .= "filter[$key]=".urlencode($value);
            else
                $filter .= "filter[$key]=".urlencode($value)."&";
        }

        return $this->connector->request(
            'accounts?'.$filter,
            [],
            "GET"
        );
    }

    /**
     * @param $data
     * @return array|\stdClass
     */
    public function create($data)
    {
        return $this->connector->request(
            'accounts',
            $data,
            "POST"
        );
    }

    /**
     * @param $account_id
     * @param array $data
     * @return array|\stdClass
     */
    public function edit($account_id, $data = [])
    {
        return $this->connector->request(
            'accounts/' . $account_id,
            $data,
            "PUT"
        );
    }

    /**
     * @param $account_id
     * @return array|\stdClass
     */
    public function delete($account_id)
    {
        return $this->connector->request(
            'accounts/' . $account_id,
            [],
            "DELETE"
        );
    }

    /**
     * @param $account_id
     * @return array|\stdClass
     */
    public function list_transactions($account_id)
    {
        return $this->connector->request(
            'accounts/' . $account_id . '/transactions?include=debit_account,credit_account',
            [],
            "GET"
        );
    }

    /**
     * @param $account_id
     * @param $data
     * @return array|\stdClass
     */
    public function import_transactions($account_id, $data)
    {
        return $this->connector->request(
            'accounts/' . $account_id . '/debit_transactions',
            $data,
            "POST"
        );
    }

    /**
     * @param $account_id
     * @param $data
     * @return array|\stdClass
     */
    public function export_transactions($account_id, $data)
    {
        return $this->connector->request(
            'accounts/' . $account_id . '/credit_transactions',
            $data,
            "POST"
        );
    }

    /**
     * @param $transaction_id
     * @return array|\stdClass
     */
    public function show_transactions($transaction_id)
    {
        return $this->connector->request(
            'transactions/' . $transaction_id,
            [],
            "GET"
        );
    }

    /**
     * @param $transaction_id
     * @return array|\stdClass
     */
    public function delete_transactions($transaction_id)
    {
        return $this->connector->request(
            'transactions/' . $transaction_id,
            [],
            "DELETE"
        );
    }
}
class Authorization extends Request
{
    public $LIVE_URL = "https://api.parasut.com";
    public $DEMO_URL = "https://api.heroku-staging.parasut.com";
    public $version = "v4";
    public $authorization_file_name = 'authorization.ini';
    public $grant_type = "password";

    public $api_url;
    public $config;
    public $access_token;
    public $company_id;
    public $ini_file;

    public function call($class)
    {
        return new $class($this);
    }


    /**
     * Authorization constructor.
     * @param $config
     * @throws \Parasut\API\Exception
     */
    public function __construct($config)
    {
        //check the configuration data
        $this->checkConfigData($config);

        $authorizationFile = __DIR__."/".$this->authorization_file_name;

        //if not exists authorization.ini
        if (!file_exists($authorizationFile))
            file_put_contents($authorizationFile, "");

        //configuration variables
        $this->config = $config;
        $this->api_url = (isset($config["development"]) && $config["development"]) ? $this->DEMO_URL : $this->LIVE_URL; //demo or live
        $this->company_id = $this->config["company_id"];
        $this->config["grant_type"] = $this->grant_type;
        $this->ini_file = $authorizationFile;

        //check authorize
        $this->checkAuthorization();
    }

    /**
     * Check the configuration data
     * @throws Exception
     */
    private function checkConfigData($config)
    {
        if (!isset($config["client_id"]))
            throw new \Parasut\API\Exception("`client_id` parameter missing", 400);

        if (!isset($config["redirect_uri"]))
            throw new \Parasut\API\Exception("`redirect_uri` parameter missing", 400);

        if (!isset($config["company_id"]))
            throw new \Parasut\API\Exception("`company_id` parameter missing", 400);

        if (!isset($config["username"]))
            throw new \Parasut\API\Exception("`username` parameter missing",400);

        if (!isset($config["password"]))
            throw new \Parasut\API\Exception("`password` parameter missing", 400);
    }

    /**
     * Check Authorization
     * @return void
     * @throws \Parasut\API\Exception
     */
    private function checkAuthorization()
    {
        $tokens = parse_ini_file($this->ini_file);

        if (empty($tokens)) {
            $this->accessAuthorization();
            return;
        }

        if (isset($tokens['company_id']) && md5($tokens['company_id']) !== md5($this->company_id))
        {
            $this->accessAuthorization();
            return;
        }

        if (!isset($tokens['access_token'])) {
            $this->accessAuthorization();
            return;
        }

        if (!isset($tokens['created_at']) || time() - intval($tokens['created_at']) > 7200) {
            $this->accessAuthorization();
            return;
        }

        $this->access_token = $tokens['access_token'];
    }

    /**
     * Access Authorization
     * @throws \Parasut\API\Exception
     */
    private function accessAuthorization()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url.'/oauth/token');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->config);
        $jsonData = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseData = json_decode($jsonData, true);
        curl_close($ch);

        if ($responseCode === 200)
        {
            $authorizationText = null;
            foreach ($responseData as $key => $value)
                $authorizationText .= $key.'='.$value."\n";

            $authorizationText .= "company_id=".md5($this->company_id)."\n";
            file_put_contents($this->ini_file, $authorizationText);

            $this->access_token = $responseData['access_token'];
        }
        else
        {
            echo $responseData["error_description"];
        }
    }

    /**
     * @param $path
     * @param null $params
     * @param $method
     * @return array|\stdClass
     */
    public function request($path, $params = null, $method)
    {
        $curlURI = $this->api_url.'/'.$this->version.'/'.$this->company_id.'/'.$path;

        $response = [];
        if ($method === "GET")
            $response = $this->__getRequest($curlURI, $params, $this->access_token);

        if ($method === "POST")
            $response = $this->__postRequest($curlURI, $params, $this->access_token);

        if ($method === "PUT")
            $response = $this->__putRequest($curlURI, $params, $this->access_token);

        if ($method === "DELETE")
            $response = $this->__deleteRequest($curlURI, $params, $this->access_token);

        return $response;
    }
}
class Request
{
    protected function __getRequest($URL, $params, $accessToken)
    {
        if (is_array($params) && count($params) > 0) {
            $URL .= '?'.http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $jsonData = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseData = json_decode($jsonData);
        curl_close($ch);

        return $this->_responseFormat($responseCode, $responseData);
    }

    protected function __postRequest($URL, $params, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $jsonData = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseData = json_decode($jsonData);
        curl_close($ch);

        return $this->_responseFormat($responseCode, $responseData);
    }

    protected function __putRequest($URL, $params, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $jsonData = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseData = json_decode($jsonData);
        curl_close($ch);

        return $this->_responseFormat($responseCode, $responseData);
    }

    protected function __deleteRequest($URL, $params, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $jsonData = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseData = json_decode($jsonData);
        curl_close($ch);

        return $this->_responseFormat($responseCode, $responseData);
    }

    private function __curlHeader($accessToken)
    {
        return [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken
        ];
    }

    private function _responseFormat($responseCode, $responseData)
    {
        if ($responseCode >= 200 && $responseCode < 400)
        {
            $return = new \stdClass();
            $return->code = $responseCode;
            $return->result = isset($responseData) ? $responseData : null;
            return $return;
        }
        else
        {
            $return = new \stdClass();

            $return->code = $responseCode;
            switch ($responseCode) {
                case '400':
                    if (isset($responseData->error))
                    {
                        $return->error_title = null;
                        $return->error_message = "Bad Request: ". $responseData->error;
                    }
                    elseif (isset($responseData->errors))
                    {
                        $return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
                        $errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
                        $return->error_message = "Bad Request: ". $errorDetail;
                    }
                    break;
                case '401':
                    if (isset($responseData->error))
                    {
                        $return->error_title = null;
                        $return->error_message = "Unauthorized: ". $responseData->error;
                    }
                    elseif (isset($responseData->errors))
                    {
                        $return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
                        $errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
                        $return->error_message = "Unauthorized: ". $errorDetail;
                    }
                    break;
                case '403':
                    if (isset($responseData->error))
                    {
                        $return->error_title = null;
                        $return->error_message = "Forbidden: ". $responseData->error;
                    }
                    elseif (isset($responseData->errors))
                    {
                        $return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
                        $errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
                        $return->error_message = "Forbidden: ". $errorDetail;
                    }
                    break;
                case '404':
                    if (isset($responseData->error))
                    {
                        $return->error_title = null;
                        $return->error_message = "Not Found: ". $responseData->error;
                    }
                    elseif (isset($responseData->errors))
                    {
                        $return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
                        $errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
                        $return->error_message = "Not Found: ". $errorDetail;
                    }
                    break;
                case '422':
                    if (isset($responseData->error))
                    {
                        $return->error_title = null;
                        $return->error_message = "Unprocessable Entity: ". $responseData->error;
                    }
                    elseif (isset($responseData->errors))
                    {
                        $return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
                        $errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
                        $return->error_message = "Unprocessable Entity: ". $errorDetail;
                    }
                    break;
                case '429':
                    if (isset($responseData->error))
                    {
                        $return->error_title = null;
                        $return->error_message = "Too many requests: ". $responseData->error;
                    }
                    elseif (isset($responseData->errors))
                    {
                        $return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
                        $errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
                        $return->error_message = "Too many requests: ". $errorDetail;
                    }
                    break;
                default:
                    break;
            }

            return $return;
        }
    }
}
class Contacts
{
    public $connector;

    /**
     * Contacts constructor.
     * @param Authorization $connector
     */
    public function __construct(Authorization $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param int $page
     * @param int $size
     * @return array|\stdClass
     */
    public function list_contacts($page = 1, $size = 25)
    {
        return $this->connector->request(
            "contacts?page[number]=$page&page[size]=$size",
            [],
            "GET"
        );
    }

    /**
     * Contact total count
     * @return integer
     */
    public function count_contacts()
    {
        return $this->connector->request(
            "contacts?page[number]=1&page[size]=2",
            [],
            "GET"
        )->result->meta->total_count;
    }

    /**
     * Show contact
     * @param $contact_id
     * @return array|\stdClass
     */
    public function show($contact_id)
    {
        return $this->connector->request(
            "contacts/$contact_id",
            [],
            "GET"
        );
    }

    /**
     * Search contact with params
     * @param array $data
     * @return array|\stdClass
     */
    public function search($data = [])
    {
        $filter = null;
        foreach ($data as $key => $value)
        {
            if (end($data) == $value)
                $filter .= "filter[$key]=".urlencode($value);
            else
                $filter .= "filter[$key]=".urlencode($value)."&";
        }

        return $this->connector->request(
            "contacts?$filter",
            [],
            "GET"
        );
    }

    /**
     * Create contact
     * @param $data
     * @return array|\stdClass
     */
    public function create($data)
    {
        return $this->connector->request(
            "contacts",
            $data,
            "POST"
        );
    }

    /**
     * Edit contact
     * @param $contact_id
     * @param array $data
     * @return array|\stdClass
     */
    public function edit($contact_id , $data = [])
    {
        return $this->connector->request(
            "contacts/$contact_id",
            $data,
            "PUT"
        );
    }

    /**
     * Delete contact
     * @param $contact_id
     * @return array|\stdClass
     */
    public function delete($contact_id)
    {
        return $this->connector->request(
            "contacts/$contact_id",
            [],
            "DELETE"
        );
    }
}
class Products
{
    public $connector;

    /**
     * Products constructor.
     * @param Authorization $connector
     */
    public function __construct(Authorization $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param int $page
     * @param int $size
     * @return array|\stdClass
     */
    public function list_products($page = 1, $size = 25)
    {
        return $this->connector->request(
            "products?page[number]=$page&page[size]=$size",
            [],
            "GET"
        );
    }

    /**
     * @return mixed
     */
    public function count_products()
    {
        return $this->connector->request(
            "products?page[number]=1&page[size]=2",
            [],
            "GET"
        )->result->meta->total_count;
    }

    /**
     * @param $product_id
     * @return array|\stdClass
     */
    public function show($product_id)
    {
        return $this->connector->request(
            "products/$product_id?include=inventory_levels,category",
            [],
            "GET"
        );
    }

    /**
     * @param array $data
     * @return array|\stdClass
     */
    public function search($data)
    {
        $filter = null;
        foreach ($data as $key => $value)
        {
            if (end($data) == $value)
                $filter .= "filter[$key]=".urlencode($value);
            else
                $filter .= "filter[$key]=".urlencode($value)."&";
        }

        return $this->connector->request(
            "products?$filter",
            [],
            "GET"
        );
    }

    /**
     * @param $data
     * @return array|\stdClass
     */
    public function create($data)
    {
        return $this->connector->request(
            "products",
            $data,
            "POST"
        );
    }

    /**
     * @param $product_id
     * @param array $data
     * @return array|\stdClass
     */
    public function edit($product_id, $data = [])
    {
        return $this->connector->request(
            "products/$product_id",
            $data,
            "PUT"
        );
    }

    /**
     * @param $product_id
     * @return array|\stdClass
     */
    public function delete($product_id)
    {
        return $this->connector->request(
            "products/$product_id",
            [],
            "DELETE"
        );
    }
}
class Invoice
{
    public $connector;

    /**
     * Invoices constructor.
     * @param Authorization $connector
     */
    public function __construct(Authorization $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param int $page
     * @param int $size
     * @return array|\stdClass
     */
    public function list_invoices($page = 90, $size = 25)
    {
        return $this->connector->request(
            "sales_invoices/?page[number]=$page&page[size]=$size",
            [],
            'GET'
        );
    }

    /**
     * @return mixed
     */
    public function count_sales_invoices()
    {
        return $this->connector->request(
            "sales_invoices/?page[size]=1",
            [],
            'GET'
        )->result->meta->total_count;
    }

    /**
     * @param int $page
     * @param int $size
     * @return array|\stdClass
     */
    public function list_e_invoices($page = 1, $size = 25)
    {
        return $this->connector->request(
            "e_invoices/?page[number]=$page&page[size]=$size",
            [],
            'GET'
        );
    }

    /**
     * @return mixed
     */
    public function count_e_invoices()
    {
        return $this->connector->request(
            "e_invoices/?page[number]=1&page[size]=2",
            [],
            'GET'
        )->result->meta->total_count;
    }
    public function checkJobStatus($id)
    {
        return $this->connector->request(
            'trackable_jobs/'.$id,
            [],
            'GET'
        );
    }

    /**
     * @param array $data
     * @return array|\stdClass
     */
    public function search($data = [])
    {
        $filter = null;
        foreach ($data as $key => $value)
        {
            if (end($data) == $value)
                $filter .= "filter[$key]=".urlencode($value);
            else
                $filter .= "filter[$key]=".urlencode($value)."&";
        }

        return $this->connector->request(
            "sales_invoices?$filter",
            [],
            'GET'
        );
    }

    /**
     * @param $invoice_id
     * @return array|\stdClass
     */
    public function show($invoice_id)
    {
        return $this->connector->request(
            "sales_invoices/$invoice_id?include=active_e_document,contact,details.product",
            [],
            'GET'
        );
    }


    /**
     * @param $data
     * @return array|\stdClass
     */
    public function create($data)
    {
        return $this->connector->request(
            "sales_invoices?include=active_e_document",
            $data,
            'POST'
        );
    }

    /**
     * @param $invoice_id
     * @param $data
     * @return array|\stdClass
     */
    public function edit($invoice_id, $data)
    {
        return $this->connector->request(
            "sales_invoices/$invoice_id",
            $data,
            'POST'
        );
    }

    /**
     * @param $invoice_id
     * @return array|\stdClass
     */
    public function delete($invoice_id)
    {
        return $this->connector->request(
            "sales_invoices/$invoice_id",
            [],
            'DELETE'
        );
    }

    /**
     * @param $invoice_id
     * @return array|\stdClass
     */
    public function cancel($invoice_id)
    {
        return $this->connector->request(
            "sales_invoices/$invoice_id/cancel",
            [],
            'DELETE'
        );
    }

    /**
     * @param $invoice_id
     * @param $data
     * @return array|\stdClass
     */
    public function pay($invoice_id, $data)
    {
        return $this->connector->request(
            "sales_invoices/$invoice_id/payments",
            $data,
            'POST'
        );
    }

    /**
     * @param $vkn
     * @return array|\stdClass
     */
    public function check_vkn_type($vkn)
    {
        return $this->connector->request(
            "e_invoice_inboxes?filter[vkn]=$vkn",
            [],
            'GET'
        );
    }

    /**
     * @param $data
     * @return array|\stdClass
     */
    public function create_e_archive($data)
    {
        return $this->connector->request(
                    'e_archives',
            $data,
            'POST'
        );
    }

    /**
     * @param $e_archive_id
     * @return array|\stdClass
     */
    public function show_e_archive($e_archive_id)
    {
        return $this->connector->request(
            'e_archives/'.$e_archive_id,
            [],
            'GET'
        );

    }

    /**
     * @param $e_archive_id
     * @return array|\stdClass
     */
    public function pdf_e_archive($e_archive_id)
    {
        return $this->connector->request(
            "e_archives/$e_archive_id/pdf",
            [],
            'GET'
        );
    }

    /**
     * @param $data
     * @return array|\stdClass
     */
    public function create_e_invoice($data)
    {
        return $this->connector->request(
            'e_invoices',
            $data,
            "POST"
        );
    }

    /**
     * @param $e_invoice_id
     * @return array|\stdClass
     */
    public function show_e_invoice($e_invoice_id)
    {
        return $this->connector->request(
            'e_invoices/'.$e_invoice_id,
            [],
            "GET"
        );
    }

    /**
     * @param $e_invoice_id
     * @return array|\stdClass
     */
    public function pdf_e_invoice($e_invoice_id)
    {
        return $this->connector->request(
            "e_invoices/$e_invoice_id/pdf",
            [],
            "GET"
        );
    }

    /**
     * @param $url
     * @param $path
     * @return bool
     */
    public function upload_pdf($url, $path)
    {
        if (!function_exists("file_put_contents"))
            return false;

        if (!function_exists("file_get_contents"))
            return false;

        $getPDF = @file_get_contents($url);

        if (!$getPDF)
            return false;

        $upload = @file_put_contents($path, $getPDF);

        if (!$upload)
            return false;

        return true;
    }

    /**
     * @param $trackable_id
     * @return array|\stdClass
     */
    public function trackable_jobs($trackable_id)
    {
        return $this->connector->request(
            "trackable_jobs/$trackable_id",
            [],
            "GET"
        );
    }
}
?>



