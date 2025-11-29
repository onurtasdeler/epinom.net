<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
  <?php $user = getActiveUsers(); ?>
  $(document).ready(function() {

    $("#streamerUpdateForm").validate({
      rules: {

      },
      messages: {

      },
      submitHandler: function(form) {
        var formData = new FormData(document.getElementById("streamerUpdateForm"));
        $("#submitButton").prop("disabled", true);
        $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
        $.ajax({
          url: "<?= base_url("streamer-application-update") ?>",
          type: 'POST',
          data: formData,
          success: function(response) {
            if (response) {

              if (response.hata == "var") {
                toastr.warning(response.message);
                $("#submitButton").prop("disabled", false);
              } else {
                $(".deleted").remove();
                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                $("#uyCont .alert").html(response.message);
                $("#uyCont").fadeIn(500);
                $("#submitButton").remove();
                toastr.success(response.message);
                setTimeout(function() {
                  window.location.reload();
                }, 2000);
              }
            } else {
              toastr.warning("<?= langS(22, 2)  ?>");
              $("#submitButton").prop("disabled", false);
              $("#submitButton").html("<i class='fa fa-check'></i> <?= langS(57, 2) ?>");
            }
          },
          cache: false,
          contentType: false,
          processData: false
        });

      }
    });
  });

  function popup(url, w, h, title) {
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    var title = title || document.title;

    var win = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    var win_timer = setInterval(function() {
      if (win.closed) {
        window.location.reload();
        clearInterval(win_timer);
      }
    }, 100)
  }
</script>