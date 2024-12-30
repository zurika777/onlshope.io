/*==============sortirebis statiebis da suratebis===================*/
$(document).ready( function() {
    /**
     * Для прокрутки блока новостей
     */
    $("#newsticker").jCarouselLite( {
        vertical: true,
        hoverPause: true,
        btnPrev: "#news-prev",
        btnNext: "#news-next",
        visible: 3,
        auto: 3000,
        speed: 500
    });

loadCart();
$("#style-grid") .click(function () {
    $("#block__tovar-grid") .show();
    $("#block__tovar-list") .hide();
    $("#style-grid").attr("src","images/icon-grid-red.svg");
    $("#style-list").attr("src","images/icon-list.svg");
    $.cookie('select_style','grid');
});
$("#style-list") .click(function () {
    $("#block__tovar-grid") .hide();
    $("#block__tovar-list") .show();
    $("#style-list").attr("src","images/icon-list-red.svg");
    $("#style-grid").attr("src","images/icon-grid.svg");
    $.cookie('select_style','list');
});


    if ($.cookie('select_style') == 'list')
    {

        $("#block__tovar-grid") .hide();
        $("#block__tovar-list") .show();

        $("#style-list").attr("src","images/icon-list-red.svg");
        $("#style-grid").attr("src","images/icon-grid.svg");

    } else {
        $("#block__tovar-grid") .show();
        $("#block__tovar-list") .hide();

        $("#style-grid").attr("src","images/icon-grid-red.svg");
        $("#style-list").attr("src","images/icon-list.svg");
    }

/*==============catalogis===================*/

$(".category-section") .hide();
$('#block-category > ul > li > a').click(function () {
    if ($(this).attr('class') != 'active') {
        $('#block-category > ul > li > ul').slideUp(400);
        $(this).next().slideToggle(400);

        $('#block-category > ul > li > a').removeClass('active');
        $(this).addClass('active');
        $.cookie('select_cat', $(this).attr('id'));
    }else
    {
        $('#block-category > ul > li > a').removeClass('active');
        $('#block-category > ul > li > ul').slideUp(400);
        $.cookie('select_cat', '');
    }
});
if ($.cookie('select_cat') != '')
{
    $('#block-category > ul > li > #'+$.cookie('select_cat')).addClass('active').next().show();
};

/*==============sortirebis listis===================*/
$("#select-sort").click(function () {

    $("#sorting-list").slideToggle(200);

});

/*==============shesvlis ===================*/
$("#reg-auth-title").click(function () {

    $("#block-top-auth").slideToggle(200);

});



$('#genpass').click(function () {
    $.ajax({
        type: "POST",
        url: "functions/genpass.php",
        dataType: "html",
        cache: false,
        success: function (data) {
            $('#reg_pass').val(data);
        }

    });
});

$('#reloadcaptcha').click(function () {
    $('#block-captcha > img') .attr("src","reg/reg_captcha.php?r="+ Math.random());

});

$('.top-auth').toggle(
    function() {
        $(".top-auth").attr("id","active-button");
        $("#block-top-auth").fadeIn(200);
    },
    function() {
        $(".top-auth").attr("id","");
        $("#block-top-auth").fadeOut(200);
    }
);

/*parolis agdgenis */

$('#button-pass-show-hide').click(function(){
    var statuspass = $('#button-pass-show-hide').attr("class");

    if (statuspass == "pass-show")
    {
        $('#button-pass-show-hide').attr("class","pass-hide");

        var $input = $("#auth_pass");
        var change = "text";
        var rep = $("<input placeholder='პაროლი' type='" + change + "' />")
            .attr("id", $input.attr("id"))
            .attr("name", $input.attr("name"))
            .attr('class', $input.attr('class'))
            .val($input.val())
            .insertBefore($input);
        $input.remove();
        $input = rep;

    }else
    {
        $('#button-pass-show-hide').attr("class","pass-show");

        var $input = $("#auth_pass");
        var change = "password";
        var rep = $("<input placeholder='პაროლი' type='" + change + "' />")
            .attr("id", $input.attr("id"))
            .attr("name", $input.attr("name"))
            .attr('class', $input.attr('class'))
            .val($input.val())
            .insertBefore($input);
        $input.remove();
        $input = rep;

    }

});

/*autentificatiis shemocmeba*/

$("#button-auth").click(function() {

    var auth_login = $("#auth_login").val();
    var auth_pass = $("#auth_pass").val();


    if (auth_login == "" || auth_login.length > 30 )
    {
        $("#auth_login").css("borderColor","#FDB6B6");
        send_login = 'no';
    }else {

        $("#auth_login").css("borderColor","#DBDBDB");
        send_login = 'yes';
    }


    if (auth_pass == "" || auth_pass.length > 15 )
    {
        $("#auth_pass").css("borderColor","#FDB6B6");
        send_pass = 'no';
    }else { $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes'; }



    if ($("#rememberme").prop('checked'))
    {
        auth_rememberme = 'yes';

    }else { auth_rememberme = 'no'; }


    if ( send_login == 'yes' && send_pass == 'yes' )
    {
        $("#button-auth").hide();
        $(".auth-loading").show();

        $.ajax({
            type: "POST",
            url: "include/auth.php",
            data: "login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
            dataType: "html",
            cache: false,
            success: function(data) {

                if (data == true )
                {
                    location.reload();

                }else
                {
                    $("#message-auth").slideDown(400);
                    $(".auth-loading").hide();
                    $("#button-auth").show();
                    //alert( "Прибыли данные: "+data);

                }

            }
        });
    }
});


/* parolis agdgena gamochena*/

$('#remind-pass').click(function(){
    $('#input-email-pass').fadeOut(200, function() {
        $('#block-remind').fadeIn(300);
    });
});
$('#prev-auth').click(function(){
    $('#block-remind').fadeOut(200, function(){
        $('#input-email-pass').fadeIn(300);
    }) ;
});


/**
 * motxovnis gagzavna parolis agdgenis damushaveba
 *  ajax-is meshveobit
 */
$('#button-remind').click(function(){
    var recall_email = $("#remind-email").val();
    if (recall_email == "" || recall_email.length > 20 ) {
        $('#remind-email').css("borderColor", "#FDB6B6");
    } else {
        $("#remind-email").css("borderColor", "#DBDBDB");
        $("#button-remind").hide();
        $(".auth-loading").show();

        $.ajax({
            type: "POST",
            url: "include/remind_pass.php",
            data: "email="+recall_email,
            dataType: "html",
            cache: false,
            success: function(data){
                if (data == 1 ) {
                    $(".auth-loading").hide();
                    $("#button-remind").show();
                    $('#message-remind').attr("class","message-remind-success").html("თქვენს E-mail-ზე გამოგეგზავნათ პაროლი.").slideDown(400);
                    setTimeout("$('#message-remind') .html('') .hide(), $('#block-remind') .hide(), $('#input-email-pass') .show()", 3000);

                } else {
                    //alert( "Прибыли данные: "+data);
                    $(".auth-loading").hide();
                    $("#button-remind").show();
                    $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);
                }
            }
        })
    }

});
//profilis gamochena klikze

$('#auth-user-info').click(function(){
    $('#block-user').fadeToggle(100);
});

$('#logout').click(function () {
    $.ajax({
        type: "POST",
        url: "include/logout.php",
        dataType: "html",
        cache: false,
        success: function (data) {
            if (data == 'logout')
            {
                location.reload();
            }

        }
    });

});

/*siis gamochena serchis dzebnis dros*/

$('#input-search').bind('textchange', function(e){
    e.preventDefault();
    var input_search = $('#input-search').val();

    if (input_search.length >= 2 && input_search.length < 60) {
        $.ajax({
            type: 'POST',
            url: 'include/search.php',
            data: 'text='+input_search,
            dataType: 'html',
            cache: false,
            success: function(data) {
                if (data > '') {
                    $('#result-search').show().html(data);
                } else {
                    $('#result-search').hide();
                }
            }
        });
    } else {
        $('#result-search').hide();
    }
});

//kontaqtis monacemebis
function isValidEmail($email) {
    var pattern = new RegExp(/^[-a-z0-9_\.]+@[-a-z0-9_\.]+\.[a-z]{2,6}$/i);
    return pattern.test($email);
}

$('#confirm-button-next').click(function(e) {

    var order_fio = $("#order_fio").val();
    var order_email = $("#order_email").val();
    var order_phone = $("#order_phone").val();
    var order_address = $("#order_address").val();
    var send_order_error = "";

    // Проверка способа доставки
    if (!$(".order_delivery").is(":checked")) {
        $(".label_delivery").css('color', '#E07B7B');
           send_order_delivery = '0';
//        send_order_error = 'error';
    } else {
        $(".label_delivery").css('color','#000000');
//            send_order_delivery = '1';
    }
    // Проверка фамилии
    if (order_fio == "" || order_fio.length > 50) {
        $("#order_fio").css('borderColor', '#FDB6B6');
//            send_order_fio = '0';
        send_order_error = 'error';
    } else {
        $('#order_fio').css('borderColor','#DBDBDB');
//            send_order_fio = '1';
    }
    // Проверка email
    if (order_email == "" || isValidEmail(order_email) == false) {
        $('#order_email').css('borderColor','#FDB6B6');
//            send_order_email = '0';
        send_order_error = 'error';
    } else {
        $('#order_email').css('borderColor','#DBDBDB');
//            send_order_email = '1';
    }
    // Проверка телефона
    if (order_phone == "" || order_phone.length > 50) {
        $('#order_phone').css('borderColor','#FDB6B6');
//            send_order_phone = '0';
        send_order_error = 'error';
    } else {
        $('#order_phone').css('borderColor', '#DBDBDB');
//            send_order_phone = '1';
    }
    // Проверка адреса
    if (order_address == "" || order_address.length > 150) {
        $('#order_address').css('borderColor', '#FDB6B6');
//            send_order_address = '0';
        send_order_error = 'error';
    } else {
        $('#order_address').css('borderColor', '#DBDBDB');
//            send_order_address = '1';
    }
    // Если нет ошибки, то отправляем форму
    if( send_order_error.indexOf('error') === -1) {
        return true;
    }
    e.preventDefault();
});


// nivtis damateba kalatashi

$('.add__cart-style-list, .add__cart-style-grid, .add-cart, .random-add-cart').click(function(e){
    e.preventDefault();
    var tid = $(this).attr("tid");
    $.ajax({
        type: "POST",
        url: "include/addtocart.php",
        data: "id="+tid,
        dataType: "html",
        cache: false,
        success: function(data){

            loadCart();

        }
    });
});

function loadCart() {
    $.ajax({
        type: "POST",
        url: "include/loadcart.php",
        dataType: "html",
        cache: false,
        success: function(data) {
            if (data == "0") {

                $("#block-basket > a").html("კალათა ცარიელია");
            } else {
                $("#block-basket > a").html(data);
   //               $('.itog-price > strong').html(groupPrice(itogprice));
            }
        }
    });
}


//fun_group_price
function fun_group_price(intprice) {
    var result_total = String(intprice);
    var lenstr = result_total.length;

    switch (lenstr) {
        case 4: {
            groupPrice = result_total.substring(0, 1)+" "+result_total.substring(1, 4);
            break;
        }
        case 5: {
            groupPrice = result_total.substring(0, 2)+" "+result_total.substring(2, 5);
            break;
        }
        case 6: {
            groupPrice = result_total.substring(0, 3)+" "+result_total.substring(3, 6);
            break;
        }
        case 7: {
            groupPrice = result_total.substring(0, 1)+" "+result_total.substring(1, 4)+" "+result_total.substring(4, 7);
            break;
        }
        default: {
            groupPrice = result_total;
        }
    }
    return groupPrice;
}


function groupPrice(value) {
    var value = String(value);
    // \B - находит не границу слов, антоним \b
    // x(?=y) - находит x, только если за x следует y
    // x(!y) - находит x, только если за x не следует y
    // (:x) - находит x, но не запоминает
    // g - глобальный поиск(обрабатываются все совпадения)
    return  value.replace(/\B(?=(?:\d{3})+(?!\d))/g,' ');
}

//nivtebis shemcireba
$('.count-minus').click(function() {
    var iid = $(this).attr("iid");
    $.ajax({
        type: "POST",
        url: "include/count_minus.php",
        data: "id="+iid,
        dataType: "html",
        cache: false,
        success: function(data) {
            $("#input-id"+iid).val(data);
            loadCart();

            var priceproduct = $("#tovar"+iid+" > p").attr("price");
                result_total = Number(priceproduct) * Number(data);

            $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" ლარი");
            $("#tovar"+iid+" > h5 > .span-count").html(data);
            itog_price();
        }
    });
});

//nivtebis momateba

$('.count-plus').click(function(){
    var iid = $(this).attr("iid");
    $.ajax({
        type: "POST",
        url: "include/count_plus.php",
        data: "id="+iid,
        dataType: "html",
        cache: false,
        success: function(data) {
            $("#input-id"+iid).val(data);
            loadCart();

            var priceproduct = $("#tovar"+iid+" > p").attr("price");
                result_total = Number(priceproduct) * Number(data);

            $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" ლარი");
            $("#tovar"+iid+" > h5 > .span-count").html(data);
            itog_price();
        }

    });
});

//enteris dacheraze
$('.count-input').keypress(function(e){
    if (e.keyCode==13) {
        var iid = $(this).attr("iid");
        var incount = $("#input-id"+iid).val();

        $.ajax({
            type: "POST",
            url: "include/count_input.php",
            data: "id="+iid+"&count="+incount,
            dataType: "html",
            cache: false,
            success: function(data) {
                $("#input-id"+iid).val(data);
                loadCart();

                var priceproduct = $("#tovar"+iid+" > p").attr("price");
                    result_total = Number(priceproduct) * Number(data);

                $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" ლარი");
                $("#tovar"+iid+" > h5 > .span-count").html(data);
                itog_price();
            }
        });
    }
});

//itog prais
function itog_price(){
    $.ajax({
        type: "POST",
        url: "include/itog_price.php",
        dataType: "html",
        cache: false,
        success: function(data) {
            $(".itog-price > strong").html(data);
        }
    });
}

/**
 * forma otzivis
 */
$('#button-send-review').click(function(){
    var name = $('#name_review').val(),
        good = $('#good_review').val(),
        bad = $('#bad_review').val(),
        comment = $('#comment_review').val(),
        iid = $('#button-send-review').attr('iid'),
        name_review = '',
        good_review = '',
        bad_review = '',
        comment_review = '';

    if (name != "") {
        name_review = '1';
        $('#name_review').css('borderColor', "#DBDBDB");
    } else {
        name_review = "0";
        $('#name_review').css('borderColor', '#FDB6B6');
    }
    if (good != "") {
        good_review = '1';
        $('#good_review').css('borderColor', "#DBDBDB");
    } else {
        good_review = "0";
        $('#good_review').css('borderColor', '#FDB6B6');
    }
    if (bad != "") {
        bad_review = '1';
        $('#bad_review').css('borderColor', "#DBDBDB");
    } else {
        bad_review = "0";
        $('#bad_review').css('borderColor', '#FDB6B6');
    }
    if (name_review == '1' && good_review == '1' && bad_review == '1') {
        $('#button-send-review').hide();
        $('#reload-img').show();

        $.ajax({
            type: 'POST',
            url: 'include/add_review.php',
            data: 'id='+iid+'&name='+name+'&good='+good+'&bad='+bad+'&comment='+comment,
            dataType: 'html',
            cache: false,
            success: function(){
                setTimeout('$.fancybox.close()', 1000);
            }
        });
    }
});

/**
 * like"
 */
$('#likegood').click(function(){
    var tid = $(this).attr('tid');

    $.ajax({
        type: 'POST',
        url: 'include/like.php',
        data: 'id='+tid,
        dataType: 'html',
        cache: false,
        success: function(data) {
            if (data == 'no') {
                alert('თქვენ უკვე მოიწონეთ!');
            } else {
                $('#likegoodcount').html(data);
            }
        }
    });
});
});