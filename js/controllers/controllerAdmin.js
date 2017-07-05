/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewAdmin.ts" />
/// <reference path="../libs/typescript/select2.d.ts" />
/// <reference path="../application/application.ts" />
/// <reference path="controllerPrincipal.ts" />
/**
 * controller of the admin area
 */
var ControllerAdmin = (function () {
    /**
     * Constructor
     */
    function ControllerAdmin(application) {
        this.application = application;
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
        //Clear datas
        $("#admin .tags-select").each(function () {
            $(this)["0"].innerHTML = '';
        });
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
        var that = this;
        var url = $("#admin #newImage-admin #newImage-url-admin").val();
        var description = $("#admin #newImage-admin #newImage-description-admin").val();
        var categories = $("#admin #newImage-admin #newImage-categories-admin").val();
        var tags = $("#admin #newImage-admin #newImage-tags-admin").val();
        if (url == undefined || url == "") {
            that.application.getControllerPrincipal().formMsg("newImage-admin", "error", "URL is required.");
        }
        else {
            $.ajax({
                url: './php/admin/newImage.php',
                type: 'POST',
                data: 'urlImage=' + url + '&descriptionImage=' + description + '&tabCategories=' + JSON.stringify(categories) + '&tabTags=' + JSON.stringify(tags),
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        that.application.getControllerGallery().updateLatestTopGallery();
                        that.application.getControllerPrincipal().formMsg("newImage-admin", "success", "Image successfully added");
                        that.viewAdmin.resetNewImageInterface();
                    }
                    else {
                        that.application.getControllerPrincipal().formMsg("newImage-admin", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    that.application.getControllerPrincipal().formMsg("newImage-admin", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Check if the image url exist and fill fields if that is the case

     */
    ControllerAdmin.prototype.checkImageUrl = function () {
        var url = $("#admin #editImage-admin #url-image-input").val();
        var that = this;
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
                    that.application.getControllerPrincipal().formMsg("edit-image-url", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                that.application.getControllerPrincipal().formMsg("edit-image-url", "error", "Internal error.");
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
            that.application.getControllerPrincipal().formMsg("edit-image-option", "error", "URL is required.");
        }
        else {
            $.ajax({
                url: './php/admin/editImage.php',
                type: 'POST',
                data: 'urlImage=' + url + '&descriptionImage=' + description + '&tabCategories=' + JSON.stringify(categories) + '&tabTags=' + JSON.stringify(tags),
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        that.application.getControllerGallery().updateLatestTopGallery();
                        that.application.getControllerPrincipal().formMsg("edit-image-option", "success", "Image successfully edited");
                        that.viewAdmin.resetEditImageInterface();
                    }
                    else {
                        that.application.getControllerPrincipal().formMsg("edit-image-option", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    that.application.getControllerPrincipal().formMsg("edit-image-option", "error", "Internal error.");
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
                    that.application.getControllerGallery().updateLatestTopGallery();
                    that.application.getControllerPrincipal().formMsg("confirm-delete-image", "success", "Image successfully deleted.");
                    that.viewAdmin.resetEditImageInterface();
                }
                else {
                    that.application.getControllerPrincipal().formMsg("confirm-delete-image", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                that.application.getControllerPrincipal().formMsg("confirm-delete-image", "error", "Internal error.");
            }
        });
    };
    /**
     * Add a new category in the database
     */
    ControllerAdmin.prototype.newCategory = function () {
        var that = this;
        var name = $("#admin #newCategory-admin #newAdmin-name-admin").val();
        var url = $("#admin #newCategory-admin #newAdmin-url-admin").val();
        var parent = $("#admin #newCategory-admin #newCategoryParent").val();
        if (name == undefined || name == "") {
            that.application.getControllerPrincipal().formMsg("newCategory-admin", "error", "A name is required.");
        }
        else if (parent == undefined || parent == "") {
            that.application.getControllerPrincipal().formMsg("newCategory-admin", "error", "Category is required.");
        }
        else {
            $.ajax({
                url: './php/admin/newCategory.php',
                type: 'POST',
                data: 'nameCategory=' + name + '&urlImageCategory=' + url + '&idParent=' + parent,
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        that.application.getControllerPrincipal().formMsg("newCategory-admin", "success", "Category successfully added");
                        that.setSelectListCategories();
                        that.setSelectListImageCategories();
                        that.application.getControllerPrincipal().setSearchList();
                    }
                    else {
                        that.application.getControllerPrincipal().formMsg("newCategory-admin", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    console.log(resultat.responseText);
                    that.application.getControllerPrincipal().formMsg("newCategory-admin", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Check if the category name exist and fill fields if that is the case
     */
    ControllerAdmin.prototype.checkCategoryName = function () {
        var category = $("#admin #editCategory-admin #name-category-input").val();
        var that = this;
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
                    $('#admin #edit-category-admin').css('display', 'none');
                    $('#admin #edit-category-option').css('display', 'block');
                    $('#admin #category-name-delete').html(data[1]);
                }
                else {
                    that.application.getControllerPrincipal().formMsg("edit-category-admin", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                that.application.getControllerPrincipal().formMsg("edit-category-admin", "error", "Internal error.");
            }
        });
    };
    /**
     * Edit the category by it name
     */
    ControllerAdmin.prototype.editCategory = function () {
        var that = this;
        var lastName = $("#admin #editCategory-admin #name-category-input").val();
        var newName = $("#admin #editCategory-admin #edit-name-category").val();
        var url = $('#admin #editCategory-admin #category-image-url').val();
        var parent = $('#admin #editCategory-admin #editCategoryParent').val();
        if (newName == undefined || newName == "") {
            that.application.getControllerPrincipal().formMsg("edit-category-option", "error", "A name is required.");
        }
        else if (parent == undefined || parent == "") {
            that.application.getControllerPrincipal().formMsg("edit-category-option", "error", "Category is required.");
        }
        else {
            $.ajax({
                url: './php/admin/editCategory.php',
                type: 'POST',
                data: 'lastNameCategory=' + lastName + '&newNameCategory=' + newName + '&urlImageCategory=' + url + '&idParent=' + parent,
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        that.application.getControllerPrincipal().formMsg("edit-category-admin", "success", "Category successfully edited.");
                        that.application.getControllerGallery().updateLatestTopGallery();
                        that.viewAdmin.resetEditCategoryInterface();
                        that.setSelectListCategories();
                        that.setSelectListImageCategories();
                        that.application.getControllerPrincipal().setSearchList();
                    }
                    else {
                        that.application.getControllerPrincipal().formMsg("edit-category-option", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    that.application.getControllerPrincipal().formMsg("edit-category-option", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Delete the category by it name
     */
    ControllerAdmin.prototype.deleteCategory = function () {
        var that = this;
        var name = $("#admin #editCategory-admin #name-category-input").val();
        $.ajax({
            url: './php/admin/deleteCategory.php',
            type: 'POST',
            data: 'nameCategory=' + name,
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    that.application.getControllerPrincipal().formMsg("confirm-delete-category", "success", "Category successfully deleted.");
                    that.application.getControllerGallery().updateLatestTopGallery();
                    that.viewAdmin.resetEditCategoryInterface();
                    that.setSelectListCategories();
                    that.setSelectListImageCategories();
                    that.application.getControllerPrincipal().setSearchList();
                }
                else {
                    that.application.getControllerPrincipal().formMsg("confirm-delete-category", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                that.application.getControllerPrincipal().formMsg("confirm-delete-category", "error", "Internal error.");
            }
        });
    };
    /**
     * Add new tags in the database
     */
    ControllerAdmin.prototype.addTags = function () {
        var that = this;
        var tags = $('#admin #editTags-admin .new-tags-select').val();
        if (tags == undefined || tags == "") {
            that.application.getControllerPrincipal().formMsg("editTags-admin", "error", "Tags is required.");
        }
        else {
            $.ajax({
                url: './php/admin/addTags.php',
                type: 'POST',
                data: 'tags=' + JSON.stringify(tags),
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        that.setSelectListTags();
                        that.application.getControllerPrincipal().formMsg("editTags-admin", "success", "Tags that do not exist have been successfully added.");
                        that.viewAdmin.resetEditTagInterface();
                        that.application.getControllerPrincipal().setSearchList();
                    }
                    else {
                        that.application.getControllerPrincipal().formMsg("editTags-admin", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    that.application.getControllerPrincipal().formMsg("editTags-admin", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Delete the tags by name
     */
    ControllerAdmin.prototype.deleteTags = function () {
        var that = this;
        var tags = $('#admin #editTags-admin .tags-select').val();
        if (tags == undefined || tags == "") {
            $('#admin #confirm-delete-tag').modal('hide');
            that.application.getControllerPrincipal().formMsg("editTags-admin", "error", "Tags is required.");
        }
        else {
            $.ajax({
                url: './php/admin/deleteTags.php',
                type: 'POST',
                data: 'tags=' + JSON.stringify(tags),
                dataType: 'json',
                success: function (data) {
                    if (data[0] === "success") {
                        that.setSelectListTags();
                        that.application.getControllerPrincipal().formMsg("editTags-admin", "success", "Tags that exist have been successfully deleted.");
                        that.application.getControllerGallery().updateLatestTopGallery();
                        that.viewAdmin.resetEditTagInterface();
                        that.application.getControllerPrincipal().setSearchList();
                    }
                    else {
                        that.application.getControllerPrincipal().formMsg("confirm-delete-tag", "error", data[1]);
                    }
                },
                error: function (resultat, statut, erreur) {
                    that.application.getControllerPrincipal().formMsg("confirm-delete-tag", "error", "Internal error.");
                }
            });
        }
    };
    /**
     * Delete all tags, categories and images which aren't referenced to other element
     */
    ControllerAdmin.prototype.deleteUnreferencedRecords = function () {
        var that = this;
        $.ajax({
            url: './php/admin/deleteUnreferencedRecords.php',
            dataType: 'json',
            success: function (data) {
                if (data[0] === "success") {
                    that.setSelectListTags();
                    that.setSelectListCategories();
                    that.setSelectListImageCategories();
                    that.application.getControllerPrincipal().formMsg("confirm-delete-unreferenced", "success", "All unreferenced records have been successfully deleted.");
                    that.application.getControllerGallery().updateLatestTopGallery();
                    that.application.getControllerPrincipal().setSearchList();
                }
                else {
                    that.application.getControllerPrincipal().formMsg("confirm-delete-unreferenced", "error", data[1]);
                }
            },
            error: function (resultat, statut, erreur) {
                that.application.getControllerPrincipal().formMsg("confirm-delete-unreferenced", "error", "Internal error.");
            }
        });
    };
    return ControllerAdmin;
}());
