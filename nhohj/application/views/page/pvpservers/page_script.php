<script>
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