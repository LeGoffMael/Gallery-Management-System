/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../controlers/controlerPrincipal.ts" />
/// <reference path="../controlers/controlerNav.ts" />
/// <reference path="../controlers/controlerGallery.ts" />
/// <reference path="../controlers/controlerSession.ts" />
/// <reference path="../controlers/controlerSettings.ts" />
/// <reference path="../controlers/controlerAdmin.ts" />
/**
 * Represents the running Web application
 */
var Application = (function () {
    /**
     * Initialization of all controlers
     */
    function Application() {
        this.controlerPrincipal = new ControlerPrincipal();
        this.controlerNav = new ControlerNav();
        this.controlerGallery = new ControlerGallery();
        this.controlerSession = new ControlerSession();
    }
    Application.admin = function () {
        var controlerSettings = new ControlerSettings();
        var controlerAdmin = new ControlerAdmin();
    };
    return Application;
}());
//Start the application when page is loaded
var application = null;
$(window).ready(function () {
    application = new Application();
});
