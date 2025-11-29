<!doctype html>
<html lang="tr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url("assets/vendor/bootstrap/css/bootstrap.min.css")?>">
    <link href="<?=base_url("assets/vendor/fonts/circular-std/style.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/style.css?v=2")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/chartist-bundle/chartist.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/morris-bundle/morris.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/c3charts/c3.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/DataTables/datatables.min.css")?>"/>

    <title>EPİNDENİZİ Control Panel</title>
</head>

<body>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->

    <?php
    $this->load->view("template_parts/header");
    ?>

    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">
                                Destek Talebi: <?=$desk->title?> - #<?=$desk->help_code?>
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Destek Talebi: <?=$desk->title?> - #<?=$desk->help_code?>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <?php
                if(isset($alert)){
                    ?>
                    <div class="alert alert-<?=$alert["class"]?>">
                        <i class="fas fa-check"></i> <?=$alert["message"]?>
                    </div>
                    <?php
                }
                ?>
                <div id="helpdesk">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header font-weight-bold">Mesajlar</h5>
                                <div class="card-body">
                                    <style>
                                        #desk-messages{
                                            height:300px;
                                            overflow-x: hidden;
                                            overflow-y:scroll;
                                            padding-right:5px;
                                        }
                                        #desk-messages::-webkit-scrollbar {
                                            width: 2px;
                                        }

                                        /* Track */
                                        #desk-messages::-webkit-scrollbar-track {
                                            background: #f1f1f1;
                                        }

                                        /* Handle */
                                        #desk-messages::-webkit-scrollbar-thumb {
                                            background: #888;
                                        }

                                        /* Handle on hover */
                                        #desk-messages::-webkit-scrollbar-thumb:hover {
                                            background: #555;
                                        }
                                    </style>
                                    <div id="desk-messages">
                                    <?php
                                        if(count($desk_messages)>0){
                                            foreach($desk_messages as $msg):
                                                $user = $this->db->where([
                                                    'id' => $msg->user_id
                                                ])->get('users')->row();
                                                if($msg->user_id == getActiveUser()->id){
                                    ?>
                                        <div class="desk-message mb-2">
                                            <div class="d-flex align-items-start justify-content-end">
                                                <div class="w-auto shadow-sm rounded bg-primary text-light text-right font-weight-light small p-2 mr-2" data-toggle="tooltip" data-placement="left" data-html="true" title="<small><?=date('d/m/Y H:i', strtotime($msg->created_at))?></small>"><?=$msg->text?></div>
                                                <img src="<?=get_gravatar($user->email, 32)?>" class="rounded-circle" width="32" height="32" alt="<?=$user->email?>">
                                            </div>
                                        </div>
                                    <?php
                                                }else {
                                    ?>
                                        <div class="desk-message mb-2">
                                            <div class="d-flex align-items-start justify-content-start">
                                                <img src="<?= get_gravatar($user->email, 32) ?>"
                                                     class="rounded-circle" width="32" height="32"
                                                     alt="<?= $user->email ?>">
                                                <div
                                                    class="w-auto shadow-sm rounded bg-dark text-light font-weight-light small p-2 ml-2"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-html="true"
                                                    title="<small><?= date('d/m/Y H:i', strtotime($msg->created_at)) ?></small>"><?= $msg->text ?></div>
                                            </div>
                                        </div>
                                    <?php
                                                }
                                            endforeach;
                                        }else{
                                            ?>
                                            <div class="alert alert-light shadow-sm text-center mb-0">
                                                <i class="fas fa-info-circle"></i> Hiç mesaj bulunmuyor.
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    </div>
                                    <div id="reply-area" class="mt-2 pt-2 border-top">
                                    <?php
                                        if($desk->is_cancel == 1){
                                    ?>
                                        <div class="alert alert-danger small mb-1">Bu destek talebi sonlandırılmış. <strong>Sonlandıran Kişi:</strong> <?=$this->db->where([
                                                    'id' => $desk->is_cancel_user_id
                                                ])->get('users')->row()->email?></div>
                                            <div class="text-center small text-muted">Yine de mesaj göndermek ister misin?</div>
                                    <?php
                                        }
                                    ?>
                                        <textarea id="reply-area-text" rows="2" class="form-control" placeholder="Mesajınız..."></textarea>
                                        <div class="text-right pt-2">
                                            <button class="btn btn-primary btn-sm" id="send-msg-button" type="submit">Gönder</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header font-weight-bold">#<?=$desk->help_code?> - <?=$desk->title?></h5>
                                <div class="card-body">
                                    <div class="shadow-sm p-3 border mb-2">
                                        <h5 class="mb-1 font-weight-bold border-bottom">Destek Mesajı</h5>
                                        <div><?=$desk->text?></div>
                                    </div>
                                <?php
                                    if($desk->is_cancel == 0){
                                ?>
                                    <a href="<?=current_url() . '?close_desk'?>" class="text-danger">Bu destek talebini sonlandır</a>
                                <?php
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->load->view("template_parts/footer");
        ?>
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->

<?php
$this->load->view("template_parts/footer_scripts");
?>

<script>
    $("#desk-messages").animate({ scrollTop: $('#desk-messages').prop("scrollHeight")}, 1000);
    $('#send-msg-button').click(function(e){
        e.preventDefault();
        sendMessage($('#reply-area-text').val());
    });
    function sendMessage(msg){
        if(msg !== ''){
            $.post('<?=current_url() . '?send_msg'?>', {
                <?=$this->security->get_csrf_token_name()?>: '<?=$this->security->get_csrf_hash()?>',
                msg_text: msg
            },function(response){
                window.location.reload()
            });
        }
    }
</script>

</body>

</html>