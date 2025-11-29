function formatMoney(number, decPlaces, decSep, thouSep) {
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-" : "";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;

    return sign + (j ? i.substr(0, j) + thouSep : "") + i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) + (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}
function createPopup(url,w,h,title){
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    var title = title||document.title;
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: function(toast) {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// ON PAGE LOAD
$(function() {

    var homeSlider = new Swiper('#home-slider .swiper-container', {
        pagination: {
            el: '#home-slider .swiper-pagination'
        },
        navigation: {
            nextEl: '#home-slider .swiper-button-next',
            prevEl: '#home-slider .swiper-button-prev',
        },
        autoplay: {
            delay: 3500,
            disableOnInteraction: false
        },
    });

    var homeSlider2 = new Swiper('#home-slider-2 .swiper-container', {
        pagination: {
            el: '#home-slider-2 .swiper-pagination'
        },
        navigation: {
            nextEl: '#home-slider-2 .swiper-button-next',
            prevEl: '#home-slider-2 .swiper-button-prev',
        },
        autoplay: {
            delay: 3500,
            disableOnInteraction: false
        },
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': '%2 görselden %1.',
        'fadeDuration': 200
    });
    // feather icons init
    feather.replace();

    $('[data-toggle="tooltip"]').tooltip();

    $('.phone-number-mask').mask('0000 000 00 00', {
        placeholder: "05__ ___ __ __"
    });

    $('.tc-no-mask').mask('99999999999',{
        placeholder: "___________"
    });

    $('.qty-input').mask('0#', {
        placeholder: "Adet"
    });

    $('.qty-input').on('input', function(){
        if($(this).val() < 1){
            $(this).val(1);
        }
    });

    $('[data-toggle="cart-item-qty-plus"]').click(function(e){
        e.preventDefault();
        if($(this).val() == null){
            $(this).val(1);
        }
        $($(this).data('target')).val(parseInt($($(this).data('target')).val()) + 1);
        cart.update($(this).data('rowid'), parseInt($($(this).data('target')).val()), true);
        let qtyPrice = parseFloat($(this).data('qty-price'));
        $($(this).data('subtotal-area')).html(formatMoney(qtyPrice * parseInt($($(this).data('target')).val()), 2) + ' AZN');
    });

    $('[data-toggle="cart-item-qty-minus"]').click(function(e){
        e.preventDefault();
        if($(this).val() == null){
            $(this).val(1);
        }
        $($(this).data('target')).val(parseInt($($(this).data('target')).val()) - 1);
        cart.update($(this).data('rowid'), parseInt($($(this).data('target')).val()), true);
        let qtyPrice = parseFloat($(this).data('qty-price'));
        $($(this).data('subtotal-area')).html(formatMoney(qtyPrice * parseInt($($(this).data('target')).val()), 2) + ' AZN');
    });

    $('.update-cart-item').click(function(){
        cart.update($(this).data('rid'), $($(this).data('qtydom')).val(), true);
    });

    $('.delete-cart-item').click(function(){
        cart.remove($(this).data('rid'), true);
    });

    $('#headerSearchInput').autoComplete({
        minChars: 2,
        source: function(term, response){
            $.getJSON(websiteConfig.api_url + 'search', { query: term }, function(data){ response(data); });
        },
        renderItem: function (item, search){
            search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
            return '<div class="autocomplete-suggestion"><a href="' + item.url + '">' + item.name + '</a></div>';
        },
        onSelect: function(e, term, item){
            let url = item.children('a').attr('href');
            window.location.href = url;
        }
    });

    $('#categorySearchInput').on('focus', function(){
        $(this).parent().css({
            'border-color':'var(--primary)'
        });
    });
    $('#categorySearchInput').on('blur', function(){
        $(this).parent().css({
            'border-color':'#ced4da'
        });
    });
    $('#categorySearchInput').on('input', function(e){
        e.preventDefault();
        $('#mainCategoryAreaList').html(`<div class="text-center"><div class="spinner-grow spinner-grow-sm m-3 text-primary" role="status">
          <span class="sr-only">Yükleniyor...</span>
        </div></div>`);
        if ($(this).val().length>2) {
            $.getJSON(websiteConfig.api_url + 'catsearch', {
                query: $(this).val()
            }, function(res){
                $('#mainCategoryAreaList').html(res.data.list_html);
                feather.replace();
                if(res.data.list.length === 0) {
                    $('#mainCategoryAreaList').html(`<div class="text-center"><small class="text-muted">Hiç sonuç bulunamadı.</small></div>`);
                }
            });
        } else {
            $.getJSON(websiteConfig.api_url + 'catsearch', {
                query: ''
            }, function(res){
                $('#mainCategoryAreaList').html(res.data.list_html);
                feather.replace();
                if(res.data.list.length === 0) {
                    $('#mainCategoryAreaList').html(`<div class="text-center"><small class="text-muted">Hiç sonuç bulunamadı.</small></div>`);
                }
            });
        }
    });

    $(".add-to-cart").click(function(e){
        e.preventDefault();
        let qty = 1;
        let qtyInput = $($(this).data('qty-input'));
        if (qtyInput) {
            qty = parseInt(qtyInput.val());
        }
        cart.add($(this).data("pid"), qty);
        Toast.fire({
            icon: 'success',
            title: '<strong>' + $(this).data("pname") + '</strong>&nbsp; ürünü sepetinize eklendi.'
        });
        cart.list(true);
    });

    $(".add-to-cart-modal").click(function(e){
        e.preventDefault();
        cart.add(
            $(this).data("pid"),
            $($(this).data('input')).val(),
            $($(this).data('form')).serializeArray(),
            $($(this).data('response-area')),
            $($(this).data('form')),
            $($(this).data('input') + 'FormGroup'),
            $(this)
        );
        cart.list(true);
    });

    $('.product-qty-input').on('input', function(e){
        let qty = $(this).val();
        let priceArea = $($(this).data('price-area'));
        let price = parseFloat($(this).data('qty-price'));
        priceArea.html(formatMoney(qty * price) + ' <small>AZN</small>');
    });

    $('.product-qty-input').on('blur', function(e){
        if (parseInt($(this).val()) < 1) {
            $(this).val(1);
        }
        let qty = $(this).val();
        let priceArea = $($(this).data('price-area'));
        let price = parseFloat($(this).data('qty-price'));
        priceArea.html(formatMoney(qty * price) + ' <small>AZN</small>');
    });

});

$('[data-toggle="please-log-in-button"]').on('click', function(e){
    e.preventDefault();
    let dataTitle = $(this).data('title');
    Toast.fire({
        icon: 'warning',
        title: dataTitle ? dataTitle : 'Giriş yapmanız gerekiyor.'
    });
});


if(websiteConfig.user.is_logged_in == true){
    setInterval(function(){
        checkUnreadThings();
    },1000 * 60 * 2);
}

function updateCSRF(csrf_token) {
    let csrfInput = $('[name="epinom_csrf"]');
    csrfInput.val(csrf_token);
}

setInterval(function () {
    window.location.reload();
}, 7200000);

$(function(){
    $('#addCommentForm button[type="submit"]').on('click', function(e){
        e.preventDefault();
        let form = $('#addCommentForm');
        $(this).prop('disabled', true);
        $.post(form[0].action, form.serialize(), (r)=>{
            let response = JSON.parse(r);
            if(response.error === true) {
                $('#commentAlertArea').html(response.alert);
                $(this).prop('disabled', false);
            } else {
                $('#commentAlertArea').html(response.alert);
                $('#commentFormElements').remove();
                $(this).remove();
            }
        });
    });
});

$(function(){
    $('#headerMenu ul li.has-child .multi-dropdown').on('click', 'ul li.has-child a.h', function(e) {
        e.preventDefault();
        let sub = $(this).parent().children('.sub-categories');
        sub.slideToggle(200, ()=>{
            if(!sub.hasClass('show')) {
                sub.addClass('show');
                $(this).children('.feather').addClass('flip');
            } else {
                sub.removeClass('show');
                $(this).children('.feather').removeClass('flip');
            }
        });
    });
})

$(function(){
    $('#loadingArea').fadeOut(100);
    setTimeout(function(){
        $('#loadingArea').remove();
    },500);
});

$(function(){
    $('#mobileMenuButton').on('click', function(e){
        e.preventDefault();
        $('#desktop-menu').slideToggle(200);
    });
});

$(function(){
    $('#headerMenu ul li.has-child').hover(function(){
        let target = $($(this).children('a').data('menu-dropdown'));
        target.fadeIn(200);
    }, function(){
        let target = $($(this).children('a').data('menu-dropdown'));
        target.fadeOut(0);
    })
});

$('.specialfields_qty').on('input', function(){
    if (parseInt($(this).val()) > 0) {
        let target = $($(this).data('target'));
        let qtyprice = parseFloat($(this).data('qty-price'));
        let amount = qtyprice * parseInt($(this).val());
        target.html(formatMoney(amount) + ' AZN');
    }
});
$('.specialfields_qty').on('blur', function(){
    if (parseInt($(this).val()) < 1) {
        $(this).val(1);
    }
    let target = $($(this).data('target'));
    let qtyprice = parseFloat($(this).data('qty-price'));
    let amount = qtyprice * parseInt($(this).val());
    target.html(formatMoney(amount) + ' AZN');
});

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
$(function(){
    $('[name="isGiftCart"]').on('change', function(e){
        e.preventDefault();
        if ($(this).val() === '1') {
            $('.cartEndModalButton').text('Alışverişi Tamamla ve Hediyeyi Gönder');
            $('.cartEndGift').fadeIn(200);
            $('#cartFormD, #cartFormM').append($('<input/>').attr('name', 'isGiftCart').attr('value', 1).attr('type','hidden'));
            $('#cartFormD, #cartFormM').append($('<input/>').attr('name', 'giftCartEmail').attr('value', $('#cartEndModalGiftEmailInput').val()).attr('type','hidden'));
        } else {
            $('.cartEndModalButton').text('Alışverişi Tamamla');
            $('.cartEndGift').fadeOut(200);
            $('#cartFormD input[name="isGiftCart"]').remove();
            $('#cartFormD input[name="giftCartEmail"]').remove();
            $('#cartFormM input[name="isGiftCart"]').remove();
            $('#cartFormM input[name="giftCartEmail"]').remove();
        }
    });
    $('.cartEndModalButton').on('click', function(){
        if ($('[name="isGiftCart"]').val() === '1') {
            if (validateEmail($('#cartEndModalGiftEmailInput').val())) {
                $('input[name="giftCartEmail"]').val($('#cartEndModalGiftEmailInput').val());
                $('#cartFormD').submit();
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'Belirttiğiniz e-posta adresi geçersiz.'
                });
                $('#cartEndModalGiftEmailInput').val('');
                $('#cartEndModalGiftEmailInput').focus();
            }
            return;
        }
        $('#cartFormD').submit();
    });
});