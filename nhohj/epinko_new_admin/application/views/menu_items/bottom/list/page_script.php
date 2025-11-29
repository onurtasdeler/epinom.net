<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>

<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script>

</script>
<script>
    var tabless;
    $("#menu #makaleId").html("");

    // begin first table


    function sosyalDelete(id){
        var a="";
        $.post("<?= base_url($this->nameTekil.'-cek') ?>",{data:id},function(response){
            if(response){
                $("#menu #makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }
    function sosyalDelete2(id){
        var a="";
        var form = $("#frm-example");
        var rows_selected = tabless.column(0).checkboxes.selected();
        var str="";
        $(".silll").remove();
        $.each(rows_selected, function(index, rowId){
            $(form).append(
                $('<input>').attr('type', 'hidden')
                    .attr('name', 'id[]').attr("class","silll")
                    .val(rowId));

                str += rowId.toString() + ", ";
        });




        if(str==""){
            $("#menu2 #makaleId").html("Herhangi bir kayıt seçmediniz.");
            $("#baslikToplu").html("Lütfen Silinecek Kayıtları Seçiniz.");
            $("#siltopluonay").hide();
            $("#menu2 #toplumetin").html("");
            $("#vazgectoplu").html("Tamam");
            $("#siltopluonay").attr("onclick",'gonder(1)');
        }else{
            $.post("<?= base_url($this->nameTekil.'-cek-toplu') ?>",{data : str,tur:1},function(response){
                $("#vazgectoplu").html("Vazgeç");
                $("#siltopluonay").show();
                $("#siltopluonay").attr("onclick",'gonder(2)');
                $("#menu2 #makaleId").html("Kayıtlar Silinecektir. Emin misiniz ?");
                $("#menu2 #toplumetin").html("<br>" + response + " adlı kayıtlar silinecektir.");
            });

        }
        /*$.post("<?= base_url('liman-cek') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);

            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });*/
    }
    function gonder(type){
        if(type==1){

        }else{
            var form = $("#frm-example");

            $.post("<?= base_url($this->nameTekil.'-cek-toplu') ?>",{data : form.serialize() ,tur:2},function(response){
                if($.trim(response)=="1"){
                    alertS("Kayıtlar başarılı şekilde silindi.","success");
                    $('#kt_datatable').DataTable().ajax.reload();
                   $("#vazgectoplu").trigger("click");
                }
            });
        }
    }


    function durum_degistir(types,id){
        if(types!=""){
            var $data= $("#switch-lg_" + types + "_" + id).prop("checked");
            var $data_url=$("#switch-lg_" + types + "_" + id).data("url");
        }else{
            var $data= $("#switch-lg_" + id).prop("checked");
            var $data_url=$("#switch-lg_" + id).data("url");
        }

        if(typeof $data !== "undefined" && typeof $data_url!=="undefined"){
            $.post($data_url,{data : $data},function(response){
                if(response==2){
                    alertToggle(2,"Bir hata meydana geldi.","Hata");

                }else if(response==1){
                    alertToggle(1,"Durum Güncellendi.","İşlem Başarılı");
                }
            });
        }
    }

    function sosyal_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url($this->nameTekil.'-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"<?= $this->titleAdTekil ?> Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }

    function sosyal_delete2(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url($this->nameTekil.'-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"<?= $this->titleAdTekil ?> Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }


    $(document).ready(function() {
        //$("#kt_datatable_filter").hide();
        tabless  = $('#kt_datatable').DataTable({

            responsive: true,
            processing: true,
            "searchDelay": 500,
            serverSide: true,
            ajax: {
                url: "<?= base_url($this->nameTekil."-list-table") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ssid','status','order_id','ikon','parent','status','action'],
                },
            },
            "language":{
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },
            dom: '<"row"<"col-lg-12"B><"col-lg-6 mt-4"l><"col-lg-6 text-right mt-4"f>>rtip',
            columns: [
                {data: 'order_id',responsivePriority: 1},
                {data: 'ikon',responsivePriority: 1},
                {data: 'name',responsivePriority: 2},
                {data: 'parent',responsivePriority: 3},
                {data: 'status',responsivePriority: 4},
                {data: 'action', responsivePriority: -1,searchable:false},
            ],
            columnDefs: [

                {
                    orderable:true,
                    searchable:true,
                    visible:true,
                    targets:0,
                },{
                    orderable:false,
                    searchable:false,
                    visible:true,
                    targets:1,
                    "render": function (data, type, row) {
                        if(row.ikon){
                            return '<i class="' + row.ikon + '"></i></span>';
                        }else{
                            return '-';
                        }
                    }
                }, {
                    orderable:true,
                    searchable:true,
                    visible:true,
                    targets:2,


                }, {
                    orderable:true,
                    searchable:true,
                    visible:true,
                    targets:3,
                    "render": function (data, type, row) {
                        if(row.parent==1){
                            return '<span class="badge badge-success">1. Alan</span>';
                        }else if(row.parent==2){
                            return '<span class="badge badge-info"> 2. Alan</span>';
                        }else if(row.parent==3){
                            return '<span class="badge badge-warning">3. Alan</span>';
                        }

                    }
                },
                {
                    orderable:true,
                    searchable:false,
                    targets:4,
                    "render": function (data, type, row) {
                        if(row.status==1){
                            return '<span class="switch switch-outline switch-icon switch-success">' +
                                '<label><input type="checkbox" id="switch-lg_1_'+ row.ssid +'" checked data-url="<?= base_url($this->nameTekil.'-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                'onchange="durum_degistir(1,'+ row.ssid +')" name="select"><span></span></label></span>';
                        }else{
                            return '<span class="switch switch-outline switch-icon switch-success">' +
                                '<label><input type="checkbox" id="switch-lg_1_'+ row.ssid +'"  data-url="<?= base_url($this->nameTekil.'-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                'onchange="durum_degistir(1,'+ row.ssid +')" name="select"><span></span></label></span>';
                        }
                    }
                },

                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable:false,
                    render: function(data, type,row) {
                        return '<a href="<?= base_url('alt-menu-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
                            '<i class="la la-edit text-warning"></i></a>'+
                            '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
                    },
                },
            ],
            order: [[ 1, "asc" ]],

            buttons: [
                {
                    extend: 'print',
                    text: 'Yazdır',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excele Aktar',
                    exportOptions: {
                        columns: ':visible'
                    }
                },{
                    extend: 'pdfHtml5',
                    text: 'PDF Aktar',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Aktarılacak Sütunlar',
                    exportOptions: {
                        columns: ':visible'
                    }
                }

            ],
        });
        //selectboxlar değiştiğinde olacaklar
        $('#kt_datatable tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            if(!this.checked){
                var el = $('#example-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if(el && el.checked && ('indeterminate' in el)){
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });
    });
</script>




