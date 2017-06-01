/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewAdmin.ts" />
/**
 * controller of the admin area
 */
var ControllerAdmin = (function () {
    /**
     * Constructor
     */
    function ControllerAdmin() {
        this.viewAdmin = new ViewAdmin(this);
    }
    return ControllerAdmin;
}());
