<!--Admin zone-->
<section class="tab-pane fade" id="admin">
    <h1>Administration</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion">
                <!--New image-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> NEW IMAGE</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="The address of the image" required />
                                <br />
                                <textarea class="form-control" placeholder="Description" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="categorySelection">
                                    <div class="form-group">
                                        <label for="category"> Category </label>
                                        <select class="categories-select form-control" id="category" required>
                                            <option selected="selected">Choose a category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="tagsSelection">
                                    <div class="form-group">
                                        <label for="tags"> Tags (separated by ;)</label>
                                        <input type="text" class="form-control" id="tags" placeholder="Tags" />
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> EDIT IMAGE</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="col-md-12" id="edit-image-url">
                                <div class="input-group">
                                    <input type="text" id="url-image-input" class="form-control" placeholder="The URL of the image to edit" required />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div id="edit-image-option">
                                <div class="col-md-12">
                                    <textarea class="form-control" placeholder="Description" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="categorySelection">
                                        <div class="form-group">
                                            <label for="category"> Category </label>
                                            <select class="form-control" id="category" required>
                                                <option>Sport</option>
                                                <option>Travel</option>
                                                <option>Birthday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="tagsSelection">
                                        <div class="form-group">
                                            <label for="tags"> Tags (separated by ;)</label>
                                            <input type="text" class="form-control" id="tags" placeholder="Tags" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="submit-saveImage-admin" class="btn btn-success btn-sm">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-record-title="" data-toggle="modal" id="image-delete" data-target="#confirm-delete-image">
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
                            <br />
                            <div class="row">
                                <div class="col-md-6" id="categoryParentSelection">
                                    <div class="form-group">
                                        <label for="categoryParent"> Category's parent :</label>
                                        <select class="form-control" id="categoryParent">
                                            <option selected disabled>Root</option>
                                            <option>Sport</option>
                                            <option>Travel</option>
                                            <option>Birthday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="categoryChildSelection">
                                    <div class="form-group">
                                        <label for="categoryChild"> Category's childs :</label>
                                        <select class="form-control" id="categoryChild" multiple>
                                            <option>Sport</option>
                                            <option>Travel</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                            <option>Birthday</option>
                                        </select>
                                        <small>Hold down the Ctrl button to select multiple options.</small>
                                    </div>
                                </div>
                            </div>
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
                            <div class="col-md-12" id="edit-categorie-name">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="The categorie to edit" required />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div id="edit-categorie-option">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Title" required />
                                    <br />
                                    <input type="text" class="form-control" id="categorie-image-url" placeholder="Category's image url" required />
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-6" id="categoryParentSelection">
                                        <div class="form-group">
                                            <label for="categoryParent"> Category's parent :</label>
                                            <select class="form-control" id="categoryParent" required>
                                                <option>Sport</option>
                                                <option>Travel</option>
                                                <option>Birthday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="categoryChildSelection">
                                        <div class="form-group">
                                            <label for="categoryChild"> Category's childs :</label>
                                            <select class="form-control" id="categoryChild" multiple required>
                                                <option>Sport</option>
                                                <option>Travel</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                                <option>Birthday</option>
                                            </select>
                                            <small>Hold down the Ctrl button to select multiple options.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="submit-saveCategory-admin"  class="btn btn-success btn-sm">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                    </button>
                                    <button class="btn btn-danger btn-sm" id="categorie-delete" data-record-title="" data-toggle="modal" data-target="#confirm-delete-category">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </button>
                                    <button id="cancel-edit-categorie" class="btn btn-secondary btn-sm">Cancel</button>
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
                                    <input type="text" class="form-control" placeholder="Tag name to add (separated by ;)" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" id="submit-newTag-admin" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                                <br />
                                <div class="input-group" id="delete-tag">
                                    <input type="text" class="form-control" placeholder="Tag name to delete (separated by ;)" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger" data-record-title="" data-toggle="modal" data-target="#confirm-delete-tag">
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
                    <p>You are about to delete <b><i class="image-name-delete"></i></b>, this procedure is irreversible.</p>
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
                    <p>You are about to delete <b><i class="tag-name-delet"></i></b>, this procedure is irreversible.</p>
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