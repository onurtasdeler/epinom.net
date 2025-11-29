<div class="topbar">
    <!--begin::Search-->
    
    <!--end::Search-->
    <!--begin::Notifications-->
    <div class="dropdown show">
        <!--begin::Toggle-->

        <!--end::Toggle-->
        <!--begin::Dropdown-->
        <!--end::Dropdown-->
    </div>
    <!--end::Notifications-->
    <!--begin::Quick Actions-->


    <!--end::Languages-->
    <!--begin::User-->
    <div class="topbar-item">
        <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
             id="kt_quick_user_toggle">
            <?php
            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));

            ?>
            <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Merhaba</span>
            <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"> </span>

                                            <span class="symbol-label font-size-h5 font-weight-bold"><?= $uye->name ?></span>
            <i class="fa fa-cog"></i>

        </div>
    </div>
    <!--end::User-->
</div>