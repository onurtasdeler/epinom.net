<script>
    $(document).ready(function() {
        $('#invoiceForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();
            $.post(url, data, function(response) {
                $('#invoiceButton').attr('disabled', true);
                $('#invoiceButton').html('<i class="fas fa-spinner fa-spin"></i> <?= langS(14, 2) ?>');

                if (response.status === true) {
                    toastr.success(response.message);
                    $('#invoiceButton').attr('disabled', false);
                    $('#invoiceButton').html('<?= langS(395, 8) ?>');
                } else {
                    toastr.warning(response.message);
                    $('#invoiceButton').attr('disabled', false);
                    $('#invoiceButton').html('<i class="fa fa-arrow-right"></i> <?= langS(395, 8) ?>');
                }
            }, 'json');
        });

        $('#provinceSelect').change(function() {
            var province = $(this).val();
            var dataId = $(this).find(':selected').attr('data-id');
            $.get('<?= base_url('api/getDistricts/') ?>' + dataId, function(response) {
                if(response.status === true) {
                    $('#districtSelect').html('');
                    response.data.forEach(function(district) {
                        $('#districtSelect').append('<option value="' + district.ad + '">' + district.ad + '</option>');
                    });
                }
            });
        });
    });
</script>