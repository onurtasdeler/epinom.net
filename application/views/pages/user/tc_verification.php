<!DOCTYPE html>
<html lang="tr" class="h-100">

<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title>
        <?= getSiteTitle() ?> - Kimlik Doğrulaması
    </title>
</head>

<body class="bg-body" id="kt_body">
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Password reset -->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="<?= base_url() ?>" class="mb-12">
                    <img alt="Logo" src="<?= getSiteLogo() ?>" class="h-40px">
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    
                    <?php
                    echo form_open(current_url(), [
                        "id" => "tcVerificationPageForm",
                        "class" => "form w-100 fv-plugins-bootstrap5 fv-plugins-framework"
                    ]);
                    ?>
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">T.C Kimlik Doğrulaması</h1>
                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-400 fw-bold fs-5">Alışverişlerde çalıntı kredi kartı vb. durumlarda sorun yaşamamak adına bu işlemi yapmaktayız.</div>
                            <!--end::Link-->
                        </div>
                        <!--begin::Heading-->
                        <?php
                        if (isset($alert)):
                            ?>
                            <div class="alert alert-<?= $alert["class"] ?>">
                                <?= $alert["message"] ?>
                            </div>
                            <?php
                        endif;
                        ?>
                        <?php
                        if (isset($form_error)):
                            ?>
                            <div class="alert alert-danger">
                                <?= validation_errors('<div>', '</div>') ?>
                            </div>
                            <?php
                        endif;
                        ?>
                        <?php if (@$alert['class'] != 'success'): ?>
                        <!--begin::Input group-->
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-gray-900 fs-6">İsim</label>
                            <input class="form-control form-control-solid" type="text" value="<?= set_value('firstname'); ?>" name="firstname"
                                autocomplete="off">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Soyisim</label>
                            <input class="form-control form-control-solid" type="text" value="<?= set_value('lastname'); ?>" name="lastname"
                                autocomplete="off">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Doğum Yılı</label>
                            <input class="form-control form-control-solid" type="number" maxlength="4" value="<?= set_value('birthyear') ? set_value('birthyear') : date('Y') - 10; ?>" name="birthyear"
                                autocomplete="off">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-gray-900 fs-6">T.C Kimlik Numarası</label>
                            <input class="form-control form-control-solid" type="text" maxlength="14" value="<?= set_value('tc_no'); ?>" name="tc_no"
                                autocomplete="off">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex flex-wrap justify-content-center pb-lg-0 mt-10">
                            <button type="submit" name="idVerification" value="<?= md5(rand()) ?>"
                                class="btn btn-lg btn-primary fw-bolder me-4">
                                <span class="indicator-label">Onayla</span>
                                <span class="indicator-progress">Lütfen bekleyiniz...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                        <?php endif; ?>
                        <div></div>
                    <?= form_close(); ?>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Password reset-->
    </div>

    <script src="<?= base_url("assets/dist/js/script.js") ?>?ver=13"></script>
</body>

</html>