<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Installation</title>
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
    <div class="container" id="install">
        <div style="margin-top:50px" class="form col-md-12 col-md-8 col-md-offset-2 col-lg-4 col-lg-offset-4">
            <div class="panel-heading" align="center">
                <img class="img-circle" onclick="location.href='index.php';" id="img_logo" src="images/logo/logo.png" />
                <div class="panel-title">Installation</div>
            </div>
            <div class="panel-body">
				<div id="welcome">
                    <h1>Hey ! <i class="fa fa-hand-peace-o" aria-hidden="true"></i></h1>
                    <h2>Thank you for downloading Gallery-Management-System.</h2>
					<h2>Are you ready for installation?</h2>
                    <button class="btn btn-primary install-button pull-right">
                        Start <i class="fa fa-check" aria-hidden="true"></i>
                    </button>
				</div>
                <div id="set-db">
                    <button href="install.php?step=1" class="btn btn-primary install-button pull-right">
                        Start <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
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
	<script>
    	$("#welcome button").click(function (e) {
    		$("#install").toggleClass("toggled");
    	});
	</script>
</body>
</html>