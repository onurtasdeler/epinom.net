<script>
    $(document).ready(function() {
        $('#refundForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();
            $.post(url, data, function(response) {
                $('#refundButton').attr('disabled', true);
                $('#refundButton').html('<i class="fas fa-spinner fa-spin"></i> <?= langS(14, 2) ?>');

                if (response.status === true) {
                    toastr.success(response.message);
                    $('#refundButton').attr('disabled', false);
                    $('#refundButton').html('<?= langS(395, 8) ?>');
                    $('#refundForm')[0].reset();
                } else {
                    toastr.warning(response.message);
                    $('#refundButton').attr('disabled', false);
                    $('#refundButton').html('<i class="fa fa-arrow-right"></i> <?= langS(395, 8) ?>');
                }
            }, 'json');
        });
    });
</script>