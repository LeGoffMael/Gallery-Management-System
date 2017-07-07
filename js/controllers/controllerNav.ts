/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewNav.ts" />
/// <reference path="controllerGallery.ts" />
/// <reference path="../application/application.ts" />

/**
 * controller of the navigation
 */
class ControllerNav {

    /**
     * The link between controllers
     */
    private application: Application;
    /**
     * View associated to the controller
     */
    private viewNav: ViewNav;

    /**
     * Constructor
     */
    constructor(application: Application) {
        this.application = application;
        this.viewNav = new ViewNav(this);
        this.initNav();
    }

    private initNav() {
        var that = this;
        $('#home-link').click(function () {
            location.href = 'index.php';
        });
        $('#nav-categ').click(function () {
            that.application.getControllerGallery().setCategories(1, true)
        });
        $('#nav-tag').click(function () {
            that.application.getControllerPrincipal().setTagsList();
        });
        //Reset scroll
        $('.sidebar-nav a, .sidebar-nav button').click(function () {
            $('.main').scrollTop(0);
            that.application.getControllerGallery().updateLatestTopGallery();
        });
    }

    public getApplication() {
        return this.application;
    }
}