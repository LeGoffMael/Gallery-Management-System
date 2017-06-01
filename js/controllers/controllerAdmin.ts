/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewAdmin.ts" />

/**
 * controller of the admin area
 */
class ControllerAdmin {

    /**
     * View associated to the controller
     */
    private viewAdmin: ViewAdmin;

    /**
     * Constructor
     */
    constructor() {
        this.viewAdmin = new ViewAdmin(this);
    }
}