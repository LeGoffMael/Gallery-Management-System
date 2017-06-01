/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../controllers/controllerPrincipal.ts" />
/**
 * Principal View
 */
var ViewPrincipal = (function () {
    /**
    * Constructor
    * @param {ControllerPrincipal} controller controller associated to the view
    */
    function ViewPrincipal(controller) {
        /**
         * controller associated to the view
         */
        this.controllerPrincipal = null;
        this.controllerPrincipal = controller;
    }
    return ViewPrincipal;
}());
