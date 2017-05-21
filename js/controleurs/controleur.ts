/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../vues/vue.ts" />

/**
 * Constroleur principal de l'application
 */
class Controleur {
    /**
     * Vue associ� au controleur
     */
    private vue: Vue;

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

    /**
     * Change l'interface en fonction des param�tres en entr�es
     * @param form
     * @param type
     * @param msg
     */
    static formMsg(form, type, msg) {
        if (type == 'success') {
            $("#" + form + "-form .msg-error").css('display', 'none');
            $("#" + form +"-form .msg-success span").html(msg);
            $("#" + form +"-form .msg-success").css('display', 'block');
            $("#div-forms").css("height", $("#" + form +"-form").height());
        }
        else if (type == 'error') {
            $("#" + form + "-form .msg-success").css('display', 'none');
            $("#" + form +"-form .msg-error span").html("  " +msg);
            $("#" + form +"-form .msg-error").css('display','block');
            $("#div-forms").css("height", $("#" + form +"-form").height());
        }
    }

    /**
     * Appel le script g�rant la connexion
     */
    static login() {
        $.ajax({
            url: './php/functions/login.php',
            type: 'post',
            dataType: 'json',
            data: 'login_username_mail=' + $('input[name=login_username_mail]').val() +'&login_password=' + $('input[name=login_password]').val(),
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("login", "success", "Connexion r�ussie");
                    document.location.reload(true);
                } else {
                    Controleur.formMsg("login", "error", data[1]);
                }
            },
            error: function () {
                Controleur.formMsg("login", "error", "Internal error.");
            }
        });
    }

    static lostPassword() {
        $.ajax({
            url: './php/functions/lostPassword.php',
            type: 'post',
            dataType: 'json',
            data: 'lost_mail=' + $('input[name=lost_mail]').val(),
            success: function (data) {
        	    if (data[0] === "success") {
                    Controleur.formMsg("lost", "success", "E-mail sent, please go to your inbox.");
        	    } else {
                    Controleur.formMsg("lost", "error", data[1]);
        	    }
            },
            error: function () {
        		Controleur.formMsg("lost", "error", "Internal error (Check if your server can send mails).");
            }
        });
    }

    /**
     * Formulaire des param�tres
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
     * Cr�e les gallerys latest et top
     */
    public setGallery() {
        $(".galleryLatest").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/LastGallery.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    Vue.initialiserGallery();
                    Vue.initialiserLightBox();
                },
                error: function (resultat, statut, erreur) {
                    alert('erreur gallery latest (' + erreur + ')');
                }
            });
        });

        $(".galleryTop").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/TopGallery.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    Vue.initialiserGallery();
                    Vue.initialiserLightBox();
                },
                error: function (resultat, statut, erreur) {
                    alert('erreur gallery top ('+erreur+')');
                }
            });
        });
    }

    /**
     * Fait un vote
     * @param urlImage
     */
    static setVote(currentVote, urlImage) {
        var that = this;
        $.ajax({
            url: './php/Score.php',
            type: 'GET',
            data: 'currentVote=' + currentVote +'&urlImage=' + urlImage,
            dataType: 'html',
            success: function (code_html) {
            },
            error: function (resultat, statut, erreur) {
                alert('erreur vote (' + urlImage + ': ' + currentVote + ')');
            }
        });
        location.reload();
    }

    /**
     * Cr�e la gallery des categories parent
     */
    static setCategories() {
        $(".galleryCategories").each(function () {
            var that = this;
            $.ajax({
                url: './php/galleries/ParentCategories.php',
                type: 'GET',
                //async: false,
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                },
                error: function (resultat, statut, erreur) {
                    alert('erreur parent categories (' + erreur + ')');
                }
            });
        });
    }

    static setCategoriesChild(name) {
        if (name != 'null') {
            var controleur = this;
            $(".galleryCategories").each(function () {
                var that = this;
                $.ajax({
                    url: './php/galleries/ChildCategories.php',
                    type: 'GET',
                    //async: false,
                    data: 'nameParent=' + name,
                    dataType: 'html',
                    success: function (code_html) {
                        $(that).html(code_html);
                        Vue.initialiserGallery();
                        Vue.initialiserLightBox();
                    },
                    error: function (resultat, statut, erreur) {
                        alert('erreur categorie ' + name + ' (' + erreur + ')');
                    }
                });
            });
        }
        else {
            this.setCategories();
        }
    }

    /**
     * Retourne si le param est dans l'url
     */
    static urlContain(param) {
        var string = window.location.href,
            substring = param;
        return string.includes(substring);
    }

    /**
     * Retourne toutes les vars de l'url
     */
    static getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }
}