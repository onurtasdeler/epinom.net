<?php



function user_login_log_add($email,$status=0,$ip){

    $t=&get_instance();

    $t->load->model("m_tr_model");

    $sorgu=$t->m_tr_model->query("SELECT * FROM table_users_login WHERE ip='".$ip."' and login_date >= NOW() - INTERVAL 1 minute");

    return 1;

    if($sorgu){



        if(count($sorgu)>5){



            $getLoginDeneme=getTableSingle("table_users_login",array("ip" => $ip));



            if($getLoginDeneme->banned_date=="0000-00-00 00:00:00"){

                $gecici_ban=$t->m_tr_model->updateTable("table_users_login",array("banned_date" => date("Y-m-d H:i:s")),array("ip" => $ip));

                return 2;

            }else{

                $baslangicTarihi = new DateTime(date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"))));

                $fark=$baslangicTarihi->diff(new DateTime(date("Y-m-d H:i:s",strtotime($getLoginDeneme->banned_date))));

                $fark_dakika=$fark->i;

                $fark=60-$fark->s;

                if($fark_dakika>=1){



                    unset($_SESSION["banned"]);

                    $gecici_ban_kaldir=$t->m_tr_model->updateTable("table_users_login",array("banned_date" => ""),array("ip" => $ip));

                    return 1;

                }else{

                    if($fark<=0){

                        unset($_SESSION["banned"]);

                        $gecici_ban_kaldir=$t->m_tr_model->updateTable("table_users_login",array("banned_date" => ""),array("ip" => $ip));

                        return 1;

                    }else{

                        $t->session->set_userdata("banned" ,array(

                            "mesaj" =>  "Çok fazla sayıda deneme yaptınız. <br> Lütfen $fark saniye bekleyiniz.",

                            "tarih" =>  date("Y-m-d H:i:s"),

                            "banned_date" => $getLoginDeneme->banned_date,

                            "fark" => $fark,

                            "ip" => $getLoginDeneme->ip

                        ));

                        return "a";

                    }

                }

            }

        }else{

            $add=$t->m_tr_model->add_new(array("email" => $email,"ip" => $ip,"status" =>$status,"login_date" => date("Y-m-d H:i:s")),"table_users_login");

            return 1;

        }

    }else{

        $add=$t->m_tr_model->add_new(array("email" => $email,"ip" => $ip,"status" =>$status,"login_date" =>  date("Y-m-d H:i:s")),"table_users_login");

        return 1;

    }

}



function token_control(){

    if($_SESSION["tokens"]){

        $t=&get_instance();

        $cek=getTableSingle("table_users",array("token" => $_SESSION["tokens"]["tokens"],"status" => 1,"banned" => 0));

        if($cek){

            return "1";

        }else{

            return "2";

        }

    }else{

        return "2";

    }

}



function getActiveUsers(){
    if($_SESSION["tokens"]){

        $t=&get_instance();

        $cek=getTableSingle("table_users",array("token" => $_SESSION["tokens"]["tokens"],"status" => 1,"banned" => 0));

        if($cek){

           return $cek;

        }else{

            return false;

        }

    }else{

        return false;

    }

}



function balanceMinus($user,$price,$types,$desc,$product_id=0,$order_id=0,$advert_id=0){

    if($_SESSION["tokens"]){

        $t=&get_instance();

        $t->load->model("m_tr_model");

        if($user->balance>=$price){

            $kaydet=$t->m_tr_model->add_new(array(

                "user_id" => $user->id,

                "type" => $types,

                "quantity" => $price,

                "description" => $desc,

                "status" => 1,

                "product_id" => $product_id,

                "order_id" => $order_id,

                "created_at" =>  date("Y-m-d H:i:s")

            ),"table_users_balance_history");



            if($kaydet){

                $guncelle=$t->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$kaydet."-".rand(111,999)),array("id" => $kaydet));

                return true;

            }else{

                return false;

            }

        }else{

            return "bakiye_yetersiz";

        }

    }else{

        return "oturum";

    }

}



function adsCreateDoping($user_id,$advert_id,$doping_id,$price){

    if($_SESSION["tokens"]){

        $t=&get_instance();

        $t->load->model("m_tr_model");

        $kaydet=$t->m_tr_model->add_new(array(

            "user_id" => $user_id,

            "advert_id" => $advert_id,

            "doping_id" => $doping_id,

            "price" => $price,

            "created_at" =>  date("Y-m-d H:i:s")

            ),"table_adverts_dopings_users");

        if($kaydet){

            return true;

        }else{

            return false;

        }

    }else{

        return "oturum";

    }

}



function TCDogrula($tc,$ad,$soyad,$dogumyili)

{

    $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");

    try {

        $result = $client->TCKimlikNoDogrula

        (

            [

                'TCKimlikNo' => $tc,

                'Ad' => $ad,

                'Soyad' => $soyad,

                'DogumYili' => $dogumyili

            ]

        );

        if ($result->TCKimlikNoDogrulaResult)

        {

           return 1;

        } else

        {

          return 2;

        }

    } catch (Exception $e) {

        return 3;

    }

}



function addNotis($user_id,$type,$noti_id,$advert_id=0,$order_id=0,$com=0,$talep=0){

    $t=&get_instance();

    $t->load->model("m_tr_model");

    $kaydet=$t->m_tr_model->add_new(array(

        "user_id" => $user_id,

        "type" => $type,

        "noti_id" => $noti_id,

        "advert_id" => $advert_id,

        "order_id" => $order_id,

        "comment_id" => $com,

        "created_at" => date("Y-m-d H:i:s"),

        "talep_id" => $talep

    ),"table_notifications_user");

}

?>