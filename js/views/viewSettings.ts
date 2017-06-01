/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerSettings.ts" />

/**
 * View of the settings area
 */
class ViewSettings {
    /**
     * controller associated to the view
     */
    private controllerSettings: ControllerSettings = null;

    /**
    * Constructor
    * @param {controllerSettings} controller controller associated to the view
    */
    constructor(controller: ControllerSettings) {
        this.controllerSettings = controller;
        this.initSettingsZone();
    }

    /**
     * Initializes the configuration area
     */
    private initSettingsZone() {
        var that = this;
        $('body').on('click', '#submit-general-settings', function (e) {
            e.preventDefault();
            that.controllerSettings.submitGeneralSettings();
        });
        $('body').on('click', '#submit-appareance-settings', function (e) {
            e.preventDefault();
            that.controllerSettings.changeTheme();
        });
        $('body').on('click', '#newTheme-button', function (e) {
            that.controllerSettings.addTheme();
        });
        $('body').on('click', '#submit-account-settings', function (e) {
            e.preventDefault();
            that.controllerSettings.submitAccountSettings();
        });
        $('body').on('click', '#submit-addAdmin-settings', function (e) {
            e.preventDefault();
            that.controllerSettings.addAdmin();
        });
        $('body').on('click', '#submit-database-settings', function (e) {
            e.preventDefault();
            that.controllerSettings.changeConfig();
        });
        that.initThemesRadio(null);
        $(".colored-radio").click(function () {
            that.initThemesRadio($(this));
        });
    }

    /**
     * Initializes themes radio button
     * @param click Represents the theme clicked (null by default)
     */
    private initThemesRadio(click) {
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
    }
}