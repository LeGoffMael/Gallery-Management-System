/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewPrincipal.ts" />
/// <reference path="../application/application.ts" />
/// <reference path="controllerGallery.ts" />

/**
 * Principal controller of the application
 */
class ControllerPrincipal {

    /**
     * The link between controllers
     */
    private application: Application;
    /**
     * View associated to the controller
     */
    private viewPrincipal: ViewPrincipal;

    /**
     * Constructor
     */
    constructor(application: Application) {
        this.application = application;
        this.viewPrincipal = new ViewPrincipal(this);
        this.setUrl();
        this.menuClicked();
        this.setTagsList(); 
    }

    public startLoader(element) {
        this.stopLoader(element);
        $(element).addClass('loaderContainer').append('<span class="ellipsis"></span>');
    }

    public stopLoader(element) {
        $(element).removeClass('loaderContainer').children('.ellipsis').remove();
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
            this.application.getControllerGallery().setCategoriesChild(this.getUrlVars().categoryName, 1, true);
        }
        else if (hash.includes('*')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            this.application.getControllerGallery().setTagGallery(this.getUrlVars().nameTag, 1, true);
        }
        else {
            hash && $('.menuLink[href="' + hash + '"]').tab('show');
        }

        if (hash == "#home") {
            $('#nav-home').addClass('active');
        }
        else if (hash == "#categories") {
            this.application.getControllerGallery().setCategories(); 
        }
    }

    /**
     * Write and show the tab clicked
     */
    private menuClicked() {
        var that = this;
        $('.menuLink').click(function (e) {
            if ($(this).hasClass('tagsLink')) {
                that.setTagsList();
            }
            $(this).tab('show');
            window.location.hash = this.hash;
        });
    }

    /**
     * Display all the tags name in the tags area
     */
    public setTagsList() {
        $.ajax({
            url: './php/functions/getAllTags.php',
            dataType: 'json',
            success: function (json) {
                var html = "<ul class='list-inline'>";
                for (var i = 0; i < json.length; i++) {
                    html += "<li class='list-inline-item col-lg-2 col-sm-3 col-xs-4 text-center'><a class='label label-default tagLink' data-tagLink='"+ json[i].text +"' href='#tags?nameTag=" + json[i].text + "'>" + json[i].text + "<span class='badge'>" + json[i].nb + "</span></a></li>";
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
    public setSearchList() {
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
    public getUrlVars() {
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
    public formMsg(form, type, msg) {
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