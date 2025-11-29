<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
$taleps=getLangValue(97,"table_pages");
?>
<script>
    <?php $user=getActiveUsers(); ?>


    $(document).ready(function (){



        var table = $('#kt_datatable');
        table.DataTable({
            responsive: true,
            "language":{
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },
            dom:'rtip',
            order: [[0, "asc"]],


        });



    });
</script>