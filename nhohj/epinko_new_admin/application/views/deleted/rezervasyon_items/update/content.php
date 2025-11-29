<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <!--begin::Details-->
                        <div class="d-flex mb-9">
                            <!--begin: Pic-->
                            <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                <div class="symbol symbol-50 symbol-lg-120">
                                    <?php
                                    if($data["veri"]->image!=""){
                                        $parse=explode("/-/",$data["veri"]->image);
                                        foreach ($parse as $item) {
                                            if(file_exists("../upload/rezervasyonlar/".$item)){
                                                ?>
                                                <img src="<?=base_url("../../upload/rezervasyonlar/".$item) ?>" alt="image">
                                                <br>
                                                <?php
                                            }
                                        }
                                    }else{
                                        ?>
                                        <img src="https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png" alt="image">
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                    <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                                </div>
                            </div>
                            <!--end::Pic-->
                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <!--begin::Title-->

                                <!--begin::Content-->
                                <div class="d-flex flex-wrap justify-content-between mt-1">
                                    <div class="d-flex flex-column flex-grow-1 pr-8">
                                        <div class="d-flex flex-wrap mb-4">
                                            <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                                <div class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Randevu Tarihi</span>
                                                    <span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 font-weight-bold"><?php
                                                        echo "<span class='text-success'>".date("Y-m-d",strtotime($data["veri"]->randevutarihi))."</span>";
                                                        ?></span>
                                                </div>
                                                <div style="margin-left: 50px" class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Hizmet</span>
                                                    <span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 text-primary font-weight-bold">
                                                        <?php
                                                        $verii=getTableSingle("table_services",array("id" => $data["veri"]->hizmet_id));
                                                        echo "<span class='text-primary'>".$verii->name."</span>";
                                                        ?>

                                                    </span>
                                                </div>
                                                <div style="margin-left: 50px" class="d-flex flex-column text-dark-75">
                                                    <span class="font-weight-bolder font-size-sm">Mesaj</span>
                                                    <span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 text-primary font-weight-bold">
                                                        <?php
                                                        echo "<span class='text-info'>".$data["veri"]->mesaj."</span>";
                                                        ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Ad Soyad</th>
                                                    <th>Cinsiyet</th>
                                                    <th>Telefon</th>
                                                    <th>Ev Telefonu</th>
                                                    <th>Email</th>
                                                    <th>D.Tarihi</th>
                                                    <th>İşlem Tarihi</th>
                                                    <th>Dönüş Tipi</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?= $data["veri"]->adsoyad ?></td>
                                                    <td><?php
                                                        if($data["veri"]->cinsiyet==1){
                                                            ?>
                                                            Erkek
                                                            <?php
                                                        }else if($data["veri"]->cinsiyet==3){
                                                            ?>
                                                            LGBT
                                                            <?php
                                                        }else{
                                                            ?>
                                                            Kadın
                                                            <?php
                                                        }
                                                        ?></td>
                                                    <td><?= $data["veri"]->tel ?></td>
                                                    <td><?= $data["veri"]->telev ?></td>
                                                    <td><?= $data["veri"]->email ?></td>
                                                    <td><?= date("Y-m-d",strtotime($data["veri"]->dtarihi)) ?></td>
                                                    <td><?= date("Y-m-d",strtotime($data["veri"]->date))  ?></td>
                                                    <td><?= $data["veri"]->donus ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                        <div class="separator separator-solid"></div>
                        <!--begin::Items-->

                        <!--begin::Items-->
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</form>