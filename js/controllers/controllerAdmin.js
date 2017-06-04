/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewAdmin.ts" />
/// <reference path="../libs/typescript/select2.d.ts" />
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
    ControllerAdmin.prototype.setSelectListCategories = function () {
        var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
        $(".categories-select").select2({
            data: data
        });
    };
    return ControllerAdmin;
}());
