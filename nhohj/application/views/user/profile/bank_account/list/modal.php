<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog custModal  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= langS(206) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <?php
                    if(getActiveUsers()){
                        $bank=getTable("table_user_bank",array("user_id" => getActiveUsers()->id,"deleted" => 0));
                        if($bank){
                            if(count($bank)>=5){
                                $goster=2;
                            }else{
                                $goster=1;
                            }
                        }else{
                            $goster=1;
                        }
                    }
                    if($goster==1){
                        ?>
                        <form action="" method="post" id="supportForm" onsubmit="return false " enctype="multipart/form-data">

                            <div class="row box-table p-5" >
                                <div class="col-lg-12 " >
                                    <div class="row nuron-information">
                                        <div class="col-md-6 deleted" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(210) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="banka_adi" id="banka_adi"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(210) ?>">
                                            </div>
                                            <input type="hidden" name="lang" value="<?= $_SESSION["lang"] ?>">
                                        </div>
                                        <div class="col-md-6 deleted" >
                                            <div class="input-box " >
                                                <label for="name" class="form-label"><?= langS(207) ?> <small class="text-danger">*</small></label>
                                            </div>
                                            <select class="form-control selects" id="mainCategory" name="mainCat" required data-msg="<?= langS(8,2) ?>" style="width:100%">
                                                <option selected value="1"><?= langS(204) ?></option>
                                                <option value="2"><?= langS(205) ?></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mt-5 deleted" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(209) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="iban" id="iban"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(209) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 deleted" id="sahipCont" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(208) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="bank_account" id="bank_account"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(208) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4" id="uyCont" style="display:none;">
                                            <div class="alert alert-danger"></div>
                                        </div>

                                        <div class="input-box mt-4" >
                                            <button type="submit" class="btn btn-info btn-large w-100" id="submitButton"><?= langS(206) ?></button>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </form>

                        <?php
                    }else{
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning"><?= langS(211) ?></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="editModal" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog custModal  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= langS(213) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <?php
                   $goster=1;
                    if($goster==1){
                        ?>
                        <form action="" method="post" id="editForm" onsubmit="return false " enctype="multipart/form-data">

                            <div class="row box-table p-5" >
                                <div class="col-lg-12 " >
                                    <div class="row nuron-information">
                                        <input type="hidden" name="sToken" id="sToken" value="">
                                        <div class="col-md-6 deleted" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(210) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="banka_adi" id="m_banka_adi"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(210) ?>">
                                            </div>
                                            <input type="hidden" name="lang" value="<?= $_SESSION["lang"] ?>">
                                        </div>
                                        <div class="col-md-6 deleted" >
                                            <div class="input-box " >
                                                <label for="name" class="form-label"><?= langS(207) ?> <small class="text-danger">*</small></label>
                                            </div>
                                            <select class="form-control selects" id="m_mainCategory" name="mainCat" required data-msg="<?= langS(8,2) ?>" style="width:100%">
                                                <option selected value="1"><?= langS(204) ?></option>
                                                <option value="2"><?= langS(205) ?></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 deleted" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(209) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="iban" id="m_iban"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(209) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 deleted" id="sahipCont" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(208) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="bank_account" id="m_bank_account"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(208) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4" id="m_uyCont" style="display:none;">
                                            <div class="alert alert-danger"></div>
                                        </div>

                                        <div class="input-box mt-4" >
                                            <button type="submit" class="btn btn-info btn-large w-100" id="m_submitButton"><?= langS(213) ?></button>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </form>

                        <?php
                    }else{
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning"><?= langS(211) ?></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="deleteModal" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog   modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="text-danger fa fa-trash"></i> <?= langS(218) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <div class="row">
                        <div class="col-lg-12 deleted">
                            <b id="bankDelete"></b>
                        </div>
                        <div class="col-lg-12" id="uy" style="display: none">
                            <div class="alert">

                            </div>
                        </div>
                        <div class="col-lg-6 deleted">
                            <div class="input-box mt-4" >
                                <button type="button" onclick="$('#deleteModal').modal('hide')" class="btn btn-warning btn-small w-100" id="vazgec"><?= ($_SESSION["lang"]==1)?"Vazgeç":"Cancel" ?></button>
                            </div>

                        </div>
                        <input type="hidden" name="ssToken" id="ssToken">

                        <div class="col-lg-6 deleted">
                            <div class="input-box mt-4" >
                                <button type="button"  class="btn btn-danger btn-small w-100" id="deleteButton"><i class="fa fa-trash"></i> <?= ($_SESSION["lang"]==1)?"Sil":"Delete" ?></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal2" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog custModal  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= langS(206) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <?php
                    if(getActiveUsers()){
                        $bank=getTable("table_user_bank",array("user_id" => getActiveUsers()->id,"deleted" => 0));
                        if($bank){
                            if(count($bank)>=3){
                                $goster=2;
                            }else{
                                $goster=1;
                            }
                        }else{
                            $goster=1;
                        }
                    }
                    if($goster==1){
                        ?>
                        <form action="" method="post" id="supportForm" onsubmit="return false " enctype="multipart/form-data">

                            <div class="row box-table p-5" >
                                <div class="col-lg-12 " >
                                    <div class="row nuron-information">
                                        <div class="col-md-6 deleted" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(210) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="banka_adi" id="banka_adi"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(210) ?>">
                                            </div>
                                            <input type="hidden" name="lang" value="<?= $_SESSION["lang"] ?>">
                                        </div>
                                        <div class="col-md-6 deleted" >
                                            <div class="input-box " >
                                                <label for="name" class="form-label"><?= langS(207) ?> <small class="text-danger">*</small></label>
                                            </div>
                                            <select class="form-control selects" id="mainCategory" name="mainCat" required data-msg="<?= langS(8,2) ?>" style="width:100%">
                                                <option selected value="1"><?= langS(204) ?></option>
                                                <option value="2"><?= langS(205) ?></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 deleted" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(209) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="iban" id="iban"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(209) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 deleted" id="sahipCont" >
                                            <div class="input-box pb--20" >
                                                <label for="name" class="form-label"><?= langS(208) ?> <small class="text-danger">*</small></label>
                                                <input type="text" name="bank_account" id="bank_account"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(208) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4" id="uyCont" style="display:none;">
                                            <div class="alert alert-danger"></div>
                                        </div>

                                        <div class="input-box mt-4" >
                                            <button type="submit" class="btn btn-info btn-large w-100" id="submitButton"><?= langS(206) ?></button>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </form>

                        <?php
                    }else{
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning"><?= langS(211) ?></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
