/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewGallery.ts" />
/**
 * controller of the galleries
 */
var ControllerGallery = (function () {
    /**
     * Constructor
     */
    function ControllerGallery() {
        this.viewGallery = new ViewGallery(this);
        this.setLatestGallery();
        this.setTopGallery();
    }
    /**
     * Create the latest gallery
     */
    ControllerGallery.prototype.setLatestGallery = function () {
        $(".galleryLatest").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/LastGallery.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    ViewGallery.initGallery();
                    ViewGallery.initLightBox();
                },
                error: function (resultat, statut, erreur) {
                    console.log('error gallery latest (' + erreur + ')');
                }
            });
        });
    };
    /**
     * Create the top gallery
     */
    ControllerGallery.prototype.setTopGallery = function () {
        $(".galleryTop").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/TopGallery.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    ViewGallery.initGallery();
                    ViewGallery.initLightBox();
                },
                error: function (resultat, statut, erreur) {
                    console.log('error gallery top (' + erreur + ')');
                }
            });
        });
    };
    /**
     * Create parent categories gallery
     */
    ControllerGallery.setCategories = function () {
        $(".galleryCategories").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/ParentCategories.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                },
                error: function (resultat, statut, erreur) {
                    console.log('error parent categories (' + erreur + ')');
                }
            });
        });
    };
    /**
     * Create the child categories of the category send in parameters
     * @param name the parent category
     */
    ControllerGallery.setCategoriesChild = function (name) {
        if (name != 'null') {
            $(".galleryCategories").each(function () {
                var that = this;
                $.ajax({
                    url: './php/galleries/ChildCategories.php',
                    type: 'GET',
                    data: 'nameParent=' + name,
                    dataType: 'html',
                    success: function (code_html) {
                        $(that).html(code_html);
                        ViewGallery.initGallery();
                        ViewGallery.initLightBox();
                    },
                    error: function (resultat, statut, erreur) {
                        console.log('error category ' + name + ' (' + erreur + ')');
                    }
                });
            });
        }
        else {
            ControllerGallery.setCategories();
        }
    };
    /**
     * Do a vote
     * @param currentVote up or down
     * @param urlImage the image voted
     */
    ControllerGallery.setVote = function (currentVote, urlImage) {
        var that = this;
        $.ajax({
            url: './php/Score.php',
            type: 'POST',
            data: 'currentVote=' + currentVote + '&urlImage=' + urlImage,
            dataType: 'html',
            success: function (code_html) {
                location.reload();
            },
            error: function (resultat, statut, erreur) {
                console.log('error vote (' + urlImage + ': ' + currentVote + ')');
            }
        });
    };
    return ControllerGallery;
}());
