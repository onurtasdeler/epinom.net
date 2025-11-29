
<?php
if($this->input->get("token")){

}else{
    redirect(base_url(gg()."404"));
}
$sayfas=getLangValue(94,"table_pages");
$kayitt=getLangValue(24,"table_pages");
$anasayfa=getLangValue(11,"table_pages");
$giris=getLangValue(25,"table_pages");
?>

<?php
$tabl=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
?>
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head") ?>
    <style>
        label.error {
            color: #ff4267 !important;
            padding: 3px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            display: block !important;
        }
    </style>

</head>

<body class="template-color-1 nft-body-connect">

<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->




<div class="rn-breadcrumb-inner ptb--30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="title text-center text-md-start"><?= $sayfas->titleh1 ?></h5>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">
                    <li class="item"><a href="<?= base_url() ?>"><?= $anasayfa->titleh1 ?></a></li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item current"><?= $sayfas->titleh1 ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>



<div class="login-area rn-section-gapTop">
    <div class="container">
        <div class="row g-5">
            <div class="offset-2 col-lg-8 col-md-6 ml_md--0 ml_sm--0 col-sm-12">
                <div class="form-wrapper-one registration-area">
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <h4><?= $kayitt->titleh1 ?></h4>
                        </div>
                        <div class="col-lg-4" style="text-align: right">
                            <img style="width: 50%" src="<?= geti("logo/".$this->general->site_logo) ?>" alt="">
                        </div>
                    </div>
                    <?php
                    if($this->input->get("token")){
                        $goster=2;
                        $kont=getTableSingle("table_users",array("email_onay" => 0,"email_onay_kod" => $this->input->get("token") ));
                        if($kont){
                            $date1 = new DateTime(date("Y-m-d H:i:s"));
                            $date2 = new DateTime($kont->email_onay_send_at);
                            $diff = $date2->diff($date1);

                            if($diff->format("%h")>=2){
                                $delete=$this->m_tr_model->delete("table_users",array("id" => $kont->id));
                                ?>


                                        <?= html_entity_decode($kayitt->contentalt) ?>

                                <script>
                                    setTimeout(function (){
                                        window.location.href="<?= base_url(gg().$kayitt->link) ?>"
                                    },2000)
                                </script>
                            <?php
                            }else{
                            $guncelle=$this->m_tr_model->updateTable("table_users",array("email_onay" => 1,"status" => 1,"email_onay_kod" => "","uyelik_onay_date" => date("Y-m-d H:i:s")),array("id" => $kont->id));
                            $logekle=$this->m_tr_model->add_new(array(
                                "user_id" => $kont->id,
                                "user_email" => $kont->email,
                                "ip" => $_SERVER["REMOTE_ADDR"],
                                "title" => "Üyelik Onayı Gerçekleştirildi..",
                                "description" => $kont->nick_name." kullanıcı adı üye mail onayını gerçekleştirdi ve üyelik oluşturuldu.",
                                "date" => date("Y-m-d H:i:s"),
                                "status" => 1
                            ),"ft_logs");


                            ?>
                                <?= html_entity_decode($sayfas->contentust) ?>
                                <script>
                                    setTimeout(function (){
                                        window.location.href="<?= base_url(gg().$giris->link) ?>"
                                    },2000)
                                </script>
                                <?php
                            }
                        }else{
                            redirect(base_url(gg()."404"));
                        }
                    }else{
                        redirect(base_url(gg()."404"));
                    }

                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Start Footer Area -->
<?php $this->load->view("includes/footer") ?>
<!-- End Footer Area -->

<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>
<!-- Start Top To Bottom Area  -->
<div class="rn-progress-parent">
    <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- End Top To Bottom Area  -->
<!-- JS ============================================ -->
<?php $this->load->view("includes/script") ?>

</body>

</html>