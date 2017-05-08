/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../vues/vue.ts" />

/**
 * Constroleur principal de l'application
 */
class Controleur {
    /**
     * Vue associé au controleur
     */
    private vue: Vue;

    private login: boolean = false;

    /**
     * Constructeur
     */
    constructor() {
        this.setGallery();
    }

    /**
     * Initialisation du controleur
     */
    initialiser() {
        this.vue = new Vue(this);
    }

    //Getter et Setter de l'état de connexion
    public get Login(): boolean {
        return this.login;
    }
    /**
     * Initialise la navigation en fonction de l'état de connexion
     * @param l
     */
    public setLogin(l: boolean) {
        this.login = l;

        if (this.Login == false) {
            $("#nav-logout").css("display", "none");
            $("#nav-login").css("display", "block");
            $(".nav-log").css("display", "none");
        }
        else {
            $("#nav-logout").css("display", "block");
            $("#nav-login").css("display", "none");
            $(".nav-log").css("display", "block");
        }
    }

    /**
     * Formulaire des paramètres
     */
    public submitGeneralSettings() {
        var title = $('#site-title').val();
        var limit = $('#site-limits').val();
        var language = $('#site-language').val();
        
        $.ajax({
            url: './php/Settings.php',
            type: 'GET',
            data: 'title=' + title + '&limit=' + limit + '&language=' + language,
            dataType: 'html',
            error: function (resultat, statut, erreur) {
                alert('erreur');
            }
        });
    }

    /**
     * Crée les gallerys latest et top
     */
    public setGallery() {
        $(".galleryLatest").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/LastGallery.php',
                type: 'GET',
                async: false,
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                },
                error: function (resultat, statut, erreur) {
                    console.log('erreur gallery latest (' + erreur + ')');
                }
            });
        });

        $(".galleryTop").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/TopGallery.php',
                type: 'GET',
                async: false,
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                },
                error: function (resultat, statut, erreur) {
                    console.log('erreur gallery top ('+erreur+')');
                }
            });
        });
    }

    /**
     * Crée la gallery des categories parent
     */
    static setCategories() {
        $(".galleryCategories").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/ParentCategories.php',
                type: 'GET',
                async: false,
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                },
                error: function (resultat, statut, erreur) {
                    console.log('erreur parent categories (' + erreur + ')');
                }
            });
        });
    }

    static setCategoriesChild(name) {
        var controleur = this;
        $(".galleryCategories").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/ChildCategories.php',
                type: 'GET',
                async: false,
                data: 'nameParent=' + name,
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    Vue.initialiserGallery();
                    Vue.initialiserLightBox();
                },
                error: function (resultat, statut, erreur) {
                    console.log('erreur categorie '+name+' (' + erreur + ')');
                }
            });
        });
    }
}