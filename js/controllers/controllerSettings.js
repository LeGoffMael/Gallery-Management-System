/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/jquery.validation.d.ts" />
/// <reference path="controllerPrincipal.ts" />
/// <reference path="../views/viewSettings.ts" />
/**
 * controller of the settings area
 */
var ControllerSettings = (function () {
    /**
    * Constructor
    */
    function ControllerSettings() {
        this.viewSettings = new ViewSettings(this);
        this.initValidate();
    }
    /**
     * Apply jquery validation
     */
    ControllerSettings.prototype.initValidate = function () {
        $(document).ready(function () {
            $('#account-settings-form').validate({
                rules: {
                    passwordSettings: {
                        required: true
                    },
                    password2Settings: {
                        equalTo: "#passwordSettings",
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
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    };
    /**
    * General Settings Form
    */
    ControllerSettings.prototype.submitGeneralSettings = function () {
        var title = $('#site-title').val();
        var limit = $('#site-limits').val();
        $.ajax({
            url: './php/settings/changeSettings.php',
            type: 'POST',
            data: 'title=' + title + '&limit=' + limit,
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("general-settings", "success", "Updated settings.");
                    location.reload();
                }
                else {
                    ControllerPrincipal.formMsg("general-settings", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("general-settings", "error", "Internal error.");
            }
        });
    };
    /**
    * Account Settings Form
    */
    ControllerSettings.prototype.submitAccountSettings = function () {
        var username = $('input[name=username-settings]').val();
        var mail = $('input[name=mail-settings]').val();
        var newPassword = $('input[name=passwordSettings]').val();
        var confirmPassword = $('input[name=password2Settings]').val();
        $.ajax({
            url: './php/settings/updateAccount.php',
            type: 'post',
            dataType: 'json',
            data: 'username=' + username + '&mail=' + mail + '&newPassword=' + newPassword + '&confirmPassword=' + confirmPassword,
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("account-settings", "success", "Updated account");
                }
                else {
                    ControllerPrincipal.formMsg("account-settings", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("account-settings", "error", "Internal error.");
            }
        });
    };
    /**
    * Theme change form
    */
    ControllerSettings.prototype.changeTheme = function () {
        var themeId = $('#appareance-settings input[type="radio"]:checked').val();
        $.ajax({
            url: './php/settings/changeTheme.php',
            type: 'post',
            dataType: 'json',
            data: 'idTheme=' + themeId,
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("appareance-settings", "success", "Updated theme.");
                    location.reload();
                }
                else {
                    ControllerPrincipal.formMsg("appareance-settings", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("appareance-settings", "error", "Internal error.");
            }
        });
    };
    /**
    * Add a new theme in the database
    */
    ControllerSettings.prototype.addTheme = function () {
        var name = $('#newTheme input[id="name-newTheme"]').val();
        var mainColor = $('#newTheme input[id="mainColor-newTheme"]').val();
        var mainDarkFontColor = $('#newTheme input[id="mainDarkFontColor-newTheme"]').val();
        var bodyColor = $('#newTheme input[id="bodyColor-newTheme"]').val();
        var bodyFontColor = $('#newTheme input[id="bodyFontColor-newTheme"]').val();
        var sideBarColor = $('#newTheme input[id="sideBarColor-newTheme"]').val();
        var sideBarFontColor = $('#newTheme input[id="sideBarFontColor-newTheme"]').val();
        var linkColor = $('#newTheme input[id="linkColor-newTheme"]').val();
        var linkHoverColor = $('#newTheme input[id="linkHoverColor-newTheme"]').val();
        $.ajax({
            url: './php/settings/addTheme.php',
            type: 'post',
            dataType: 'json',
            data: 'nameTheme=' + name + '&mainColor=' + mainColor + '&mainDarkFontColor=' + mainDarkFontColor + '&bodyColor=' + bodyColor + '&bodyFontColor=' + bodyFontColor + '&sideBarColor=' + sideBarColor + '&sideBarFontColor=' + sideBarFontColor + '&linkColor=' + linkColor + '&linkHoverColor=' + linkHoverColor,
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("newTheme", "success", "Theme added.");
                    location.reload();
                }
                else {
                    ControllerPrincipal.formMsg("newTheme", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("newTheme", "error", "Internal error.");
            }
        });
    };
    /**
    * Form for adding an admin
    */
    ControllerSettings.prototype.addAdmin = function () {
        var mail = $('input[name=mail-add-admin]').val();
        $.ajax({
            url: './php/settings/addAdmin.php',
            type: 'post',
            dataType: 'json',
            data: 'mail=' + mail,
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("addAdmin", "success", "E-mail sent.");
                }
                else {
                    ControllerPrincipal.formMsg("addAdmin", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("addAdmin", "error", "Internal error.");
            }
        });
    };
    /**
    * Database Settings Form
    */
    ControllerSettings.prototype.changeConfig = function () {
        var name = $('input[name=database-name-settings]').val();
        var user = $('input[name=database-user-settings]').val();
        var password = $('input[name=database-pwd-settings]').val();
        var host = $('input[name=database-host-settings]').val();
        $.ajax({
            url: './php/settings/changeConfig.php',
            type: 'post',
            dataType: 'json',
            data: 'DB_NAME=' + name + '&DB_USER=' + user + '&DB_PASSWORD=' + password + '&DB_HOST=' + host,
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("database-settings", "success", "Updated config.php");
                }
                else {
                    ControllerPrincipal.formMsg("database-settings", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("database-settings", "error", "Internal error.");
            }
        });
    };
    return ControllerSettings;
}());