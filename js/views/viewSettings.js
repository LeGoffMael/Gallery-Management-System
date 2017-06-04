/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerSettings.ts" />
/**
 * View of the settings area
 */
var ViewSettings = (function () {
    /**
    * Constructor
    * @param {controllerSettings} controller controller associated to the view
    */
    function ViewSettings(controller) {
        /**
         * controller associated to the view
         */
        this.controllerSettings = null;
        this.controllerSettings = controller;
        this.initSumbitSettingsArea();
    }
    /**
     * Initializes the configuration area and the on click event for submit buttons
     */
    ViewSettings.prototype.initSumbitSettingsArea = function () {
        var that = this;
        //When the admin edit de general settings
        $('#submit-general-settings').click(function (e) {
            e.preventDefault();
            that.controllerSettings.submitGeneralSettings();
        });
        //When the admin edit the current theme
        $('#submit-appareance-settings').click(function (e) {
            e.preventDefault();
            that.controllerSettings.changeTheme();
        });
        //When the admin add a new theme
        $('#newTheme-button').click(function (e) {
            e.preventDefault();
            that.controllerSettings.addTheme();
        });
        //When the admin edit her account configuration
        $('#submit-account-settings').click(function (e) {
            e.preventDefault();
            that.controllerSettings.submitAccountSettings();
        });
        //When the admin add a new admin
        $('#submit-addAdmin-settings').click(function (e) {
            e.preventDefault();
            that.controllerSettings.addAdmin();
        });
        //When the admin submit a database configuration
        $('#submit-database-settings').click(function (e) {
            e.preventDefault();
            that.controllerSettings.changeConfig();
        });
        //Initalize themes radio buttons
        that.initThemesRadio(null);
        $(".colored-radio").click(function () {
            that.initThemesRadio($(this));
        });
    };
    /**
     * Initializes themes radio button
     * @param click Represents the theme clicked (null by default)
     */
    ViewSettings.prototype.initThemesRadio = function (click) {
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
    return ViewSettings;
}());
