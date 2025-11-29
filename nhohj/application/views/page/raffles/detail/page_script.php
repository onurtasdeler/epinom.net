<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        let befores = "";


    });
    function joinToRaffle() {
        $("#joinRaffleBtn").attr("disabled", true);
        $.ajax({
            url: '<?= base_url("join-to-raffle") ?>',
            method: 'POST',
            data: {
                raffleId:<?= $cekilis->id ?>
            },
            success: function (response) {
                if (response) {
                    if (response.error) {
                        toastr.warning(response.message)
                    } else {
                        toastr.success("<?= (lac() == 1) ? "Çekiliş'e başarıyla katıldınız." : "You are registered to raffle." ?>")
                        setTimeout(()=>{
                            location.reload();
                        },2000);
                    }
                }
            },
            error: function (err) {
                toastr.warning("<?= lac() == 1 ? "Bilinmeyen bir hata oluştu." : "An unknown error occured." ?>")
            }
        }).done(() => {
            $("#joinRaffleBtn").attr("disabled", false);
        })
    }
    function startCountdown(countdownElement) {
        const endDateStr = countdownElement.getAttribute('data-date');
        const endDate = new Date(endDateStr).getTime(); // Hedef tarih ve saati al

        function updateCountdown() {
            const now = new Date().getTime();
            const remainingTime = endDate - now;

            if (remainingTime <= 0) {
                clearInterval(interval);
                countdownElement.innerHTML = "Süre doldu!";
                return;
            }

            const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
            const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

            // Dinamik olarak değerleri güncelle
            countdownElement.querySelector('.time.day').textContent = days;
            countdownElement.querySelector('.time.hour').textContent = hours;
            countdownElement.querySelector('.time.minute').textContent = minutes;
            countdownElement.querySelector('.time.second').textContent = seconds;
        }

        updateCountdown(); // İlk güncelleme
        const interval = setInterval(updateCountdown, 1000); // Her saniye güncelle
    }

    // Tüm countdown elementlerini bul ve her biri için countdown başlat
    document.querySelectorAll('[data-type="countdown2"]').forEach(function (element) {
        startCountdown(element);
    });
</script>