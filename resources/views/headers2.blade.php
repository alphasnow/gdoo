@verbatim
<div class="panel-heading tabs-box">
    <ul class="nav nav-tabs">
        <template v-for="tab in header.tabs.items">
        <li :class="header.tabs.active == tab.value ? 'active' : ''">
            <a class="text-sm" @click="tabBtn(tab)">{{tab.name}}</a>
        </li>
        </template>
    </ul>
</div>

<div class="wrapper-xs">
    <div class="pull-right">
        <template v-for="button in header.right_buttons">
            <a v-if="button.display" @click="linkBtn(button)" :class="'btn btn-sm btn-' + button.color"><i :class="'fa ' + button.icon"></i> {{button.name}}</a>
        </template>

        <a v-if="header.trash_btn" @click="actBtn('trash')" :class="'btn btn-sm btn-default ' + (header.search_form.query.by == 'trash' ? 'active' : '')"><i class="fa fa-trash"></i>回收站 ({{header.trash_count}})</a>
    </div>

    <a v-if="header.access.create && header.create_btn" @click="actBtn('create')" class="btn btn-sm btn-success hinted" :title="'新建' + header.name"><i class="icon icon-plus"></i> 新建</a>
    
    <div class="btn-group">
        <a class="btn btn-info btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bars"></i> 操作 <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <template v-for="button in header.center_buttons">
                <li v-if="button.action == 'divider'" class="divider"></li>
                <li v-else-if="button.display == 1"><a @click="linkBtn(button)"><i class="'fa ' + button.icon"></i> {{button.name}}</a></li>
            </template>
        </ul>
    </div> 

    <span class="visible-xs">
        <div class="btn-group">
        <a @click="actBtn('filter')" class="btn btn-sm btn-default"><i class="fa fa-search"></i> 搜索</a>
        </div>
    </span>

    <!-- 简单搜索表单 -->
    <form v-if="header.search_form.simple_search" :id="header.table + '-search-form'" class="search-inline-form form-inline hidden-xs" name="mysearch" method="get">
        <div class="form-group search-group">
            <select name="field_0" id="search-field-0" class="form-control input-sm">
                <option data-type="empty" value="">筛选条件</option>
                <template v-for="column in header.search_form.columns">
                    <option :data-type="column.form_type" :data-title="column.name" :value="column.field">{{column.name}}</option>
                </template>
            </select>
        </div>
        
        <div class="form-group" style="display:none;"> 
            <select name="condition_0" id="search-condition-0" class="form-control input-sm"></select> 
        </div> 
        
        <div class="form-group" id="search-value-0"></div>
        
        <div class="btn-group">
            <button id="search-submit" type="submit" class="btn btn-sm btn-default">
                <i class="fa fa-search"></i> 搜索</button>
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu text-xs" role="menu">
                <li><a @click="actBtn('filter')"><i class="fa fa-search"></i> 高级搜索</a></li>
            </ul>
        </div>
    </form>
    <a v-else class="btn btn-sm btn-default" @click="actBtn('filter')"><i class="fa fa-search"></i> 筛选</a>

    <div v-if="header.bys" class="btn-group" role="group">
        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-filter"></span> {{header.by_title}}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <template v-for="item in header.bys.items">
                <li v-if="item.value == 'divider'" class="divider"></li>
                <li v-else :class="item.value == header.bys.value ? 'active' : ''"><a @click="byBtn(item)">{{item.name}}</a></li>
            </template>
        </ul>
    </div>

    <template v-for="button in header.left_buttons">
        <a v-if="button.display == 1" @click="linkBtn(button)" :class="'btn btn-sm btn-' + button.color"><i :class="'fa ' + button.icon"></i> {{button.name}}</a> 
    </template>
    
    <div style="display:none;">
        <form :id="header.table + '-search-form-advanced'" class="search-form" method="get">
            <div class="wrapper-xs1 search-form-advanced">
                <div class="row">

                    <template v-for="(column, i) in header.search_form.columns">

                        <div class="wrapper-xs" v-if="column.form_type != 'text2'">
                            <div class="form-group">
                                <label class="control-label col-xs-3">{{column.name}}</label>
                                <?php
                                if (is_array($column['form_type'])) {
                                    $_type = $column['form_type'][0];
                                } else {
                                    $_type = $column['form_type'];
                                }
                                ?>
                                <input type="hidden" :name="'field_'+i" :id="'advanced-search-field-'+i" :data-title="column.name" :data-type="column.form_type" :value="column.field">
                            </div>
                            <div class="col-xs-2">
                            <div class="form-group" style="display:none;">
                                <select :name="'condition_'+i" :id="'advanced-search-condition-'+i" class="form-control input-sm"></select>
                            </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="form-group" :id="'advanced-search-value-'+i"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </template>

                </div>
            </div>
        </form>
    </div>

</div>
@endverbatim