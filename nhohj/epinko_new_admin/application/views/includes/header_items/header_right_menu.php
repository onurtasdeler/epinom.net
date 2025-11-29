<div class="topbar">
    <!--begin::Search-->

    <!--end::Search-->
    <!--begin::Notifications-->
    <div class="dropdown show">
        <!--begin::Toggle-->
        <?php
        $cek = getTableOrder("admin_notification", array("is_read" => 0), "id", "desc", 10);
        ?>
        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
            <div class="btn btn-icon  btn-dropdown mr-1 <?= ($cek)?"pulse pulse-danger btn-light":"btn-clean" ?>">
                <i class="flaticon2-bell-5  <?= ($cek)?"pulse pulse-danger btn-light":"btn-clean" ?>"></i>
                <span class="pulse-ring"></span>
            </div>
        </div>
        <!--end::Toggle-->
        <!--begin::Dropdown-->
        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg "
             x-placement="bottom-end"
             style="position: absolute; transform: translate3d(-292px, 65px, 0px); top: 0px; left: 0px; will-change: transform;">
            <form>
                <!--begin::Header-->
                <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top"
                     style="background-image: url(<?= base_url() ?>assets/backend/media/misc/bg-1.jpg)">
                    <!--begin::Title-->
                    <h4 class="d-flex flex-center rounded-top">
                        <span class="">Bildirimler</span>
                        <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">xx Bildirim</span>
                    </h4>
                    <!--end::Title-->
                    <!--begin::Tabs-->

                    <!--end::Tabs-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="tab-content">
                    <!--begin::Tabpane-->
                    <div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
                        <!--begin::Scroll-->
                        <div class="scroll pr-7 mr-n7 ps" data-scroll="true" data-height="300" data-mobile-height="200"
                             style="height: 300px; overflow: hidden;" id="bildirimPanel">

                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <?php

                            if ($cek) {
                                foreach ($cek as $item) {
                                    ?>
                                    <div class="d-flex align-items-center mb-6">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a href="<?= base_url($item->link) ?>"
                                               class="text-dark text-hover-primary mb-1 font-size-lg">
                                                <?= $item->baslik ?>
                                            </a>
                                            <span class="text-muted"><?= $item->aciklama ?></span>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="alert alert-warning"> Yeni Bildirim Bulunmuyor</div>
                                <?php
                            }
                            ?>


                            <!--end::Item-->
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                            </div>
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Action-->
                        <div class="d-flex flex-center pt-7">
                            <a href="#" class="btn btn-light-primary font-weight-bold text-center">Tümünü Gör</a>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--end::Tabpane-->
                </div>
                <!--end::Content-->
            </form>
        </div>
        <!--end::Dropdown-->
    </div>
    <!--end::Notifications-->
    <!--begin::Quick Actions-->


    <!--end::Languages-->
    <!--begin::User-->
    <div class="topbar-item">
        <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
             id="kt_quick_user_toggle">
            <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Merhaba</span>
            <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"> <?= $_SESSION["user1"]["name"] ?></span>
            <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                            <span class="symbol-label font-size-h5 font-weight-bold"><i class="fa fa-user"></i></span>
                                        </span>
        </div>
    </div>
    <!--end::User-->
</div>