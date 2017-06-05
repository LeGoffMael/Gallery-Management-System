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
        this.initSelect();
        this.submitAdmin();
    }

    /**
     * Initializes the administration area
     */
    private initAdminArea() {
        var that = this;
        $('#admin #delete-tag button').click(function () {
            $('#admin #delete-tag button').attr('data-record-title', $('#admin #delete-tag input[type="text"]').val());
        });
        //Cancel edit
        $('#admin #cancel-edit-image').click(function () {
            that.resetEditImageInterface();
        });
        $('#admin #cancel-edit-category').click(function () {
            that.resetEditCategoryInterface();
        });
    }

    /**
     * Add data in select lists
     */
    private initSelect() {
        this.controllerAdmin.setSelectListImageCategories();
        this.controllerAdmin.setSelectListCategories();
        this.controllerAdmin.setSelectListTags();
        this.controllerAdmin.setNewTag();
    }

    /**
     * Initializes submit event
     */
    private submitAdmin() {
        var that = this;
        //When the admin add a new image
        $('#submit-newImage-admin').click(function (e) {
            that.controllerAdmin.newImage();
            e.preventDefault();
        });

        //Check if the image exist
        $('#check-image-admin').click(function (e) {
            that.controllerAdmin.checkImageUrl();
            e.preventDefault();
        });
        //When the admin edit an image
        $('#submit-saveImage-admin').click(function (e) {
            that.controllerAdmin.editImage();
            e.preventDefault();
        });
        //When the admin delete an image
        $('#submit-deleteImage-admin').click(function (e) {
            that.controllerAdmin.deleteImage();
            e.preventDefault();
        });


        //When the admin add a new category
        $('#submit-newCategory-admin').click(function (e) {
            that.controllerAdmin.newCategory();
            e.preventDefault();
        });

        //Check if the category exist
        $('#check-category-admin').click(function (e) {
            that.controllerAdmin.checkCategoryName();
            e.preventDefault();
        });
        //When the admin edit a category
        $('#submit-saveCategory-admin').click(function (e) {
            that.controllerAdmin.editCategory();
            e.preventDefault();
        });
        //When the admin delete a category
        $('#submit-deleteCategory-admin').click(function (e) {
            that.controllerAdmin.deleteCategory();
            e.preventDefault();
        });

        //When the admin add new tag(s)
        $('#submit-newTag-admin').click(function (e) {
            that.controllerAdmin.addTags();
            e.preventDefault();
        });
        //When the admin delete tag(s)
        $('#submit-deleteTag-admin').click(function (e) {
            that.controllerAdmin.deleteTags();
            e.preventDefault();
        });

        //When the admin delete all unreferenced records
        $('#submit-deleteUnreferenced-admin').click(function (e) {
            that.controllerAdmin.deleteUnreferencedRecords();
            e.preventDefault();
        });
    }

    /**
     * Reset the edit image area
     */
    public resetEditImageInterface() {
        $('#admin #confirm-delete-image').modal('hide');
        $("#admin #editImage-admin #url-image-input").val('');
        $('#admin #edit-image-url').css('display', 'block');
        $('#admin #edit-image-option').css('display', 'none');
        $('#admin #image-name-delete').html('');
    }

    /**
     * Reset the edit category area
     */
    public resetEditCategoryInterface() {
        $('#admin #confirm-delete-category').modal('hide');
        $("#admin #name-category-input").val('');
        $('#admin #edit-category-admin').css('display', 'block');
        $('#admin #edit-category-option').css('display', 'none');
        $('#admin #category-name-delete').html('');
    }

    /**
     * Reset the edit tag area
     */
    public resetEditTagInterface() {
        $('#admin #confirm-delete-tag').modal('hide');
        $('#admin #editTags-admin .new-tags-select')["0"].innerHTML = '';
        $('#admin #editTags-admin .tags-select').val('');
    }
}