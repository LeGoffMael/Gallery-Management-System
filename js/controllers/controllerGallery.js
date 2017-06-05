/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewGallery.ts" />
/// <reference path="controllerPrincipal.ts" />
/**
 * controller of the galleries
 */
var ControllerGallery = (function () {
    /**
     * Constructor
     */
    function ControllerGallery() {
        this.viewGallery = new ViewGallery(this);
        ControllerGallery.updateLatestTopGallery();
        this.paginationManagement();
    }
    ControllerGallery.prototype.paginationManagement = function () {
        $('.main').scroll(function () {
            if ($('.main')[0].scrollHeight - $('.main')[0].scrollTop == $('.main')[0].clientHeight) {
                var allPage = $('.main #' + ControllerGallery.getCurrentGallery() + ' .pageGallery');
                var nextPage = allPage.last().attr('data-nextPage');
                if (ControllerGallery.getCurrentGallery() == 'home') {
                    ControllerGallery.setLatestGallery(nextPage, false);
                }
                else if (ControllerGallery.getCurrentGallery() == 'top') {
                    ControllerGallery.setTopGallery(nextPage, false);
                }
                else {
                    var nextPage = $('.main #categories .pageGallery').last().attr('data-nextPage');
                    console.log(nextPage);
                    ControllerGallery.setCategoriesChild(ControllerGallery.getCurrentGallery(), nextPage, false);
                }
            }
        });
    };
    /**
     * Reset top and latest galleries
     */
    ControllerGallery.updateLatestTopGallery = function () {
        ControllerGallery.setLatestGallery(1, true);
        ControllerGallery.setTopGallery(1, true);
    };
    /**
     * Create the latest gallery
     */
    ControllerGallery.setLatestGallery = function (page, reset) {
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
    ControllerGallery.setTopGallery = function (page, reset) {
        $.ajax({
            url: './php/galleries/TopGallery.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if (reset)
                    $("#galleryTop").html(html);
                else
                    $("#galleryTop").html($(".galleryTop").html() + html);
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
    ControllerGallery.setCategories = function () {
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
    ControllerGallery.setCategoriesChild = function (name, page, reset) {
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
            ControllerGallery.setCategories();
        }
    };
    /**
     * Create the gallery of the tag
     * @param id the tag id
     * @param page the page to display category
     * @param reset if the new gallery crushed the last
     */
    ControllerGallery.setTagGallery = function (nameTag, page, reset) {
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
                ViewGallery.initGallery();
                ViewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error parent categories (' + erreur + ')');
            }
        });
    };
    /**
     * Return the current gallery
     */
    ControllerGallery.getCurrentGallery = function () {
        //To determine in which gallery we are
        var gallery = null;
        var hash = window.location.hash;
        gallery = hash.substring(hash.lastIndexOf('#') + 1);
        //If we are in a category
        if (gallery.includes('categoryName'))
            gallery = ControllerPrincipal.getUrlVars().categoryName;
        ;
        if (gallery == '')
            gallery = 'home';
        return gallery;
    };
    /**
     * Do a vote and refresh the value displayed
     * @param currentVote up or down
     * @param urlImage the image voted
     */
    ControllerGallery.setVote = function (currentVote, urlImage) {
        var gallery = ControllerGallery.getCurrentGallery();
        $.ajax({
            url: './php/Score.php',
            type: 'POST',
            data: 'currentVote=' + currentVote + '&urlImage=' + urlImage,
            dataType: 'html',
            success: function (code_html) {
                //If we are in the latests gallery
                if (gallery == 'home') {
                    ControllerGallery.updateLatestTopGallery();
                }
                else if (gallery == 'top')
                    ControllerGallery.setTopGallery(1, true);
                else if (gallery == null)
                    location.reload();
                else {
                    ControllerGallery.setCategoriesChild(gallery, false, 1);
                    ControllerGallery.setTopGallery(1, true);
                }
                //Change score displayed in the light box
                ControllerGallery.updateLightBox(code_html);
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
    ControllerGallery.updateLightBox = function (vote) {
        $('#pswp div.score').html(vote);
    };
    return ControllerGallery;
}());
