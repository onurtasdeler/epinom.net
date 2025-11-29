<?php
//login control
function loginControl($y=1){
    $t =&get_instance();
    if ($t->session->userdata("user1")) {
        $t->load->model("m_tr_model");
        $t->formControl = uniqid("user_");
        setSession2("formCheck", $t->formControl);
        if($y==2){
            redirect(base_url("yetki-yok"));
        }
    } else {
        redirect(base_url("login"));
    }
}

//get settings
function getSettings(){
    return getTableSingle("options_general",array("id"=>1));
}

//get module
function getModule($id){
    return getTableSingle("module",array("id"=>$id));
}


function veriTemizle($mVar){
    if(is_array($mVar)){
        foreach($mVar as $gVal => $gVar){
            if(!is_array($gVar)){
                $mVar[$gVal] = htmlspecialchars(strip_tags(urldecode(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($gVar))))))));  // -> Dizi olmadığını fark edip temizledik.
            }else{
                $mVar[$gVal] = veriTemizle($gVar);
            }
        }
    }else{
        $mVar = htmlspecialchars(strip_tags(urldecode(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($mVar)))))))); // -> Dizi olmadığını fark edip temizledik.
    }
    return $mVar;
}


//---------------- ADVERTS ----------------------//
function addBalancePay($user_id,$type,$price,$desc,$ilan_id=0,$pro_id=0,$dop_id){
    $t=&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableSingle("table_users",array("id" => $user_id,"status" => 1,"banned" => 0));
    if($cek){
        $kaydet=$t->m_tr_model->add_new(array(
            "user_id" => $user_id,
            "type" => $type,
            "quantity" => $price,
            "description" => $desc,
            "ilan_id" => $ilan_id,
            "created_at" => date("Y-m-d H:i:s"),
            "product_id" => $pro_id,
            "doping_id" => $dop_id
        ),"table_users_balance_history");
        if($kaydet){
            if($type==1){
                $guncelle=$t->m_tr_model->updateTable("table_users",array("balance" => ($cek->balance + $price)),array("id" => $cek->id));
            }else{
                $guncelle=$t->m_tr_model->updateTable("table_users",array("balance" => ($cek->balance - $price)),array("id" => $cek->id));
            }
            if($guncelle){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }

}

function addNoti($user_id,$type,$noti_id,$advert_id=0,$order_id=0,$com=0,$talep=0){
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

//page create
function pageCreate($view,$data,$page,$postData){
    try {
        $t=&get_instance();
        if($data["err"]==true){
            $viewData=array(
                'view'=>$view,
                'page'=>$page,
                'data'=>$data,
                'postData' => $postData
            );
        }else{
            $viewData=array(
                'view'=>$view,
                'page'=>$page,
                'data'=>$data,
                'postData' => $postData
            );
        }

        $t->load->view("blank",$viewData);
    }catch (Exception $ex){
        return $ex;
    }

}

//alert popup model
function createModal($title,$desc,$quitSelect,$mainButton,$menuid="menu"){
    ?>

    <div class="modal fade" id="<?= $menuid ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?= ($mainButton[5])?$mainButton[5]:"" ?>"><?= $title ?></h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <p class="text-center text-dark">
                        <strong id="makaleId"></strong>
                        <input type="hidden" id="silinecek-<?= $menuid ?>">
                        <input type="hidden" id="tur">
                    </p>
                    <p class="text-center text-dark" id="<?= ($mainButton[7])?$mainButton[7]:"" ?>"><?= $desc ?></p>
                </div>
                <div class="modal-footer">
                    <?php
                    if($quitSelect==1){
                        ?>
                        <button type="button" id="<?= ($mainButton[6])?$mainButton[6]:"" ?>" class="btn btn-warning light" onclick="$('#<?= $menuid ?>').modal('hide')" data-dismiss="modal">Vazgeç</button>
                        <?php
                    }
                    ?>
                    <a class="btn <?= $mainButton[2] ?> light menu_sil" id="<?= ($mainButton[4])?$mainButton[4]:"" ?>" onclick="<?= $mainButton[1] ?>"> <em class="<?= $mainButton[3] ?>"></em><?= $mainButton[0] ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php
}



function email_gonder($sTo, $sSubject, $sMessage,$id,$tur,$template)
{
    $t=&get_instance();
    $t->load->library('phpmailer_lib');
    $mail = $t->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host     = 'smtp.yandex.com';
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;

    $mail->setFrom('', '');
    $mail->addReplyTo('', '');

    // Add a recipient
    $mail->addAddress($sTo);

    // Email subject
    $mail->Subject = $sSubject;
    $mail->CharSet = 'UTF-8';

    // Set email format to HTML
    $mail->isHTML(true);
    $site=file_get_contents($template);
    // Email body content

    $mail->Body = $site;
    // Send email
    if(!$mail->send()){
        return false;
    }else{
        return true;
    }
}

//module create Form
function getModuleForm($name,$data=null,$type){
    $t=&get_instance();
    $getRow=getTableSingle("module",array("name" => $name,"status" => 1));
    if($getRow){
        $expName=explode(",",$getRow->form_field);
        $expType=explode(",",$getRow->form_field_type);
        $expText=explode(",",$getRow->form_text);
        $expCol =explode(",",$getRow->form_field_col);
        $expRequired =explode(",",$getRow->form_field_required);
        $sayac=0;

        if($expName){
            foreach ($expName as $item) {
                ?>
                <div class="form-group row">
                    <label class="col-lg-<?= (12-$expCol[$sayac]) ?> col-form-label"><strong><?= $expText[$sayac] ?>:</strong>
                    </label>
                    <div class="col-lg-<?= $expCol[$sayac] ?>">
                        <?php
                        //select box

                        $arama_sonucu=strstr($expType[$sayac],"select");
                        if($arama_sonucu!==FALSE){
                            $expSelect=explode("/",$expType[$sayac]);
                            if($expSelect[1]=="status"){
                                if($type=="upd"){
                                    if($data->$item==1){
                                        ?>
                                        <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">
                                            <option value="0">Pasif</option>
                                            <option value="1" selected>Aktif</option>
                                        </select>
                                        <?php
                                    }else{
                                        ?>
                                        <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">
                                            <option value="0" selected>Pasif</option>
                                            <option value="1" >Aktif</option>
                                        </select>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">
                                        <option value="0">Pasif</option>
                                        <option value="1" selected>Aktif</option>
                                    </select>
                                    <?php
                                }

                            }else{
                                $getResult=getTableOrder($expSelect[1],array("status" => 1),"id","asc");
                                if($getResult){
                                    ?>
                                    <select name="<?= $item ?>" class="form-control" id="<?= $item ?>">
                                        <option value="">Seçiniz</option>
                                        <?php
                                        foreach ($getResult as $item2) {
                                            if($type=="upd"){
                                                if($item2->id==$data->$item){
                                                    ?>
                                                    <option selected value="<?= $item2->id ?>"><?= $item2->name ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?= $item2->id ?>"><?= $item2->name ?></option>
                                                    <?php
                                                }
                                            }else{
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

                        }else{
                            if($type=="upd"){
                                ?> <input type="<?= $expType[$sayac] ?>" name="<?= $item ?>" value="<?php if(!is_null($data)){ echo $data->$item; } ?>" id="<?= $item ?>" class="form-control" autocomplete="off"> <?php
                            }else{
                                ?> <input type="<?= $expType[$sayac] ?>" name="<?= $item ?>" value="<?php if(!is_null($data)){ echo $data[$item]; } ?>" id="<?= $item ?>" class="form-control" autocomplete="off"> <?php
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
function getModuleFormValidation($form,$module){
    try {
        $t=&get_instance();
        if($form){
            $t->load->library('form_validation');
            $getModule=getModule($module);
            if($getModule){
                $t->load->library('form_validation');
                $exp=explode(",",$getModule->form_field);
                $expText=explode(",",$getModule->form_text);
                $expRequired=explode(",",$getModule->form_field_required);
                $co=0;
                foreach ($exp as $item) {
                    if($expRequired[$co]==1){
                        $t->form_validation->set_rules($item,$expText[$co], 'trim|required');
                    }
                    $co++;
                }
                $t->form_validation->set_message(array(
                    "required"    =>	"{field} alanı boş geçilemez."));
                if ($t->form_validation->run() != FALSE) {
                    return array("err" => false,"message" => "");
                }
                else {
                    return array("err" => true,"type" => 1,"message" => validation_errors());
                }
            }else{
                return array("err" => true,"type" => 1,"message" => "Böyle bir modül bulunmamaktadır.");
            }
        }
    }catch (Exception $e){
        return $e->getMessage();
    }
}

//form validate alert
function formValidateAlert($type,$message,$icon){
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
function img_upload($file,$filename,$folder,$sil="",$path,$uzanti){
    try {
        $t=&get_instance();
        if($sil!=""){
            if(file_exists($path.$sil)){
                unlink($path.$sil);
            }
        }
        $dosya		=	$file['name']; // dosya ismini aldık
        $f1="";
        $target_dir = "../upload/".$folder."/";
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $ayarlar=getTableSingle("options_general",array("id" => 1));
        $newfilename = permalink($ayarlar->site_name. "-".$filename."-" . uniqid(rand(1, 1000))) . "." . $imageFileType;
        if ($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" ||$imageFileType == "JPG" || $imageFileType == "JPEG" || $imageFileType == "PNG" || $imageFileType=="webp" || $imageFileType=="svg") {
            if($uzanti){
                if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {
                    $f1 = $newfilename;
                }
            }else{
                $newfilename = permalink($ayarlar->site_name. "-".$filename."-" . uniqid(rand(1, 1000)));
                $image_f = upload_picture($file,$folder,$newfilename,"");
                $f1=$image_f.".webp";
            }
            return  $f1;
        }else{
            return 1;
        }
    }catch (Exception $ex){
        return "error";
    }
}

//get words count
function kelimesayisi($makale){
    $kelime_sayisi = str_word_count($makale, 0, "öçşığüÖÇŞİĞÜ");
    return $kelime_sayisi;
}

function veriSil($veri){
    unlink("makale.txt");
    $dosya = fopen ("makale.txt" , "a"); //dosya oluşturma işlemi
    $yaz=$veri;
    fwrite ( $dosya , $yaz ) ;
    fclose ($dosya);
    return $veri;
}

function getOpenFile(){
    $dosyaAc = fOpen("makale.txt" , "r");
    $dosyaOku = fRead ($dosyaAc , fileSize ("makale.txt"));
    $dosyaOku= str_replace("</ul>","</ul><br />",$dosyaOku);
    $dosyaOku= str_replace("<ul>","<br /><ul>",$dosyaOku);
    $dosyaOku= str_replace("</ol>","</ol><br />",$dosyaOku);
    $dosyaOku= str_replace("<ul>","<br /><ol>",$dosyaOku);
    fclose($dosyaAc);
    return $dosyaOku;
}

function IsNullOrEmptyString($str){
    return ($str === null || trim($str) === '');
}

function turkishcharacters( $string )
{
    $string = str_replace ( '&ccedil;', 'ç', $string );
    $string = str_replace ( '&yacute;','ı',$string );
    $string = str_replace ( '&Ccedil;', 'Ç', $string );
    $string = str_replace ( '&Ouml;', 'Ö', $string );
    $string = str_replace ( '&Yacute;', 'Ü', $string );
    $string = str_replace ( '&ETH;','Ğ',$string );
    $string = str_replace ( '&THORN;','Ş', $string );
    $string = str_replace ( '&Yacute;','İ', $string );
    $string = str_replace ( '&ouml;','ö', $string );
    $string = str_replace ( '&thorn;','ş', $string );
    $string = str_replace ( '&eth;','ğ', $string );
    $string = str_replace ( '&uuml;','ü', $string );
    $string = str_replace ( '&yacute;','ı', $string );
    $string = str_replace ( '&amp;','&', $string );

    return $string;
}

function ucwords_tr($str) {
    return ltrim(mb_convert_case(str_replace(array('i','I'), array('İ','ı'),mb_strtolower($str)), MB_CASE_TITLE, 'UTF-8'));
}

function trtekkelime($gelen)
{
    $uzunluk=strlen($gelen);
    $ilkharf = mb_substr($gelen,0,1,"UTF-8");
    $sonrakiharfler = mb_substr($gelen,1,$uzunluk,"UTF-8");
    $bir = array("ö","ç","i","ş","ğ","ü");
    $iki = array("Ö","Ç","İ","Ş","Ğ","Ü");
    $buyumus = str_replace($bir,$iki,$ilkharf);
    return ucwords($buyumus).$sonrakiharfler;
}

/// İmage Delete
function img_delete($url){
    if(file_exists("../upload/".$url)){
        unlink("../upload/".$url);
    }
}

function getcur(){
    $t=&get_instance();
    $t->load->model("m_tr_model");
    $tt=$t->m_tr_model->getTableSingle("table_currency",array("main" => 1,"status" => 1));
    if($tt){
        return $tt->name_short;
    }
}




