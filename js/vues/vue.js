/// <reference path="../controleurs/controleur.ts" />
/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../libs/bootstrap/bootstrap.d.ts" />
/// <reference path="../../packages/bootstrap-select/bootstrap-select.d.ts" />
/**
 * Vue principale de l'application
 */
var Vue = (function () {
    /**
     * Constructeur
     * @param {Controleur} controleur Controleur à associer à la vue
     */
    function Vue(controleur) {
        /**
         * Constroleur associé à la vue principale
         */
        this.controleur = null;
        this.controleur = controleur;
        this.initialiserSideBarButton();
        Vue.initialiserSideBarWidth();
        Vue.initialiserGallery();
        this.initialiserSettingsZone();
        this.initialiserAdminZone();
        this.initialiserLoginModal();
        Vue.initialiserLightBox();
    }
    /**
     * Modifie la nav lorsque l'on clique sur le bouton
     */
    Vue.prototype.initialiserSideBarButton = function () {
        var that = this;
        $(".wrapper").toggleClass("toggled");
        $(".sidebar-toggle").click(function () {
            $(".wrapper").toggleClass("toggled");
            if ($(".sidebar-toggle a i").hasClass("fa-caret-right")) {
                $(".sidebar-toggle a i").removeClass("fa-caret-right");
                $(".sidebar-toggle a i").addClass("fa-caret-left");
            }
            else if ($(".sidebar-toggle a i").hasClass("fa-caret-left")) {
                $(".sidebar-toggle a i").removeClass("fa-caret-left");
                $(".sidebar-toggle a i").addClass("fa-caret-right");
            }
            Vue.initialiserSideBarWidth();
        });
    };
    /**
     * Change l'apparence de plusieurs éléments en fonction de l'état de la nav
     */
    Vue.initialiserSideBarWidth = function () {
        //Si la nav est rétrécie
        if (($(".sidebar-nav span").css("display") == "none") || (window.matchMedia("(max-width: 770px)").matches)) {
            $(".sidebar-nav li a").css("margin-left", "0");
            $("#little-search").css("display", "block");
            $(".notifs").removeClass("pull-right");
            $(".notifs").css("margin-right", "0");
            $(".notifs").css("padding-right", "0");
            $(".notifs").children(".badge").css("font-size", "100%");
            $(".notifs").children(".badge").css("top", "0");
            $(".notifs").children(".badge").css("right", "0");
            $(".profil").css("margin-right", "0");
            $("#search-form").css("display", "none");
            $("#contact").css("margin-left", "1px");
            $("#contact").css("font-size", "90%");
            if (window.matchMedia("(max-width: 770px)").matches) {
                $(".sidebar-toggle").css('display', 'none');
                $(".sidebar").css('padding-top', '5px');
            }
        }
        else if (($(".sidebar-nav span").css("display") == "inline") || (window.matchMedia("(min-width: 770px)").matches)) {
            $(".sidebar-toggle").css('display', 'block');
            $(".sidebar").css('padding-top', '0px');
            $(".sidebar-nav li a").css("margin-left", "10px");
            $("#little-search").css("display", "none");
            $(".notifs").addClass("pull-right");
            $(".notifs").css("margin-right", "10px");
            $(".notifs").css("padding-right", "10px");
            $(".notifs").children(".badge").css("font-size", "75%");
            $(".notifs").children(".badge").css("top", "4px");
            $(".notifs").children(".badge").css("right", "-5px");
            $(".profil").css("margin-right", "20px");
            $("#search-form").css("display", "block");
            $("#contact").css("margin-left", "5px");
            $("#contact").css("font-size", "100%");
        }
    };
    /**
     * Initialise les labels tooltip
     */
    Vue.prototype.inititaliserToolTip = function () {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    };
    /**
     * Initialise la zone de configuration
     */
    Vue.prototype.initialiserSettingsZone = function () {
        var that = this;
        $('body').on('click', '#submit-general-settings', function (e) {
            e.preventDefault();
            that.controleur.submitGeneralSettings();
        });
        $('body').on('click', '#submit-account-settings', function (e) {
            e.preventDefault();
            that.controleur.submitAccountSettings();
        });
        $('body').on('click', '#submit-addAdmin-settings', function (e) {
            e.preventDefault();
            that.controleur.addAdmin();
        });
        $('body').on('click', '#submit-database-settings', function (e) {
            e.preventDefault();
            that.controleur.changeConfig();
        });
    };
    /**
     * Initialise la zone d'administration
     */
    Vue.prototype.initialiserAdminZone = function () {
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
    };
    /**
     * Initialisation de la gallerie d'image
     */
    Vue.initialiserGallery = function () {
        //On change la taille max des images en fonctions de la hauteur et de la largeur de l'écran.
        $(".gallery-container a .img-fluid").css("max-height", $(window).height() / 3);
        if (window.matchMedia("(min-width: 900px)").matches) {
            $(".gallery-container a .img-fluid").css("max-width", $(window).width() / 2);
        }
        else {
            $(".gallery-container a .img-fluid").css("max-width", $(window).width() / 3);
        }
    };
    /**
     * Initialise la modal contenant le formulaire de connexion
     * source : http://bootsnipp.com/snippets/featured/modal-login-with-jquery-effects
     */
    Vue.prototype.initialiserLoginModal = function () {
        var that = this;
        $('#login_lost_btn').click(function () { that.modalAnimate($('#login-form'), $('#lost-form')); });
        $('#lost_login_btn').click(function () { that.modalAnimate($('#lost-form'), $('#login-form')); });
    };
    /**
     * Effectue l'animation entre les changements de formulaires
     * @param $oldForm
     * @param $newForm
     */
    Vue.prototype.modalAnimate = function ($oldForm, $newForm) {
        var $modalAnimateTime = 300;
        var $msgAnimateTime = 150;
        var $msgShowTime = 2000;
        var $divForms = $('#div-forms');
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height", "auto");
        $oldForm.fadeToggle($modalAnimateTime, function () {
            $divForms.animate({ height: $newH }, $modalAnimateTime, function () {
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    };
    /**
     * Affiche le message correspondant aux données du formulaire de connexion
     * @param form
     * @param msg
     */
    Vue.prototype.msgChange = function (form, msg) {
        if (msg == "error") {
            $('#login-modal #' + form + ' #msg-error').css('display', 'block');
            $('#login-modal #' + form + ' #msg-success').css('display', 'none');
        }
        else if (msg == "success") {
            $('#login-modal #' + form + ' #msg-error').css('display', 'none');
            $('#login-modal #' + form + ' #msg-success').css('display', 'block');
        }
        else {
            $('#login-modal #msg-error').css('display', 'none');
            $('#login-modal #msg-success').css('display', 'none');
        }
    };
    /**
     * Initialise la light box
     * source : http://photoswipe.com/
     */
    Vue.initialiserLightBox = function () {
        var initPhotoSwipeFromDOM = function (gallerySelector) {
            var parseThumbnailElements = function (el) {
                var thumbElements = el.childNodes, numNodes = thumbElements.length, items = [], el, childElements, thumbnailEl, size, item;
                for (var i = 0; i < numNodes; i++) {
                    el = thumbElements[i];
                    // include only element nodes 
                    if (el.nodeType !== 1) {
                        continue;
                    }
                    childElements = el.children;
                    size = el.getAttribute('data-size').split('x');
                    //Définition des variables
                    item = {
                        src: el.getAttribute('href'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10),
                        categs: el.getAttribute('data-categories'),
                        tags: el.getAttribute('data-tags'),
                        score: el.getAttribute('data-score')
                    };
                    item.el = el; // save link to element for getThumbBoundsFn
                    if (childElements.length > 0) {
                        item.msrc = childElements[0].getAttribute('src'); // thumbnail url
                        if (childElements.length > 1) {
                            item.title = childElements[1].innerHTML; // caption (contents of figure)
                        }
                    }
                    var mediumSrc = el.getAttribute('data-med');
                    if (mediumSrc) {
                        size = el.getAttribute('data-med-size').split('x');
                        // "medium-sized" image
                        item.m = {
                            src: mediumSrc,
                            w: parseInt(size[0], 10),
                            h: parseInt(size[1], 10)
                        };
                    }
                    // original image
                    item.o = {
                        src: item.src,
                        w: item.w,
                        h: item.h
                    };
                    items.push(item);
                }
                return items;
            };
            // find nearest parent element
            //Appelée lors de l'ouverture
            var closest = function closest(el, fn) {
                return el && (fn(el) ? el : closest(el.parentNode, fn));
            };
            //Appelée lors de l'ouverture
            var onThumbnailsClick = function (e) {
                e = e || window.event;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;
                var eTarget = e.target || e.srcElement;
                var clickedListItem = closest(eTarget, function (el) {
                    return el.tagName === 'A';
                });
                if (!clickedListItem) {
                    return;
                }
                var clickedGallery = clickedListItem.parentNode;
                var childNodes = clickedListItem.parentNode.childNodes, numChildNodes = childNodes.length, nodeIndex = 0, index;
                for (var i = 0; i < numChildNodes; i++) {
                    if (childNodes[i].nodeType !== 1) {
                        continue;
                    }
                    if (childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }
                if (index >= 0) {
                    openPhotoSwipe(index, clickedGallery);
                }
                return false;
            };
            var photoswipeParseHash = function () {
                var hash = window.location.hash.substring(1), params = {};
                if (hash.length < 5) {
                    return params;
                }
                var vars = hash.split('&');
                for (var i = 0; i < vars.length; i++) {
                    if (!vars[i]) {
                        continue;
                    }
                    var pair = vars[i].split('=');
                    if (pair.length < 2) {
                        continue;
                    }
                    params[pair[0]] = pair[1];
                }
                if (params.gid) {
                    params.gid = parseInt(params.gid, 10);
                }
                return params;
            };
            var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
                var pswpElement = document.querySelectorAll('.pswp')[0], gallery, options, items;
                items = parseThumbnailElements(galleryElement);
                // define options (if needed)
                options = {
                    galleryUID: galleryElement.getAttribute('data-pswp-uid'),
                    getThumbBoundsFn: function (index) {
                        // See Options->getThumbBoundsFn section of docs for more info
                        var thumbnail = items[index].el.children[0], pageYScroll = window.pageYOffset || document.documentElement.scrollTop, rect = thumbnail.getBoundingClientRect();
                        return { x: rect.left, y: rect.top + pageYScroll, w: rect.width };
                    },
                    //On ajoute la description, les categories et les tags
                    addCaptionHTMLFn: function (item, captionEl, isFake) {
                        if (!item.title) {
                            captionEl.children[0].innerText = '';
                            return false;
                        }
                        captionEl.children[0].innerHTML = item.title + "<br/><small>Categorie(s): " + item.categs + "</small>";
                        captionEl.children[0].innerHTML += "<br/><small>Tag(s): " + item.tags + "</small>";
                        captionEl.children[0].innerHTML += "<div class='score'>" + item.score + "</a></div>";
                        return true;
                    }
                };
                if (fromURL) {
                    if (options.galleryPIDs) {
                        // parse real index when custom PIDs are used 
                        // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                        for (var j = 0; j < items.length; j++) {
                            if (items[j].pid == index) {
                                options.index = j;
                                break;
                            }
                        }
                    }
                    else {
                        options.index = parseInt(index, 10) - 1;
                    }
                }
                else {
                    options.index = parseInt(index, 10);
                }
                options.history = false;
                // exit if index not found
                if (isNaN(options.index)) {
                    return;
                }
                var radios = document.getElementsByName('gallery-style');
                for (var i = 0, length = radios.length; i < length; i++) {
                    if (radios[i].checked) {
                        if (radios[i].id == 'radio-all-controls') {
                        }
                        else if (radios[i].id == 'radio-minimal-black') {
                            options.mainClass = 'pswp--minimal--dark';
                            options.barsSize = { top: 0, bottom: 0 };
                            options.captionEl = false;
                            options.fullscreenEl = false;
                            options.shareEl = false;
                            options.bgOpacity = 0.85;
                            options.tapToClose = true;
                            options.tapToToggleControls = false;
                        }
                        break;
                    }
                }
                if (disableAnimation) {
                    options.showAnimationDuration = 0;
                }
                // Pass data to PhotoSwipe and initialize it
                gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                // see: http://photoswipe.com/documentation/responsive-images.html
                var realViewportWidth, useLargeImages = false, firstResize = true, imageSrcWillChange;
                gallery.listen('beforeResize', function () {
                    var dpiRatio = window.devicePixelRatio ? window.devicePixelRatio : 1;
                    dpiRatio = Math.min(dpiRatio, 2.5);
                    realViewportWidth = gallery.viewportSize.x * dpiRatio;
                    if (realViewportWidth >= 1200 || (!gallery.likelyTouchDevice && realViewportWidth > 800) || screen.width > 1200) {
                        if (!useLargeImages) {
                            useLargeImages = true;
                            imageSrcWillChange = true;
                        }
                    }
                    else {
                        if (useLargeImages) {
                            useLargeImages = false;
                            imageSrcWillChange = true;
                        }
                    }
                    if (imageSrcWillChange && !firstResize) {
                        gallery.invalidateCurrItems();
                    }
                    if (firstResize) {
                        firstResize = false;
                    }
                    imageSrcWillChange = false;
                });
                gallery.listen('gettingData', function (index, item) {
                    if (useLargeImages) {
                        item.src = item.o.src;
                        item.w = item.o.w;
                        item.h = item.o.h;
                    }
                    else {
                        item.src = item.m.src;
                        item.w = item.m.w;
                        item.h = item.m.h;
                    }
                });
                gallery.init();
                //Lorsque l'on clique sur un lien dans la lightbox
                $('.pswp__caption__center small').on('click', 'a', function (e) {
                    //gallery.close();
                    location.reload();
                });
            };
            // select all gallery elements
            var galleryElements = document.querySelectorAll(gallerySelector);
            for (var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute('data-pswp-uid', i + 1);
                galleryElements[i].onclick = onThumbnailsClick;
            }
            // Parse URL and open gallery if it contains #&pid=3&gid=1
            var hashData = photoswipeParseHash();
            if (hashData.pid && hashData.gid) {
                openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
            }
        };
        initPhotoSwipeFromDOM('.demo-gallery');
    };
    return Vue;
}());
