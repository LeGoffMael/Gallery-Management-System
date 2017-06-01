/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewGallery.ts" />

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
        this.setLatestGallery();
        this.setTopGallery();
    }

    /**
     * Create the latest gallery
     */
    public setLatestGallery() {
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
    }

    /**
     * Create the top gallery
     */
    public setTopGallery() {
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
    }

    /**
     * Create parent categories gallery
     */
    static setCategories() {
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
    }

    /**
     * Create the child categories of the category send in parameters
     * @param name the parent category
     */
    static setCategoriesChild(name) {
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
    }

    /**
     * Do a vote
     * @param currentVote up or down
     * @param urlImage the image voted
     */
    static setVote(currentVote, urlImage) {
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
    }
}