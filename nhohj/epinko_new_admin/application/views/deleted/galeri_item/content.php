<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <?php $this->load->view($this->viewFolderSafe . "/sub_header") ?>
    <!--end::Subheader-->

    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid" style="margin-top: 15px">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Notice-->
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) " />
                                    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span> &nbsp;
                        <h3 class="card-label">Galeri</h3>
                    </div>

                </div>
                <div class="card-body">
                <a href="<?= base_url("galeri-add") ?>"  class="btn btn-primary mb-2">Yeni Galeri</a>
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>Sıra No</th>
                            <th>Galeri Resim</th>
                            <th>Galeri Seo ALT</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cek=getTableOrder("bk_opt_s_galeri",array(),"order_id","asc");
                            if($cek){
                                foreach ($cek as $item) {
                                    ?>
                                        <tr>
                                            <td><?= $item->order_id ?></td>
                                            <?php $url=str_replace("admin/","",base_url("")) ?>
                                            <td><img width="150" height="150" src="<?= $url."upload/galeri/1200x400/".$item->menu_img ?>" alt=""></td>
                                            <td><?= $item->menu_name ?></td>


                                            <td>
                                                <a href="<?= base_url('galeri-update/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Update">
                                                    <i class="la la-pencil text-warning"></i>
                                                </a><a  class="btn btn-sm btn-clean btn-icon " onclick="categoryDelete(<?= $item->id ?>)"  data-toggle="modal" data-id="<?= $item->id ?>"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="modal" id="menu">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Galeri Sil</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center text-dark">
                                        <strong id="makaleId"></strong>
                                        <input type="hidden" id="silinecek">
                                    </p>
                                    <p class="text-center text-dark">
                                        Emin misiniz ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning light" data-dismiss="modal">Back</button>
                                    <a class="btn btn-danger light menu_sil" onclick="category_delete()"> <i class="fa fa-trash"></i>Delete</a>
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
</div>