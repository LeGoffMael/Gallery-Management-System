<?php
	require_once('php/Settings.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Site gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="images/logo/logo.png" />
    <link rel="stylesheet" href="css/libs/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/libs/flagIcon/flag-icon.min.css" />
    <link rel="stylesheet/less" type="text/css" href="css/style.less"/>
    <link rel="stylesheet/less" type="text/css" href="css/nav.less"/>
    <link rel="stylesheet/less" type="text/css" href="css/loginModal.less"/>
    <link rel="stylesheet/less" type="text/css" href="css/gallery.less"/>
    <link rel="stylesheet/less" type="text/css" href="css/categories.less"/>
    <link rel="stylesheet/less" type="text/css" href="css/settings.less"/>
    <link rel="stylesheet/less" type="text/css" href="css/admin.less"/>
  </head>
<body>
    <!--Main content-->
    <div class="wrapper">
        <!--La nav gauche-->
        <div class="sidebar">
                <!--Bouton de réduction-->
                <div class="button sidebar-toggle text-right"><a><i class="fa fa-caret-left fa-2x"></i></a></div>

                <div id="logo" class="text-center">
                    <p id="home-link"><img class="logo" src="images/logo/logo.png" alt="Name Website"></p>
                </div>

                <!--Recherche-->
                <form id="search-form" class="form-search form-horizontal">
                    <div class="input-append">
                        <input type="text" class="search-input" placeholder="Search...">
                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                    </div>
                </form>

                <ul class="nav sidebar-nav">

                    <!--Recherche retrecie-->
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

                    <!--Liens-->
                    <li class="active" data-toggle="tooltip" id="nav-home" data-placement="right" title="Home"><a href="#home" data-toggle="tab"><i class="fa fa-home"></i> <span>Home</span></a></li>
                    <li data-toggle="tooltip" id="nav-top" data-placement="right" title="Top"><a href="#top" data-toggle="tab"><i class="fa fa-thumbs-up"></i> <span>Top</span></a></li>
                    <li data-toggle="tooltip" onClick="Controleur.setCategories()" id="nav-categ" data-placement="right" title="Categories"><a href="#categories" data-toggle="tab"><i class="fa fa-bookmark"></i> <span>Categories</span></a></li>

                    <li class="nav-divider" id="firstDivider"></li>

                    <!--Persos-->
                    <li data-toggle="tooltip" id="nav-settings" class="nav-log" data-placement="right" title="Settings"><a href="#settings" data-toggle="tab"><i class="fa fa-cogs"></i> <span>Settings</span></a></li>
                    <li data-toggle="tooltip" id="nav-admin" class="nav-log"  data-placement="right" title="Administration"><a href="#admin" data-toggle="tab"><i class="fa fa-wrench"></i> <span>Administration</span></a></li>

                    <li class="nav-divider"></li>

                    <!--Connexion/Deconnexion-->
                    <li data-toggle="tooltip" id="nav-login" data-placement="right" title="Login"><a href="#" data-target="#login-modal" data-toggle="modal"><i class="fa fa-sign-in"></i> <strong><span>Login</span></strong></a></li>
                    <li data-toggle="tooltip" id="nav-logout" data-placement="right" title="Logout"><a href="#home" data-toggle="tab"><i class="fa fa-sign-out"></i> <strong><span>Logout</span></strong></a></li>

                </ul>

                <a href="#" id="contact" data-target="#contact-modal" data-toggle="modal"><small>Contact</small></a>
            </div>
        
        <!--Les différentes zones du menu-->
        <div class="main">
            <div class="tab-content">
                <!--Accueil-->
                <section class="tab-pane active" id="home">
                    <div class="galleryLatest"></div>
                </section>
                <!--Top-->
                <section class="tab-pane fade" id="top">
                    <div class="galleryTop"></div>
                </section>
                <!--Categories-->
                <section class="tab-pane fade" id="categories">
                    <div class="galleryCategories"></div>
                </section>
                <!--Settings-->
                <section class="tab-pane fade" id="settings">
                    <h1>Settings</h1>
                    <div id="settings-content">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#general-settings" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> General</a>
                            </li>
                            <li>
                                <a href="#appareance-settings" data-toggle="tab"><i class="fa fa-paint-brush" aria-hidden="true"></i> Appareance</a>
                            </li>
                            <li>
                                <a href="#account-settings" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Account</a>
                            </li>
                            <li>
                                <a href="#database-settings" data-toggle="tab"><i class="fa fa-database" aria-hidden="true"></i> Database</a>
                            </li>
                        </ul>

                        <div class="tab-content clearfix">
                            <!--General-->
                            <div class="tab-pane active" id="general-settings">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend>General Settings</legend>
                                        <!--Title-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="site-title">Site title</label>
                                            <div class="col-md-4">
                                                <input value="<?php echo Settings::getInstance()->getTitle();?>" id="site-title" name="site-title" type="text" placeholder="Site title" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!--Limits-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="site-limits">Gallery limits</label>
                                            <div class="col-md-4">
                                                <input value="<?php echo Settings::getInstance()->getLimit();?>" min="20" max="80" id="site-limits" name="site-limits" type="number" placeholder="Site limits" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!--Language-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="site-language"><i class="fa fa-globe" aria-hidden="true"></i> Language</label>
                                            <div class="col-md-4">
                                                <select id="site-language" name="site-language" class="selectpicker" data-width="fit">
                                                    <option <?php if( Settings::getInstance()->getLanguage() == "English") echo 'selected';?> data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
                                                    <option <?php if( Settings::getInstance()->getLanguage() == "French") echo 'selected';?> data-content='<span class="flag-icon flag-icon-fr"></span> French'>French</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--Submit-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="submit-general-settings"></label>
                                            <div class="col-md-4">
                                                <button id="submit-general-settings" name="submit-general-settings" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                                <form class="form-horizontal" id="uploadimage" action="" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <legend>Upload logo</legend>
                                        <!--Logo-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="site-logo">Site logo (.png)</label>
                                            <div class="col-md-4">
                                                <input id="site-logo" name="site-logo" class="input-file" type="file" accept=".png">
                                            </div>
                                        </div>
                                        <!--Submit-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="submit-logo"></label>
                                            <div class="col-md-4">
                                                <button type="submit" id="submit-logo" name="submit-logo" class="btn btn-success"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
												<?php
												if(isset($_POST['submit-logo']))
												{	
													//Vérifier si bien uploadé
													if ($_FILES['site-logo']['error'] > 0)
														echo 'Erreur lors du transfert<br/>';
													else
													{
														//Vérifier le format du fichier
														$extensions_valides = array( 'png' ); //liste des formats correctes
														$extension_upload = strtolower(  substr(  strrchr($_FILES['site-logo']['name'], '.')  ,1)  );
														if ( in_array($extension_upload,$extensions_valides) )
														{
															//Déplacer le fichier
															$nom = "images/logo/logo.png";
															$resultat = move_uploaded_file($_FILES['site-logo']['tmp_name'],$nom);
															if ($resultat)
																echo "Transfert réussi";
															else
																echo "Problème lors du tranfert";
														}
														else echo "Le format du fichier doit être un .png";
													}
												}
                                                ?>
											</div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <!--Appareance-->
                            <div class="tab-pane" id="appareance-settings">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend>Appareance Settings</legend>
                                        <!--theme-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="private-theme">Theme</label>
                                            <div class="col-md-4 themes">
                                                <div class="radio-inline">
                                                    <label for="private-theme-dark">
                                                        <input type="radio" name="private-theme" id="private-theme-dark" value="1" checked="checked">
                                                        Dark Theme
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--Submit-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="submit-appareance-settings"></label>
                                            <div class="col-md-4">
                                                <button id="submit-appareance-settings" name="submit-appareance-settings" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <!--Account-->
                            <div class="tab-pane" id="account-settings">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend>Account Settings</legend>
                                        <!-- Username -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="username-settings">Username</label>
                                            <div class="col-md-4">
                                                <input id="username-settings" placeholder="Enter to change the username" name="username-settings" type="text" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!-- Mail -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="mail-settings">Adress mail</label>
                                            <div class="col-md-4">
                                                <input id="mail-settings" placeholder="Enter to change the mail" name="mail-settings" type="email" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!-- Password -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="password-settings">Password</label>
                                            <div class="col-md-4">
                                                <input id="password-settings" name="password-settings" placeholder="Enter to change the password" type="password" class="form-control input-md">

                                                <input id="password2-settings" name="password2-settings" placeholder="Confirm password" type="password" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!--Submit-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="submit-account-settings"></label>
                                            <div class="col-md-4">
                                                <button id="submit-account-settings" name="submit-account-settings" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend>Add an administrator</legend>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6 col-md-offset-3" id="add-admin">
                                                <div class="alert alert-danger">
                                                    <strong>Be careful!</strong> All the administrators can modify the content of the application.
                                                </div>
                                                <div class="input-group">
                                                    <input id="mail-add-admin" placeholder="The email adress to the future administrator" name="mail-add-admin" type="email" class="form-control input-md">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <!--Database-->
                            <div class="tab-pane" id="database-settings">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <legend>Database Settings</legend>
                                        <!-- Host name -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="database-host-settings">Database host</label>
                                            <div class="col-md-4">
                                                <input id="database-host-settings" name="database-host-settings" type="text" placeholder="127.0.0.1" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!-- Database -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="database-name-settings">Database name</label>
                                            <div class="col-md-4">
                                                <input id="database-name-settings" name="database-name-settings" type="text" placeholder="gallery" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!-- Username -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="database-user-settings">Username</label>
                                            <div class="col-md-4">
                                                <input id="database-user-settings" name="database-user-settings" type="text" placeholder="root" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!-- Password -->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="database-pwd-settings">Password</label>
                                            <div class="col-md-4">
                                                <input id="database-pwd-settings" name="database-pwd-settings" type="password" placeholder="" class="form-control input-md">
                                            </div>
                                        </div>
                                        <!--Submit & export-->
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="submit-database-settings"></label>
                                            <div class="col-md-4">
                                                <button id="submit-database-settings" name="submit-database-settings" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                                <button type="button" id="export-database" class="btn"><i class="fa fa-download" aria-hidden="true"></i> Export</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Admin zone-->
                <section class="tab-pane fade" id="admin">
                    <h1>Administration</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion">
                                <!--New picture-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> NEW PICTURE</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" placeholder="The address of the picture" required />
                                                <br />
                                                <textarea class="form-control" placeholder="Description" rows="3"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" id="categorySelection">
                                                    <div class="form-group">
                                                        <label for="category"> Category </label>
                                                        <select class="form-control" id="category" required>
                                                            <option selected disabled>Choose an option</option>
                                                            <option>Sport</option>
                                                            <option>Travel</option>
                                                            <option>Birthday</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="tagsSelection">
                                                    <div class="form-group">
                                                        <label for="tags"> Tags (separated by ;)</label>
                                                        <input type="text" class="form-control" id="tags" placeholder="Tags"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <form class="form form-inline " role="form">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--Edit picture-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> EDIT PICTURE</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="col-md-12" id="edit-image-url">
                                                <div class="input-group">
                                                    <input type="text" id="url-image-input" class="form-control" placeholder="The URL of the image to edit" required />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="edit-image-option">
                                                <div class="col-md-12">
                                                    <textarea class="form-control" placeholder="Description" rows="3"></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" id="categorySelection">
                                                        <div class="form-group">
                                                            <label for="category"> Category </label>
                                                            <select class="form-control" id="category" required>
                                                                <option>Sport</option>
                                                                <option>Travel</option>
                                                                <option>Birthday</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="tagsSelection">
                                                        <div class="form-group">
                                                            <label for="tags"> Tags (separated by ;)</label>
                                                            <input type="text" class="form-control" id="tags" placeholder="Tags" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-record-title="" data-toggle="modal" id="image-delete" data-target="#confirm-delete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                    <button id="cancel-edit-image" class="btn btn-secondary btn-sm">Cancel</button>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--New category-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-bookmark"></i>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTree"> NEW CATEGORY</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" placeholder="Title" required />
                                                <br />
                                                <input type="text" class="form-control" id="categorie-image-url" placeholder="Category's image url" required />
                                            </div>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-6" id="categoryParentSelection">
                                                    <div class="form-group">
                                                        <label for="categoryParent"> Category's parent :</label>
                                                        <select class="form-control" id="categoryParent">
                                                            <option selected disabled>Root</option>
                                                            <option>Sport</option>
                                                            <option>Travel</option>
                                                            <option>Birthday</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="categoryChildSelection">
                                                    <div class="form-group">
                                                        <label for="categoryChild"> Category's childs :</label>
                                                        <select class="form-control" id="categoryChild" multiple>
                                                            <option>Sport</option>
                                                            <option>Travel</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                            <option>Birthday</option>
                                                        </select>
                                                        <small>Hold down the Ctrl button to select multiple options.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <form class="form form-inline " role="form">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--Edit category-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-bookmark"></i>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"> EDIT CATEGORY</a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="col-md-12" id="edit-categorie-name">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="The categorie to edit" required />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="edit-categorie-option">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="Title" required />
                                                    <br />
                                                    <input type="text" class="form-control" id="categorie-image-url" placeholder="Category's image url" required />
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="col-md-6" id="categoryParentSelection">
                                                        <div class="form-group">
                                                            <label for="categoryParent"> Category's parent :</label>
                                                            <select class="form-control" id="categoryParent" required>
                                                                <option>Sport</option>
                                                                <option>Travel</option>
                                                                <option>Birthday</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="categoryChildSelection">
                                                        <div class="form-group">
                                                            <label for="categoryChild"> Category's childs :</label>
                                                            <select class="form-control" id="categoryChild" multiple required>
                                                                <option>Sport</option>
                                                                <option>Travel</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                                <option>Birthday</option>
                                                            </select>
                                                            <small>Hold down the Ctrl button to select multiple options.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" id="categorie-delete" data-record-title="" data-toggle="modal" data-target="#confirm-delete">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                    <button id="cancel-edit-categorie" class="btn btn-secondary btn-sm">Cancel</button>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Edit tags-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"> MANAGE TAGS</a>
                                        </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="col-md-12" id="manage-tag">
                                                <div class="input-group" id="add-tag">
                                                    <input type="text" class="form-control" placeholder="Tag name to add (separated by ;)"/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                                <br/>
                                                <div class="input-group" id="delete-tag">
                                                    <input type="text" class="form-control" placeholder="Tag name to delete (separated by ;)"/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-danger" data-record-title="" data-toggle="modal" data-target="#confirm-delete">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Modal delete-->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="label-delete" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="label-delete">Confirm Delete</h4>
                                </div>
                                <div class="modal-body">
                                    <p>You are about to delete <b><i class="title"></i></b> record, this procedure is irreversible.</p>
                                    <p>Do you want to proceed?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger btn-ok">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
                                <div id="msg-success" class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> Success !</div>
                                <div id="msg-error" class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> Error.</div>
                            </div>
                            <input id="login_username" class="form-control" type="text" placeholder="Username" required>
                            <input id="login_password" class="form-control" type="password" placeholder="Password" required>
                            <div class="checkbox">
                                <label><input type="checkbox"> Remember me</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                            </div>
                            <div>
                                <button id="login_lost_btn" type="button" class="btn btn-link">Lost Password?</button>
                            </div>
                        </div>
                    </form>
                    <form id="lost-form" style="display:none;">
                        <div class="modal-body">
                            <div id="div-login-msg">
                                <div id="msg-success" class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> E-mail sent, please go to your inbox.</div>
                                <div id="msg-error" class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> The e-mail does not match.</div>
                            </div>
                            <input id="lost_email" class="form-control" type="email" placeholder="The e-mail address of your account" required>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
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

    <!--La Light Box-->
    <div id="gallery" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <div class="pswp__caption__center">
                    </div>
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
    	less = { env: 'production' }; //hide less message
	</script>
    <script src="js/libs/less/less.min.js"></script>
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
    <!--Pour la gallerie-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.3.0/js/mdb.min.js"></script>
    <!--Pour la light box-->
    <script src="js/libs/photoSwipe/photoswipe.min.js"></script>
    <script src="js/libs/photoSwipe/photoswipe-ui-default.min.js"></script>
    <!--MVC-->
    <script src="js/application/applications.js"></script>
    <script src="js/controleurs/controleur.js"></script>
    <script src="js/vues/vue.js"></script>
    <script>
        //Lors de chaque changement de taille de l'écrans
    	$(window).resize(function () {
            Vue.initialiserSideBarWidth();
            Vue.initialiserGallery();
        });
        
        //Lorsque l'on reload on retourne à la même zone
        $(function () {
        	var hash = window.location.hash;

        	if (hash.includes('categoryName')) {
        		var newHash = hash.split("?");
        		hash && $('.sidebar-nav li a[href="' + newHash[0] + '"]').tab('show');
        		Controleur.setCategoriesChild(Controleur.getUrlVars().categoryName);
        	}
        	else {
        		hash && $('.sidebar-nav li a[href="' + hash + '"]').tab('show');
        	}

            if (hash == "#home") {
                $('#nav-home').addClass('active');
            }

            $('.sidebar-nav li a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });
    </script>
</body>
</html>