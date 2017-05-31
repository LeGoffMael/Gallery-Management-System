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
                <form id="general-settings-form" class="form-horizontal">
                    <fieldset>
                        <legend>General Settings</legend>
                        <div id="div-general-msg">
                            <div class="alert alert-danger msg-error">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span></span>
                            </div>
                            <div class="alert alert-success msg-success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <span></span>
                            </div>
                        </div>
                        <!--Title-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="site-title">Site title</label>
                            <div class="col-md-4">
                                <input value="<?php echo htmlspecialchars(Settings::getInstance()->getTitle());?>" id="site-title" name="site-title" type="text" placeholder="Site title" class="form-control input-md">
                            </div>
                        </div>
                        <!--Limits-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="site-limits">Gallery limits</label>
                            <div class="col-md-4">
                                <input value="<?php echo htmlspecialchars(Settings::getInstance()->getLimit());?>" min="20" max="80" id="site-limits" name="site-limits" type="number" placeholder="Site limits" class="form-control input-md">
                            </div>
                        </div>
                        <!--Language-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="site-language">Language</label>
                            <div class="col-md-4">
                                <input type="hidden" name="currentCountry" id="currentCountry" value="<?php echo htmlspecialchars(Settings::getInstance()->getLanguage());?>">
                                <select class="form-control input-md" id="site-language" name="country"></select>
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
                <form id="appareance-settings-form" class="form-horizontal">
                    <fieldset>
                        <legend>Appareance Settings</legend>
                        <div id="div-theme-msg">
                            <div class="alert alert-danger msg-error">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span></span>
                            </div>
                            <div class="alert alert-success msg-success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <span></span>
                            </div>
                        </div>
                        <!--theme-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="private-theme">Theme</label>
                            <div class="col-md-8 themes">
                                <?php
                                    foreach(Settings::getInstance()->getThemes() as $index => $theme) {
                                        if($theme == Settings::getInstance()->getTheme())
                                            echo "<label for='private-theme-".str_replace(' ', '-', $theme[1])."'><input type='radio' name='private-theme-".str_replace(' ', '-', $theme[1])."' id='private-theme-".str_replace(' ', '-', $theme[1])."' class='colored-radio' data-color='".$theme[6]."' value='".$theme[0]."' checked='checked'>".$theme[1]."</label>";
                                        else
											echo "<label for='private-theme-".str_replace(' ', '-', $theme[1])."'><input type='radio' name='private-theme-".str_replace(' ', '-', $theme[1])."' id='private-theme-".str_replace(' ', '-', $theme[1])."' class='colored-radio' data-color='".$theme[6]."' value='".$theme[0]."'>".$theme[1]."</label>";
                                    }
                                ?>
								<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#newTheme"><i class="fa fa-plus" aria-hidden="true"></i> Add new theme</button>
                            </div>
                        </div>

						<!-- Modal new theme-->
						<div id="newTheme" class="modal fade" role="dialog">
						  <div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Custom theme</h4>
								</div>
								<div class="modal-body form-horizontal">
									<div id="newTheme-form">
										<div class="alert alert-danger msg-error">
											<i class="fa fa-times" aria-hidden="true"></i>
											<span></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4" for="name-newTheme">Theme name</label>
										<div class="col-md-8">
											<input id="name-newTheme" class="form-control" name="name-newTheme" type="text" required />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-6" for="mainColor-newTheme">Main color</label>
										<div class="col-md-6">
											<input id="mainColor-newTheme" class="form-control" name="mainColor-newTheme" type="color" required />
										</div>		
									</div>
									<div class="form-group">
										<label class="col-md-6" for="mainDarkFontColor-newTheme">Main dark font color</label>
										<div class="col-md-6">
											<input id="mainDarkFontColor-newTheme" class="form-control" name="mainDarkFontColor-newTheme" type="color" required />
										</div>		
									</div>	
									<div class="form-group">
										<label class="col-md-6" for="bodyColor-newTheme">Body color</label>
										<div class="col-md-6">
											<input id="bodyColor-newTheme" class="form-control" name="bodyColor-newTheme" type="color" required />
										</div>		
									</div>	
									<div class="form-group">
										<label class="col-md-6" for="bodyFontColor-newTheme">Body font color</label>
										<div class="col-md-6">
											<input id="bodyFontColor-newTheme" class="form-control" name="bodyFontColor-newTheme" type="color" required />
										</div>		
									</div>	
									<div class="form-group">
										<label class="col-md-6" for="sideBarColor-newTheme">Side bar color</label>
										<div class="col-md-6">
											<input id="sideBarColor-newTheme" class="form-control" name="sideBarColor-newTheme" type="color" required />
										</div>
									</div>	
									<div class="form-group">
										<label class="col-md-6" for="sideBarFontColor-newTheme">Side bar font color</label>
										<div class="col-md-6">
											<input id="sideBarFontColor-newTheme" class="form-control" name="sideBarFontColor-newTheme" type="color" required />
										</div>		
									</div>	
									<div class="form-group">
										<label class="col-md-6" for="linkColor-newTheme">Link color</label>
										<div class="col-md-6">
											<input id="linkColor-newTheme" class="form-control" name="linkColor-newTheme" type="color" required />
										</div>		
									</div>	
									<div class="form-group">
										<label class="col-md-6" for="linkHoverColor-newTheme">Link hover color</label>
										<div class="col-md-6">
											<input id="linkHoverColor-newTheme" class="form-control" name="linkHoverColor-newTheme" type="color" required />
										</div>		
									</div>						
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="button" id="newTheme-button" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
								</div>
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
                <form id="account-settings-form" class="form-horizontal">
                    <fieldset>
                        <legend>Account Settings</legend>
						 <div id="div-account-msg">
                            <div class="alert alert-danger msg-error">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span></span>
                            </div>
                            <div class="alert alert-success msg-success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <span></span>
                            </div>
                        </div>
                        <!-- Username -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="username-settings">Username</label>
                            <div class="col-md-4">
                                <input value="<?php echo $_SESSION['user'];?>" id="username-settings" placeholder="Enter to change the username" name="username-settings" type="text" class="form-control input-md">
                            </div>
                        </div>
                        <!-- Mail -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="mail-settings">Adress mail</label>
                            <div class="col-md-4">
                                <input value="<?php echo $_SESSION['mail'];?>" id="mail-settings" placeholder="Enter to change the mail" name="mail-settings" type="email" class="form-control input-md">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="passwordSettings">Password</label>

                            <div class="col-md-4">
                                <div class="form-group required has-feedback">
                                    <div class="">
                                        <input id="passwordSettings" name="passwordSettings" placeholder="Enter to change the password" type="password" class="form-control input-md">
                                        <span class="glyphicon form-control-feedback" id="passwordSettingsIcon"></span>
                                    </div>
                                </div>
                                <div class="form-group required has-feedback">
                                    <div class="">
                                        <input id="password2Settings" name="password2Settings" placeholder="Confirm password" type="password" class="form-control input-md">
                                        <span class="glyphicon form-control-feedback" id="password2SettingsIcon"></span>
                                    </div>
                                </div>
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
                <form id="addAdmin-form" class="form-horizontal">
                    <fieldset>
                        <legend>Add an administrator</legend>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-md-offset-3" id="add-admin">
                                <div class="alert alert-danger">
                                    <strong>Be careful!</strong> All the administrators can modify the content of the application.
                                </div>
                                <div id="div-account-msg">
                                    <div class="alert alert-danger msg-error">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                    <div class="alert alert-success msg-success">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input id="mail-add-admin" placeholder="The email adress to the future administrator" name="mail-add-admin" type="email" class="form-control input-md">
                                    <span class="input-group-btn">
                                        <button  id="submit-addAdmin-settings" name="submit-addAdmin-settings" class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <!--Database-->
            <div class="tab-pane" id="database-settings">
                <form id="database-settings-form" class="form-horizontal">
                    <fieldset>
                        <legend>Database Settings</legend>
                        <div id="div-database-msg">
                            <div class="alert alert-danger msg-error">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span></span>
                            </div>
                            <div class="alert alert-success msg-success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <span></span>
                            </div>
                        </div>
                        <!-- Host name -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="database-host-settings">Database host</label>
                            <div class="col-md-4">
                                <input value="<?php echo DB_HOST;?>" id="database-host-settings" name="database-host-settings" type="text" placeholder="MySQL hosting address" class="form-control input-md">
                            </div>
                        </div>
                        <!-- Database -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="database-name-settings">Database name</label>
                            <div class="col-md-4">
                                <input value="<?php echo DB_NAME;?>" id="database-name-settings" name="database-name-settings" type="text" placeholder="Name of the data base" class="form-control input-md">
                            </div>
                        </div>
                        <!-- Username -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="database-user-settings">Username</label>
                            <div class="col-md-4">
                                <input value="<?php echo DB_USER;?>" id="database-user-settings" name="database-user-settings" type="text" placeholder="User of the database" class="form-control input-md">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="database-pwd-settings">Password</label>
                            <div class="col-md-4">
                                <input value="<?php echo DB_PASSWORD;?>" id="database-pwd-settings" name="database-pwd-settings" type="password" placeholder="Password of the database" class="form-control input-md">
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