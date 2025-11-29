<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 0px;">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <?php $this->load->view("settings/toolbar") ?>

                    </div>
                    <div class="col-lg-9">
                        <div class="card card-custom">
                            <?php $this->load->view("includes/page_inner_header_card") ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th>Sağlayıcı</th>
                                                    <th style="">Durum</th>
                                                    <th style="width: 10%;"> İşlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Google</td>
                                                    <td>
                                                        <span class="switch switch-outline switch-icon switch-success">
                                                            <label>
                                                                <input type="checkbox" id="switch-lg_google" <?= $data["veri"][0]->google_login == 1 ? 'checked' : '' ?> data-url="<?= base_url('social-update/google') ?>" onchange="durum_degistir('google')" name="select">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td nowrap="nowrap">
                                                        <a href="<?= base_url('ayarlar/social-update/google') ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
                                                            <i class="la la-edit text-warning"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Twitch</td>
                                                    <td>
                                                        <span class="switch switch-outline switch-icon switch-success">
                                                            <label>
                                                                <input type="checkbox" id="switch-lg_twitch" <?= $data["veri"][0]->twitch_login == 1 ? 'checked' : '' ?> data-url="<?= base_url('social-update/twitch') ?>" onchange="durum_degistir('twitch')" name="select">
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </td>
                                                    <td nowrap="nowrap">
                                                        <a href="<?= base_url('ayarlar/social-update/twitch') ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
                                                            <i class="la la-edit text-warning"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>


                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
        <br>
    </div>
</form>