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
        this.menuClicked();
        ControllerPrincipal.setTagsList(); 
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
            ControllerGallery.setCategoriesChild(ControllerPrincipal.getUrlVars().categoryName, 1, true);
        }
        else if (hash.includes('nameTag')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            ControllerGallery.setTagGallery(ControllerPrincipal.getUrlVars().nameTag, 1, true);
        }
        else {
            hash && $('.menuLink[href="' + hash + '"]').tab('show');
        }

        if (hash == "#home") {
            $('#nav-home').addClass('active');
        }
        else if (hash == "#categories") {
            ControllerGallery.setCategories();
        }
    }

    /**
     * Write and show the tab clicked
     */
    private menuClicked() {
        $('.menuLink').click(function (e) {
            $(this).tab('show');
            window.location.hash = this.hash;
        });
    }

    /**
     * Display all the tags name in the tags area
     */
    static setTagsList() {
        $.ajax({
            url: './php/functions/getAllTags.php',
            dataType: 'json',
            success: function (json) {
                var html = "<ul class='list-inline'>";
                for (var i = 0; i < json.length; i++) {
                    html += "<li class='list-inline-item col-lg-2 col-sm-3 col-xs-4 text-center'><a class='label label-default' onClick='ControllerGallery.setTagGallery(&#34;" + json[i].text + "&#34;,1,true)' href='#tags?nameTag=" + json[i].text + "'>" + json[i].text + "<span class='badge'>" + json[i].nb + "</span></a></li>";
                }
                html += "</ul>";

                $('#tags h1').html('Tags');
                $("#tagsContent").html(html);
            },
            error: function (resultat, statut, erreur) {
                console.log('error tags list (' + erreur + ')');
            }
        });
    }

    /**
     * Init the auto complete search
      */
    static setSearchList() {
        var search = [];

        $.ajax({
            url: './php/functions/getAllCategories.php',
            dataType: 'json',
            success: function (json) {
                for (var i = 0; i < json.length; i++) {
                    search.push(json[i].text);
                }
            },
            error: function (resultat, statut, erreur) {
                console.log('error tags list (' + erreur + ')');
            }
        });
        $.ajax({
            url: './php/functions/getAllTags.php',
            dataType: 'json',
            success: function (json) {
                for (var i = 0; i < json.length; i++) {
                    search.push(json[i].text);
                }
            },
            error: function (resultat, statut, erreur) {
                console.log('error tags list (' + erreur + ')');
            }
        });

        $('.search-input').typeahead({
            source: search
        });
    }

    /**
     * Returns all variables included in the URL
     */
    static getUrlVars() {
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
            $("#" + form + " .msg-error").css('display', 'none');
            $("#" + form + " .msg-success span").html("  " +msg);
            $("#" + form +" .msg-success").css('display', 'block');
            $("#div-forms").css("height", $("#" + form +"-form").height());
        }
        else if (type == 'error') {
            $("#" + form + " .msg-success").css('display', 'none');
            $("#" + form +" .msg-error span").html("  " +msg);
            $("#" + form +" .msg-error").css('display','block');
            $("#div-forms").css("height", $("#" + form +"-form").height());
        }
    }
}