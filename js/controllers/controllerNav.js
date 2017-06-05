/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewNav.ts" />
/// <reference path="controllerGallery.ts" />
/**
 * controller of the navigation
 */
var ControllerNav = (function () {
    /**
     * Constructor
     */
    function ControllerNav() {
        this.viewNav = new ViewNav(this);
        this.initNav();
    }
    ControllerNav.prototype.initNav = function () {
        $('#home-link').click(function () {
            location.href = 'index.php';
        });
        $('#nav-categ').click(function () {
            ControllerGallery.setCategories();
        });
        //Reset scroll
        $('.sidebar-nav a').click(function () {
            $('.main').scrollTop(0);
            ControllerGallery.updateLatestTopGallery();
        });
    };
    return ControllerNav;
}());
