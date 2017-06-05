<?php
	require_once('php/Settings.php');
	session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo htmlspecialchars(Settings::getInstance()->getTitle());?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="images/logo/logo.png" />
    <link rel="stylesheet" href="css/libs/bootstrap/css/bootstrap.min.css"/>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <link rel="stylesheet" href="css/libs/flagIcon/flag-icon.min.css" />
  	<link rel="stylesheet/less" type="text/css" href="css/style.less" />
  	<link rel="stylesheet/less" type="text/css" href="css/nav.less" />
  	<link rel="stylesheet/less" type="text/css" href="css/loginModal.less" />
  	<link rel="stylesheet/less" type="text/css" href="css/gallery.less" />
  	<link rel="stylesheet/less" type="text/css" href="css/categories.less" />
  	<link rel="stylesheet/less" type="text/css" href="css/settings.less" />
  	<link rel="stylesheet/less" type="text/css" href="css/admin.less" />
  </head>
<body>
    <!--Main content-->
    <div class="wrapper">
        <!-- The left navigation -->
        <div class="sidebar">
                <!-- Reduction button -->
                <div class="button sidebar-toggle text-right"><a><i class="fa fa-caret-left fa-2x"></i></a></div>

                <div id="logo" class="text-center">
                    <p id="home-link"><img class="logo" src="images/logo/logo.png" alt="Logo" /></p>
                </div>

                <!-- Search -->
                <form id="search-form" class="form-search form-horizontal">
                    <div class="input-append">
                        <input type="text" class="search-input" placeholder="Search...">
                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                    </div>
                </form>

                <ul class="nav sidebar-nav">

                    <!-- Search reduced -->
                    <li id="little-search">
                        <a data-toggle="dropdown" href="#"><i class="fa fa-search"></i></a>

                        <ul class="dropdown-menu">
                            <li>
                                <form id="search-form" class="form-search form-horizontal">
                                    <div class="input-append">
                                        <input type="text" class="search-input" placeholder="Search...">
                                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <!-- Links -->
                    <li class="active" data-toggle="tooltip" id="nav-home" data-placement="right" title="Home"><a class="menuLink" href="#home" data-toggle="tab"><i class="fa fa-home"></i> <span>Home</span></a></li>
                    <li data-toggle="tooltip" id="nav-top" data-placement="right" title="Top"><a class="menuLink" href="#top" data-toggle="tab"><i class="fa fa-thumbs-up"></i> <span>Top</span></a></li>
                    <li data-toggle="tooltip" id="nav-categ" data-placement="right" title="Categories"><a class="menuLink" href="#categories" data-toggle="tab"><i class="fa fa-bookmark"></i> <span>Categories</span></a></li>

                    <li class="nav-divider" id="firstDivider"></li>

					<?php
                    if (!empty($_SESSION['id'])) {
						//If the user isn't logged
						echo '<li data-toggle="tooltip" id="nav-settings" class="nav-log" data-placement="right" title="Settings"><a class="menuLink" href="#settings" data-toggle="tab"><i class="fa fa-cogs"></i> <span>Settings</span></a></li>
							  <li data-toggle="tooltip" id="nav-admin" class="nav-log"  data-placement="right" title="Administration"><a class="menuLink" href="#admin" data-toggle="tab"><i class="fa fa-wrench"></i> <span>Administration</span></a></li>

							  <li class="nav-divider"></li>

							  <!--Connexion/Deconnexion-->

						      <li data-toggle="tooltip" id="nav-logout" data-placement="right" title="Logout"><a href="php/session/logout.php"><i class="fa fa-sign-out"></i> <strong><span>Logout</span></strong></a></li>';
                    } else {
						//If the user is logged
						echo '<li data-toggle="tooltip" id="nav-login" data-placement="right" title="Login"><a href="#" data-target="#login-modal" data-toggle="modal"><i class="fa fa-sign-in"></i> <strong><span>Login</span></strong></a></li>';
                    }
                    ?>

                </ul>

                <a href="#" id="contact" data-target="#contact-modal" data-toggle="modal"><small>Contact</small></a>
            </div>
        
        <!-- The differents menu areas -->
        <div class="main">
            <div class="tab-content">
                <!-- Home -->
                <section class="tab-pane active" id="home">
					<h1>Latest</h1>
                    <div class="galleryLatest"></div>
                </section>
                <!-- Top -->
                <section class="tab-pane fade" id="top">
					<h1>Top</h1>
                    <div class="galleryTop"></div>
                </section>
                <!-- Categories -->
                <section class="tab-pane fade" id="categories">
                    <div class="galleryCategories"></div>
                </section>
				<?php
				//If the user is logged
				if (!empty($_SESSION['id'])) {
					include_once('php/includes/settingsArea.php');
					include_once('php/includes/adminArea.php');
				}
                ?>
            </div>
        </div>
    </div>

    <!--Login modal-->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <img class="img-circle" id="img_logo" src="images/logo/logo.png">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div id="div-forms">
                    <form id="login-form">
                        <div class="modal-body">
                            <div id="div-login-msg">
								<div class="alert alert-danger msg-error">
									<i class="fa fa-times" aria-hidden="true"></i>
									<span></span>
								</div>
								<div class="alert alert-success msg-success">
									<i class="fa fa-check" aria-hidden="true"></i>
									<span></span>
								</div>
                            </div>
							<input id="login_username_mail" name="login_username_mail" class="form-control" type="text" placeholder="Username or mail" required />
                            <input id="login_password" name="login_password" class="form-control" type="password" placeholder="Password" required>
                            <div class="checkbox">
                                <label><input type="checkbox"> Remember me</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
								<button class="btn btn-primary btn-lg btn-block" type="button" id="login-button">Login</button>
                            </div>
                            <div>
                                <button id="login_lost_btn" type="button" class="btn btn-link">Lost Password?</button>
                            </div>
                        </div>
                    </form>
                    <form id="lost-form" style="display:none;">
                        <div class="modal-body">
                            <div id="div-login-msg">
								<div class="alert alert-success msg-success">
									<i class="fa fa-check" aria-hidden="true"></i>
									<span></span>
								</div>
								<div class="alert alert-danger msg-error">
									<i class="fa fa-times" aria-hidden="true"></i>
									<span></span>
								</div>
                            </div>
							<input id="lost_mail" name="lost_mail" class="form-control" type="email" placeholder="The e-mail address of your account" required />
                        </div>
                        <div class="modal-footer">
                            <div>
								<button class="btn btn-primary btn-lg btn-block" type="button" id="lost-password-button">Send</button>
                            </div>
                            <div>
                                <button id="lost_login_btn" type="button" class="btn btn-link">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--The Light Box-->
	<div id="pswp" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="pswp__bg"></div>
		<div class="pswp__scroll-wrap">
			<div class="pswp__container">
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
				<div class="pswp__item"></div>
			</div>
			<div class="pswp__ui pswp__ui--hidden">
				<div class="pswp__top-bar">
					<div class="pswp__counter"></div>
					<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
					<button class="pswp__button pswp__button--share" title="Share"></button>
					<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
					<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
					<div class="pswp__preloader">
						<div class="pswp__preloader__icn">
							<div class="pswp__preloader__cut">
								<div class="pswp__preloader__donut"></div>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="pswp__loading-indicator"><div class="pswp__loading-indicator__line"></div></div> -->
				<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
					<div class="pswp__share-tooltip">
						<!-- <a href="#" class="pswp__share--facebook"></a>
                        <a href="#" class="pswp__share--twitter"></a>
                        <a href="#" class="pswp__share--pinterest"></a>
                        <a href="#" download class="pswp__share--download"></a> -->
					</div>
				</div>
				<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
				<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
				<div class="pswp__caption">
					<div class="pswp__caption__center"></div>
				</div>
			</div>
		</div>
	</div>

    <!--Contact modal-->
    <div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" id="label-delete">Contact</h4>
                </div>
                <div class="modal-body">
                    <p>Application developed by <b>Maël Le Goff</b>.<br/>
                    <i>legoffmael@gmail.com</i></p>

                    <p>External links used :</p>
                    <ul>
                        <li><a href="https://mdbootstrap.com/javascript/lightbox/" target="_blank">Gallery</a></li>
                        <li><a href="http://photoswipe.com/" target="_blank">Light box</a></li>
                        <li><a href="http://bootsnipp.com/snippets/featured/modal-login-with-jquery-effects" target="_blank">Login modalbox</a></li>
                        <li><a href="http://bootsnipp.com/snippets/featured/articles-submission-accordion" target="_blank">Admin zone</a></li>
                    </ul>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
    <!-- For the gallery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.3.0/js/mdb.min.js"></script>
    <!-- For the light box -->
    <script src="js/libs/photoSwipe/photoswipe.min.js"></script>
    <script src="js/libs/photoSwipe/photoswipe-ui-default.min.js"></script>
    <!-- Views & controllers -->
    <script src="js/application/application.js"></script>
    <script src="js/controllers/controllerPrincipal.js"></script>
    <script src="js/views/viewPrincipal.js"></script>
	<script src="js/controllers/controllerNav.js"></script>
	<script src="js/views/viewNav.js"></script>
	<script src="js/controllers/controllerSession.js"></script>
	<script src="js/views/viewSession.js"></script>
	<script src="js/controllers/controllerGallery.js"></script>
    <script src="js/views/viewGallery.js"></script>
<?php
if (!empty($_SESSION['id']))
{
?>
	<!-- If the user is logged -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<script src="js/controllers/controllerSettings.js"></script>
	<script src="js/views/viewSettings.js"></script>
	<script src="js/controllers/controllerAdmin.js"></script>
	<script src="js/views/viewAdmin.js"></script>
	<script>
    	Application.admin();
	</script>
<?php
}
?>
</body>
</html>