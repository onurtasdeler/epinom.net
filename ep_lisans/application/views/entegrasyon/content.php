<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head d-flex justify-content-between">
                    <h5><?= $page["h3"] ?></h5>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 id="secTitle" class="nk-block-title">NETGSM API Bilgileri</h6>
                                                        </div>
                                                    </div>

                                                    <form id="smsayar" method="post" action="<?= base_url("sms-ayarlari") ?>" class="">
                                                        <input type="hidden" name="updateId" id="updateId">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row m-2">
                                                                    <div class="col-12 bg-white">
                                                                        <div class="row p-3">
                                                                            <div class="col-12 col-lg-4">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Netgsm API Username</label>
                                                                                        <input type="text" class="form-control" id="username" name="username" value="<?= $data["v"]->user ?>" placeholder="Netgsm API Username">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-4">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Netgsm API Password</label>
                                                                                        <input type="text" class="form-control" id="pass" name="pass" value="<?= $data["v"]->pass ?>" placeholder="Netgsm API Password">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-4">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Netgsm API HEADER</label>
                                                                                        <input type="text" class="form-control" id="hader" name="header" value="<?= $data["v"]->header ?>" placeholder="Netgsm API Header">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for=""></label>
                                                                                        <span type="submit" name="de" id="smsayarSubmit" class="form-control btn btn-success d-flex justify-content-center">Güncelle</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
    <?php $this->load->view($this->viewFolder . "/modal") ?>

</div>


