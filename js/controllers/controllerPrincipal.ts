/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewPrincipal.ts" />
/// <reference path="controllerGallery.ts" />

/**
 * Principal controller of the application
 */
class ControllerPrincipal {
    /**
     * View associated to the controller
     */
    private viewPrincipal: ViewPrincipal;

    /**
     * Constructor
     */
    constructor() {
        this.viewPrincipal = new ViewPrincipal(this);
        this.setUrl();      
    }

    /**
     * When we reload we return to the same area
     */
    private setUrl() {
        var hash = window.location.hash;

        //If the url contain a name of a gallery
        if (hash.includes('categoryName')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            ControllerGallery.setCategoriesChild(this.getUrlVars().categoryName);
        }
        else {
            hash && $('.sidebar-nav li .menuLink[href="' + hash + '"]').tab('show');
        }

        if (hash == "#home") {
            $('#nav-home').addClass('active');
        }
        else if (hash == "#categories") {
            ControllerGallery.setCategories();
        }

        //Write and show the tab clicked
        $('.sidebar-nav li .menuLink').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop() || $('html').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
        });
    }

    /**
     * Returns all variables included in the URL
     */
    private getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }

    /**
     * Changes the interface according to the input parameters
     * @param form the form
     * @param type error / success
     * @param msg the message to display
     */
    static formMsg(form, type, msg) {
        if (type == 'success') {
            $("#" + form + "-form .msg-error").css('display', 'none');
            $("#" + form +"-form .msg-success span").html(msg);
            $("#" + form +"-form .msg-success").css('display', 'block');
            $("#div-forms").css("height", $("#" + form +"-form").height());
        }
        else if (type == 'error') {
            $("#" + form + "-form .msg-success").css('display', 'none');
            $("#" + form +"-form .msg-error span").html("  " +msg);
            $("#" + form +"-form .msg-error").css('display','block');
            $("#div-forms").css("height", $("#" + form +"-form").height());
        }
    }
}