<!--Settings-->
<section class="tab-pane fade" id="settings">
	<h1>Settings</h1>
	<div id="settings-content">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#general-settings" data-toggle="tab">
					<i class="fa fa-cog" aria-hidden="true"></i> General
				</a>
			</li>
			<li>
				<a href="#appareance-settings" data-toggle="tab">
					<i class="fa fa-paint-brush" aria-hidden="true"></i> Appareance
				</a>
			</li>
			<li>
				<a href="#account-settings" data-toggle="tab">
					<i class="fa fa-user" aria-hidden="true"></i> Account
				</a>
			</li>
			<li>
				<a href="#database-settings" data-toggle="tab">
					<i class="fa fa-database" aria-hidden="true"></i> Database
				</a>
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
								<input value="<?php echo htmlspecialchars(Settings::getInstance()->getTitle());?>" id="site-title" name="site-title" type="text" placeholder="Site title" class="form-control input-md" />
							</div>
						</div>
						<!--Limits-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="site-limits">Gallery limits</label>
							<div class="col-md-4">
								<input value="<?php echo htmlspecialchars(Settings::getInstance()->getLimit());?>" min="20" max="80" id="site-limits" name="site-limits" type="number" placeholder="Site limits" class="form-control input-md" />
							</div>
						</div>
						<!--Submit-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-general-settings"></label>
							<div class="col-md-4">
								<button id="submit-general-settings" name="submit-general-settings" class="btn btn-success">
									<i class="fa fa-floppy-o" aria-hidden="true"></i> Save
								</button>
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
								<input id="site-logo" name="site-logo" class="input-file" type="file" accept=".png" />
							</div>
						</div>
						<!--Submit-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-logo"></label>
							<div class="col-md-4">
								<button type="submit" id="submit-logo" name="submit-logo" class="btn btn-success">
									<i class="fa fa-upload" aria-hidden="true"></i> Upload
								</button>
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
						<!--Theme-->
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
								<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#newTheme">
									<i class="fa fa-plus" aria-hidden="true"></i> Add new theme
								</button>
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
										<button type="button" id="newTheme-button" class="btn btn-success">
											<i class="fa fa-plus" aria-hidden="true"></i> Add
										</button>
									</div>
								</div>
							</div>
						</div>

						<!--Submit-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-appareance-settings"></label>
							<div class="col-md-4">
								<button id="submit-appareance-settings" name="submit-appareance-settings" class="btn btn-success">
									<i class="fa fa-floppy-o" aria-hidden="true"></i> Save
								</button>
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
								<input value="<?php echo $_SESSION['user'];?>" id="username-settings" placeholder="Enter to change the username" name="username-settings" type="text" class="form-control input-md" />
							</div>
						</div>
						<!-- Mail -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="mail-settings">Adress mail</label>
							<div class="col-md-4">
								<input value="<?php echo $_SESSION['mail'];?>" id="mail-settings" placeholder="Enter to change the mail" name="mail-settings" type="email" class="form-control input-md" />
							</div>
						</div>
						<!-- Password -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="passwordSettings">Password</label>

							<div class="col-md-4">
								<div class="form-group required has-feedback">
									<div class="">
										<input id="passwordSettings" name="passwordSettings" placeholder="Enter to change the password" type="password" class="form-control input-md" />
										<span class="glyphicon form-control-feedback" id="passwordSettingsIcon"></span>
									</div>
								</div>
								<div class="form-group required has-feedback">
									<div class="">
										<input id="password2Settings" name="password2Settings" placeholder="Confirm password" type="password" class="form-control input-md" />
										<span class="glyphicon form-control-feedback" id="password2SettingsIcon"></span>
									</div>
								</div>
							</div>
						</div>
						<!--Submit-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-account-settings"></label>
							<div class="col-md-4">
								<button id="submit-account-settings" name="submit-account-settings" class="btn btn-success">
									<i class="fa fa-floppy-o" aria-hidden="true"></i> Save
								</button>
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
									<strong>Be careful!</strong>All the administrators can modify the content of the application.
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
									<input id="mail-add-admin" placeholder="The email adress to the future administrator" name="mail-add-admin" type="email" class="form-control input-md" />
									<span class="input-group-btn">
										<button id="submit-addAdmin-settings" name="submit-addAdmin-settings" class="btn btn-success" type="button">
											<i class="fa fa-check" aria-hidden="true"></i>
										</button>
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
								<input value="<?php echo DB_HOST;?>" id="database-host-settings" name="database-host-settings" type="text" placeholder="MySQL hosting address" class="form-control input-md" />
							</div>
						</div>
						<!-- Database -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="database-name-settings">Database name</label>
							<div class="col-md-4">
								<input value="<?php echo DB_NAME;?>" id="database-name-settings" name="database-name-settings" type="text" placeholder="Name of the data base" class="form-control input-md" />
							</div>
						</div>
						<!-- Username -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="database-user-settings">Username</label>
							<div class="col-md-4">
								<input value="<?php echo DB_USER;?>" id="database-user-settings" name="database-user-settings" type="text" placeholder="User of the database" class="form-control input-md" />
							</div>
						</div>
						<!-- Password -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="database-pwd-settings">Password</label>
							<div class="col-md-4">
								<input value="<?php echo DB_PASSWORD;?>" id="database-pwd-settings" name="database-pwd-settings" type="password" placeholder="Password of the database" class="form-control input-md" />
							</div>
						</div>
						<!--Submit & export-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-database-settings"></label>
							<div class="col-md-4">
								<button id="submit-database-settings" name="submit-database-settings" class="btn btn-success">
									<i class="fa fa-floppy-o" aria-hidden="true"></i> Save
								</button>
								<button type="button" id="export-database" class="btn">
									<i class="fa fa-download" aria-hidden="true"></i> Export
								</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</section>