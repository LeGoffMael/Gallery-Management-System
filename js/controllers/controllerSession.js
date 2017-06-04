/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewSession.ts" />
/// <reference path="controllerPrincipal.ts" />
/**
 * controller of the session
 */
var ControllerSession = (function () {
    /**
     * Constructor
     */
    function ControllerSession() {
        this.viewSession = new ViewSession(this);
    }
    /**
     * Call the script that manages the connection
     */
    ControllerSession.prototype.login = function () {
        $.ajax({
            url: './php/session/login.php',
            type: 'post',
            dataType: 'json',
            data: 'login_username_mail=' + $('input[name=login_username_mail]').val() + '&login_password=' + $('input[name=login_password]').val(),
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("login-form", "success", "Connexion réussie");
                    document.location.reload(true);
                }
                else {
                    ControllerPrincipal.formMsg("login-form", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("login-form", "error", "Internal error.");
            }
        });
    };
    /**
     * Call the password management script
     */
    ControllerSession.prototype.lostPassword = function () {
        $.ajax({
            url: './php/session/lostPassword.php',
            type: 'post',
            dataType: 'json',
            data: 'lost_mail=' + $('input[name=lost_mail]').val(),
            success: function (data) {
                if (data[0] === "success") {
                    ControllerPrincipal.formMsg("lost-form", "success", "E-mail sent, please go to your inbox.");
                }
                else {
                    ControllerPrincipal.formMsg("lost-form", "error", data[1]);
                }
            },
            error: function () {
                ControllerPrincipal.formMsg("lost-form", "error", "Internal error (Check if your server can send mails).");
            }
        });
    };
    return ControllerSession;
}());
