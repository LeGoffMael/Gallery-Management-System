/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewGallery.ts" />
/// <reference path="../application/application.ts" />
/// <reference path="controllerPrincipal.ts" />
/**
 * controller of the galleries
 */
var ControllerGallery = (function () {
    /**
     * Constructor
     */
    function ControllerGallery(application) {
        this.application = application;
        this.viewGallery = new ViewGallery(this);
        this.updateLatestTopGallery();
        this.paginationManagement();
        this.voteButton();
        this.goToCategory();
        this.goToTag();
    }
    /**
     * Set vote when vote button is clicked
     */
    ControllerGallery.prototype.voteButton = function () {
        var that = this;
        $("#pswp").on("click", "a.voteButton", function () {
            var typeVote = $(this).attr('data-typeVote');
            var url = $(this).attr('data-voteUrl');
            that.setVote(typeVote, url);
        });
    };
    /**
     * Set category when a new is clicked
     */
    ControllerGallery.prototype.goToCategory = function () {
        var that = this;
        $("#categories").on("click", "a.categoryLink", function () {
            console.log('category');
            var parent = $(this).attr('data-categoryLink');
            console.log(parent);
            that.setCategoriesChild(parent, 1, true);
        });
    };
    /**
     * Set tag when a new is clicked
     */
    ControllerGallery.prototype.goToTag = function () {
        var that = this;
        $("#tags").on("click", "a.tagLink", function () {
            var tag = $(this).attr('data-tagLink');
            console.log(tag);
            that.setTagGallery(tag, 1, true);
        });
        $("#tags").on("click", "a.tagsLink", function () {
            that.application.getControllerPrincipal().setTagsList();
        });
    };
    /**
     * Return the current gallery
     */
    ControllerGallery.prototype.getCurrentGallery = function () {
        //To determine in which gallery we are
        var gallery = null;
        var hash = window.location.hash;
        gallery = hash.substring(hash.lastIndexOf('#') + 1);
        //If we are in a category
        if (gallery.includes('categoryName'))
            gallery = 'categories';
        else if (gallery.includes('nameTag'))
            gallery = 'tags';
        else if (gallery == '')
            gallery = 'home';
        return gallery;
    };
    /**
     * Detect if the user is at the bottom
     * And update the current gallery with it next page
     */
    ControllerGallery.prototype.paginationManagement = function () {
        var that = this;
        $('.main').scroll(function () {
            if ($('.main')[0].scrollHeight - $('.main')[0].scrollTop == $('.main')[0].clientHeight) {
                var allPage = $('.main #' + that.getCurrentGallery() + ' .pageGallery');
                var nextPage = allPage.last();
                if (that.getCurrentGallery() == 'home') {
                    that.setLatestGallery(nextPage.attr('data-nextPage'), false);
                }
                else if (that.getCurrentGallery() == 'top') {
                    that.setTopGallery(nextPage.attr('data-nextPage'), false);
                }
                else if (that.getCurrentGallery() == 'categories') {
                    that.setCategoriesChild(that.application.getControllerPrincipal().getUrlVars().categoryName, nextPage, false);
                }
                else if (that.getCurrentGallery() == 'tags') {
                    that.setTagGallery(that.application.getControllerPrincipal().getUrlVars().nameTag, nextPage, false);
                }
                else if (that.getCurrentGallery() == 'search') {
                    var terms = $("#search-form input").val();
                    if (terms == "" || terms == null)
                        terms = $("#search-form-reduce input").val();
                    that.setSearchResult(terms, nextPage, false);
                }
            }
        });
    };
    /**
     * Reset top and latest galleries
     */
    ControllerGallery.prototype.updateLatestTopGallery = function () {
        this.setLatestGallery(1, true);
        this.setTopGallery(1, true);
    };
    /**
     * Create the latest gallery
     */
    ControllerGallery.prototype.setLatestGallery = function (page, reset) {
        $.ajax({
            url: './php/galleries/LastGallery.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if (reset)
                    $("#galleryLatest").html(html);
                else
                    $("#galleryLatest").html($("#galleryLatest").html() + html);
                //Hide other no items to display
                $("#galleryLatest").children('h2:not(:first)').css('display', 'none');
                ViewGallery.initGallery();
                ViewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error gallery latest (' + erreur + ')');
            }
        });
    };
    /**
     * Create the top gallery
     */
    ControllerGallery.prototype.setTopGallery = function (page, reset) {
        $.ajax({
            url: './php/galleries/TopGallery.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if (reset)
                    $("#galleryTop").html(html);
                else
                    $("#galleryTop").html($("#galleryTop").html() + html);
                //Hide other no items to display
                $("#galleryTop").children('h2:not(:first)').css('display', 'none');
                ViewGallery.initGallery();
                ViewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error gallery top (' + erreur + ')');
            }
        });
    };
    /**
     * Create parent categories gallery
     */
    ControllerGallery.prototype.setCategories = function () {
        $.ajax({
            url: './php/galleries/ParentCategories.php',
            type: 'GET',
            dataType: 'html',
            success: function (html) {
                $("#galleryCategories").html(html);
            },
            error: function (resultat, statut, erreur) {
                console.log('error parent categories (' + erreur + ')');
            }
        });
    };
    /**
     * Create the child categories of the category send in parameters
     * @param name the parent category
     * @param page the page to display category
     * @param reset if the new gallery crushed the last
     */
    ControllerGallery.prototype.setCategoriesChild = function (name, page, reset) {
        if (name != 'null') {
            $.ajax({
                url: './php/galleries/ChildCategories.php',
                type: 'POST',
                data: 'nameParent=' + name + '&page=' + page,
                dataType: 'html',
                success: function (html) {
                    if (reset)
                        $("#galleryCategories").html(html);
                    else
                        $("#galleryCategories").html($("#galleryCategories").html() + html);
                    //Hide other title
                    $("#galleryCategories").children('h1:not(:first)').css('display', 'none');
                    //Hide other no items to display
                    $("#galleryCategories").children('h2:not(:first)').css('display', 'none');
                    ViewGallery.initGallery();
                    ViewGallery.initLightBox();
                },
                error: function (resultat, statut, erreur) {
                    console.log('error category ' + name + ' (' + erreur + ')');
                }
            });
        }
        else {
            this.setCategories();
        }
    };
    /**
     * Create the gallery of the tag
     * @param id the tag id
     * @param page the page to display category
     * @param reset if the new gallery crushed the last
     */
    ControllerGallery.prototype.setTagGallery = function (nameTag, page, reset) {
        $.ajax({
            url: './php/galleries/TagGallery.php',
            type: 'POST',
            data: 'nameTag=' + nameTag + '&page=' + page,
            dataType: 'html',
            success: function (html) {
                if (reset)
                    $("#tagsContent").html(html);
                else
                    $("#tagsContent").html($(".galleryTop").html() + html);
                $('#tags h1').html('Tags::<a class="menuLink tagsLink" href= "#tags" data-toggle="tab" >' + nameTag + '</a>');
                ViewGallery.initGallery();
                ViewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error search (' + erreur + ')');
            }
        });
    };
    /**
     * Display the result of the search
     */
    ControllerGallery.prototype.setSearchResult = function (terms, page, reset) {
        if (terms != "" && terms != undefined) {
            $.ajax({
                url: './php/galleries/SearchResult.php',
                type: 'POST',
                data: 'terms=' + terms + '&page=' + page,
                dataType: 'html',
                success: function (html) {
                    if (reset)
                        $("#searchResult").html(html);
                    else
                        $("#searchResult").html($("#searchResult").html() + html);
                    $('#search h1').html('Search::' + terms);
                    //Hide other no items to display
                    $("#searchResult").children('h2:not(:first)').css('display', 'none');
                    ViewGallery.initGallery();
                    ViewGallery.initLightBox();
                },
                error: function (resultat, statut, erreur) {
                    console.log('error search (' + erreur + ')');
                }
            });
        }
    };
    /**
     * Do a vote and refresh the value displayed
     * @param currentVote up or down
     * @param urlImage the image voted
     */
    ControllerGallery.prototype.setVote = function (currentVote, urlImage) {
        var gallery = this.getCurrentGallery();
        var that = this;
        $.ajax({
            url: './php/Score.php',
            type: 'POST',
            data: 'currentVote=' + currentVote + '&urlImage=' + urlImage,
            dataType: 'html',
            success: function (code_html) {
                //If we are in the latest gallery
                if (gallery == 'home') {
                    that.updateLatestTopGallery();
                }
                else if (gallery == 'top')
                    that.setTopGallery(1, true);
                else if (gallery == null)
                    location.reload();
                else {
                    that.setCategoriesChild(gallery, false, 1);
                    that.setTopGallery(1, true);
                }
                //Change score displayed in the light box
                that.updateLightBox(code_html);
            },
            error: function (resultat, statut, erreur) {
                console.log('error vote (' + urlImage + ': ' + currentVote + ')');
            }
        });
    };
    /**
     * Update the content of the light box
     * @param vote the new vote value
     */
    ControllerGallery.prototype.updateLightBox = function (vote) {
        $('#pswp div.score').html(vote);
    };
    return ControllerGallery;
}());
