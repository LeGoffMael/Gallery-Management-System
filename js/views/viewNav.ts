﻿/// <reference path="../libs/typescript/jquery.d.ts" />
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
        this.initSideBarWidth();        
        $(window).on('resize', this.onWindowResized.bind(this));
    }

    /**
     * When the window is resized
     * @param event
     */
    private onWindowResized(event: UIEvent): void {
        this.initSideBarWidth();
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
            that.initSideBarWidth();
        });
    }

    /**
     * Change the appearance of multiple items depending on the state of the nav
     */
    private initSideBarWidth() {
        //If the navigation is reduce
        if (($(".sidebar-nav span").css("display") == "none") || (window.matchMedia("(max-width: 770px)").matches)) {
            $(".sidebar-nav li a").css("margin-left", "0");
            $("#little-search").css("display", "block");
            $("#search-form").css("display", "none");
            $("#contact").css("margin-left", "1px");
            $("#contact").css("font-size", "90%");

            if (window.matchMedia("(max-width: 770px)").matches) {
                $(".sidebar-toggle").css('display', 'none');
                $(".sidebar").css('padding-top', '5px');
            }

            this.initToolTip();
        }
        //Else
        else if (($(".sidebar-nav span").css("display") == "inline") || (window.matchMedia("(min-width: 770px)").matches)) {
            $(".sidebar-toggle").css('display', 'block');
            $(".sidebar").css('padding-top', '0px');
            $(".sidebar-nav li a").css("margin-left", "10px");
            $("#little-search").css("display", "none");
            $("#search-form").css("display", "block");
            $("#contact").css("margin-left", "5px");
            $("#contact").css("font-size", "100%");
        }
    }

    /**
     * Initializes tooltip labels
     */
    private initToolTip() {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    }
}