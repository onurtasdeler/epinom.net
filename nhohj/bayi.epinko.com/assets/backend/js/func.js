
// formdan alert bildirimi yapar
function form_return(tip,metin,idd,show_time,refresh_time,hide_ani_time,hide_time,refresh_page){
    $(idd).addClass(tip);
    $(idd +" .alert-text").html(metin);
    var body = $("html, body");
    if(hide_ani_time==0 && hide_time==0){
        $(idd).show(show_time);
        refresh_redirect(refresh_time,refresh_page);
    }else{
        body.stop().animate({scrollTop:0}, 270, 'swing', function() {show_hide(idd,show_time,hide_ani_time,hide_time)});
    }

}

function refresh_redirect(time,refresh_page=""){
    if(refresh_page!=""){
        setTimeout(function(){ window.location.href=refresh_page; }, time);
    }else{
        setTimeout(function(){ window.location.reload() }, time);
    }

}


//alert gösterme ve gizleme işlemi yapar
function show_hide(item_id,show_ani_time,hide_ani_time,hide_time){
    $(item_id).show(show_ani_time);
    setTimeout(function(){ $(item_id).hide(hide_ani_time); }, hide_time);
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)), //aksilik olmadan decodeURIComponent fonksiyonu ile url metni oku
        sURLVariables = sPageURL.split('&'), //dizi haline getir
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) { //parametreler icerisinde dongu ile gezin
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) { //istenilen parametre dizide, urlde var sa
            return sParameterName[1] === undefined ? true : sParameterName[1]; //parametre icerigi bos degilse veriyi geriye donder
        }
    }
}

function insertParam(key, value) {
    key = encodeURIComponent(key);
    value = encodeURIComponent(value);

    // kvp looks like ['key1=value1', 'key2=value2', ...]
    var kvp = document.location.search.substr(1).split('&');
    let i=0;

    for(; i<kvp.length; i++){
        if (kvp[i].startsWith(key + '=')) {
            let pair = kvp[i].split('=');
            pair[1] = value;
            kvp[i] = pair.join('=');
            break;
        }
    }

    if(i >= kvp.length){
        kvp[kvp.length] = [key,value].join('=');
    }

    // can return this or...
    let params = kvp.join('&');

    // reload page with new params
    document.location.search = params;
}



