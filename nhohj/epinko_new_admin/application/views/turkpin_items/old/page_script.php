<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<?php $this->load->view($this->viewFolder."/datatable_script.php") ?>
<script>
    $(document).ready(function() {
        $("#kt_datatable_filter").hide();
        //selectboxlar değiştiğinde olacaklar
    });
</script>

