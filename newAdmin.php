<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>New Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="images/logo/logo.png" />
    <link rel="stylesheet" href="css/libs/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/libs/flagIcon/flag-icon.min.css" />
    <link rel="stylesheet/less" type="text/css" href="css/style.less" />
    <link rel="stylesheet/less" type="text/css" href="css/secondaryPage.less" />
</head>
<body>
    <div class="container">
        <div style="margin-top:50px" class="form col-md-12 col-md-8 col-md-offset-2 col-lg-4 col-lg-offset-4">
            <div class="panel-heading" align="center">
                <img class="img-circle" onclick="location.href='index.php';" id="img_logo" src="images/logo/logo.png" />
<?php
if (isset($_GET['hash']))
{
?>
                <div class="panel-title">New Admin</div>
            </div>
            <div class="panel-body">
                <form method="post" id="newAdmin-form" class="form-horizontal">
                    <div id="div-newAdmin-msg">
                        <div class="alert alert-danger msg-error">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <span></span>
                        </div>
                        <div class="alert alert-success msg-success">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <span></span>
                        </div>
                    </div>
                    <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>" />
                    <div class="form-group required has-feedback">
                        <div class="controls col-md-12  col-lg-12">
                            <input class="input-md textinput textInput form-control" id="username" name="username" placeholder="Username" type="text" />
                            <span class="glyphicon form-control-feedback" id="usernameIcon"></span>
                        </div>
                    </div>
                    <div class="form-group required has-feedback">
                        <div class="controls col-md-12  col-lg-12">
                            <input class="input-md textinput textInput form-control" id="newPassword" name="newPassword" placeholder="New password" type="password" />
                            <span class="glyphicon form-control-feedback" id="newPasswordIcon"></span>
                        </div>
                    </div>
                    <div class="form-group required has-feedback">
                        <div class="controls col-md-12  col-lg-12">
                            <input class="input-md textinput textInput form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" type="password" />
                            <span class="glyphicon form-control-feedback" id="confirmPasswordIcon"></span>
                        </div>
                    </div>

                    <div class="controls col-md-12 text-center">
                        <input type="button" value="Reset" class="btn btn-primary btn btn-info" onclick="resetPassword();" id="submit-id-signup" />
                    </div>
                    <div>
                        <button id="linkWebsite" type="button" onclick="location.href='index.php';" class="btn btn-link">← Return to galleries</button>
                    </div>
                </form>
<?php
}
else {
?>
                <div class="panel-title">Error: no data</div>
            </div>
<?php
}
?>
        </div>
    </div>
    </div>       
    <!-- SCRIPTS -->
    <script>
    		less = {
    			env: 'production', //hide less message
    		};
    </script>
    <script src="js/libs/less/less.min.js"></script>
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<?php
	if (isset($_GET['hash']))
	{
    ?>
		<script>
        	function resetPassword() {
        		$.ajax({
        			url: './php/pages/newAdmin.php',
        			type: 'post',
        			dataType: 'json',
        			data: 'hash=' + $('input[name=hash]').val() + '&username=' + $('input[name=username]').val() + '&mail=' + $('input[name=mail]').val() + '&newPassword=' + $('input[name=newPassword]').val() + '&confirmPassword=' + $('input[name=confirmPassword]').val(),
        			success: function (data) {
        				if (data[0] === "success") {
        					formMsg("newAdmin", "success", "Your account is ready.");
        				} else {
        					formMsg("newAdmin", "error", data[1]);
        				}
        			},
        			error: function () {
        				formMsg("newAdmin", "error", "Internal error.");
        			}
        		});
        	}

        	function formMsg(form, type, msg) {
        		if (type == 'success') {
        			$("#" + form + "-form .msg-error").css('display', 'none');
        			$("#" + form + "-form .msg-success span").html(msg);
        			$("#" + form + "-form .msg-success").css('display', 'block');
        			$("#div-forms").css("height", $("#" + form + "-form").height());
        		}
        		else if (type == 'error') {
        			$("#" + form + "-form .msg-success").css('display', 'none');
        			$("#" + form + "-form .msg-error span").html("  " + msg);
        			$("#" + form + "-form .msg-error").css('display', 'block');
        			$("#div-forms").css("height", $("#" + form + "-form").height());
        		}
        	}

        	$( document ).ready(function() {
        		$('form').validate({
        			rules: {
        				user: {
        					required: true
        				},
        				newPassword: {
        					required: true
        				},
        				confirmPassword: {
        					equalTo: "#newPassword",
        					required: true
        				}
        			},
        			highlight: function (element) {
        				var id_attr = "#" + $(element).attr("id") + "Icon";
        				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        				$(id_attr).removeClass('glyphicon-ok').addClass('glyphicon-remove');
        			},
        			unhighlight: function (element) {
        				var id_attr = "#" + $(element).attr("id") + "Icon";
        				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        				$(id_attr).removeClass('glyphicon-remove').addClass('glyphicon-ok');
        			},
        			errorElement: 'span',
        			errorClass: 'help-block',
        			errorPlacement: function (error, element) {
        				if (element.length) {
        					error.insertAfter(element);
        				} else {
        					error.insertAfter(element);
        				}
        			}
        		});
        	});
		</script>
<?php
	}
?>
</body>
</html>