<?php namespace Gdoo\Workflow\Controllers;

use DB;
use Auth;
use Request;

use Gdoo\Index\Controllers\DefaultController;

use Gdoo\User\Models\User;

class WidgetController extends DefaultController
{
    public $permission = ['index'];
    
    public function index()
    {
        if (Request::method() == 'POST') {
            $rows = [];
            $json['total'] = sizeof($rows);
            $json['data'] = $rows;
            return $json;
        }
        return $this->render();
    }
}
