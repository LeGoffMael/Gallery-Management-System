/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewSession.ts" />
/// <reference path="controllerPrincipal.ts" />
/// <reference path="../application/application.ts" />
/**
 * controller of the session
 */
var ControllerSession = (function () {
    /**
     * Constructor
     */
    function ControllerSession(application) {
        this.application = application;
        this.viewSession = new ViewSession(this);
    }
    /**
     * Call the script that manages the connection
     */
    ControllerSession.prototype.login = function () {
        var that = this;
        $.ajax({
            url: './php/session/login.php',
            type: 'post',
            dataType: 'json',
            data: 'login_username_mail=' + $('input[name=login_username_mail]').val() + '&login_password=' + $('input[name=login_password]').val(),
            success: function (data) {
                if (data[0] === "success") {
                    that.application.getControllerPrincipal().formMsg("login-form", "success", "Connexion réussie");
                    document.location.reload(true);
                }
                else {
                    that.application.getControllerPrincipal().formMsg("login-form", "error", data[1]);
                }
            },
            error: function () {
                that.application.getControllerPrincipal().formMsg("login-form", "error", "Internal error.");
            }
        });
    };
    /**
     * Call the password management script
     */
    ControllerSession.prototype.lostPassword = function () {
        var that = this;
        $.ajax({
            url: './php/session/lostPassword.php',
            type: 'post',
            dataType: 'json',
            data: 'lost_mail=' + $('input[name=lost_mail]').val(),
            success: function (data) {
                if (data[0] === "success") {
                    that.application.getControllerPrincipal().formMsg("lost-form", "success", "E-mail sent, please go to your inbox.");
                }
                else {
                    that.application.getControllerPrincipal().formMsg("lost-form", "error", data[1]);
                }
            },
            error: function () {
                that.application.getControllerPrincipal().formMsg("lost-form", "error", "Internal error (Check if your server can send mails).");
            }
        });
    };
    return ControllerSession;
}());
