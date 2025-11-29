<script>
    $("[tags-input]").select2({
        tags: true,
        tokenSeparators: [','],
        maximumSelectionLength: 20,
        maximumInputLength: 20
    });

    let dataBefore = [];

    $("[tags-input]").on('select2:open', function () {
        dataBefore = $("[tags-input]").select2('data').map(item => item.id);
    });

    $("[tags-input]").on('select2:select', function (e) {
        const selectedItems = $("[tags-input]").select2('data').length;
        if (selectedItems > 20) {
            $("[tags-input]").val(dataBefore).trigger('change');
            alert('En fazla 20 seçim yapabilirsiniz!');
        }
    });

    $("[tags-input]").on('select2:unselect', function () {
        dataBefore = $("[tags-input]").select2('data').map(item => item.id);
    });
</script>

<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    $(document).ready(function() {
        $("#dateRange").daterangepicker({
            locale: {
                format: 'DD.MM.YYYY'
            }
        }, function(start, end, label) {
            getReport(start.format("YYYY-MM-DD"),end.format("YYYY-MM-DD"));
        });
    });
    
    function getReport(start,end) {
        $.get("<?= base_url('gelir-gider-kar') ?>?startDate="+start+"&endDate="+end,undefined,function(response){
            response = JSON.parse(response);
            $("#manuelOutcome").text(response.manualOutcome + " <?= getcur(); ?>");
            $("#manuelIncome").text(response.manualIncome + " <?= getcur(); ?>");
            $("#manuelEarning").text(response.manualEarning + " <?= getcur(); ?>");
            $("#epinOutcome").text(response.epinOutcome + " <?= getcur(); ?>");
            $("#epinIncome").text(response.epinIncome + " <?= getcur(); ?>");
            $("#epinEarning").text(response.epinEarning + " <?= getcur(); ?>");
            $("#advertOutcome").text(response.advertOutcome + " <?= getcur(); ?>");
            $("#advertIncome").text(response.advertIncome + " <?= getcur(); ?>");
            $("#advertEarning").text(response.advertEarning + " <?= getcur(); ?>");
            $("#bayiOutcome").text(response.bayiOutcome + " <?= getcur(); ?>");
            $("#bayiIncome").text(response.bayiIncome + " <?= getcur(); ?>");
            $("#bayiEarning").text(response.bayiEarning + " <?= getcur(); ?>");
            $("#totalEarning").text(response.totalEarning + " <?= getcur(); ?>");            
        });
    }
    function triggerReport() {
        var daterangepicker = $("#dateRange").data("daterangepicker");
        daterangepicker.callback(
            daterangepicker.startDate,
            daterangepicker.endDate
        );
    }
    getReport("<?= date('Y-01-01') ?>","<?= date('Y-12-31'); ?>");
</script>

