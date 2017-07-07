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
        this.latestScroll = 0;
        this.topScroll = 0;
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
            that.application.getControllerGallery().setCategories(1, true);
        });
        $('#nav-tag').click(function () {
            that.application.getControllerPrincipal().setTagsList();
        });
        //update scroll
        $('.sidebar-nav a, .sidebar-nav button').click(function () {
            if (that.getApplication().getControllerGallery().getCurrentGallery() == 'home') {
                $('.main').scrollTop(that.latestScroll);
            }
            else if (that.getApplication().getControllerGallery().getCurrentGallery() == 'top') {
                $('.main').scrollTop(that.topScroll);
            }
            that.application.getControllerGallery().updateCurrentGallery();
        });
    };
    ControllerNav.prototype.getApplication = function () {
        return this.application;
    };
    ControllerNav.prototype.setLatestScroll = function (scroll) {
        this.latestScroll = scroll;
    };
    ControllerNav.prototype.setTopScroll = function (scroll) {
        this.topScroll = scroll;
    };
    return ControllerNav;
}());
