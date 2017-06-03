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

    /**
     * Constructor
     * @param {ControllerGallery} controller controller associated to the view
     */
    constructor(controller: ControllerGallery) {
        this.controllerGallery = controller;
        ViewGallery.initGallery();
        ViewGallery.initLightBox();
        $(window).on('resize', this.onWindowResized.bind(this));
    }

    /**
     * When the window is resized
     * @param event
     */
    private onWindowResized(event: UIEvent): void {
        ViewGallery.initGallery();
    }

    /**
     * Initializing the image galleries
     */
    static initGallery() {
        //The maximum size of the images is changed according to the height and width of the screen.
        $(".gallery-container a .img-fluid").css("max-height", $(window).height() / 3);
        if (window.matchMedia("(min-width: 900px)").matches) {
            $(".gallery-container a .img-fluid").css("max-width", $(window).width() / 2);
        }
        //If it's a little screen
        else {
            $(".gallery-container a .img-fluid").css("max-width", $(window).width() / 3);
        }
    }

    /**
     * Initializing the light box
     * source : http://photoswipe.com/
     */
    static initLightBox() {
        var initPhotoSwipeFromDOM = function (gallerySelector) {

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

                    // include only element nodes 
                    if (el.nodeType !== 1) {
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

                var childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

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
                var hash = window.location.hash.substring(1),
                    params = {};

                if (hash.length < 5) { // pid=1
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
                var pswpElement = document.querySelectorAll('.pswp')[0],
                    gallery,
                    options,
                    items;

                items = parseThumbnailElements(galleryElement);

                // define options (if needed)
                options = {

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
                gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

                // see: http://photoswipe.com/documentation/responsive-images.html
                var realViewportWidth,
                    useLargeImages = false,
                    firstResize = true,
                    imageSrcWillChange;

                gallery.listen('beforeResize', function () {

                    var dpiRatio = window.devicePixelRatio ? window.devicePixelRatio : 1;
                    dpiRatio = Math.min(dpiRatio, 2.5);
                    realViewportWidth = gallery.viewportSize.x * dpiRatio;


                    if (realViewportWidth >= 1200 || (!gallery.likelyTouchDevice && realViewportWidth > 800) || screen.width > 1200) {
                        if (!useLargeImages) {
                            useLargeImages = true;
                            imageSrcWillChange = true;
                        }

                    } else {
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
                    } else {
                        item.src = item.m.src;
                        item.w = item.m.w;
                        item.h = item.m.h;
                    }
                });

                gallery.init();
                ViewGallery.eventGallery(gallery);
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
    }

    static eventGallery(element) {
        var gallery = element;
        //When the user voted
        $('div.score').on('click', 'a', function (e) {
            console.log('gallery :');
            console.log(gallery);
            gallery.invalidateCurrItems();
            gallery.updateSize(true);
            gallery.ui.update();
            console.log(ControllerGallery.getCurrentGallery());
        });
        
        //When clicking on a link in the lightbox
        $('.pswp__caption__center small').on('click', 'a', function (e) {
            console.log('reload');
            location.reload();
        });
    }
}