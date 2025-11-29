<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <h5>Firma Bilgileri</h5>

                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            if($data["hata"]){
                                if($data["hata"]=="var"){
                                    ?>
                                    <div class="alert alert-danger">
                                        Bilgiler güncellenirken hata meydana geldi.
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="alert alert-success">
                                        Bilgiler başarılı şekilde güncellendi.
                                    </div>
                                    <?php
                                }

                            }else{

                            }
                            ?>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="row d-flex justify-content-start m-2">
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-5">
                                                    <label for="firmaLogosu">Firma Logosu</label>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group mt-2">
                                                        <div class="form-control-wrap">
                                                            <div class="form-file" >
                                                                <input name="logo" type="file" class="form-file-input" id="customFile">
                                                                <label class="form-file-label" for="customFile">Firma Logosu</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 text-center mt-2">
                                                    <?php
                                                    if($data["v"]->site_logo!=""){
                                                        ?>
                                                        <img width="200" height="200" src="<?= "../upload/logo/".$data["v"]->site_logo ?>" alt="">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 ">
                            <div class="row m-2">

                                <div class="col-12 bg-white">
                                    <div class="row p-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="firmaUnvani">Firma Unvanı</label>
                                                    <input type="text" class="form-control" id="firmaUnvani" value="<?= $data["v"]->firma_unvan ?>" name="firmaUnvani" placeholder="Örnek: ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="firmaAdresi">Firma Adresi</label>
                                                    <input type="text" class="form-control" id="firmaAdresi" value="<?= $data["v"]->firma_adres ?>"  name="firmaAdresi" placeholder="Örnek: ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="firmaAdresi">Firma İl</label>
                                                    <input type="text" class="form-control" id="firmaAdresi" value="<?= $data["v"]->il ?>"  name="il" placeholder=" ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="firmaAdresi">Firma İlçe</label>
                                                    <input type="text" class="form-control" id="firmaAdresi" value="<?= $data["v"]->ilce ?>"  name="ilce" placeholder=" ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="firmaTel">Firma Telefon</label>
                                                    <input type="text" class="form-control phone" id="firmaTel" name="firmaTel" value="<?= $data["v"]->tel ?>"   placeholder="Örnek: ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="firmaEposta">Firma E-posta</label>
                                                    <input type="text" class="form-control" id="firmaEposta" name="firmaEposta" value="<?= $data["v"]->eposta ?>"   placeholder="Örnek: ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="vergiDairesi">Vergi Dairesi</label>
                                                    <input type="text" class="form-control" id="vergiDairesi" name="vergiDairesi" value="<?= $data["v"]->vdaire ?>"  placeholder="Örnek: ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for="vergiNo">Vergi No</label>
                                                    <input type="text" class="form-control" id="vergiNo" name="vergiNo" value="<?= $data["v"]->vno ?>"  placeholder="Örnek: ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-12">
                                            <div class="form-control-wrap">
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <button type="submit" name="" class="btn btn-success d-flex justify-content-center btn-block">Bilgileri Güncelle</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    </form>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>