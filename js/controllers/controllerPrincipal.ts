/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewPrincipal.ts" />
/// <reference path="../application/application.ts" />
/// <reference path="controllerGallery.ts" />
/// <reference path="../libs/typescript/typeahead.ts" />

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

    private categoriesReady = false;
    private tagsReady = false;
    private categories = [];
    private tags = [];

    /**
     * Constructor
     */
    constructor(application: Application) {
        this.application = application;
        this.viewPrincipal = new ViewPrincipal(this);
        this.setTagsList(); 
        this.menuClicked();
        this.setUrl();
    }

    public startLoader(element) {
        this.stopLoader(element);
        $(element).append('<div class="loaderContainer"><span class="ellipsis"></span></div>');
    }

    public stopLoader(element) {
        $(element).children('.loaderContainer').each(function () {
            $(this).remove();
        });
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
        else if (hash.includes('nameTag')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            this.application.getControllerGallery().setTagGallery(this.getUrlVars().nameTag, 1, true);
        }
        else if (hash.includes('searchTerm')) {
            var newHash = hash.split("?");
            hash && $('.sidebar-nav li .menuLink[href="' + newHash[0] + '"]').tab('show');
            //Display it
            this.application.getControllerGallery().setSearchResult(this.getUrlVars().searchTerm, 1, true);
        }
        else {
            hash && $('.menuLink[href="' + hash + '"]').tab('show');
        }

        if (hash == "#home") {
            $('#nav-home').addClass('active');
        }
        else if (hash == "#categories") {
            this.application.getControllerGallery().setCategories(1, true); 
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
        var that = this;
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
                //Remove tag content
                that.application.getControllerGallery().removeTagContent();
                $("#tagsList").html(html);
            },
            error: function (resultat, statut, erreur) {
                console.log('error tags list (' + erreur + ')');
            }
        });
    }

    /**
     * Remove tags list
     */
    public removeTagsList() {
        $("#tagsList").html('');
    }

    /**
     * Init the auto complete search
      */
    public setSearchList() {
        var that = this;

        $.ajax({
            url: './php/functions/getAllCategories.php',
            dataType: 'json',
            success: function (json) {
                for (var i = 0; i < json.length; i++) {
                    var obj = new Object();
                    obj.name = json[i].text;
                    obj.id = json[i].id;
                    obj.nb = json[i].nb;
                    that.categories.push(obj);
                }
                that.categoriesReady = true;
                that.callTypahead();
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
                    var obj = new Object();
                    obj.name = json[i].text;
                    obj.id = json[i].id;
                    obj.nb = json[i].nb;
                    that.tags.push(obj);
                }
                that.tagsReady = true;
                that.callTypahead();
            },
            error: function (resultat, statut, erreur) {
                console.log('error tags list (' + erreur + ')');
            }
        });
    }

    public callTypahead() {
        if (this.categoriesReady && this.tagsReady) {
            setTypahead($('.search-input'), this.categories, this.tags);
        }
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