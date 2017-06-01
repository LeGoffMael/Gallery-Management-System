/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerSession.ts" />

/**
 * View of the session
 */
class ViewSession {
    /**
     * controller associated to the view
     */
    private controllerSession: ControllerSession = null;

    /**
    * Constructor
    * @param {ControllerSession} controller controller associated to the view
    */
    constructor(controller: ControllerSession) {
        this.controllerSession = controller;
        this.initLoginModal();
    }

    /**
     * Initializes the modal which containing the login form
     * source : http://bootsnipp.com/snippets/featured/modal-login-with-jquery-effects
     */
    private initLoginModal() {
        var that = this;
        $('#login_lost_btn').click(function () {
            that.modalAnimate($('#login-form'), $('#lost-form'));
        });
        $('#lost_login_btn').click(function () {
            that.modalAnimate($('#lost-form'), $('#login-form'));
        });
        $('#login-button').click(function () {
            that.controllerSession.login();
        });
        $('#lost-password-button').click(function () {
            that.controllerSession.lostPassword();
        });
    }

    /**
     * Performs animation between form changes
     * @param $oldForm
     * @param $newForm
     */
    private modalAnimate($oldForm, $newForm) {
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
    }
}