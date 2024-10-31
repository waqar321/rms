<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ABASEEN RMS | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="noindex, follow">
    <link href="<?php echo url_secure('build/css/custom.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url_secure('build/css/login.css') ?>">
    <link href="<?php echo url_secure('vendors/sweet_alert/sweetalert2.min.css') ?>"  rel="stylesheet"/>
    <style>
        .swal2-popup{
            width:25em;
        }
    </style>
</head>
<body class="form-v10">
<div class="page-content">
    <div class="form-v10-content">
        <form id="myform" action="" novalidate="novalidate" data-parsley-validate class="form-horizontal form-label-left form-detail" method="post">

            <div class="form-left">
                <h2 class="logo"><a href="<?php echo url_secure("merchant/login") ?>"><img
                            src="<?php echo url_secure('build/images/logo/logo-removebg-preview.png') ?>" alt=""></a>
                </h2>
                <div class="form-row">
                    <div class="main">
                        <h1 class="text-alignment">
                            <a href="" class="typewrite" data-period="2000" data-type='[ "Welcome To ABASEEN RMS Portal", "Take Your Business To New Heights", "Pakistan Fastest Cash On Delivery Services"]'>
                                <span class="wrap"></span>
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="form-right">
                <h2 style="color: white">ABASEEN RMS <b style="color: #ffca00">ADMIN</b> LOGIN</h2>
                <div class="form-row">
                    <input type="text" class="form-control" placeholder="User ID" required="" name="user_id"/>
                </div>
                <div class="form-row form-row-2">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password"/>
                </div>

                <div class="form-row-last text-alignment">
                    <input type="submit" name="submit-btn" class="register" value="Submit">
                </div>

                <div class="separator">
                    <div class="clearfix"></div>
                    <br/>
                    <div>
                        <h1 class="text-alignment color-code"><?php echo 'ABASEEN RMS'; ?></h1>
                        <p class="text-alignment color-code">©{{date('Y')}} All Rights Reserved. <?php echo 'ABASEEN RMS'; ?>!</p>
                    </div>
                </div>


            </div>
        </form>
    </div>
</div>
<script src="<?php echo url_secure('vendors/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?php echo url_secure('vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo url_secure('build/js/custom.min.js') ?>"></script>
<script src="<?php echo url_secure('vendors/sweet_alert/sweetalert2.all.min.js') ?>" ></script>
<script src="<?php echo url_secure('vendors/validate/jquery.validate.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo url_secure('build/js/ScantumToken.js') ?>"></script>
<script>
    var sw;
    $("#myform").validate({
        errorClass: "danger",
        errorPlacement: function (error, element) {
            error.addClass('w-100').appendTo(element.parent(0));
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            sw = Swal.fire({
                title: 'Auto close after login!',
                // timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        // b.textContent = Swal.getTimerLeft()
                    }, 300)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            });
            var data = $('#myform').serialize();
            $.ajax({
                url: '<?php echo api_url('login'); ?>',
                method: 'POST',
                data:data,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                    if (data && data.status == 1) {
                        saveToken(data.token); //local storage
                        window.location.href = '<?php echo url_secure('dashboard') ?>'
                    } else {
                        var errors = (data.errors) ? data.errors : {};
                        if (Object.keys(errors).length > 0) {

                            var error_key = Object.keys(errors);
                            for (var i = 0; i < error_key.length; i++) {
                                var fieldName = error_key[i];
                                var errorMessage = errors[fieldName];
                                if ($('#' + fieldName).length) {
                                    var element = $('#' + fieldName);
                                    var element_error = `${errorMessage}`;
                                    element.next('.error-container').html(element_error);
                                    element.focus();
                                }
                            }
                        }

                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    var msg = xhr.responseJSON.message;
                    sw.close();
                    Swal.fire(
                        'Error!',
                        'Form submission failed: ' + msg,
                        'error'
                    );
                }
            });
        }
    });


</script>


<script>
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function() {
            that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #ccc}";
        document.body.appendChild(css);
    };
</script>
</body>
</html>
