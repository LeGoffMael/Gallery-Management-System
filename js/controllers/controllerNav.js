/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewNav.ts" />
/// <reference path="controllerGallery.ts" />
/// <reference path="../application/application.ts" />
/**
 * controller of the navigation
 */
var ControllerNav = (function () {
    /**
     * Constructor
     */
    function ControllerNav(application) {
        this.application = application;
        this.viewNav = new ViewNav(this);
        this.initNav();
    }
    ControllerNav.prototype.initNav = function () {
        var that = this;
        $('#home-link').click(function () {
            location.href = 'index.php';
        });
        $('#nav-categ').click(function () {
            that.application.getControllerGallery().setCategories();
        });
        $('#nav-tag').click(function () {
            that.application.getControllerPrincipal().setTagsList();
        });
        //Reset scroll
        $('.sidebar-nav a,button').click(function () {
            $('.main').scrollTop(0);
            that.application.getControllerGallery().updateLatestTopGallery();
        });
    };
    ControllerNav.prototype.getApplication = function () {
        return this.application;
    };
    return ControllerNav;
}());
