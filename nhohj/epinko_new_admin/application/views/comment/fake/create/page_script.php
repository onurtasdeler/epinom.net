<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#select2').select2({
            ajax: {
                url: '<?= base_url('fake-yorum/categories'); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.c_name
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: 'Kategori seçin',
            minimumInputLength: 2
        });

        $('#commentForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            $.ajax({
                url: '<?= base_url('fake-yorum/save'); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        alertS(response.message, "success");
                    } else {
                        alertS(response.message, "error");
                    }

                    $('#commentForm').trigger('reset');
                    $('#select2').val(null).trigger('change');
                }
            });
        });
    });
</script>