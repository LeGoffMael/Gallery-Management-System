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
    ControllerGallery.prototype.getViewGallery = function () {
        return this.viewGallery;
    };
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
            var parent = $(this).attr('data-categoryLink');
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
            that.setTagGallery(tag, 1, true);
        });
        $("#tags").on("click", "a.tagsLink", function () {
            that.application.getControllerPrincipal().setTagsList();
        });
    };
    /**
     * Return if the gallery is empty
     * @param gallery
     */
    ControllerGallery.prototype.galleryNotEmpty = function (gallery) {
        var res = false;
        if (gallery.includes('<img'))
            res = true;
        return res;
    };
    /**
     * Remove categories child
     */
    ControllerGallery.prototype.removeCategoriesChild = function () {
        $("#categoriesChild").html('');
    };
    /**
     * Remove category gallery
     */
    ControllerGallery.prototype.removeCategoryGallery = function () {
        $("#galleryCategories .gallery-container").html('<div class="pageGallery" data-nextpage="1"></div>');
    };
    /**
     * Remove tag content
     */
    ControllerGallery.prototype.removeTagContent = function () {
        $("#tagContent .gallery-container").html('<div class="pageGallery" data-nextpage="1"></div>');
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
        else if (gallery.includes('searchTerm'))
            gallery = 'search';
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
                var nextPage = allPage.last().attr('data-nextPage');
                if (that.getCurrentGallery() == 'home') {
                    that.setLatestGallery(nextPage, false);
                }
                else if (that.getCurrentGallery() == 'top') {
                    that.setTopGallery(nextPage, false);
                }
                else if (that.getCurrentGallery() == 'categories') {
                    that.setCategoriesChild(that.application.getControllerPrincipal().getUrlVars().categoryName, nextPage, false);
                }
                else if (that.getCurrentGallery() == 'tags') {
                    that.setTagGallery(that.application.getControllerPrincipal().getUrlVars().nameTag, nextPage, false);
                }
                else if (that.getCurrentGallery() == 'search') {
                    that.setSearchResult(that.application.getControllerPrincipal().getUrlVars().searchTerm, nextPage, false);
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
        var that = this;
        $.ajax({
            url: './php/galleries/LastGallery.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if (that.galleryNotEmpty(html)) {
                    //Start loader
                    that.application.getControllerPrincipal().startLoader('#galleryLatest .gallery');
                }
                if (reset)
                    $("#galleryLatest .gallery-container").html(html);
                else
                    $("#galleryLatest .gallery-container").html($("#galleryLatest .gallery-container").html() + html);
                $("#galleryLatest img:last").on("load", function () {
                    //Stop loader
                    that.application.getControllerPrincipal().stopLoader('#galleryLatest .gallery');
                });
                //Hide other no items to display
                $("#galleryLatest").children('h2:not(:first)').css('display', 'none');
                that.viewGallery.initGallery();
                that.viewGallery.initLightBox();
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
        var that = this;
        $.ajax({
            url: './php/galleries/TopGallery.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if (that.galleryNotEmpty(html)) {
                    //Start loader
                    that.application.getControllerPrincipal().startLoader('#galleryTop .gallery');
                }
                if (reset)
                    $("#galleryTop .gallery-container").html(html);
                else
                    $("#galleryTop .gallery-container").html($("#galleryTop .gallery-container").html() + html);
                $("#galleryTop img:last").on("load", function () {
                    //Stop loader
                    that.application.getControllerPrincipal().stopLoader('#galleryTop .gallery');
                });
                //Hide other no items to display
                $("#galleryTop").children('h2:not(:first)').css('display', 'none');
                that.viewGallery.initGallery();
                that.viewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error gallery top (' + erreur + ')');
            }
        });
    };
    /**
     * Create parent categories gallery
     */
    ControllerGallery.prototype.setCategories = function (page, reset) {
        var that = this;
        this.removeCategoriesChild();
        this.removeCategoryGallery();
        //Display categories without parent
        $.ajax({
            url: './php/galleries/ParentCategories.php',
            type: 'GET',
            dataType: 'html',
            success: function (html) {
                $("#categoriesChild").html(html);
            },
            error: function (resultat, statut, erreur) {
                console.log('error parent categories (' + erreur + ')');
            }
        });
        //Display images without categories
        $.ajax({
            url: './php/galleries/GalleryWithoutCategory.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if (that.galleryNotEmpty(html)) {
                    //Start loader
                    that.application.getControllerPrincipal().startLoader('#galleryCategories .gallery');
                }
                if (reset)
                    $("#galleryCategories .gallery-container").html(html);
                else
                    $("#galleryCategories .gallery-container").html($("#galleryCategories .gallery-container").html() + html);
                $("#galleryCategories img:last").on("load", function () {
                    //Stop loader
                    that.application.getControllerPrincipal().stopLoader('#galleryCategories .gallery');
                });
                that.viewGallery.initGallery();
                that.viewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error category gallery ' + name + ' (' + erreur + ')');
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
        var that = this;
        if (name != 'null') {
            if (page == 1) {
                //Display categories child
                $.ajax({
                    url: './php/galleries/ChildCategories.php',
                    type: 'POST',
                    data: 'nameParent=' + name + '&page=' + page,
                    dataType: 'html',
                    success: function (html) {
                        $("#categoriesChild").html(html);
                    },
                    error: function (resultat, statut, erreur) {
                        console.log('error categories child ' + name + ' (' + erreur + ')');
                    }
                });
            }
            //Display category gallery
            $.ajax({
                url: './php/galleries/CategoryGallery.php',
                type: 'POST',
                data: 'name=' + name + '&page=' + page,
                dataType: 'html',
                success: function (html) {
                    if (that.galleryNotEmpty(html)) {
                        //Start loader
                        that.application.getControllerPrincipal().startLoader('#galleryCategories .gallery');
                    }
                    if (reset)
                        $("#galleryCategories .gallery-container").html(html);
                    else
                        $("#galleryCategories .gallery-container").html($("#galleryCategories .gallery-container").html() + html);
                    $("#galleryCategories img:last").on("load", function () {
                        //Stop loader
                        that.application.getControllerPrincipal().stopLoader('#galleryCategories .gallery');
                    });
                    //Hide other title
                    $("#galleryCategories").children('h1:not(:first)').css('display', 'none');
                    //Hide other no items to display
                    $("#galleryCategories").children('h2:not(:first)').css('display', 'none');
                    that.viewGallery.initGallery();
                    that.viewGallery.initLightBox();
                },
                error: function (resultat, statut, erreur) {
                    console.log('error category gallery ' + name + ' (' + erreur + ')');
                }
            });
        }
        else {
            this.setCategories(page, reset);
        }
    };
    /**
     * Create the gallery of the tag
     * @param id the tag id
     * @param page the page to display category
     * @param reset if the new gallery crushed the last
     */
    ControllerGallery.prototype.setTagGallery = function (nameTag, page, reset) {
        var that = this;
        $.ajax({
            url: './php/galleries/TagGallery.php',
            type: 'POST',
            data: 'nameTag=' + nameTag + '&page=' + page,
            dataType: 'html',
            success: function (html) {
                //Remove tags list
                that.application.getControllerPrincipal().removeTagsList();
                if (that.galleryNotEmpty(html)) {
                    //Start loader
                    that.application.getControllerPrincipal().startLoader('#tagContent .gallery');
                }
                if (reset)
                    $("#tagContent .gallery-container").html(html);
                else
                    $("#tagContent .gallery-container").html($("#tagContent .gallery-container").html() + html);
                $("#tagContent img:last").on("load", function () {
                    //Stop loader
                    that.application.getControllerPrincipal().stopLoader('#tagContent .gallery');
                });
                $('#tags h1').html('Tags::<a class="menuLink tagsLink" href= "#tags" data-toggle="tab" >' + nameTag + '</a>');
                that.viewGallery.initGallery();
                that.viewGallery.initLightBox();
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
        var that = this;
        if (terms != "" && terms != undefined) {
            $.ajax({
                url: './php/galleries/SearchResult.php',
                type: 'POST',
                data: 'terms=' + terms + '&page=' + page,
                dataType: 'html',
                success: function (html) {
                    if (that.galleryNotEmpty(html)) {
                        //Start loader
                        that.application.getControllerPrincipal().startLoader('#searchResult .gallery');
                    }
                    if (reset)
                        $("#searchResult .gallery-container").html(html);
                    else
                        $("#searchResult .gallery-container").html($("#searchResult .gallery-container").html() + html);
                    $("#searchResult img:last").on("load", function () {
                        //Stop loader
                        that.application.getControllerPrincipal().stopLoader('#searchResult .gallery');
                    });
                    $('#search h1').html('Search::' + terms);
                    //Hide other no items to display
                    $("#searchResult").children('h2:not(:first)').css('display', 'none');
                    that.viewGallery.initGallery();
                    that.viewGallery.initLightBox();
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
