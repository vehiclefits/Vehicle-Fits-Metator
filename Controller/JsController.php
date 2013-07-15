<?php
/**
 * Metator (http://metator.com/)
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace VehicleFitsMetator\Controller;

use Application\AbstractActionController;
use Metator\Product\Form;
use Metator\Product\Product;
use Metator\Image\Saver;

class JsController extends AbstractActionController
{

    function indexAction()
    {
        //header('Content-Type:application/x-javascript');
        require_once(__DIR__.'/../vendor/vehiclefits/vehicle-fits-core/library/VF/html/vafAjax.js.include.php');
        return $this->response;
    }

    function processAction()
    {
        require_once(__DIR__.'/../vendor/vehiclefits/vehicle-fits-core/library/VF/html/vafAjax.include.php');
        return $this->response;
    }
}