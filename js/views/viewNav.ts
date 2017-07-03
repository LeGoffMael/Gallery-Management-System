/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerNav.ts" />

/**
 * View of the navigation
 */
class ViewNav {
    /**
     * controller associated to the view
     */
    private controllerNav: ControllerNav = null;

    /**
     * Constructor
     * @param {ControllerNav} controller controller associated to the view
     */
    constructor(controller: ControllerNav) {
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
    private onWindowResized(event: UIEvent): void {
        this.initSideBar();
    }

    /**
     * Edit the navigation when you click on the button
     */
    private initSideBarButton() {
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
    }

    /**
     * Change the appearance of multiple items depending on the state of the nav
     */
    private initSideBar() {
        //If the navigation is reduce
        if (($('.wrapper').hasClass("toggled") == false)) {
            this.initToolTip();
        }
        //Else
        else if ($('.wrapper').hasClass("toggled") == true) {
            this.destroyTooltip();
        }
    }

    /**
     * Initializes nav tooltip labels
     */
    private initToolTip() {
        $(document).ready(function () {
            $(".sidebar").tooltip({ selector: '[data-toggle=tooltip]' });
        });
    }
    /**
     * Destroy nav tooltip labels
     */
    private destroyTooltip() {
        $('.sidebar').tooltip('destroy');
    }

    /**
     * Init the mobile navigation
     */
    private initMobileNav() {
        $("#mobile-toggle").click(function (e) {
            e.preventDefault();
            $(".wrapper").toggleClass("mobile-toggled");
        });
        //Close toggle on link or button clicked
        $(".sidebar-nav a,button").click(function (e) {
            e.preventDefault();
            $(".wrapper").removeClass("mobile-toggled");
        });
    }

    /**
     * Init search button
     */
    private initSearch() {
        ControllerPrincipal.setSearchList();
        $("#search-form a").click(function (e) {
            var val = $("#search-form input").val();
            if (val != "" && val != undefined)
                ControllerGallery.setSearchResult(val,1,true);
        });
        $("#search-form-reduce a").click(function (e) {
            var val = $("#search-form-reduce input").val();
            if (val != "" && val != undefined)
                ControllerGallery.setSearchResult(val,1,true);
        });
    }
}