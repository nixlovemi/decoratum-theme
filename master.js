var template_url = "http://decoratum.com.br/wp-content/themes/decoratum-theme/";

$(document).ready(function () {
    $('.slider-cake2 .center2').slick({
        infinite: true,
        centerMode: true
    });

    $('.slider-prod-single').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });

    initPlugins();
});

$(document).on("click", ".rad-slc-frete", function () {
    var value = $(this).val();

    $.ajax({
        type: "POST",
        url: template_url + 'ajax-selecShippingCart.php',
        data: 'valueRd=' + value,
        beforeSend: function () {
            $("#spn-cart-total").html("Calculando...");
        },
        error: function (a, b, c) {
            $("#spn-cart-total").html("Erro ao calcular frete. Tente novamente mais tarde!");
        },
        success: function (retorno) {
            $("#spn-cart-total").html(retorno);
        }
    });
});

function redirectURL(url){
    document.location.href = url;
}

function closeMessage(){
    $.pgwModal('close');
}

function showMessage(title, msg, close){
    if (typeof close === 'undefined') {
        close = true;
    }
    
    $.pgwModal({
        title: title,
        content: msg,
        closable: close
    });
}

function execProdFilter(categoryId, orderBy) {
    categoryId = (typeof categoryId === 'undefined') ? '' : categoryId;
    orderBy = (typeof orderBy === 'undefined') ? '' : orderBy;

    var hddn_cat = $("#hddn-filters-category-id").val();
    var hddn_ord = $("#hddn-filters-order-by").val();

    if (categoryId != "") {
        hddn_cat = categoryId;
    }

    if (orderBy != "") {
        hddn_ord = orderBy;
    }

    var arrHref = document.location.href.split("?");
    document.location.href = arrHref[0] + '?categoryId=' + categoryId + '&orderBy=' + orderBy;
}

function addCoupon_Cart() {
    var couponCode = $("#cupom_carrinho").val();
    var idResp = "ret-ajax-coupon";
    var idTot = "spn-cart-total";

    $.ajax({
        type: "POST",
        url: template_url + 'ajax-calculaCupom.php',
        data: 'couponCode=' + couponCode,
        beforeSend: function () {
            $("#" + idResp).html("Processando...");
            $("#" + idTot).html("Processando...");
        },
        error: function (a, b, c) {
            $("#" + idResp).html("Erro ao calcular cupom. Tente novamente mais tarde!");
        },
        success: function (retorno) {
            $("#" + idResp).html(retorno);
            getCartTotal(idTot);
        }
    });
}

function execCheckout(){
    var formVars = $("#frm-checkout").serialize();
    
    $.ajax({
        type: "POST",
        url: template_url + 'ajax-checkout.php',
        data: 'exec=1&' + formVars,
        dataType: 'json',
        beforeSend: function () {
            showMessage("ALERTA", "Processando pedido, por favor aguarde e não atualize o navegador.<br /><center><img src='"+template_url+"images/ajax-loader.gif'></center>", false);
        },
        error: function (a, b, c) {
            showMessage("ERRO", "Erro ao finalizar compra. Por favor entre em contato!");
        },
        success: function (retorno) {
            if(retorno.ok){
                showMessage("SUCESSO", retorno.msg + "<br /><center><img src='"+template_url+"images/ajax-loader.gif'></center>", false);
                
                // redirect pro pagseguro
                // var html = "<form method='' id='frmCheckoutPagseguro' action='https://pagseguro.uol.com.br/v2/checkout/payment.html?code="+retorno.pagSeguroKey+"'></form>";
                // $("body").append(html);
                
                setTimeout(" redirectURL('https://pagseguro.uol.com.br/v2/checkout/payment.html?code="+retorno.pagSeguroKey+"') ", 1800);
            } else {
                showMessage("ERRO", retorno.msg);
                return;
            }
        }
    });
}

function getCartTotal(dvResp){
    // se tiver frete selecionado
    var vlrFrete = 0;
    var slcFrete = $("#rd-slc-frete").val();
    if(typeof slcFrete !== "undefined"){
        slcFrete = slcFrete.split("|");
        vlrFrete = slcFrete[0];
    }
    
    $.ajax({
        type: "POST",
        url: template_url + 'ajax-calculaCartTotal.php',
        data: 'exec=1&vlrFrete=' + vlrFrete,
        beforeSend: function () {
            $("#" + dvResp).html("Processando...");
        },
        error: function (a, b, c) {
            $("#" + dvResp).html("Erro ao calcular total. Tente novamente mais tarde!");
        },
        success: function (retorno) {
            $("#" + dvResp).html(retorno);
        }
    });
}

function addToCart(productId, qty) {
    var arrHref = document.location.href.split("?");
    document.location.href = arrHref[0] + '?add-to-cart=' + productId + '&quantity=' + qty;
}

function addToCart_HOME(productId) {
    addToCart(productId, 1);
}

function addToCart_SP() {
    var proId = $("#hddnSpProId").val();
    var qtde = $("#qtdeItem").val();

    if (!proId > 0) {
        showMessage("ERRO", "Erro ao inserir produto no carrinho. Tente novamente em breve!");
        return;
    }

    if (!qtde > 0) {
        showMessage("ALERTA", "Por favor, digite uma quantidade entre 01 e 99!");
        return;
    }

    addToCart(proId, qtde);
}

function changeCartItem(productId) {
    var qty = $("#qty_" + productId).val();

    if (!productId > 0) {
        showMessage("ERRO", "Erro ao alterar quantidade. Tente novamente em breve!");
        return;
    }

    if (!qty > 0) {
        showMessage("ALERTA", "Por favor, digite uma quantidade entre 01 e 99!");
        return;
    }

    var arrHref = document.location.href.split("?");
    document.location.href = arrHref[0] + '?change-qty=' + productId + '&quantity=' + qty;
}

function calculaFrete(produtoIds, quantidades, cepDestino, idResp, freteCarrinho) {
    freteCarrinho = typeof freteCarrinho !== 'undefined' ? freteCarrinho : 'N';

    $.ajax({
        type: "POST",
        url: template_url + 'ajax-calculaFrete.php',
        data: 'produtoIds=' + produtoIds + '&quantidades=' + quantidades + '&cepDestino=' + cepDestino + '&freteCarrinho=' + freteCarrinho,
        beforeSend: function () {
            $("#" + idResp).html("Processando...");
        },
        error: function (a, b, c) {
            $("#" + idResp).html("Erro ao calcular frete. Tente novamente mais tarde!");
        },
        success: function (retorno) {
            $("#" + idResp).html(retorno);
        }
    });
}

function goToShopping(){
    document.location.href = 'http://decoratum.com.br/produtos';
}

function clearCart() {
    document.location.href = 'http://decoratum.com.br/produtos/?a=clearCart';
}

function valida_cpf(strCPF) {
    strCPF = strCPF.replace(/\./g, '');
    strCPF = strCPF.replace(/\-/g, '');

    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000" || strCPF == "11111111111" || strCPF == "22222222222" || strCPF == "33333333333" || strCPF == "44444444444" || strCPF == "55555555555" || strCPF == "66666666666" || strCPF == "77777777777" || strCPF == "88888888888" || strCPF == "99999999999")
        return false;

    for (i = 1; i <= 9; i++)
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)))
        return false;

    Soma = 0;
    for (i = 1; i <= 10; i++)
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11)))
        return false;
    return true;
}

function valida_email(email) {
    var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return filtro.test(email);
}

function initPlugins() {
    $(".mask-cpf").mask("999.999.999-99");
    $(".mask-cep").mask("99999-999");
    $(".mask-qty-prod").mask("99");
}

function goToCheckout() {
    var freteSel = typeof $("#rd-slc-frete:checked").val() !== "undefined";
    if (!freteSel) {
        showMessage("ALERTA", "Para finalizar, selecione o frete!");
        return;
    }

    var cepValue = $("#frete_carrinho").val();
    var freteArr = $("#rd-slc-frete:checked").val().split("|");
    var freteValue = freteArr[0];
    var freteName = freteArr[1];
    
    var html = '<form id="frmCheckout" method="post" action="http://decoratum.com.br/checkout/">';
    html += '<input type="hidden" name="freteValue" value="'+freteValue+'">';
    html += '<input type="hidden" name="freteName" value="'+freteName+'">';
    html += '<input type="hidden" name="cepValue" value="'+cepValue+'">';
    html += '</form>';
    $("body").append(html);
    
    setTimeout(" $('#frmCheckout').submit(); ", 200);
}

/* old functions
================*/
function continueShop() {
    /*var href = '';
     $('a[href*="/produtos"]').each(function (index, element) {
     href = $(this).attr("href");
     });
     
     if (href != '') {
     document.location.href = href;
     }*/
}

function removeCartItem(id_prod) {
    /*if (confirm('Deseja retirar esse item do carrinho?')) {
     var htmlForm = '<form action="" method="POST" id="frmDeletaItemCarrinho">';
     htmlForm += "  <input type='hidden' name='ID_PROD_DEL' value='" + id_prod + "' />";
     htmlForm += '</form>';
     
     $('body').append(htmlForm);
     setTimeout(" $('form#frmDeletaItemCarrinho').submit(); ", 500);
     }*/
}

function updateCart() {
    /*
     // pega todas as selects com a qtdes
     var arr_valores = new Array();
     
     $(".qtd-item-carrinho").each(function (index) {
     var id_prod = $(this).attr('data-id-prod');
     var qtde = $(this).val();
     
     var array = new Array();
     array["id_prod"] = id_prod;
     array["qtde"] = qtde;
     
     arr_valores.push($.extend({}, array));
     });
     
     var JSONResp = {
     "produtos": $.extend({}, arr_valores)
     };
     var StringJSONResp = JSON.stringify(JSONResp);
     
     var htmlForm = '<form action="" method="POST" id="frmAtualizaCarrinho">';
     htmlForm += "  <input type='hidden' name='stringfyJSON' value='" + encodeURIComponent(StringJSONResp) + "' />";
     htmlForm += '</form>';
     
     $('body').append(htmlForm);
     setTimeout(" $('form#frmAtualizaCarrinho').submit(); ", 500);
     */
}

function finishShop(pg) {
    /*
     $.ajax({
     type: "POST",
     url: 'http://crochepassoapasso.com.br/sonhodetrufa/wp-content/themes/sonhodetrufa-v1/ajax-finalizaModalPg.php',
     data: 'pg=1',
     success: function (msg) {
     $.pgwModal({
     title: 'Finalizar Pedido',
     content: msg,
     maxWidth: 800,
     closeOnBackgroundClick: false,
     });
     setTimeout("initPlugins();", 500);
     }
     });
     */
}

function finishPrevPage(pg_atual) {
    /*if (pg_atual == 2) {
     $('div#compraModal-1').show();
     $('div#compraModal-2').hide();
     $('div#compraModal-3').hide();
     }*/
}

function buscaCep(cep) {
    /*$.ajax({
     type: "POST",
     url: 'http://crochepassoapasso.com.br/sonhodetrufa/wp-content/themes/sonhodetrufa-v1/ajax-pesquisaCep.php',
     data: 'cep=' + cep,
     beforeSend: function () {
     $('#tb-endereco-completo').show(1000);
     },
     success: function (msg) {
     console.log(msg);
     }
     });*/
}
/*==============*/