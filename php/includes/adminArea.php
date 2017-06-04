<!--Admin zone-->
<section class="tab-pane fade" id="admin">
    <h1>Administration</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion">
                <!--New image-->
                <div class="panel panel-default" id="newImage-admin">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> NEW IMAGE</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div id="div-general-msg">
                                <div class="alert alert-danger msg-error">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                    <span></span>
                                </div>
                                <div class="alert alert-success msg-success">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="newImage-url-admin" placeholder="The address of the image" required />
                                <br />
                                <textarea class="form-control" id="newImage-description-admin" placeholder="Description" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="categoriesSelection">
                                    <div class="form-group">
                                        <label for="newImage-categories-admin"> Category </label>
                                        <select multiple="true" class="form-control image-categories-select" id="newImage-categories-admin" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="tagsSelection">
                                    <div class="form-group">
                                        <label for="newImage-tags-admin"> Tags</label>
                                        <select multiple="true" class="form-control tags-select" id="newImage-tags-admin" placeholder="Tags">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <form class="form form-inline " role="form">
                                <div class="form-group">
                                    <button type="submit" id="submit-newImage-admin" class="btn btn-success btn-sm">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Edit image-->
                <div class="panel panel-default" id="editImage-admin">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> EDIT IMAGE</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-md-12" id="edit-image-url">
                                <div id="div-general-msg">
                                    <div class="alert alert-danger msg-error">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                    <div class="alert alert-success msg-success">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="text" id="url-image-input" class="form-control" placeholder="The URL of the image to edit" required />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" id="check-image-admin" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div id="edit-image-option">
                                <div id="div-general-msg">
                                    <div class="alert alert-danger msg-error">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                    <div class="alert alert-success msg-success">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <textarea id="edit-image-description" class="form-control" placeholder="Description" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="categorySelection">
                                        <div class="form-group">
                                            <label for="category"> Category </label>
                                            <select multiple="true" class="form-control image-categories-select" id="category" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="tagsSelection">
                                        <div class="form-group">
                                            <label for="tags"> Tags</label>
                                            <select multiple="true" class="form-control tags-select" id="tags" placeholder="Tags"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="submit-saveImage-admin" class="btn btn-success btn-sm">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" id="image-delete" data-target="#confirm-delete-image">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </button>
                                    <button id="cancel-edit-image" class="btn btn-secondary btn-sm">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--New category-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-bookmark"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTree"> NEW CATEGORY</a>
                        </h4>
                    </div>
                    <div id="collapseTree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Title" required />
                                <br />
                                <input type="text" class="form-control" id="categorie-image-url" placeholder="Category's image url" required />
                            </div>
                            
                            <label for="newCategoryParent"> Category's parent :</label>
                            <select class="form-control categories-select" id="newCategoryParent" required>
                                <option value="-1">Root</option>
                            </select>

                            <br />

                            <form class="form form-inline " role="form">
                                <div class="form-group">
                                    <button type="submit" id="submit-newCategory-admin" class="btn btn-success btn-sm">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--Edit category-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-bookmark"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"> EDIT CATEGORY</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-md-12" id="edit-category-name">
                                <div id="div-general-msg">
                                    <div class="alert alert-danger msg-error">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                    <div class="alert alert-success msg-success">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="name-category-input" placeholder="The category to edit" required />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" id="check-category-admin" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div id="edit-category-option">
                                <div class="col-md-12">
                                    <input type="text" id="edit-name-category" class="form-control" placeholder="Title" required />
                                    <br />
                                    <input type="text" class="form-control" id="category-image-url" placeholder="Category's image url" required />
                                
                                    <label for="editCategoryParent"> Category's parent :</label>
                                    <select class="form-control categories-select" id="editCategoryParent" required>
                                        <option value="-1">Root</option>
                                    </select>
									<br/>
								</div>

                                <div class="form-group">
                                    <button type="submit" id="submit-saveCategory-admin"  class="btn btn-success btn-sm">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                    <button class="btn btn-danger btn-sm" id="categorie-delete" data-toggle="modal" data-target="#confirm-delete-category">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </button>
                                    <button id="cancel-edit-category" class="btn btn-secondary btn-sm">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Edit tags-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"> MANAGE TAGS</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-md-12" id="manage-tag">
                                <div class="input-group" id="add-tag">
                                    <select multiple="true" class="new-tags-select"></select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" id="submit-newTag-admin" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                                <br />
                                <div class="input-group" id="delete-tag">
                                    <select multiple="true" class="form-control tags-select"></select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete-tag">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal delete image-->
    <div class="modal fade confirm-delete" id="confirm-delete-image" tabindex="-1" role="dialog" aria-labelledby="label-delete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" id="label-delete">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <div id="div-general-msg">
                        <div class="alert alert-danger msg-error">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <span></span>
                        </div>
                        <div class="alert alert-success msg-success">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <span></span>
                        </div>
                    </div>
                    <p>You are about to delete <b><i id="image-name-delete"></i></b>, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submit-deleteImage-admin" class="btn btn-danger btn-ok">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal delete category-->
    <div class="modal fade confirm-delete" id="confirm-delete-category" tabindex="-1" role="dialog" aria-labelledby="label-delete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" id="label-delete">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete <b><i id="category-name-delete"></i></b>, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submit-deleteCategory-admin" class="btn btn-danger btn-ok">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal delete tag-->
    <div class="modal fade confirm-delete" id="confirm-delete-tag" tabindex="-1" role="dialog" aria-labelledby="label-delete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" id="label-delete">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete <b><i id="tag-name-delet"></i></b>, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submit-deleteTag-admin" class="btn btn-danger btn-ok">Delete</button>
                </div>
            </div>
        </div>
    </div>
</section>