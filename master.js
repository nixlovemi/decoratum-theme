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

function calculaFrete(produtoIds, cepDestino, idResp) {
    $.ajax({
        type: "POST",
        url: 'http://decoratum.com.br/wp-content/themes/decoratum-theme/ajax-calculaFrete.php',
        data: 'produtoIds=' + produtoIds + '&cepDestino=' + cepDestino,
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
}

function clearCart() {
    var url = document.location.href;
    var idx = url.indexOf('?');

    if (idx > 0) {
        var url_split = url.split('?');
        url = url_split[0];
    }

    url = url + '?a=clearCart';
    document.location.href = url;
}

function continueShop() {
    var href = '';
    $('a[href*="/produtos"]').each(function (index, element) {
        href = $(this).attr("href");
    });

    if (href != '') {
        document.location.href = href;
    }
}

function removeCartItem(id_prod) {
    if (confirm('Deseja retirar esse item do carrinho?')) {
        var htmlForm = '<form action="" method="POST" id="frmDeletaItemCarrinho">';
        htmlForm += "  <input type='hidden' name='ID_PROD_DEL' value='" + id_prod + "' />";
        htmlForm += '</form>';

        $('body').append(htmlForm);
        setTimeout(" $('form#frmDeletaItemCarrinho').submit(); ", 500);
    }
}

function updateCart() {
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
}

function finishShop(pg) {
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
}

function finishNextPage(pg_atual) {
    if (pg_atual == 1) {
        // checa se está na prim pg
        var div_1_visible = $('div#compraModal-1').is(':visible');
        if (div_1_visible) {
            // valida nome
            var nome = $('#finaliza-nome').val();
            if (nome.length < 3) {
                alert('Por favor, informe o nome com mais de 3 caracteres!');
                $('#finaliza-nome').focus();
                return;
            }
            // ===========

            // valida sobrenome
            var sobrenome = $('#finaliza-sobrenome').val();
            if (sobrenome.length < 3) {
                alert('Por favor, informe o sobrenome com mais de 3 caracteres!');
                $('#finaliza-sobrenome').focus();
                return;
            }
            // ================

            // valida cpf
            var cpf = $('#finaliza-cpf').val();
            if (!valida_cpf(cpf)) {
                alert('Por favor, informe um CPF válido!');
                $('#finaliza-cpf').focus();
                return;
            }
            // ==========

            // valida email
            var email = $('#finaliza-email').val();
            if (!valida_email(email)) {
                alert('Por favor, informe um email válido!');
                $('#finaliza-email').focus();
                return;
            }
            // ============

            // vai para a próxima aba
            $('div#compraModal-1').hide();
            $('div#compraModal-2').show();
            $('div#compraModal-3').hide();
        }
        // ========================
    }
}

function finishPrevPage(pg_atual) {
    if (pg_atual == 2) {
        $('div#compraModal-1').show();
        $('div#compraModal-2').hide();
        $('div#compraModal-3').hide();
    }
}

function buscaCep(cep) {
    $.ajax({
        type: "POST",
        url: 'http://crochepassoapasso.com.br/sonhodetrufa/wp-content/themes/sonhodetrufa-v1/ajax-pesquisaCep.php',
        data: 'cep=' + cep,
        beforeSend: function () {
            $('#tb-endereco-completo').show(1000);
        },
        success: function (msg) {
            console.log(msg);
        }
    });
}