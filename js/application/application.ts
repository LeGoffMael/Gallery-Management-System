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
class Application
{
    //Principal controller of the application
    private controllerPrincipal: ControllerPrincipal;
    private controllerNav: ControllerNav;
    private controllerGallery: ControllerGallery;
    private controllerSession: ControllerSession;

    /**
     * Initialization of all controllers
     */
    constructor()
    {
        this.controllerPrincipal = new ControllerPrincipal();
        this.controllerNav = new ControllerNav();
        this.controllerGallery = new ControllerGallery();
        this.controllerSession = new ControllerSession();
    }

    /**
     * WHen the user is logged
     */
    static admin() {
        var controllerSettings = new ControllerSettings();
        var controllerAdmin = new ControllerAdmin();
    }
}

//Start the application when page is loaded
var application: Application = null;
$(window).ready(() => {
    application = new Application();
});