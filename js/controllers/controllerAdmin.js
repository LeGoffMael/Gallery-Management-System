/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewAdmin.ts" />
/// <reference path="../libs/typescript/select2.d.ts" />
/// <reference path="controllerPrincipal.ts" />
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
    /**
     * Apply the select2 plugin with datas for categories select
     */
    ControllerAdmin.prototype.setSelectListCategories = function () {
        $.ajax({
            url: './php/functions/getAllCategories.php',
            dataType: 'json',
            success: function (json) {
                $(".categories-select").select2({
                    placeholder: "Choose a category",
                    data: json,
                    width: '100%'
                });
            },
            error: function (resultat, statut, erreur) {
                $(".categories-select").select2({
                    placeholder: "No categories found",
                    width: '100%'
                });
            }
        });
    };
    /**
     * Apply the select2 plugin with datas for image categories select
     */
    ControllerAdmin.prototype.setSelectListImageCategories = function () {
        $.ajax({
            url: './php/functions/getAllCategories.php',
            dataType: 'json',
            success: function (json) {
                $(".image-categories-select").select2({
                    placeholder: "Choose categories",
                    tokenSeparators: [";"],
                    data: json,
                    width: '100%'
                });
            },
            error: function (resultat, statut, erreur) {
                $(".image-categories-select").select2({
                    placeholder: "No categories found",
                    width: '100%'
                });
            }
        });
    };
    /**
     * Apply the select2 plugin with datas for tags select
     */
    ControllerAdmin.prototype.setSelectListTags = function () {
        $.ajax({
            url: './php/functions/getAllTags.php',
            dataType: 'json',
            success: function (json) {
                $(".tags-select").select2({
                    placeholder: "Tags",
                    tokenSeparators: [";"],
                    data: json,
                    width: '100%'
                });
            },
            error: function (resultat, statut, erreur) {
                $(".tags-select").select2({
                    tags: true,
                    tokenSeparators: [';'],
                    placeholder: "No tags found",
                    width: '100%'
                });
            }
        });
    };
    /**
     * Apply the select2 plugin with for tags select
     */
    ControllerAdmin.prototype.setNewTag = function () {
        $(".new-tags-select").select2({
            tags: true,
            placeholder: "Tags name to add",
            tokenSeparators: [";"],
            width: '100%',
            allowClear: true
        });
    };
    /**
     * Add an image in the database
     */
    ControllerAdmin.prototype.newImage = function () {
        var url = $("#admin #newImage-admin #newImage-url-admin").val();
        var description = $("#admin #newImage-admin #newImage-description-admin").val();
        var categories = $("#admin #newImage-admin #newImage-categories-admin").val();
        var tags = $("#admin #newImage-admin #newImage-tags-admin").val();
        if (url == undefined || url == "") {
            ControllerPrincipal.formMsg("newImage-admin", "error", "URL is required.");
        }
        else if (categories == undefined || categories == "") {
            ControllerPrincipal.formMsg("newImage-admin", "error", "Category is required.");
        }
        else {
            $.ajax({
                url: './php/admin/newImage.php',
                type: 'POST',
                data: 'urlImage=' + url + '&descriptionImage=' + description + '&tabCategories=' + JSON.stringify(categories) + '&tabTags=' + JSON.stringify(tags),
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        ControllerGallery.updateLatestTopGallery();
                        ControllerPrincipal.formMsg("newImage-admin", "success", "Image successfully added");
                    }
                    else {
                        ControllerPrincipal.formMsg("newImage-admin", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    ControllerPrincipal.formMsg("newImage-admin", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Check if the image url exist and fill fields if that is the case

     */
    ControllerAdmin.prototype.checkImageUrl = function () {
        var url = $("#admin #editImage-admin #url-image-input").val();
        $.ajax({
            url: './php/admin/checkElement.php',
            type: 'POST',
            data: 'urlImage=' + url,
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    //Fill the fields
                    $('#admin #edit-image-option #edit-image-description').val(data[2]);
                    if (data[3][0] != null)
                        $('#admin #edit-image-option .image-categories-select').select2('val', [data[3]]);
                    if (data[4][0] != null)
                        $('#admin #edit-image-option .tags-select').select2('val', [data[4]]);
                    //Show edit box
                    $('#admin #edit-image-url').css('display', 'none');
                    $('#admin #edit-image-option').css('display', 'block');
                    $('#admin #image-name-delete').html(data[1]);
                }
                else {
                    ControllerPrincipal.formMsg("edit-image-url", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                ControllerPrincipal.formMsg("edit-image-url", "error", "Internal error.");
            }
        });
    };
    /**
     * Edit the image by it url
     */
    ControllerAdmin.prototype.editImage = function () {
        var that = this;
        var url = $("#admin #editImage-admin #url-image-input").val();
        var description = $('#admin #edit-image-option #edit-image-description').val();
        var categories = $('#admin #edit-image-option .image-categories-select').val();
        var tags = $('#admin #edit-image-option .tags-select').val();
        if (url == undefined || url == "") {
            ControllerPrincipal.formMsg("edit-image-option", "error", "URL is required.");
        }
        else if (categories == undefined || categories == "") {
            ControllerPrincipal.formMsg("edit-image-option", "error", "Category is required.");
        }
        else {
            $.ajax({
                url: './php/admin/editImage.php',
                type: 'POST',
                data: 'urlImage=' + url + '&descriptionImage=' + description + '&tabCategories=' + JSON.stringify(categories) + '&tabTags=' + JSON.stringify(tags),
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        ControllerGallery.updateLatestTopGallery();
                        ControllerPrincipal.formMsg("edit-image-option", "success", "Image successfully edited");
                        that.viewAdmin.resetEditImageInterface();
                    }
                    else {
                        ControllerPrincipal.formMsg("edit-image-option", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    console.log(resultat);
                    ControllerPrincipal.formMsg("edit-image-option", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Delete the image by it url
     */
    ControllerAdmin.prototype.deleteImage = function () {
        var that = this;
        var url = $("#admin #editImage-admin #url-image-input").val();
        $.ajax({
            url: './php/admin/deleteImage.php',
            type: 'POST',
            data: 'urlImage=' + url,
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    ControllerGallery.updateLatestTopGallery();
                    ControllerPrincipal.formMsg("confirm-delete-image", "success", "Image successfully edited");
                    that.viewAdmin.resetEditImageInterface();
                    $('#admin #confirm-delete-image').modal('hide');
                }
                else {
                    ControllerPrincipal.formMsg("confirm-delete-image", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                console.log(resultat);
                ControllerPrincipal.formMsg("confirm-delete-image", "error", "Internal error.");
            }
        });
    };
    /**
     * Add a new category in the database
     */
    ControllerAdmin.prototype.newCategory = function () {
    };
    /**
     * Check if the category name exist and fill fields if that is the case
     */
    ControllerAdmin.prototype.checkCategoryName = function () {
        var category = $("#admin #name-category-input").val();
        $.ajax({
            url: './php/admin/checkElement.php',
            type: 'POST',
            data: 'nameCategory=' + category,
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    //Fill the fields
                    $('#admin #edit-category-option #edit-name-category').val(data[1]);
                    $('#admin #edit-category-option #category-image-url').val(data[2]);
                    $('#admin #edit-category-option #editCategoryParent').select2('val', data[3]);
                    $('#admin #edit-category-option #editCategoryChild').select2('val', [data[4]]);
                    //Show edit box
                    $('#admin #edit-category-option').css('display', 'block');
                    $('#admin #edit-category-name').css('display', 'none');
                    $('#admin #category-name-delete').html(data[1]);
                }
                else {
                    ControllerPrincipal.formMsg("edit-category-name", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                ControllerPrincipal.formMsg("edit-category-name", "error", "Internal error.");
            }
        });
    };
    /**
     * Edit the category by it name
     */
    ControllerAdmin.prototype.editCategory = function () {
    };
    /**
     * Delete the category by it name
     */
    ControllerAdmin.prototype.deleteCategory = function () {
    };
    /**
     * Add new tags in the database
     */
    ControllerAdmin.prototype.addTags = function () {
    };
    /**
     * Delete the tags by name
     */
    ControllerAdmin.prototype.deleteTags = function () {
    };
    return ControllerAdmin;
}());
