/// <reference path="../libs/typescript/jquery.d.ts" />
/// <reference path="../libs/typescript/bootstrap.d.ts" />
/// <reference path="../controllers/controllerPrincipal.ts" />

/**
 * Principal View
 */
class ViewPrincipal
{
  /**
   * controller associated to the view
   */
    private controllerPrincipal: ControllerPrincipal = null;

    /**
    * Constructor
    * @param {ControllerPrincipal} controller controller associated to the view
    */
    constructor(controller: ControllerPrincipal)
    {
        this.controllerPrincipal = controller;
    }
}