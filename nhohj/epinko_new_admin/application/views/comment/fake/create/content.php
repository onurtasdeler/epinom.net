<form id="commentForm" action="<?= base_url("fake-comment-create") ?>" method="post">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-4 mt-5">
                                        <label>Kategori Seçiniz</label>
                                        <select class="form-control select2" id="select2" name="category_id" required>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 mt-5">
                                        <label>Puan</label>
                                        <select class="form-control" name="point" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 mt-5">
                                        <label>Başlangıç tarihi</label>
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                    <div class="col-xl-12 mt-4">
                                        <label>Yorumlar (Her satıra bir adet gelecek şekilde giriniz)</label>
                                        <textarea class="form-control" name="comments" id="" cols="30" rows="10" placeholder="Her satıra bir adet gelecek şekilde giriniz" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        ?>
                        <div>
                            <div class="d-flex justify-content-end border-top mt-5 pt-10">
                                <div>
                                    <button type="submit"
                                        class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Oluştur
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</form>