<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cModalTitle">Logo Silinecektir. Emin misiniz?</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <button type="button" onclick="$('#modalForm').modal('hide')" name="vazgec" class="btn btn-dim btn-lg btn-gray">Vazgeç</button>
                    <button type="button" id="imgDeleted" class="btn btn-lg btn-danger"> <em class="icon ni ni-trash"></em>  Sil</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    createModal("Seçilenleri Sil", "Seçilen kayıyları silmek istediğinize emin misiniz?", 1, array("Sil", "default()", "btn-danger", "icon ni ni-trash","siltopluonay","baslikToplu","vazgectoplu","toplumetin"),"menu2");
    createModal("İş Emri Sil", "İş Emrini silmek istediğinize emin misiniz?", 1, array("Sil", "singleDeleted()", "btn-danger", "icon ni ni-trash","","",""),"menu");
?>