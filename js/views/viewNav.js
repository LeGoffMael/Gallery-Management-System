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
        this.initSideBarWidth();
        $(window).on('resize', this.onWindowResized.bind(this));
        this.initMobileNav();
    }
    /**
     * When the window is resized
     * @param event
     */
    ViewNav.prototype.onWindowResized = function (event) {
        this.initSideBarWidth();
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
            that.initSideBarWidth();
        });
    };
    /**
     * Change the appearance of multiple items depending on the state of the nav
     */
    ViewNav.prototype.initSideBarWidth = function () {
        //If the navigation is reduce
        if (($('.wrapper').hasClass("toggled") == false)) {
            $(".sidebar-nav li a").css("margin-left", "0");
            $("#little-search").css("display", "block");
            $("#search-form").css("display", "none");
            $("#contact").css("margin-left", "1px");
            $("#contact").css("font-size", "90%");
            this.initToolTip();
        }
        else if ($('.wrapper').hasClass("toggled") == true) {
            $(".sidebar-toggle").css('display', 'block');
            $(".sidebar").css('padding-top', '0px');
            $(".sidebar-nav li a").css("margin-left", "10px");
            $("#little-search").css("display", "none");
            $("#search-form").css("display", "block");
            $("#contact").css("margin-left", "5px");
            $("#contact").css("font-size", "100%");
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
    ViewNav.prototype.initMobileNav = function () {
        $("#mobile-toggle").click(function (e) {
            e.preventDefault();
            $(".wrapper").toggleClass("mobile-toggled");
        });
        $(".sidebar-nav a").click(function (e) {
            e.preventDefault();
            $(".wrapper").removeClass("mobile-toggled");
        });
    };
    return ViewNav;
}());
