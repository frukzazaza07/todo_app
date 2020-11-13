<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKC</title>
    <?php include('../component/header.php');  ?>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body style="margin: 0; padding: 0;">
    <div class="container-login" style="background-color: #FEFEFE; width: 400px; height: 456px; margin: 100px auto;  box-shadow: 0 0 10px #ECECEC;">
        <header style="padding-top: 20px;">
            <div class="head-logo" style="display: flex; justify-content: center;">
                <img src="../component/img/kkc.png" style="width: 244px; height: 150px;">
            </div>
        </header>
        <article>
            <form action="" onsubmit="return false">
                <div class="alert alert-danger" role="alert" id="alert-login" style="display:  none;"></div>
                <div class="col-12 mt-4">
                    <label class="sr-only" for="username">Username</label>
                    <div class="input-group" id="input-username">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-portrait" style="font-size: 20px;"></i></div>
                        </div>
                        <input type="text" class="form-control form-control-lg" id="username" placeholder="Username">
                    </div>
                    <small class="text-danger" id="info_username"></small>
                </div>
                <div class="col-12 mt-3">
                    <label class="sr-only" for="password">Passowrd</label>
                    <div class="input-group" id="input-password">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-pen"></i></div>
                        </div>
                        <input type="password" class="form-control form-control-lg" id="password" placeholder="Password">
                    </div>
                    <small class="text-danger" id="info_password"></small>
                </div>
                <div class="col-12 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember_me">
                        <label class="form-check-label" for="remember_me">Remember Me</label>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="confirm_login">Login</button>
                </div>
            </form>
        </article>
        <footer>

        </footer>
    </div>
</body>
<?php include('../component/footer.php');  ?>
<script>
    $('#confirm_login').click(function() {
        let username = document.querySelector('#username').value;
        let password = document.querySelector('#password').value;
        if (username == '') {
            $('#input-username').css('border', '1px solid red');
            $('#input-username').css('box-shadow', '0 0 2px red');
            $('#info_username').show();
            $('#info_username').text('ระบุ Username!');
        } else {
            $('#input-username').css('border', 'none');
            $('#input-username').css('box-shadow', 'none');
            $('#info_username').hide();
        }
        if (password == '') {
            $('#input-password').css('border', '1px solid red');
            $('#input-password').css('box-shadow', '0 0 2px red');
            $('#info_password').show();
            $('#info_password').text('ระบุ Password!');
        } else {
            $('#input-password').css('border', 'none');
            $('#input-password').css('box-shadow', 'none');
            $('#info_password').hide();
        }
        if (username != '' && password != '') {
            let JSONCreate_tricket = {
                username: username,
                password: password
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONCreate_tricket);
            $.ajax({
                url: 'login-engine/select-login.php',
                type: "post",
                data: {
                    json: jsonData
                },
                beforeSend: function() {
                    $('#confirm_login').text('Loading..')
                },
                success: function(res) {
                    //#errorRegister_email
                    let data = JSON.parse(res);
                    // console.log(data);
                    if (data.success != 1) {
                        setTimeout(function() {
                            $('#confirm_login').text('Login');
                            $('#alert-login').show();
                            $('#alert-login').text(data.message);
                        }, 500);

                    } else {
                        let location_index = '../index.php';
                        location.href = location_index;
                    }
                }

            });
        }
    });
</script>

</html>