<?php

if (getActiveUsers()) {

    $user = getActiveUsers();

    $dogrulama = getLangValue(42, "table_pages");

    $uniql = getLangValue($uniq->id, "table_pages");

    $uniql2 = getLangValue(96, "table_pages");
} else {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));
}





$text = "";

$r = getTableSingle("table_onay_kisit", array("id" => 1))->ilan_olusturma;

$r = explode("-", $r);

if ($r[0] == 1 && $r[1] == 1 && $r[2] == 1) {

    if ($user->tel_onay == 1 && $user->email_onay == 1 && $user->tc_onay == 1) {

        $goster = 1;
    } else {

        $gosterme = 2;

        $text = langS(37, 2) . ", E-mail, " . langS(36, 2);
    }
} else if ($r[0] == 0 && $r[1] == 1 && $r[2] == 1) {

    if ($user->email_onay == 1 && $user->tc_onay == 1) {

        $goster = 1;
    } else {

        if ($user->email_onay == 1) {
        } else {

            $text .= "E-mail ";
        }



        if ($user->tc_onay == 0) {

            $text .= "TC Kimlik No ";
        } else {
        }



        $gosterme = 2;
    }
} else if ($r[0] == 0 && $r[1] == 0 && $r[2] == 1) {

    if ($user->tc_onay == 1) {

        $goster = 1;
    } else {

        $gosterme = 2;

        $text = langS(36, 2);
    }
} else if ($r[0] == 0 && $r[1] == 1 && $r[2] == 0) {

    if ($user->email_onay == 1) {

        $goster = 1;
    } else {

        $gosterme = 2;

        $text = "E-mail";
    }
} else if ($r[0] == 1 && $r[1] == 0 && $r[2] == 0) {

    if ($user->tel_onay == 1) {

        $goster = 1;
    } else {

        $gosterme = 2;

        $text = langS(37, 2);
    }
} else if ($r[0] == 1 && $r[1] == 0 && $r[2] == 1) {

    if ($user->tel_onay == 1 && $user->tc_onay == 1) {

        $goster = 1;
    } else {

        $gosterme = 2;

        $text = langS(37, 2) . ", " . langS(36, 2);
    }
} else if ($r[0] == 1 && $r[1] == 1 && $r[2] == 0) {

    if ($user->tel_onay == 1 && $user->email_onay == 1) {

        $goster = 1;
    } else {

        $gosterme = 2;

        $text = langS(37, 2) . ", E-mail";
    }
} else if ($r[0] == 0 && $r[1] == 0 && $r[2] == 0) {

    $goster = 1;
}

if ($goster == 1) {

?>

    <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">

        <!-- start personal information -->

        <div class="nuron-information">

            <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

                <div class="col-12 d-flex justify-content-between mb--20 align-items-center">

                    <h4 class="title-left"><i class="fa fa-cog"></i> <?= $uniql->titleh1 ?></h4>

                </div>

                <div class="col-lg-12">

                    <hr>

                </div>

            </div>

            <div class="profile-change row g-5">



                <div class="col-lg-12 ">



                    <div class="row ">

                        <?php

                        if ($user->is_magaza == 1) {

                        ?>

                            <form action="" method="post" class="mt-1" onsubmit="return false" id="ilanCreateForm"

                                enctype="multipart/form-data">
                                
                                <input type="hidden" id="selected_default_image" name="selected_default_image" value="0">

                                <div class="row mb-4 d">

                                    <div class="col-lg-12  deleted mb-4">

                                        <h6 class="title" style="font-size: 14px">

                                            <i class="fa fa-arrow-right"></i> <?= langS(96) ?>

                                        </h6>



                                        <div class="wrappers">

                                            <input type="radio" name="" id="option-1" checked>

                                            <input type="radio" name="" id="option-2">

                                            <label for="option-1" class="option option-1">

                                                <div class="dot"></div>

                                                <span style="margin-left: 10px"><?= langS(97) ?></span>

                                            </label>

                                            <label onclick="window.location.href='<?= base_url(gg() . $uniql2->link) ?>'" for="option-2" class="option option-2">

                                                <div class="dot"></div>

                                                <a href="<?= base_url(gg() . $uniql2->link) ?>" style="margin-left: 10px"><?= langS(98) ?></a>

                                            </label>

                                        </div>

                                    </div>



                                    <div class="col-lg-12 deleted">

                                        <hr>

                                        <h6 class="title" style="font-size: 14px">

                                            <i class="fa fa-arrow-right"></i> <?= langS(99) ?>

                                        </h6>

                                    </div>

                                    <div class="col-lg-12  deleted">

                                        <div class="row">

                                            <div class="col-lg-4 marginCustom" style="position:relative;">

                                                <select onchange="getCategoryDefaultImages(event);" class="form-control selects" id="mainCategory" name="mainCat" required data-msg="<?= langS(8, 2) ?>" style="">

                                                    <option selected="" value=""><?= langS(86) ?></option>

                                                    <?php

                                                    $c = getTableOrder("table_advert_category", array("status" => 1, "top_id" => 0, "parent_id" => 0, "category_type" => 0), "order_id", "asc");

                                                    if ($c) {

                                                        foreach ($c as $iterm) {

                                                            $ll = getLangValue($iterm->id, "table_advert_category");

                                                    ?>

                                                            <option value="<?= $iterm->id ?>"><?= $iterm->name . " (Komisyon: %" . $iterm->commission_stoksuz . ") " ?></option>

                                                    <?php

                                                        }
                                                    }

                                                    ?>



                                                </select>

                                            </div>

                                            <div class="col-lg-4 marginCustom" id="topCategoryCont" style="display: none; position:relative;">

                                                <select onchange="getCategoryDefaultImages(event);" class="form-control selects" id="topCategory" required name="topCategory" data-msg="<?= langS(8, 2) ?>" style="width: 100% !important;">

                                                    <option selected=""><?= langS(86) ?></option>

                                                </select>

                                            </div>

                                            <div class="col-lg-4 mb-4 marginCustom" id="subCategoryCont" style="display: none; position:relative;">

                                                <select onchange="getCategoryDefaultImages(event);" class="form-control selects" id="subCategory" required name="subCategory" data-msg="<?= langS(8, 2) ?>" style="width: 100%">

                                                    <option selected=""><?= langS(86) ?></option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="col-lg-12 mt-5 deleted" style="margin-top: 5rem !important;">

                                        <hr>

                                        <h6 class="title" style="font-size: 14px">

                                            <i class="fa fa-arrow-right"></i> <?= langS(100) ?>

                                            <p class="mt-2 " style="font-size:12px"><?= langS(81)  ?></p>

                                        </h6>

                                    </div>



                                    <div class="col-md-12 deleted">

                                        <div class="row">

                                            <div class="col-lg-6">

                                                <div class="col-lg-12">

                                                    <div class="input-box pb--20">

                                                        <label for="nametr" class="form-label"><?= langS(79) ?> (TR)</label>

                                                        <input type="text" name="nametr" id="nametr" required data-msg="<?= langS(8, 2) ?>"

                                                            placeholder="<?= langS(79) ?> (TR)">

                                                    </div>

                                                </div>

                                                <div class="col-lg-12">

                                                    <div class="input-box pb--20">

                                                        <label for="icerik_tr" class="form-label"><?= langS(80) ?> (TR)</label>

                                                        <textarea id="icerik_tr" name="icerik_tr"></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="col-lg-12">

                                                    <div class="input-box pb--20">

                                                        <label for="nameen" class="form-label"><?= langS(79) ?> (EN)</label>

                                                        <input type="text" name="nameen" id="nameen"

                                                            placeholder="<?= langS(79) ?> (EN)">

                                                    </div>

                                                </div>

                                                <div class="col-lg-12">

                                                    <div class="input-box pb--20">

                                                        <label for="icerik_en" class="form-label"><?= langS(80) ?> (EN)</label>

                                                        <textarea id="icerik_en" name="icerik_en"></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-12 mb-4 pb-4 deleted">

                                        <div class="row" id="speTitle" style="display: none">

                                            <div class="col-lg-12 mt-5">

                                                <hr>

                                                <h6 class="title" style="font-size: 14px">

                                                    <i class="fa fa-arrow-right"></i> <?= langS(82) ?>



                                                </h6>

                                            </div>

                                        </div>

                                        <div class="row" id="speCont" style="display: none">



                                        </div>

                                    </div>

                                    <div class="col-lg-12 mt-5 deleted">
                                        <hr>
                                        <h6 class="title" style="font-size: 14px">
                                            <i class="fa fa-arrow-right"></i> <?= ($_SESSION["lang"] == 1) ? "Özel Alan Bilgileri ( Müşteri Tarafından Talep Edilen Bilgiler Örn : Kullanıcı Adı, Discord Nick'i vb. )" : "Custom Field Information" ?>
                                        </h6>
                                    </div>

                                    <div class="col-md-12 column deleted">
                                        <table class="table table-bordered table-hover" id="tab_logic_special">
                                            <thead>
                                                <tr>

                                                    <th width="80%" class="text-center">
                                                        <?= ($_SESSION["lang"] == 1) ? "Özel Alan Adı" : "Custom Field Name" ?>
                                                    </th>
                                                    <th width="10%" class="text-center">
                                                        <?= ($_SESSION["lang"] == 1) ? "Ekle" : "Add" ?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="addSpecialFieldTable">
                                                <tr id='addr0' style="vertical-align: middle !important">

                                                    <td>
                                                        <div class="input-box ">
                                                            <input type="text" name="" id="special_field"
                                                                placeholder="<?= ($_SESSION["lang"] == 1) ? "Özel Alan Adı" : "Custom Field Name" ?>" onkeypress="if(event.key === 'Enter') { event.preventDefault();document.getElementById('add_row_special').click(); }">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a id="add_row_special" class="btn-block w-100 btn text-black btn-warning btn"
                                                            style="color: black"><i class="fa fa-plus"></i></a>
                                                        <!--<a id='delete_row' class="btn btn-warning btn ">Delete Row</a>-->
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-12 mt-5 deleted">

                                        <hr>

                                        <h6 class="title" style="font-size: 14px">

                                            <i class="fa fa-arrow-right"></i> <?= langS(83) ?> <small class="text-warning"><?= langS(185) ?></small>

                                        </h6>

                                    </div>

                                    <div class="col-lg-3 mt-4 deleted">

                                        <div class="col-lg-12">

                                            <div class="input-box pb--20">

                                                <label for="price" class="form-label"><?= langS(84) ?> (<?= getcur() ?>) </label>

                                                <input disabled type="number" name="price" id="price" min="0" step="0.1" data-msg="<?= langS(8, 2) ?>" required

                                                    placeholder="<?= langS(84) ?> ">

                                                <label for="" class="error"></label>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-3 col-12 mt-4 deleted">

                                        <div class="col-lg-12">

                                            <div class="input-box pb--20">

                                                <label for="times" class="form-label"><?= langS(85) ?></label>

                                                <select name="times" required data-msg="<?= langS(8, 2) ?>" class="selectss" id="times">

                                                    <option value=""><?= langS(86) ?></option>

                                                    <?php

                                                    $cek = getTableOrder("table_adverts_delivery_time", array("status" => 1), "order_id", "asc");

                                                    if ($cek) {

                                                        foreach ($cek as $iterm) {

                                                            $ll = getLangValue($iterm->id, "table_adverts_delivery_time");



                                                    ?>

                                                            <option value="<?= $iterm->id ?>"><?= $ll->name ?></option>

                                                    <?php

                                                        }
                                                    }

                                                    ?>

                                                </select>

                                            </div>

                                        </div>



                                    </div>

                                    <div class="col-lg-3 col-12 mt-4 deleted">

                                        <div class="col-lg-12">

                                            <div class="input-box pb--20">

                                                <label for="times" class="form-label"><?= langS(391, 2) ?></label>

                                                <input type="number" name="stock" id="stock" min="0" step="1" data-msg="<?= langS(8, 2) ?>" required

                                                    placeholder="<?= langS(391, 2) ?>">

                                            </div>

                                        </div>



                                    </div>

                                    <?php

                                    if ($user->magaza_ozel_komisyon != 0) {

                                    ?>

                                        <div class="col-lg-12 mb-3 mt-3 deleted">

                                            <span class="text-info">

                                                <i class="fa fa-info" style=""></i> <?= str_replace("[k]", "<b>" . $user->magaza_ozel_komisyon . "</b>", langS(90, 2)) ?>

                                            </span>



                                        </div>

                                    <?php

                                    }

                                    ?>



                                    <div class="col-lg-12 deleted mt-3">

                                        <div class="row">

                                            <div class="col-lg-3 col-12">

                                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">

                                                    <div class="inner">

                                                        <div class="content">

                                                            <div class="row">

                                                                <div class="col-lg-3 col-4">

                                                                    <img style="padding-right: 10px;"

                                                                        width="100%" src="<?= b() . "/assets/img/tag.png" ?>" alt="">

                                                                </div>

                                                                <div class="col-lg-9 col-8">

                                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">

                                                                        <?= langS(92)  ?></a></h4>

                                                                    <p class="description" id="unitprice">-</p>

                                                                </div>

                                                            </div>



                                                        </div>

                                                    </div>



                                                </div>

                                            </div>

                                            <div class="col-lg-3 col-12">

                                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">

                                                    <div class="inner">

                                                        <div class="content">

                                                            <div class="row">

                                                                <div class="col-lg-3 col-4">

                                                                    <img style="padding-right: 10px;"

                                                                        width="100%" src="<?= b() . "/assets/img/pricing.png" ?>" alt="">

                                                                </div>

                                                                <div class="col-lg-9 col-8">

                                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">

                                                                        <?= langS(93) ?></a></h4>

                                                                    <p class="description" id="komOran">

                                                                        <?= ($user->magaza_ozel_komisyon != 0) ? "%" . $user->magaza_ozel_komisyon . " <small class='text-warning'>(" . langS(91, 2) . ")</small>" : "-" ?>

                                                                    </p>

                                                                </div>

                                                            </div>





                                                        </div>

                                                    </div>



                                                </div>

                                            </div>

                                            <div class="col-lg-3 col-12">

                                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">

                                                    <div class="inner">

                                                        <div class="content">

                                                            <div class="row">

                                                                <div class="col-lg-3 col-4 ">

                                                                    <img style="padding-right: 10px;"

                                                                        width="100%" src="<?= b() . "/assets/img/commission.png" ?>" alt="">

                                                                </div>

                                                                <div class="col-lg-9 col-8 ">

                                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">

                                                                        <?= langS(94) ?></a></h4>

                                                                    <p class="description" id="komamount">-</p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>



                                                </div>

                                            </div>

                                            <div class="col-lg-3 col-12">

                                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">

                                                    <div class="inner">

                                                        <div class="content">

                                                            <div class="row">

                                                                <div class="col-lg-3 col-4">

                                                                    <img style="padding-right: 10px;"

                                                                        width="100%" src="<?= b() . "/assets/img/money.png" ?>" alt="">

                                                                </div>

                                                                <div class="col-lg-9 col-8">

                                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">

                                                                        <?= langS(95) ?></a></h4>

                                                                    <p class="description" id="cash">-</p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>



                                                </div>

                                            </div>



                                        </div>

                                    </div>

                                    <div class="col-lg-12 mt-5 deleted mb-5">

                                        <hr>

                                        <h6 class="title" style="font-size: 14px; margin-bottom:5px;">

                                            <i class="fa fa-arrow-right"></i> Hazır Resimler

                                        </h6>

                                        <small>Hazır resimlerden ilanınız ile ilgili genel bir resim seçebilir veya resim ekle alanından resim yükleyebilirsiniz.</small>

                                    </div>

                                    <div id="default_image_list" class="row deleted">
                                        <small>Lütfen kategori seçin</small>
                                    </div>

                                    <div class="col-lg-12 mt-5 deleted">

                                        <hr>

                                        <h6 class="title" style="font-size: 14px">

                                            <i class="fa fa-arrow-right"></i> <?= langS(87) ?>

                                        </h6>

                                    </div>

                                    <div class="row deleted">

                                        <div class="col-md-4">

                                            <div class="profile-left col-lg-12">

                                                <div class="profile-image mb--30">

                                                    <h6 class="title"><?= langS(78) ?> 1<br>

                                                        <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>

                                                    </h6>

                                                    <img id="rbtinput1"

                                                        src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"

                                                        alt="">

                                                </div>

                                                <div class="button-area">

                                                    <div class="brows-file-wrapper">

                                                        <!-- actual upload which is hidden -->

                                                        <input name="fatima" id="fatima" type="file" accept="image/png, image/jpeg, image/jpg">

                                                        <!-- our custom upload button -->

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="row">

                                                <div class="profile-left col-lg-12">

                                                    <div class="profile-image mb--30">

                                                        <h6 class="title"><?= langS(78) ?> 2<br>

                                                            <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>

                                                        </h6>

                                                        <img id="rbtinput2"

                                                            src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"

                                                            alt="">

                                                    </div>

                                                    <div class="button-area">

                                                        <div class="brows-file-wrapper">

                                                            <!-- actual upload which is hidden -->

                                                            <input name="fatima2" id="nipa" type="file" accept="image/png, image/jpeg, image/jpg">

                                                            <!-- our custom upload button -->

                                                        </div>

                                                    </div>

                                                </div>



                                            </div>

                                            <input type="hidden" name="lang" value="<?= $_SESSION["lang"] ?>">

                                        </div>

                                        <div class="col-md-4">

                                            <div class="row">

                                                <div class="profile-left col-lg-12">

                                                    <div class="profile-image mb--30">

                                                        <h6 class="title"><?= langS(78) ?> 2<br>

                                                            <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>

                                                        </h6>

                                                        <img id="rbtinput3"

                                                            src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"

                                                            alt="">

                                                    </div>

                                                    <div class="button-area">

                                                        <div class="brows-file-wrapper">

                                                            <!-- actual upload which is hidden -->

                                                            <input name="fatima3" id="nipa2" type="file" accept="image/png, image/jpeg, image/jpg">

                                                            <!-- our custom upload button -->

                                                        </div>

                                                    </div>

                                                </div>



                                            </div>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="form-group">

                                                <input type="checkbox" id="html" name="sozlesme">

                                                <label for="html">

                                                    <?php

                                                    $lang = $this->db->get_where("table_langs", array("id" => $_SESSION["lang"]))->row();

                                                    $advertPage = $this->db->get_where("table_pages", array("name" => 'İlan Sözleşmesi'))->row();



                                                    if ($lang->name_short == "TR") {

                                                        echo str_replace("[l]", "<a class='text-info' href='/page/" . $advertPage->seflink_tr . "' target='_blank'>", str_replace("[lk]", "</a>", langS(88, 2)));
                                                    } else {

                                                        echo str_replace("[l]", "<a class='text-info' href='/page/" . $advertPage->seflink_en . "' target='_blank'>", str_replace("[lk]", "</a>", langS(88, 2)));
                                                    }

                                                    ?>

                                                </label>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12" id="uyCont" style="display:none;">

                                    <div class="alert alert-danger"></div>

                                </div>

                                <div class="col-md-12">

                                    <div class="input-box">

                                        <button class="btn btn-info btn-large w-100"

                                            id="submitButton"><?= langS(89) ?></button>

                                    </div>

                                </div>

                            </form>

                        <?php

                        } else {

                            redirect(base_url(gg()));
                        }

                        ?>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <?php $this->load->view("user/profile/ilan_create/page_style")  ?>

<?php

} else {

?>

    <div class="row g mb--50 mb_md--30 mb_sm--30 align-items-center">

        <div class="col-lg-12 sal-animate" data-sal="slide-up" data-sal-delay="150" data-sal-duration="800">

            <hr class="m-0">

            <div class="row">

                <div class="col-lg-12">

                    <div class="alert alert-info mt-4    ">İlan Oluşturma için <?= $text ?> Doğrulamasını tamamlamanız gerekmektedir. <br>



                        <?= str_replace("{lk}", "</a>", str_replace("{l}", "<a class='text-info' href='" . base_url(gg() . $dogrulama->link) . "'>", langS(39, 2))) ?>



                    </div>

                </div>

            </div>





        </div>



    </div>



<?php

}







?>





<!-- sigle tab content -->