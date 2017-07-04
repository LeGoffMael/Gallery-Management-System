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
    private controllerSettings: ControllerSettings;
    private controllerAdmin: ControllerAdmin;

    /**
     * Initialization of all controllers
     */
    constructor()
    {
        this.controllerGallery = new ControllerGallery(this);
        this.controllerPrincipal = new ControllerPrincipal(this);
        this.controllerNav = new ControllerNav(this);
        this.controllerSession = new ControllerSession(this);
        this.controllerSettings = new ControllerSettings(this);
        this.controllerAdmin = new ControllerAdmin(this);
        
    }

    public getControllerPrincipal() {
        return this.controllerPrincipal;
    }
    public getControllerNav() {
        return this.controllerNav;
    }
    public getControllerGallery() {
        return this.controllerGallery;
    }
    public getControllerSession() {
        return this.controllerSession;
    }
    public getControllerSettings() {
        return this.controllerSettings;
    }
    public getControllerAdmin() {
        return this.controllerAdmin;
    }
}

//Start the application when page is loaded
var application: Application = null;
$(window).ready(() => {
    application = new Application();
});