<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-between d-flex justify-content-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title"><b class="text-info"><?= $_SESSION["user1"]["username"] ?></b> > Şifre Değiştir</h4>
                                        </div>
                                        <div class="d-flex align-center">

                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="nk-data data-list">

                                        <form id="markaAddForm" enctype="multipart/form-data"
                                              onsubmit="return false" method="post" action="" class=" is-alter">
                                            <input type="hidden" name="updateId" id="updateId">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sifre">Şifre<small
                                                                    class="text-danger">*</small></label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" data-msg="Lütfen Yeni Şifrenizi giriniz"
                                                                   class="form-control" id="sifre"
                                                                   name="sifre" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sifre_tekrar">Şifre Tekrar<small
                                                                    class="text-danger">*</small></label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" data-msg="Lütfen Şifreyi Tekrar Giriniz"
                                                                   class="form-control" id="sifre_tekrar"
                                                                   name="sifre_tekrar" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 ">
                                                    <div class="form-group">
                                                        <label class="form-label" for="email-address">
                                                            &nbsp;</label>
                                                        <div class="form-control-wrap">
                                                            <div class="row">
                                                                <div class="col-lg-6" style="display:none" id="subCont1">
                                                                    <button type="button" name="vazgec"
                                                                            id="formBackButton"
                                                                            class="btn btn-md btn-warning btn-block"><em
                                                                                class="icon ni ni-cross"></em> Vazgeç
                                                                    </button>
                                                                </div>
                                                                <div class="col-lg-12" id="subCont2">
                                                                    <button type="submit" name="kaydet"
                                                                            id="markaSubmitButton"
                                                                            class="btn btn-md btn-success btn-block"><em
                                                                                class="icon ni ni-check"></em> Kaydet
                                                                    </button>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- data-list -->
                                </div><!-- .nk-block -->
                                <div class="nk-block">
                                    <div class="card border border-light">
                                        <table class="table table-ulogs">
                                            <thead class="table-light">
                                            <?php
                                            $d=getTableOrder("ft_logs",array("user_id" => $_SESSION["user1"]["user"],"status" => 2),"id","desc",20);
                                            ?>
                                            <tr>
                                                <th class="tb-col-os"><span class="overline-title">Tarayıcı <span class="d-sm-none">/ IP</span></span></th>
                                                <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                                <th class="tb-col-time"><span class="overline-title">Zaman</span></th>
                                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if($d){
                                                foreach ($d as $item) {
                                                    ?>
                                                    <tr>
                                                        <td class="tb-col-os"><?= $item->agent ?></td>
                                                        <td class="tb-col-ip"><span class="sub-text"><?= $item->ip ?></span></td>
                                                        <td class="tb-col-time"><span class="sub-text"><?= date("Y-m-d",strtotime($item->date)) ?> <span class="d-none d-sm-inline-block"><?= date("H:i",strtotime($item->date)) ?></span></span></td>
                                                        <td class="tb-col-action"><?= $item->title ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- .nk-block-head -->

                            </div>
                        </div><!-- .card-aside-wrap -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
