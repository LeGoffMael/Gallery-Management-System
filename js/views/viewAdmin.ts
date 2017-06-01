/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerAdmin.ts" />

/**
 * View of the admin area
 */
class ViewAdmin {
    /**
     * controller associated to the view
     */
    private controllerAdmin: ControllerAdmin = null;

    /**
    * Constructor
    * @param {ControllerAdmin} controllerAdmin controller associated to the view
    */
    constructor(controller: ControllerAdmin) {
        this.controllerAdmin = controller;
        this.initAdminArea();
    }

    /**
     * Initializes the administration area
     */
    private initAdminArea() {
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
    }
}