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
     * Change l'interface en fonction des paramètres en entrées
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
     * Appel le script gérant la connexion
     */
    static login() {
        $.ajax({
            url: './php/account/login.php',
            type: 'post',
            dataType: 'json',
            data: 'login_username_mail=' + $('input[name=login_username_mail]').val() +'&login_password=' + $('input[name=login_password]').val(),
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("login", "success", "Connexion réussie");
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
            url: './php/account/lostPassword.php',
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
     * Formulaire des paramètres généraux
     */
    public submitGeneralSettings() {
        var title = $('#site-title').val();
        var limit = $('#site-limits').val();
        var language = $('#site-language').val();
        
        $.ajax({
            url: './php/forms/changeSettings.php',
            type: 'POST',
            data: 'title=' + title + '&limit=' + limit + '&language=' + language,
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("general-settings", "success", "Updated settings.");
                } else {
                    Controleur.formMsg("general-settings", "error", data[1]);
                }
            },
            error: function () {
                Controleur.formMsg("general-settings", "error", "Internal error.");
            }
        });
    }

     /**
     * Formulaire des paramètres de compte
     */
    public submitAccountSettings() {
        var username = $('input[name=username-settings]').val();
        var mail = $('input[name=mail-settings]').val();
        var newPassword = $('input[name=passwordSettings]').val();
        var confirmPassword = $('input[name=password2Settings]').val();

        $.ajax({
            url: './php/forms/updateAccount.php',
            type: 'post',
            dataType: 'json',
            data: 'username=' + username + '&mail=' + mail + '&newPassword=' + newPassword + '&confirmPassword=' + confirmPassword,
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("account-settings", "success", "Updated account");
                } else {
                    Controleur.formMsg("account-settings", "error", data[1]);
                }
            },
            error: function () {
                Controleur.formMsg("account-settings", "error", "Internal error.");
            }
        });
    }

    /**
     * Formulaire de changement de theme
     */
    public changeTheme() {
        var theme = $('appareance-settings input[type="radio"]:checked').val();

        $.ajax({
            url: './php/forms/changeTheme.php',
            type: 'post',
            dataType: 'json',
            data: 'idTheme=' + theme,
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("appareance-settings", "success", "Updated theme.");
                    location.reload();
                } else {
                    Controleur.formMsg("appareance-settings", "error", data[1]);
                }
            },
            error: function () {
                Controleur.formMsg("appareance-settings", "error", "Internal error.");
            }
        });
    }

    /**
    * Formulaire d'ajout d'un admin
    */
    public addAdmin() {
        var mail = $('input[name=mail-add-admin]').val();

        $.ajax({
            url: './php/forms/addAdmin.php',
            type: 'post',
            dataType: 'json',
            data: 'mail=' + mail,
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("addAdmin", "success", "E-mail sent.");
                } else {
                    Controleur.formMsg("addAdmin", "error", data[1]);
                }
            },
            error: function () {
                Controleur.formMsg("addAdmin", "error", "Internal error.");
            }
        });
    }

    /**
    * Formulaire des paramètres de la base de données
    */
    public changeConfig() {
        var name = $('input[name=database-name-settings]').val();
        var user = $('input[name=database-user-settings]').val();
        var password = $('input[name=database-pwd-settings]').val();
        var host = $('input[name=database-host-settings]').val();

        $.ajax({
            url: './php/forms/changeConfig.php',
            type: 'post',
            dataType: 'json',
            data: 'DB_NAME=' + name + '&DB_USER=' + user + '&DB_PASSWORD=' + password + '&DB_HOST=' + host,
            success: function (data) {
                if (data[0] === "success") {
                    Controleur.formMsg("database-settings", "success", "Updated config.php");
                } else {
                    Controleur.formMsg("database-settings", "error", data[1]);
                }
            },
            error: function () {
                Controleur.formMsg("database-settings", "error", "Internal error.");
            }
        });
    }


    /**
     * Crée les gallerys latest et top
     */
    public setGallery() {
        
        $(".galleryLatest").each(function () {
            var ajaxTime = new Date().getTime();
            var that = this;
            $.ajax({
                url: './php/galleries/LastGallery.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    Vue.initialiserGallery();
                    Vue.initialiserLightBox();

                    var totalTime = new Date().getTime() - ajaxTime;
                    console.log('last => ' + totalTime);
                },
                error: function (resultat, statut, erreur) {
                    alert('erreur gallery latest (' + erreur + ')');
                }
            });
        });

        $(".galleryTop").each(function () {
            var ajaxTime = new Date().getTime();
            var that = this;
            $.ajax({
                url: './php/galleries/TopGallery.php',
                type: 'GET',
                dataType: 'html',
                success: function (code_html) {
                    $(that).html(code_html);
                    Vue.initialiserGallery();
                    Vue.initialiserLightBox();

                    var totalTime = new Date().getTime() - ajaxTime;
                    console.log('top => ' + totalTime);
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
     * Crée la gallery des categories parent
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