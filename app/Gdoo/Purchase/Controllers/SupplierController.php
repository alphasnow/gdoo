<?php namespace Gdoo\Purchase\Controllers;

use DB;
use Request;
use Auth;
use Validator;

use Gdoo\Model\Form;
use Gdoo\Model\Grid;

use Gdoo\User\Models\User;
use Gdoo\Purchase\Models\Supplier;

use Gdoo\Index\Controllers\DefaultController;

class SupplierController extends DefaultController
{
    public $permission = ['dialog'];

    public function indexAction()
    {
        $header = Grid::header([
            'code' => 'supplier',
            'referer' => 1,
            'search' => ['by' => ''],
        ]);

        $cols = $header['cols'];

        $cols['actions']['options'] = [[
            'name' => '编辑',
            'action' => 'edit',
            'display' => $this->access['edit'],
        ]];

        $search = $header['search_form'];
        $query = $search['query'];

        if (Request::method() == 'POST') {
            $model = DB::table($header['table'])->setBy($header);
            foreach ($header['join'] as $join) {
                $model->leftJoin($join[0], $join[1], $join[2], $join[3]);
            }
            $model->orderBy($header['sort'], $header['order']);

            foreach ($search['where'] as $where) {
                if ($where['active']) {
                    $model->search($where);
                }
            }

            $model->select($header['select']);
            $rows = $model->paginate($query['limit'])->appends($query);
            return Grid::dataFilters($rows, $header);
        }

        $header['buttons'] = [
            ['name' => '删除', 'icon' => 'fa-remove', 'action' => 'delete', 'display' => $this->access['delete']],
            ['name' => '导出', 'icon' => 'fa-share', 'action' => 'export', 'display' => 1],
        ];

        $header['cols'] = $cols;
        $header['tabs'] = Supplier::$tabs;
        $header['bys'] = Supplier::$bys;
        $header['js'] = Grid::js($header);

        return $this->display([
            'header' => $header,
        ]);
    }

    public function createAction($action = 'edit')
    {
        $id = (int)Request::get('id');
        $form = Form::make(['code' => 'supplier', 'id' => $id, 'action' => $action]);
        return $this->render([
            'form' => $form,
        ], 'create');
    }

    public function auditAction()
    {
        return $this->createAction('edit');
    }

    public function editAction()
    {
        return $this->createAction('edit');
    }

    public function showAction()
    {
        return $this->createAction('show');
    }

    public function dialogAction()
    {
        $search = search_form(
            ['advanced' => ''], [
                ['form_type' => 'text', 'name' => '名称', 'field' => 'supplier.name', 'options' => []],
                ['form_type' => 'text', 'name' => '编码', 'field' => 'supplier.code', 'options' => []]
        ], 'model');

        $header = Grid::header([
            'code' => 'supplier',
        ]);
        $_search = $header['search_form'];
        $query = $search['query'];

        if (Request::method() == 'POST') {
            $model = DB::table($header['table']);
            foreach ($header['join'] as $join) {
                $model->leftJoin($join[0], $join[1], $join[2], $join[3]);
            }
            $model->orderBy($header['sort'], $header['order']);

            foreach ($search['where'] as $where) {
                if ($where['active']) {
                    $model->search($where);
                }
            }

            $model->select($header['select']);
            return $model->paginate($query['limit']);
        }
        return $this->render([
            'search' => $search,
            'query' => $query,
        ]);
    }

    public function deleteAction()
    {
        if (Request::method() == 'POST') {
            $ids = Request::get('id');
            return Form::remove(['code' => 'supplier', 'ids' => $ids]);
        }
    }
}
