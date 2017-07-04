/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../controllers/controllerPrincipal.ts" />
/// <reference path="../controllers/controllerNav.ts" />
/// <reference path="../controllers/controllerGallery.ts" />
/// <reference path="../controllers/controllerSession.ts" />
/// <reference path="../controllers/controllerSettings.ts" />
/// <reference path="../controllers/controllerAdmin.ts" />
/**
 * Represents the running Web application
 */
var Application = (function () {
    /**
     * Initialization of all controllers
     */
    function Application() {
        this.controllerGallery = new ControllerGallery(this);
        this.controllerPrincipal = new ControllerPrincipal(this);
        this.controllerNav = new ControllerNav(this);
        this.controllerSession = new ControllerSession(this);
        this.controllerSettings = new ControllerSettings(this);
        this.controllerAdmin = new ControllerAdmin(this);
    }
    Application.prototype.getControllerPrincipal = function () {
        return this.controllerPrincipal;
    };
    Application.prototype.getControllerNav = function () {
        return this.controllerNav;
    };
    Application.prototype.getControllerGallery = function () {
        return this.controllerGallery;
    };
    Application.prototype.getControllerSession = function () {
        return this.controllerSession;
    };
    Application.prototype.getControllerSettings = function () {
        return this.controllerSettings;
    };
    Application.prototype.getControllerAdmin = function () {
        return this.controllerAdmin;
    };
    return Application;
}());
//Start the application when page is loaded
var application = null;
$(window).ready(function () {
    application = new Application();
});
