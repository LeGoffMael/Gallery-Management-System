/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerNav.ts" />
/**
 * View of the navigation
 */
var ViewNav = (function () {
    /**
     * Constructor
     * @param {ControllerNav} controller controller associated to the view
     */
    function ViewNav(controller) {
        /**
         * controller associated to the view
         */
        this.controllerNav = null;
        this.controllerNav = controller;
        this.initSideBarButton();
        this.initSideBar();
        $(window).on('resize', this.onWindowResized.bind(this));
        this.initMobileNav();
        this.initSearch();
    }
    /**
     * When the window is resized
     * @param event
     */
    ViewNav.prototype.onWindowResized = function (event) {
        this.initSideBar();
    };
    /**
     * Edit the navigation when you click on the button
     */
    ViewNav.prototype.initSideBarButton = function () {
        var that = this;
        $(".wrapper").toggleClass("toggled");
        $(".sidebar-toggle").click(function () {
            $(".wrapper").toggleClass("toggled");
            if ($(".sidebar-toggle a i").hasClass("fa-caret-right")) {
                $(".sidebar-toggle a i").removeClass("fa-caret-right");
                $(".sidebar-toggle a i").addClass("fa-caret-left");
            }
            else if ($(".sidebar-toggle a i").hasClass("fa-caret-left")) {
                $(".sidebar-toggle a i").removeClass("fa-caret-left");
                $(".sidebar-toggle a i").addClass("fa-caret-right");
            }
            that.initSideBar();
        });
    };
    /**
     * Change the appearance of multiple items depending on the state of the nav
     */
    ViewNav.prototype.initSideBar = function () {
        //If the navigation is reduce
        if (($('.wrapper').hasClass("toggled") == false)) {
            this.initToolTip();
        }
        else if ($('.wrapper').hasClass("toggled") == true) {
            this.destroyTooltip();
        }
    };
    /**
     * Initializes nav tooltip labels
     */
    ViewNav.prototype.initToolTip = function () {
        $(document).ready(function () {
            $(".sidebar").tooltip({ selector: '[data-toggle=tooltip]' });
        });
    };
    /**
     * Destroy nav tooltip labels
     */
    ViewNav.prototype.destroyTooltip = function () {
        $('.sidebar').tooltip('destroy');
    };
    /**
     * Init the mobile navigation
     */
    ViewNav.prototype.initMobileNav = function () {
        $("#mobile-toggle").click(function (e) {
            e.preventDefault();
            $(".wrapper").toggleClass("mobile-toggled");
        });
        //Close toggle on link or button clicked
        $(".sidebar-nav a,button").click(function (e) {
            e.preventDefault();
            $(".wrapper").removeClass("mobile-toggled");
        });
    };
    /**
     * Init search button
     */
    ViewNav.prototype.initSearch = function () {
        var that = this;
        this.controllerNav.getApplication().getControllerPrincipal().setSearchList();
        $("#search-form a").click(function (e) {
            var val = $("#search-form input").val();
            if (val != "" && val != undefined) {
                window.location.hash += '?searchTerm=' + val;
                that.controllerNav.getApplication().getControllerGallery().setSearchResult(val, 1, true);
                $("#search-form input").val('');
            }
        });
        $("#search-form-reduce a").click(function (e) {
            var val = $("#search-form-reduce input").val();
            if (val != "" && val != undefined) {
                window.location.hash += '?searchTerm=' + val;
                that.controllerNav.getApplication().getControllerGallery().setSearchResult(val, 1, true);
                $("#search-form-reduce input").val('');
            }
        });
    };
    return ViewNav;
}());
