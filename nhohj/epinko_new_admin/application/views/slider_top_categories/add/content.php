<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <br>

    <div class="d-flex flex-column-fluid">

        <div class="container">

            <div class="card card-custom">

                <?php $this->load->view("includes/page_inner_header_card") ?>

                <div class="card-body">
                    <!--begin: Datatable-->

                    <div class="row">

                        <div class="col-xl-12 col-xxl-12">

                            <!--begin::Wizard Form-->

                            <form class="form" method="post" enctype="multipart/form-data">
                                <!--begin::Wizard Step 1-->

                                <div class="row">

                                    <div class="col-xl-12">

                                        <div class="form-group row">

                                            <div class="col-xl-12">

                                                <div class="form-group">

                                                    <label>Kategoriler</label>

                                                    <select class="form-control" required name="category_id" id="">

                                                        <option value="">Seçiniz</option>
                                                        <?php foreach($data["categories"] as $item): ?>
                                                            <option value="<?= $item->id ?>"><?= $item->c_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                </div>

                                <div class="d-flex justify-content-between border-top mt-5 pt-10">

                                    <div class="mr-2">

                                    </div>

                                    <div>

                                        <a href="<?= base_url($this->baseLink) ?>" type="button"

                                           class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"

                                        >Vazgeç

                                        </a>

                                        <button type="submit"

                                                class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"

                                        >Kaydet

                                        </button>

                                    </div>

                                </div>

                                <!--end::Wizard Actions-->

                            </form>

                            <!--end::Wizard Form-->

                        </div>

                    </div>

                    <!--end::Wizard Body-->

                </div>

            </div>



        </div>

    </div>

</div>