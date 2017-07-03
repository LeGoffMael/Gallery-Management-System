/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewGallery.ts" />
/// <reference path="controllerPrincipal.ts" />

/**
 * controller of the galleries
 */
class ControllerGallery {

    /**
     * View associated to the controller
     */
    private viewGallery: ViewGallery;

    /**
     * Constructor
     */
    constructor() {
        this.viewGallery = new ViewGallery(this);
        ControllerGallery.updateLatestTopGallery();
        this.paginationManagement();
    }

    /**
     * Return the current gallery
     */
    static getCurrentGallery() {
        //To determine in which gallery we are
        var gallery = null;
        var hash = window.location.hash
        gallery = hash.substring(hash.lastIndexOf('#') + 1);
        //If we are in a category
        if (gallery.includes('categoryName'))
            gallery = 'categories';
        //If we are in a tag
        else if (gallery.includes('nameTag'))
            gallery = 'tags';
        else if (gallery == '')
            gallery = 'home';

        return gallery;
    }

    /**
     * Detect if the user is at the bottom
     * And update the current gallery with it next page
     */
    private paginationManagement() {
        $('.main').scroll(function () {
            if ($('.main')[0].scrollHeight - $('.main')[0].scrollTop == $('.main')[0].clientHeight) {
                var allPage = $('.main #' + ControllerGallery.getCurrentGallery() + ' .pageGallery');
                var nextPage = allPage.last();

                if (ControllerGallery.getCurrentGallery() == 'home') {
                    ControllerGallery.setLatestGallery(nextPage.attr('data-nextPage'), false);
                }
                else if (ControllerGallery.getCurrentGallery() == 'top') {
                    ControllerGallery.setTopGallery(nextPage.attr('data-nextPage'), false);
                }
                else if (ControllerGallery.getCurrentGallery() == 'categories') {
                    ControllerGallery.setCategoriesChild(ControllerPrincipal.getUrlVars().categoryName, nextPage, false);
                }
                else if (ControllerGallery.getCurrentGallery() == 'tags') {
                    ControllerGallery.setTagGallery(ControllerPrincipal.getUrlVars().nameTag, nextPage, false);
                }
                else if (ControllerGallery.getCurrentGallery() == 'search') {
                    var terms = $("#search-form input").val();
                    if (terms == "" ||terms == null)
                        terms = $("#search-form-reduce input").val();

                    ControllerGallery.setSearchResult(terms, nextPage, false);
                }
            }
        });
    }

    /**
     * Reset top and latest galleries
     */
    static updateLatestTopGallery() {
        ControllerGallery.setLatestGallery(1,true);
        ControllerGallery.setTopGallery(1, true);
    }

    /**
     * Create the latest gallery
     */
    static setLatestGallery(page,reset) {
        $.ajax({
            url: './php/galleries/LastGallery.php',
            type: 'POST',
            data: 'page=' + page,
            dataType: 'html',
            success: function (html) {
                if(reset)
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
    }

    /**
     * Create the top gallery
     */
    static setTopGallery(page,reset) {
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
    }

    /**
     * Create parent categories gallery
     */
    static setCategories() {
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
    }

    /**
     * Create the child categories of the category send in parameters
     * @param name the parent category
     * @param page the page to display category
     * @param reset if the new gallery crushed the last
     */
    static setCategoriesChild(name, page, reset) {
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
    }

    /**
     * Create the gallery of the tag
     * @param id the tag id
     * @param page the page to display category
     * @param reset if the new gallery crushed the last
     */
    static setTagGallery(nameTag, page, reset) {
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

                $('#tags h1').html('Tags::<a class="menuLink" href= "#tags" data- toggle="tab" onClick="ControllerPrincipal.setTagsList()" >' + nameTag + '</a>');

                ViewGallery.initGallery();
                ViewGallery.initLightBox();
            },
            error: function (resultat, statut, erreur) {
                console.log('error search (' + erreur + ')');
            }
        });
    }

    /**
     * Display the result of the search
     */
    static setSearchResult(terms, page, reset) {
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
    }


    /**
     * Do a vote and refresh the value displayed
     * @param currentVote up or down
     * @param urlImage the image voted
     */
    static setVote(currentVote, urlImage) {
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
                //If we are in the latests gallery
                else if (gallery == 'top')
                    ControllerGallery.setTopGallery(1, true);
                //If we are in the latests gallery
                else if (gallery == null)
                    location.reload()
                //If we are in a category
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
    }

    /**
     * Update the content of the light box
     * @param vote the new vote value
     */
    static updateLightBox(vote) {
        $('#pswp div.score').html(vote);
    }
}