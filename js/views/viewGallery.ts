/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../libs/typescript/bootstrap-select.d.ts" />
/// <reference path="../controllers/controllerGallery.ts" />
/// <reference path="../libs/typescript/photoswipe.d.ts" />

/**
 * View of the galleries
 */
class ViewGallery {
    /**
     * controller associated to the view
     */
    private controllerGallery: ControllerGallery = null;

    private photoswipe = null;

    /**
     * Constructor
     * @param {ControllerGallery} controller controller associated to the view
     */
    constructor(controller: ControllerGallery) {
        this.controllerGallery = controller;
        this.initGallery();
        this.initLightBox();
        $(window).on('resize', this.onWindowResized.bind(this));
    }

    public getPhotoswipe() {
        return this.photoswipe;
    }

    /**
     * When the window is resized
     * @param event
     */
    private onWindowResized(event: UIEvent): void {
        this.initGallery();
    }

    /**
     * Initializing the image galleries
     */
    public initGallery() {
        //The maximum size of the images is changed according to the height and width of the screen.
        $(".gallery-container a .img-fluid").css("max-height", $(window).height() / 3);
        if (window.matchMedia("(min-width: 900px)").matches) {
            $(".gallery-container a .img-fluid").css("max-width", $(window).width() / 2);
        }
        //If it's a little screen, images are full width screen
        else if (window.matchMedia("(max-width: 500px)").matches) {
            $(".gallery-container a .img-fluid").css("max-width", $(window).width());
        }

    }

    /**
     * Initializing the light box
     * source : http://photoswipe.com/
     */
    public initLightBox() {
        var that = this;
        var initPhotoSwipeFromDOM = function (gallerySelector) {
            // parse slide data (url, description, score, categories and tags) from DOM elements 
            // (children of gallerySelector)
            var parseThumbnailElements = function (el) {
                var thumbElements = el.childNodes,
                    numNodes = thumbElements.length,
                    items = [],
                    el,
                    childElements,
                    thumbnailEl,
                    item;

                for (var i = 0; i < numNodes; i++) {

                    el = thumbElements[i];

                    // include only element nodes <a>
                    if (el.nodeType !== 1 || el.nodeName !== 'A') {
                        continue;
                    }

                    childElements = el.children;

                    var href = el.getAttribute('href');

                    //Definition of size
                    var img = new Image();
                    img.onload = function () {
                        width = this.width;
                        height = this.height;
                    };
                    img.src = href;

                    //Definition of variables
                    item = {
                        src: href,
                        w: img.width,
                        h: img.height,
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
            var closest = function closest(el, fn) {
                return el && (fn(el) ? el : closest(el.parentNode, fn));
            };

            // triggers when user clicks on thumbnail
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

                // find index of clicked item by looping through all child nodes
                // alternatively, you may define index via data- attribute
                var clickedGallery = clickedListItem.parentNode;
                var childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

                for (var i = 0; i < numChildNodes; i++) {
                    // include only element nodes <a>
                    if (childNodes[i].nodeType !== 1 || childNodes[i].nodeName !== 'A') {
                        continue;
                    }

                    if (childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }

                if (index >= 0) {
                    // open PhotoSwipe if valid index found
                    openPhotoSwipe(index, clickedGallery);
                }
                return false;
            };

            //Open the light box
            var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
                var pswpElement = document.querySelectorAll('.pswp')[0];

                items = parseThumbnailElements(galleryElement);

                // define options (if needed)
                var options = {

                    // define gallery index (for URL)
                    galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                    getThumbBoundsFn: function (index) {
                        // See Options->getThumbBoundsFn section of docs for more info
                        var thumbnail = items[index].el.children[0],
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect();

                        return { x: rect.left, y: rect.top + pageYScroll, w: rect.width };
                    },

                    //We add the description, categories and tags
                    addCaptionHTMLFn: function (item, captionEl, isFake) {
                        if (!item.title) {
                            //item.title = 'no description';
                        }
                        captionEl.children[0].innerHTML = item.title + "<br/><small>Categorie(s): " + item.categs + "</small>";
                        captionEl.children[0].innerHTML += "<br/><small>Tag(s): " + item.tags + "</small>";
                        captionEl.children[0].innerHTML += "<div class='score'>" + item.score + "</a></div>";
                        return true;
                    }
                };

                // PhotoSwipe opened from URL
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
                    } else {
                        options.index = parseInt(index, 10) - 1;
                    }
                } else {
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

                        } else if (radios[i].id == 'radio-minimal-black') {
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
                that.photoswipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                that.photoswipe.init();
                that.eventPhotoSwipe();

            };

            // select all gallery elements
            var galleryElements = document.querySelectorAll(gallerySelector);
            for (var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute('data-pswp-uid', i +1);
                galleryElements[i].onclick = onThumbnailsClick;
            }
        };

        initPhotoSwipeFromDOM(".gallery");
    }

    public eventPhotoSwipe() {
        var that = this;
        //When clicking on a link in the lightbox
        $('#pswp small a').click(function (e) {
            location.reload();
        });

        //When current item changed
        //TODO : find better event (github issue)
        this.photoswipe.listen('imageLoadComplete', function () {
            if (that.photoswipe.getCurrentIndex() == that.photoswipe.items.length - 1) {
                //Move scroll
                var scrollTop = $('.main')[0].scrollHeight - $('.main')[0].clientHeight - 1;
                $('.main').scrollTop(scrollTop);
                that.controllerGallery.paginationManagement();
            }
        });

        this.photoswipe.listen('beforeChange', function () {
            //If image dimension is 0, retry
            if (that.photoswipe.currItem.w == 0 || that.photoswipe.currItem.h == 0) {
                that.controllerGallery.getApplication().getControllerPrincipal().startLoader('#pswp');
                var img = new Image();

                img.onload = function () {
                    that.photoswipe.currItem.w = this.width;
                    that.photoswipe.currItem.h = this.height;
                    that.photoswipe.updateSize(true);
                    that.controllerGallery.getApplication().getControllerPrincipal().stopLoader('#pswp');
                };
                img.src = that.photoswipe.currItem.src;
            }
        });

        //Set variable to null after closing photoswipe
        this.photoswipe.listen('destroy', function () {
            that.photoswipe = null;
        });
    }

    //TODO : image size always at 0
    public updateItemsPhotoSwipe() {

        if (this.photoswipe != null) {
            var that = this;
            var thumbElements = new Array();
            var i = 0;

            $('#' + this.controllerGallery.getCurrentGallery() + ' .gallery-container a').each(function () {
                i++;
                if (i > that.photoswipe.getCurrentIndex()+1)
                    thumbElements.push($(this)[0]);
            });

            var numNodes = thumbElements.length,
                items = [],
                el,
                childElements,
                thumbnailEl,
                item;

            for (var i = 0; i < numNodes; i++) {

                el = thumbElements[i];

                childElements = el.children;

                var href = el.getAttribute('href');

                //Definition of size
                var img = new Image();
                img.onload = function () {
                    width = this.width;
                    height = this.height;
                };
                img.src = href;

                //Definition of variables
                item = {
                    src: href,
                    w: img.width,
                    h: img.height,
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

                // original image
                item.o = {
                    src: item.src,
                    w: item.w,
                    h: item.h
                };

                that.photoswipe.items.push(item);
                that.photoswipe.ui.update();
                that.photoswipe.invalidateCurrItems();
                that.photoswipe.updateSize(true);
            }
        }
    }
}