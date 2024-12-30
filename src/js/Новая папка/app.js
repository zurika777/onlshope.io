/*==============sortirebis statiebis da suratebis===================*/
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


if ($.cookie('select_style') == 'grid')
{
    $("#block__tovar-grid") .show();
    $("#block__tovar-list") .hide();

    $("#style-grid").attr("src","images/icon-grid-red.svg");
    $("#style-list").attr("src","images/icon-list.svg");
} else {
    $("#block__tovar-grid") .hide();
    $("#block__tovar-list") .show();

    $("#style-list").attr("src","images/icon-list-red.svg");
    $("#style-grid").attr("src","images/icon-grid.svg");
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