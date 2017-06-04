/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewAdmin.ts" />
/// <reference path="../libs/typescript/select2.d.ts" />

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

    public setSelectListCategories() {
        var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];

        $(".categories-select").select2({
            data: data
        })

    }
}