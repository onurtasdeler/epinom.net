var CartPostRequestResult;
function updateCartCountSpan(n){
    document.getElementById("EPcartCount").innerText = n.toString();
    if (document.getElementById("EPcartCountM")) {
        document.getElementById("EPcartCountM").innerText = n.toString();
    }
}
const cart = {
    add: function(p_id, quantity, extras = [], responseArea = '' , form = '', qtyInput = '', button = '') {
        let returnV;
        if (responseArea !== '') {
            responseArea.html('');
        }
        $.ajax({
            url: websiteConfig.api_url + "/cart/add",
            type: "POST",
            data: {
                pid: p_id,
                qty: quantity,
                extra: JSON.stringify(extras)
            },
            success: (result) => {
                result = JSON.parse(result);
                if(result.error === true){
                    //console.log("Error on cart.");
                }
                if(result.validation_errors_html) {
                    if(responseArea !== '') {
                        responseArea.html(result.validation_errors_html);
                    }
                } else if (result.error == false && responseArea != '') {
                    responseArea.html(result.alert);
                    form.fadeOut(200);
                    qtyInput.fadeOut(200);
                    button.remove();
                }
                returnV = result;
            }
        });
        return returnV;
    },
    list: function(updateDOM){
        updateDOM = typeof updateDOM !== 'undefined' ? updateDOM : false;
        $.ajax({
            url: websiteConfig.api_url + "/cart/list",
            type: "POST",
            data: {},
            success: function(result){
                result = JSON.parse(result);
                if(result.error == true){
                    console.log("Error on cart.");
                }else{
                    if(updateDOM === true){
                        updateCartCountSpan(result.cart_count);
                    }
                }
            }
        });
    },
    remove: function(r_id, refresh){
        $.ajax({
            url: websiteConfig.api_url + "/cart/remove",
            type: "POST",
            data: {
                rid: r_id
            },
            success: function(result){
                result = JSON.parse(result);
                if(result.error == true){
                    console.log("Error on cart.");
                }
                if(refresh == true){
                    window.location.reload();
                }
            }
        });
    },
    update: function(r_id, quantity, refresh){
        $.ajax({
            url: websiteConfig.api_url + "/cart/update",
            type: "POST",
            data: {
                rid: r_id,
                qty: quantity
            },
            success: function(result){
                result = JSON.parse(result);
                if(refresh === true){
                    window.location.reload();
                }
            }
        });
    }
};