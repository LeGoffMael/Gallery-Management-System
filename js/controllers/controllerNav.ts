/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewNav.ts" />
/// <reference path="controllerGallery.ts" />

/**
 * controller of the navigation
 */
class ControllerNav {

    /**
     * View associated to the controller
     */
    private viewNav: ViewNav;

    /**
     * Constructor
     */
    constructor() {
        this.viewNav = new ViewNav(this);
        this.initNav();
    }

    private initNav() {
        $('#home-link').click(function () {
            location.href = 'index.php';
        });
        $('#nav-categ').click(function () {
            ControllerGallery.setCategories()
        });
        //Reset scroll
        $('.sidebar-nav a').click(function () {
            $('.main').scrollTop(0);
            ControllerGallery.updateLatestTopGallery();
        });
    }
}