<?php namespace Gdoo\Product\Models;

use Gdoo\Index\Models\BaseModel;

class ProductMaterial extends BaseModel
{
    protected $table = 'product_material';

    public static $tabs = [
        'name' => 'tab',
        'items' => [
            ['value' => 'material.index', 'url' => 'product/material/index', 'name' => '物料清单'],
        ]
    ];

    public static $bys = [
        'name' => 'by',
        'items' => [
            ['value' => '', 'name' => '全部'],
            ['value' => 'enabled', 'name' => '启用'],
            ['value' => 'disabled', 'name' => '禁用'],
            ['value' => 'divider'],
            ['value' => 'day', 'name' => '今日创建'],
            ['value' => 'week', 'name' => '本周创建'],
            ['value' => 'month', 'name' => '本月创建'],
        ]
    ];
}
