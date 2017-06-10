/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewPrincipal.ts" />
/// <reference path="controllerGallery.ts" />
/**
 * Principal controller of the application
 */
var ControllerPrincipal = (function () {
    /**
     * Constructor
     */
    function ControllerPrincipal() {
        this.viewPrincipal = new ViewPrincipal(this);
        this.setUrl();
        ControllerPrincipal.setTagsList();
    }
    ControllerPrincipal.startLoader = function (element) {
        element.addClass('loader dots');
        element.css('display', 'block');
    };
    ControllerPrincipal.stopLoader = function (element) {
        element.removeClass('loader dots');
        element.css('display', 'none');
    };
    /**
     * When we reload we return to the same area
     */
    ControllerPrincipal.prototype.setUrl = function () {
        var hash = window.location.hash;
        //If the url contain a name of a gallery
        if (hash.includes('categoryName')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            ControllerGallery.setCategoriesChild(ControllerPrincipal.getUrlVars().categoryName, 1, true);
        }
        else if (hash.includes('nameTag')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            ControllerGallery.setTagGallery(ControllerPrincipal.getUrlVars().nameTag, 1, true);
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
    };
    /**
     * Display all the tags name in the tags area
     */
    ControllerPrincipal.setTagsList = function () {
        $.ajax({
            url: './php/functions/getAllTags.php',
            dataType: 'json',
            success: function (json) {
                var html = "<ul class='list-inline'>";
                for (var i = 0; i < json.length; i++) {
                    html += "<li class='list-inline-item col-lg-2 col-sm-3 col-xs-4 text-center'><a class='label label-default' onClick='ControllerGallery.setTagGallery(&#34;" + json[i].text + "&#34;,1,true)' href='#tags?nameTag=" + json[i].text + "'>" + json[i].text + "</a></li>";
                }
                html += "</ul>";
                $("#tagsContent").html(html);
            },
            error: function (resultat, statut, erreur) {
                console.log('error tags list (' + erreur + ')');
            }
        });
    };
    /**
     * Returns all variables included in the URL
     */
    ControllerPrincipal.getUrlVars = function () {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    };
    /**
     * Changes the interface according to the input parameters
     * @param form the form
     * @param type error / success
     * @param msg the message to display
     */
    ControllerPrincipal.formMsg = function (form, type, msg) {
        if (type == 'success') {
            $("#" + form + " .msg-error").css('display', 'none');
            $("#" + form + " .msg-success span").html("  " + msg);
            $("#" + form + " .msg-success").css('display', 'block');
            $("#div-forms").css("height", $("#" + form + "-form").height());
        }
        else if (type == 'error') {
            $("#" + form + " .msg-success").css('display', 'none');
            $("#" + form + " .msg-error span").html("  " + msg);
            $("#" + form + " .msg-error").css('display', 'block');
            $("#div-forms").css("height", $("#" + form + "-form").height());
        }
    };
    return ControllerPrincipal;
}());
