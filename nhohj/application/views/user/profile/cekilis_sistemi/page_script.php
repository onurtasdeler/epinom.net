<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
  var products = <?= json_encode($urunler); ?>;
  <?php $user = getActiveUsers(); ?>
  $(document).ready(function() {
    calculatePrice();
    $("#createRaffleForm").on("submit",(el)=>{
      el.preventDefault();
      
      var data = {
        raffleRewardsList : $("#raffleRewardsList").val(),
        name : $("#name").val(),
        description : $("#description").val(),
        end_date : $("#end_date").val(),
        end_time : $("#end_time").val(),
        raffle_type : $("#raffle_type").val(),
      }
      if(data.raffleRewardsList == "") {
        toastr.warning("Tüm katılımcı ödüllerini doldurduğunuzdan emin olun. Boş katılımcıları silip tekrar deneyiniz.");
        return;
      }
      
      $("#submitButton").prop("disabled", true);
        $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
        $.ajax({
          url: "<?= base_url("create-raffle") ?>",
          type: 'POST',
          data: data,
          success: function(response,textStatus,xhr) {
            if (typeof response === 'object' && xhr.status == 200) {
              if (response.error) {
                toastr.warning(response.message);
                $("#submitButton").prop("disabled", false);
                $("#submitButton").html("Çekiliş Oluştur");
              } else {
                toastr.success(response.message);
                setTimeout(function() {
                  window.location.reload();
                }, 2000);
              }
            } else {
              toastr.warning("<?= langS(22, 2)  ?>");
              $("#submitButton").prop("disabled", false);
              $("#submitButton").html("Çekiliş Oluştur");
            }
          },
          cache: false,
        });

    })
    
  });
    function modalShow(sip,pro){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-prod-order?t=1",
                type: 'POST',
                data: {sipNo:sip,pro:pro},
                success: function (response) {
                    if(response){
                        $("#copyButton").attr("data-id",response.codesPaste);
                        $("#copyButton2").attr("data-id",response.codesPasteVia);
                        $("#mTeslim").html(" " + response.teslim + " ");
                        $("#mCode").html(" " + response.codes + " ");
                        $("#codesWord").val( response.codesPasteVia );
                        if(response.codes && response.status==2){
                            $(".codeCont").show();
                        }else{
                            $(".codeCont").hide();
                        }
                        $("#mAds").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                        $("#mAdet").html(" " + response.qty + " ");
                        if(response.status==2){
                            $("#mStatus").html("<b class='text-success'> <?= (lac()==1)?"Teslim Edildi":"Completed" ?> </b>");
                        }else  if(response.status==1){
                            $("#mStatus").html("<b class='text-warning'> <i class='fa fa-spinner fa-spin'></i> <?= (lac()==1)?"Bekliyor":"Waiting" ?> </b>");
                        }else  if(response.status==3){
                            $("#mStatus").html("<b class='text-warning'> <i class='fa fa-spinner fa-spin'></i> <?= (lac()==1)?"Hazırlanıyor":"Preparing" ?> </b>");
                        }else  if(response.status==5){
                            $("#mStatus").html("<b class='text-danger'> <i class='fa fa-times'></i> <?= (lac()==1)?"İptal Edildi":"Cancelled" ?> </b><br> <small class='text-danger'>" + response.rednedeni + "</small>");
                        }
                        $("#placebidModal1").modal("show");
                    }else{

                    }

                },
            });

        }
    }
  function addRaffleItem(el) {
    var selectedId = $(el).val();
    if(selectedId == "")
      return;
    var selectedProduct = products.find(item=>item.id == selectedId);
    var fixedPrice = parseFloat(selectedProduct.price_sell).toFixed(2);
    var tableItem = `<tr data-id="${selectedProduct.id}">
      <td style="vertical-align: middle;">
        <img src="<?= base_url("upload/product/") ?>${selectedProduct.image}" width="60" height="60">&nbsp;&nbsp;${selectedProduct.p_name}
      </td>
      <td style="vertical-align: middle;">
        ${fixedPrice}&nbsp;<?= getCur(); ?>
      </td>
      <td style="vertical-align: middle;">
        <a class="text text-danger" href="javascript:void(0)" onclick="deleteRaffleItem(this)">Kaldır</a>
      </td>
    </tr>`;
    $(el).parent().next().find("table tbody").append(tableItem);
    calculateRaffle();
    $(el).val("");
    $(el).trigger("change");
  }
  function deleteRaffleItem(el) {
    $(el).parent().parent().remove();
    calculateRaffle();
  }
  function deleteParticipant(el) {
    if($("#raffleItems>.raffleParticipant").length > 1) {
      $(el).parent().parent().remove();
      reSetParticipantNumbers();
    }
  }
  function addParticipant() {
    var html = `<div class="raffleParticipant">
                  <div class="d-flex gap-3 justify-content-between">
                    <div class="participant">1.</div>
                    <select onchange="addRaffleItem(this);">
                      <option value="" disabled selected>Ürün seçiniz...</option>
                      <?php foreach($urunler as $urun): ?>
                        <option value="<?= $urun->id ?>"><?= $urun->p_name ?></option>
                      <?php endforeach; ?>
                    </select>
                  <button class="btn btn-small btn-danger" onclick="deleteParticipant(this)">Kaldır</button>
                </div>
                <div class="mt-4">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>Ürün</th>
                        <th>Tutar</th>
                        <th>İşlem</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>`;
    $("#raffleItems").append(html);
    reSetParticipantNumbers();
  }
  function reSetParticipantNumbers() {
    $("#raffleItems .participant").each((index,el)=>{
      $(el).text((index+1) + ".");
    });
    calculateRaffle();
  }
  function calculatePrice() {
    var totalPrice = 0;
    $("#raffleItems .raffleParticipant").each((index,el)=> {
      $(el).find("table tbody tr").each((index2,el2)=>{
        var prodId = $(el2).data("id");
        var prod = products.find(item=>item.id == prodId);
        totalPrice += parseFloat(prod.price_sell);
      });
    });
    $("#totalPrice").text(totalPrice.toFixed(2) + " <?= getCur(); ?>");
  }
  function calculateRaffle() {
    var raffleItems = "";
    var itemsNotSetted = -1;
    $("#raffleItems .raffleParticipant").each((index,el)=> {
      raffleItems += (index+1);
      if(itemsNotSetted == 1) {
        raffleItems = "";
      } else {
        itemsNotSetted = 1;
        $(el).find("table tbody tr").each((index2,el2)=>{
          raffleItems += "|" + $(el2).data("id");
          itemsNotSetted = 0;
        });
        raffleItems += "\n";
        if(itemsNotSetted == 1)
          raffleItems = "";
      }
    });
    $("#raffleRewardsList").val(raffleItems);
    calculatePrice();
  }
</script>