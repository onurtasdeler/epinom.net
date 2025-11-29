<script>
    function changeStatus(status, id) {
        if (status == 3) {
            Swal.fire({
                title: 'Devam etmek istiyor musunuz?',
                text: "Bu işlemin ardından kullanıcıya bakiyesi iade edilecektir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, devam et!',
                cancelButtonText: 'Hayır, vazgeç!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('refund-status') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Başarılı!',
                                    response.message,
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Hata!',
                                    response.message,
                                    'error'
                                )
                            }

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    });
                }
            })
        } else {
            Swal.fire({
                title: 'Devam etmek istiyor musunuz?',
                text: "Bu işlemi yapmak istediğinizden emin misiniz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, devam et!',
                cancelButtonText: 'Hayır, vazgeç!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('refund-status') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire(
                                    'Başarılı!',
                                    response.message,
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Hata!',
                                    response.message,
                                    'error'
                                )
                            }

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    });
                }
            })
        }
    }
</script>