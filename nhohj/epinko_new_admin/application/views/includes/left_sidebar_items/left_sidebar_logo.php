<?php
/**
 * Created by PhpStorm.
 * User: brkki
 * Date: 28.04.2021
 * Time: 12:34
 */
?>
<div class="brand flex-column-auto justify-content-center" id="kt_brand" style="    background-color: rgb(30 30 46);">
    <!--begin::Logo-->
    <a href="<?= base_url() ?>" class="brand-logo">
        <?php
        $ayarlarr = getTableSingle("options_general", array("id" => 1));
        if ($ayarlarr->site_logo != "") {
            if ($this->uri->segment(2)) {
                if ($this->uri->segment(3)) {
                    ?>
                    <img class="img-fluid" alt="Logo"
                         src="../../../../../../upload/logo/<?= $ayarlarr->site_logo ?>"
                         width="200" height="100"/>
                    <?php
                } else {
                    ?>
                    <img class="img-fluid" alt="Logo"
                         src="../../upload/logo/<?= $ayarlarr->site_logo ?>"
                         width="200" height="100"/>
                    <?php
                }
            } else {
                ?>
                <img class="img-fluid" alt="Logo"
                     src="../upload/logo/<?= $ayarlarr->site_logo ?>"
                     width="200" height="100"/>
                <?php
            }
        } else {
            ?>
            <img class="img-fluid" alt="Logo" src="../upload/logo/270x180/logo.jpeg" width="200" height="100"/>
            <?php
        }
        ?>
    </a>
    <!--end::Logo-->
    <!--begin::Toggle-->
    <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
              <i class="fa fa-angle-double-left"></i>
            </span>
    </button>
    <!--end::Toolbar-->
</div>

