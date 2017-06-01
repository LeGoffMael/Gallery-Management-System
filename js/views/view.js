/// <reference path="../controlers/controler.ts" />
/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../libs/bootstrap/bootstrap.d.ts" />
/// <reference path="../../packages/bootstrap-select/bootstrap-select.d.ts" />
/**
 * Principal View
 */
var ViewPrincipal = (function () {
    /**
    * Constructor
    * @param {ControlerPrincipal} controler Controler associated to the view
    */
    function ViewPrincipal(controler) {
        /**
         * Controler associated to the view
         */
        this.controlerPrincipal = null;
        this.controlerPrincipal = controler;
        this.initialiserSettingsZone();
        this.initialiserAdminZone();
        this.initialiserLoginModal();
    }
    /**
     * Initialise la zone de configuration
     */
    ViewPrincipal.prototype.initialiserSettingsZone = function () {
        var that = this;
        $('body').on('click', '#submit-general-settings', function (e) {
            e.preventDefault();
            that.controleur.submitGeneralSettings();
        });
        $('body').on('click', '#submit-appareance-settings', function (e) {
            e.preventDefault();
            that.controleur.changeTheme();
        });
        $('body').on('click', '#newTheme-button', function (e) {
            that.controleur.addTheme();
        });
        $('body').on('click', '#submit-account-settings', function (e) {
            e.preventDefault();
            that.controleur.submitAccountSettings();
        });
        $('body').on('click', '#submit-addAdmin-settings', function (e) {
            e.preventDefault();
            that.controleur.addAdmin();
        });
        $('body').on('click', '#submit-database-settings', function (e) {
            e.preventDefault();
            that.controleur.changeConfig();
        });
        that.initialiserThemesRadio(null);
        $(".colored-radio").click(function () {
            that.initialiserThemesRadio($(this));
        });
    };
    ViewPrincipal.prototype.initialiserThemesRadio = function (click) {
        if (click == null) {
            $(".colored-radio").each(function () {
                $('.colored-radio').each(function () {
                    $(this).css('background', 'transparent');
                });
                $(".colored-radio:checked").css('background', $(".colored-radio:checked").attr('data-color'));
            });
        }
        else {
            $('.colored-radio').each(function () {
                $(this).css('background', 'transparent');
                $(this).prop('checked', false);
            });
            click.css('background', click.attr('data-color'));
            click.prop('checked', true);
        }
    };
    /**
     * Initialise la zone d'administration
     */
    ViewPrincipal.prototype.initialiserAdminZone = function () {
        //Set edit
        $('#admin #edit-image-url button').click(function () {
            $('#admin #edit-image-url').css('display', 'none');
            $('#admin #edit-image-option').css('display', 'block');
            $('#admin #image-delete').attr('data-record-title', $('#admin #edit-image-url input[type="text"]').val());
        });
        $('#admin #edit-categorie-name button').click(function () {
            $('#admin #edit-categorie-name').css('display', 'none');
            $('#admin #edit-categorie-option').css('display', 'block');
            $('#admin #categorie-delete').attr('data-record-title', $('#admin #edit-categorie-name input[type="text"]').val());
        });
        $('#admin #delete-tag button').click(function () {
            $('#admin #delete-tag button').attr('data-record-title', $('#admin #delete-tag input[type="text"]').val());
        });
        //Cancel edit
        $('#admin #cancel-edit-image').click(function () {
            $('#admin #edit-image-url').css('display', 'block');
            $('#admin #edit-image-option').css('display', 'none');
        });
        $('#admin #cancel-edit-categorie').click(function () {
            $('#admin #edit-categorie-name').css('display', 'block');
            $('#admin #edit-categorie-option').css('display', 'none');
        });
        //Modal delete
        $('#admin #confirm-delete').on('click', '.btn-ok', function (e) {
            $('#admin #confirm-delete').modal('hide');
            $('#admin #cancel-edit-image').click();
            $('#admin #cancel-edit-categorie').click();
        });
        $('#admin #confirm-delete').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
        });
    };
    /**
     * Initialise la modal contenant le formulaire de connexion
     * source : http://bootsnipp.com/snippets/featured/modal-login-with-jquery-effects
     */
    ViewPrincipal.prototype.initialiserLoginModal = function () {
        var that = this;
        $('#login_lost_btn').click(function () { that.modalAnimate($('#login-form'), $('#lost-form')); });
        $('#lost_login_btn').click(function () { that.modalAnimate($('#lost-form'), $('#login-form')); });
    };
    /**
     * Effectue l'animation entre les changements de formulaires
     * @param $oldForm
     * @param $newForm
     */
    ViewPrincipal.prototype.modalAnimate = function ($oldForm, $newForm) {
        var $modalAnimateTime = 300;
        var $msgAnimateTime = 150;
        var $msgShowTime = 2000;
        var $divForms = $('#div-forms');
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height", "auto");
        $oldForm.fadeToggle($modalAnimateTime, function () {
            $divForms.animate({ height: $newH }, $modalAnimateTime, function () {
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    };
    /**
     * Affiche le message correspondant aux données du formulaire de connexion
     * @param form
     * @param msg
     */
    ViewPrincipal.prototype.msgChange = function (form, msg) {
        if (msg == "error") {
            $('#login-modal #' + form + ' #msg-error').css('display', 'block');
            $('#login-modal #' + form + ' #msg-success').css('display', 'none');
        }
        else if (msg == "success") {
            $('#login-modal #' + form + ' #msg-error').css('display', 'none');
            $('#login-modal #' + form + ' #msg-success').css('display', 'block');
        }
        else {
            $('#login-modal #msg-error').css('display', 'none');
            $('#login-modal #msg-success').css('display', 'none');
        }
    };
    return ViewPrincipal;
}());
