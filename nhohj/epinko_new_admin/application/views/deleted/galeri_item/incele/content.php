<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <br>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Notice-->
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="fa fa-list"></i>
                        </span>
                        <h3 class="card-label"><strong><?= $items->adi ?></strong></h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="settings-form">
                                                            <?php
                                                            if (isset($error)) {
                                                                if ($error == 1) {
                                                            ?>
                                                                    <div class="alert alert-custom alert-notice alert-success fade show mb-5" role="alert" id="form_return">
                                                                        <div class="alert-icon">
                                                                            <i class="flaticon-warning"></i>
                                                                        </div>
                                                                        <div class="alert-text">Erfolgreich</div>
                                                                        <div class="alert-close">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                <span aria-hidden="true">
                                                                                    <i class="ki ki-close"></i>
                                                                                </span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                } else if ($error == 2) {
                                                                ?>
                                                                    <div class="alert alert-custom alert-notice alert-danger fade show mb-5" role="alert" id="form_return">
                                                                        <div class="alert-icon">
                                                                            <i class="flaticon-warning"></i>
                                                                        </div>
                                                                        <div class="alert-text">Fehler</div>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seitenname</strong></label>
                                                                    <input type="text" name="adi" value="<?= $items->adi ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Verknüpfung</strong></label>
                                                                    <input type="text" name="link" required="required" class="form-control" value="<?= $items->link ?>" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Suchmaschine</strong></label>
                                                                    <select name="noindexx" class="form-control" placeholder="Seçiniz">
                                                                        <?php
                                                                        if ($items->noindexx == 0) {
                                                                        ?>
                                                                            <option selected value="0">Index</optionselected>
                                                                            <option value="1">No Index</option>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <option value="0">Index</optionselected>
                                                                            <option selected value="1">No Index</option>
                                                                        <?php
                                                                        }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seitentitel H1</strong></label>
                                                                    <input type="text" name="baslikh1" value="<?= $items->baslikh1 ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seitentitel H2</strong></label>
                                                                    <input type="text" name="baslikh2" value="<?= $items->baslikh2 ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seitenbeschreibung</strong></label>
                                                                    <input type="text" name="aciklama" value="<?= $items->aciklama ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Title</strong></label>
                                                                    <input type="text" name="title" value="<?= $items->title ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Desc</strong></label>
                                                                    <input type="text" name="descc" value="<?= $items->descc ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Keyw</strong></label>
                                                                    <input type="text" name="keyw" value="<?= $items->keyw ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-1">
                                                                <label class="imagecheck mb-12">
                                                                    <figure class="imagecheck-figure">
                                                                        <?php
                                                                        if ($items->one_cikmis_gorsel != "") {
                                                                        ?>
                                                                            <img class="imagecheck-image hoverZoomLink" src="<?= "../../upload/pages/" . $items->img_width . "x" . $items->img_height . "/" . $items->one_cikmis_gorsel . ".webp"; ?>" style="width: 65px;">
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </figure>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Hauptbild(<?= $items->img_width ?>px x <?= $items->img_height ?>px oranında)</label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="file" class="custom-file-input" id="gorsel">
                                                                    <label class="custom-file-label">Datei aussuchen</label>
                                                                </div>
                                                                <small class="text-info" style="font-size: 100%">gif | jpg | png | jpeg | webp | svg</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-xl-12 mtop5">
                                                                <label><strong>Hauptbild SEO ALT</strong></label>
                                                                <input type="text" name="imgAlt" value="<?= $items->imgAlt ?>" required="required" class="form-control" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-xl-12 mtop5">
                                                                <label><strong>Inhalt (Bilder können in diesem Bereich nicht hochgeladen werden)</strong></label>
                                                                <textarea name="icerik" id="editor" rows="100"><?= $items->icerik ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <input type="hidden" name="tur" value="1">
                                                        <button type="submit" class="btn btn-primary light btn-xs"><i class="fa fa-check"></i>
                                                            Aktualisieren
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
    <br>

</div>