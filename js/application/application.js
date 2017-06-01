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
        this.controllerPrincipal = new ControllerPrincipal();
        this.controllerNav = new ControllerNav();
        this.controllerGallery = new ControllerGallery();
        this.controllerSession = new ControllerSession();
    }
    /**
     * WHen the user is logged
     */
    Application.admin = function () {
        var controllerSettings = new ControllerSettings();
        var controllerAdmin = new ControllerAdmin();
    };
    return Application;
}());
//Start the application when page is loaded
var application = null;
$(window).ready(function () {
    application = new Application();
});
