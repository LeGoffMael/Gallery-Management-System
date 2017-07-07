/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../views/viewNav.ts" />
/// <reference path="controllerGallery.ts" />
/// <reference path="../application/application.ts" />

/**
 * controller of the navigation
 */
class ControllerNav {

    /**
     * The link between controllers
     */
    private application: Application;
    /**
     * View associated to the controller
     */
    private viewNav: ViewNav;
    private latestScroll = 0;
    private topScroll = 0;

    /**
     * Constructor
     */
    constructor(application: Application) {
        this.application = application;
        this.viewNav = new ViewNav(this);
        this.initNav();
    }

    private initNav() {
        var that = this;
        $('#home-link').click(function () {
            location.href = 'index.php';
        });
        $('#nav-categ').click(function () {
            that.application.getControllerGallery().setCategories(1, true)
        });
        $('#nav-tag').click(function () {
            that.application.getControllerPrincipal().setTagsList();
        });
        //update scroll
        $('.sidebar-nav a, .sidebar-nav button').click(function () {
            if (that.getApplication().getControllerGallery().getCurrentGallery() == 'home') {
                $('.main').scrollTop(that.latestScroll);
            }
            else if (that.getApplication().getControllerGallery().getCurrentGallery() == 'top') {
                $('.main').scrollTop(that.topScroll);
                
            }
            that.application.getControllerGallery().updateCurrentGallery();
        });
    }

    public getApplication() {
        return this.application;
    }

    public setLatestScroll(scroll) {
        this.latestScroll = scroll;
    }

    public setTopScroll(scroll) {
        this.topScroll = scroll;
    }
}