<?php

class Api extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        websiteStatus();
        header("Access-Control-Allow-Origin: *");
    }

    function Index(){
        redirect();
        exit(json_encode([
            "error" => TRUE,
            "message" => "Endpoint not found."
        ]));
    }

    function Cart($process_type = null){
        $this->load->library('custom_cart');
        switch($process_type){
            case "add":
                $product = $this->db->where([
                    "id" => explode("-", $this->input->post("pid", TRUE))[1],
                ])->get("products")->row();
                if(isset($product->id)){
                    $product_special_fields_count = $this->db->where([
                        'product_id' => $product->id
                    ])->get('product_special_fields')->num_rows();
                    if ($product_special_fields_count > 0) {
                        $addToCartExtra = array();
                        $_post_fields = json_decode($this->input->post('extra', TRUE));
                        foreach($_post_fields as $_p_f):
                            $_p_f_db = $this->db->where([
                                'product_id' => $product->id,
                                'name' => $_p_f->name
                            ])->get('product_special_fields')->row();
                            if (isset($_p_f_db->id)) {
                                if($_p_f_db->required == 1 && empty($_p_f->value)) {
                                    exit(json_encode([
                                        'error' => TRUE,
                                        'message' => 'Error.',
                                        'validation_errors_html' => '<div class="alert alert-danger">' . $_p_f_db->label . ' alanı zorunludur.</div>'
                                    ]));
                                }
                                if ($_p_f_db->input_type == 'select') {
                                    $_s_options = json_decode($_p_f_db->select_options);
                                    $s_error = TRUE;
                                    foreach($_s_options as $_s_option):
                                        if ($_s_option->value == $_p_f->value) {
                                            $s_error = FALSE;
                                        }
                                    endforeach;
                                    if ($s_error == TRUE) {
                                        exit(json_encode([
                                            'error' => TRUE,
                                            'message' => 'Error.',
                                            'validation_errors_html' => '<div class="alert alert-danger">' . $_p_f_db->label . ' alanı geçersiz. Lütfen kontrol ediniz.</div>'
                                        ]));
                                    }
                                }
                                $addToCartExtra[] = [
                                    'name' => $_p_f_db->name,
                                    'label' => $_p_f_db->label,
                                    'value' => $_p_f->value
                                ];
                            } else {
                                exit(json_encode([
                                    'error' => TRUE,
                                    'message' => 'Error.',
                                    'validation_errors_html' => '<div class="alert alert-danger">Bir şeyler ters gitti. Lütfen sayfayı yenileyerek tekrar deneyin.</div>'
                                ]));
                            }
                        endforeach;

                        $this->custom_cart->insert([
                            "id" => "pre_" . $product->id,
                            "qty" => $this->input->post("qty", TRUE) > 0 ? intval($this->input->post("qty", TRUE)) : 1,
                            "price" => getProductPrice($product),
                            "name" => $product->product_name,
                            "options" => $addToCartExtra
                        ]);
                        if (getActiveUser()) {
                            insertUserStep(getActiveUser()->id, 'cart_add', [
                                'qty' => $this->input->post("qty", TRUE) > 0 ? intval($this->input->post("qty", TRUE)) : 1,
                                'product' => $product,
                                'extra_information' => $addToCartExtra
                            ]);
                        }
                        exit(json_encode([
                            "error" => false,
                            "message" => "Successfully added.",
                            "alert" => '<div class="alert alert-success"><i data-feather="check"></i> Ürün sepetinize başarıyla eklendi.</div>'
                        ]));
                    } else {
                        $this->custom_cart->insert([
                            "id" => "pr_" . $product->id,
                            "qty" => $this->input->post("qty", TRUE) > 0 ? intval($this->input->post("qty", TRUE)) : 1,
                            "price" => getProductPrice($product),
                            "name" => $product->product_name
                        ]);
                        if (getActiveUser()) {
                            insertUserStep(getActiveUser()->id, 'cart_add', [
                                'qty' => $this->input->post("qty", TRUE) > 0 ? intval($this->input->post("qty", TRUE)) : 1,
                                'product' => $product
                            ]);
                        }
                        exit(json_encode([
                            "error" => false,
                            "message" => "Successfully added."
                        ]));
                    }
                }else{
                    exit(json_encode([
                        "error" => false,
                        "message" => "Error."
                    ]));
                }
                break;
            case "remove":
                if(isset($_POST["rid"])):
                    $this->custom_cart->remove($this->input->post("rid", TRUE));
                    exit(json_encode([
                        "error" => false,
                        "message" => "Successfully removed."
                    ]));
                endif;
                exit(json_encode([
                    "error" => true,
                    "message" => "Error."
                ]));
                break;
            case "list":
                exit(json_encode([
                    "error" => false,
                    "message" => "Success.",
                    "cart" => [
                        "total_price" => $this->custom_cart->total(),
                        "count" => $this->custom_cart->total_items(),
                        "items" => $this->custom_cart->contents()
                    ],
                    "cart_count" => count($this->custom_cart->contents())
                ]));
                break;
            case "update":
                if(isset($_POST["rid"])){
                    $this->custom_cart->update([
                        "rowid" => $this->input->post("rid", TRUE),
                        "qty" => $this->input->post("qty", TRUE) > 0 ? intval($this->input->post("qty", TRUE)) : 1
                    ]);
                    exit(json_encode([
                        "error" => false,
                        "message" => "Successfully updated."
                    ]));
                }
                break;
            default:
                exit(json_encode([
                    "error" => true,
                    "message" => "Endpoint not found."
                ]));
                break;
        }
    }

    function Search(){
        $categories = [];
        if(isset($_GET["query"])):
            if(!empty($_GET["query"])):
                foreach($this->db->like("category_name", $this->input->get("query", TRUE), "both")->where([
                    'is_active' => 1
                ])->get('categories')->result() as $category):
                    $categories[] = [
                        "name" => $category->category_name,
                        "url" => base_url("oyunlar/" . $category->category_url),
                        "image_url" => base_url("public/categories/" . $category->image_url)
                    ];
                endforeach;
            endif;
        endif;
        exit(json_encode($categories));
    }

    function CatSearch() {

        header('Content-type: application/json');

        $categories = [];
        if(isset($_GET["query"])):
            if($this->input->get('query', TRUE)) {
                $categories_db = $this->db
                    ->like("category_name", $this->input->get("query", TRUE), "both")
                    ->where([
                        'is_active' => 1,
                        'up_category_id' => 0
                    ])
                    ->order_by('category_name ASC, id DESC')
                    ->get('categories')
                    ->result();
                if(count($categories_db) == 0) {
                    $categories_db = $this->db
                        ->like("category_name", $this->input->get("query", TRUE), "both")
                        ->where([
                            'is_active' => 1
                        ])
                        ->order_by('category_name ASC, id DESC')
                        ->get('categories')
                        ->result();
                }
            } else {
                $categories_db = $this->db
                    ->where([
                        'is_active' => 1,
                        'up_category_id' => 0
                    ])
                    ->order_by('category_name ASC, id DESC')
                    ->get('categories')
                    ->result();
            }
            foreach($categories_db as $category):
                $arr = [
                    "name" => $category->category_name,
                    "url" => base_url("oyunlar/" . $category->category_url),
                    "image_url" => base_url("public/categories/" . $category->image_url)
                ];
                $subs = $this->db->where([
                    'up_category_id' => $category->id
                ])->get('categories')->result();
                $arr['subs'] = [];
                if(count($subs)>0) {
                    foreach($subs as $_sub):
                        $arr['subs'][] = [
                            "name" => $_sub->category_name,
                            "url" => base_url("oyunlar/" . $_sub->category_url),
                            "image_url" => base_url("public/categories/" . $_sub->image_url)
                        ];
                    endforeach;
                }
                $categories[] = $arr;
                unset($arr);
                unset($subs);
            endforeach;
        endif;

        $list_html = NULL;
        foreach($categories as $_c):
            if (count($_c['subs']) > 0) {
                $list_html .= '<li class="has-child border-bottom">
                    <a class="h" href="' . $_c['url'] . '">' . $_c['name'] . ' <span data-feather="chevron-down" width="13" height="13"></span></a>  
                    <ul class="sub-categories border-top border-primary">';
                foreach($_c['subs'] as $_cs):
                    $list_html .= '<li>
                        <a href="' . $_cs['url'] . '">' . $_cs['name'] . '</a>
                    </li>';
                endforeach;
                $list_html .= '</ul>
                </li>';
            } else {
                $list_html .= '<li class="border-bottom">';
                $list_html .= '<a href="' . $_c['url'] . '">' . $_c['name'] . '</a>';
                $list_html .= '</li>';
            }
        endforeach;

        exit(json_encode([
            'error' => FALSE,
            'message' => 'success',
            'data' => [
                'list' => $categories,
                'list_html' => $list_html
            ]
        ]));
    }

    function FacebookCallback(){

        if(getActiveUser()){
            $this->Index();
            return;
        }

        $wConfig = $this->db->where('id=1')->get('config')->row();

        $fb = new \Facebook\Facebook([
            'app_id' => $wConfig->facebook_app_id,
            'app_secret' => $wConfig->facebook_app_secret,
            'default_graph_version' => $wConfig->facebook_graph_version
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            redirect('uye/kayit-ol');
            return;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            redirect('uye/kayit-ol');
            return;
        }

        $oAuth2Client = $fb->getOAuth2Client();

        if(!$accessToken->isLongLived())
        {
            $accessToken =  $oAuth2Client ->getLongLivedAccessToken($accessToken);
        }

        $response = $fb->get("/me?fields=id,name,email,picture.type(large),gender,birthday,address", $accessToken);
        $userData = $response->getGraphNode()->asArray();

        $viewData = [
            'userData' => $userData,
            'accessToken' => $accessToken
        ];
        $this->load->view('pages/loginwith/facebook', (object)$viewData);

    }

}
