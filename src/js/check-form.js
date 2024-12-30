$(document).ready(function(){
    $('#form_reg').validate({
        // правила проверки
        rules: {
            "reg_login": {
                required: true,
                minlength: 5,
                maxlength: 15,
                remote: {
                    type: "post",
                    url: "reg/check_login.php"
                }
            },
            "reg_pass": {
                required: true,
                minlength: 7,
                maxlength: 15
            },
            "reg_surname": {
                required: true,
                minlength: 3,
                maxlength: 15
            },
            "reg_name": {
                required: true,
                minlength: 3,
                maxlength: 15
            },
            "reg_patronymic": {
                required: true,
                minlength: 3,
                maxlength: 25
            },
            "reg_email": {
                required: true,
                email: true
            },
            "reg_phone": {
                required: true
            },
            "reg_address": {
                required: true
            },
            "reg_captcha": {
                required: true,
                remote: {
                    type: "post",
                    url: "reg/check_captcha.php"
                }
            }
        },

        // выводим сообщения при нарушении соответствующих правил
        messages: {
            "reg_login": {
                required: "მიუთითეთ ლოგინი!",
                minlength: "5 დან 15 სიმბოლო!",
                maxlength: "От 5 до 15 символов!",
                remote: "ლოგინი დაკავებულია!"
            },
            "reg_pass": {
                required: "მიუთითეთ პაროლი!",
                minlength: "7 დან 15 სიმბოლომდე!",
                maxlength: "7 დან 15 სიმბოლომდე!"
            },
            "reg_surname": {
                required: "მიუთითეთ თქვენი გვარი!",
                minlength: "3 დან 20 სიმბოლომდე!",
                maxlength: "3 დან 20 სიმბოლომდე!"
            },
            "reg_name": {
                required: "მიუთითეთ თქვენი სახელი!",
                minlength: "3 დან 15 სიმბოლომდე!",
                maxlength: "3 დან 15 სიმბოლომდე!"
            },
            "reg_patronymic": {
                required: "მიუთითეთ მამის სახელი!",
                minlength: "3 დან 20 სიმბოლომდე!",
                maxlength: "3 დან 20 სიმბოლომდე!"
            },
            "reg_email": {
                required: "მიუთითეთ თქვენი E-mail!",
                email: "არასწორია E-mail!"
            },
            "reg_phone": {
                required: "მიუთითეთ ტელეფონის ნომერი!"
            },
            "reg_address": {
                required: "აუცილებელია მიუთითოთ მიწოდების ადგილი!"
            },
            "reg_captcha": {
                required: "მიუთითეთ სურათის კოდი!",
                remote: "კოდი არასწორად გაქვთ მითითებულიი!!"
            }
        },
        submitHandler: function(form) {

            $(form).ajaxSubmit({
                method: 'post',
                success: function(data) {
                    if (data == true ){
                        $('#block-form-registration').fadeOut(300, function() {
                            $("#reg_message").addClass("reg_message_good").fadeIn(400).html("თქვენ წარმატებით დარეგისტრირდით!");
                            $("#form_submit").hide();
                        });
                    } else {
                        $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data);
                    }
                }
            });
        }
    });
});