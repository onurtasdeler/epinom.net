<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>



<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>





<script src="<?= base_url() ?>assets/backend/js/vue.global.js"></script>

<script>
    const {
        createApp,
        ref
    } = Vue

    createApp({
        data() {
            return {
                defaultImageList: []
            }
        },
        methods: {
            getDefaultImages(keepNews = false) {
                let ref = this;
                let emptyList = [];

                if (keepNews) {
                    emptyList = this.defaultImageList.filter(item => item.is_new === 1);
                }

                $.post("<?= base_url('ilan-kategori-gorsel-cek') ?>", {
                    data: "<?= $data["veri"]->id; ?>"
                }, function(response) {
                    const parsedResponse = JSON.parse(response);

                    if (keepNews) {
                        ref.defaultImageList = [
                            ...parsedResponse,
                            ...emptyList
                        ];
                    } else {
                        ref.defaultImageList = parsedResponse;
                    }

                });
            },
            addNewDefaultImage() {
                this.defaultImageList.push({
                    id: this.getRndId(),
                    image: "default.png",
                    category_id: <?= $data["veri"]->id; ?>,
                    sort_order: 0,
                    is_new: 1
                });
            },
            async removeDefaultImage(e) {
                let isNew = e.target.dataset.new;
                let imgId = e.target.dataset.id;
                

                if (isNew == 0){
                    const formData = new FormData();
                    formData.append("id", imgId);
                    const response = await fetch("<?= base_url('ilan-kategori-gorsel-sil') ?>", {
                        method: "POST",
                        body: formData,
                    });
                    if (response.ok) {
                        alertToggle(1, "Resim Silindi.", "Başarılı");
                    }else{
                        alertToggle(2, "Resim Silinemedi", "Başarısız ");
                    }
                }

                this.defaultImageList.splice(this.defaultImageList.findIndex(item => item.id === imgId), 1);
            },
            async uploadImage(e) {
                const file = e.target.files[0];
                if (!file) {
                    alertToggle(2, "Dosya Seçilmedi", "hata ");
                    return;
                }

                const formData = new FormData();
                formData.append("image", file);
                formData.append("id", e.target.dataset.id);
                formData.append("category_id", e.target.dataset.category);
                formData.append("is_new", e.target.dataset.new);

                const response = await fetch("<?= base_url('ilan-kategori-gorsel-yukle') ?>", {
                    method: "POST",
                    body: formData,
                });

                if (response.ok) {
                    const result = await response.json();
                    alertToggle(1, "Resim Yüklendi.", "Başarılı");
                    const item = this.defaultImageList.find(item => item.id == e.target.dataset.id);
                    item.image = result.image;
                    item.is_new = 0;
                    this.getDefaultImages(true);
                } else {
                    alertToggle(2, "Resim Yüklenemedi", "Başarısız ");
                }
            },
            getRndId() {
                let newId;
                do {
                    newId = Math.floor(Math.random() * (99999999999 - 11111111111)) + 11111111111;
                } while (this.defaultImageList.some(item => item.id === newId));
                return newId;
            },
        },
        mounted() {
            this.getDefaultImages();
        }
    }).mount('#app')
</script>


<!--end::Page Vendors-->

<script>

    $(function() {



        <?php

        if ($this->settings->lang == 1) {

            $getLang = getTable("table_langs", array("status" => 1));

            if ($getLang) {

                foreach ($getLang as $item) {

        ?>

                    $ck<?= $item->id ?> = CKEDITOR.replace('icerik_<?= $item->id ?>', {

                        filebrowserImageUploadUrl: "<?= base_url(); ?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",

                    });

                    $ck<?= $item->id ?>.on('change', function() {

                        $ck<?= $item->id ?>.updateElement();

                    });



        <?php

                }

            }

        }

        ?>

    });



    function deleteModal(id, tur) {

        var a = "";

        $.post("<?= base_url('ilan-kategori-cek') ?>", {

            data: id

        }, function(response) {

            if (response) {

                $("#makaleId").html('<strong style="color:green">' + response + "</strong>");

                $("#silinecek").val(id);

                $("#tur").val(tur);

            } else {

                alertToggle(2, "Bir hata meydana geldi.", "hata ");

            }

        });

    }



    function deleteModalSubmit() {

        var a = $("#silinecek").val();

        var tur = $("#tur").val();

        if (a != "") {

            $.post("<?= base_url('ilan-kategori-img-sil') ?>", {

                data: a,

                tur: tur

            }, function(response) {

                if (response) {

                    alertToggle(1, "Resim Silindi.", "Başarılı");

                    setTimeout(function() {

                        window.location.reload();

                    }, 1000);

                } else {

                    alertToggle(2, "Hata", "Hata");

                }

            });

        }

    }



    $(document).ready(function() {

        $("#guncelleForm").on("submit", function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            for (instance in CKEDITOR.instances) {

                CKEDITOR.instances[instance].updateElement();

            }

            $.ajax({

                url: "<?= base_url("ilan-kategori-guncelle/" . $data["veri"]->id) ?>",

                type: 'POST',

                data: formData,

                success: function(response) {

                    if (response) {

                        if (response.err) {

                            alertS(response.message, "error");

                        } else {

                            alertS(response.message, "success");



                        }

                    } else {

                        alertToggle(2, "Bir hata meydana geldi.", "hata ");

                    }

                },

                cache: false,

                contentType: false,

                processData: false

            });



        });



    });

</script>