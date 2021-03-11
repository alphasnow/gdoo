<div id="{{$header['master_table']}}-controller">
    <div class="panel no-border">
        @include('headers')
        <div class='list-jqgrid'>
            <div id="{{$header['master_table']}}-grid" style="width:100%;" class="ag-theme-balham"></div>
        </div>
    </div>
</div>

{{$header["js"]}}

<script>

(function ($) {
    var header = {{json_encode($header, JSON_UNESCAPED_UNICODE)}};

    var table = '{{$header["master_table"]}}';
    var config = gdoo.grids[table];
    var action = config.action;
    var search = config.search;

    action.dialogType = 'layer';

    // 自定义搜索方法
    search.searchInit = function (e) {
        var self = this;
    }
    
    var options = new agGridOptions();
    var gridDiv = document.querySelector("#{{$header['master_table']}}-grid");
    gridDiv.style.height = getPanelHeight(48);

    options.remoteDataUrl = '{{url()}}';
    options.remoteParams = search.advanced.query;
    options.columnDefs = config.cols;
    options.onRowDoubleClicked = function (params) {
        if (params.node.rowPinned) {
            return;
        }
        if (params.data == undefined) {
            return;
        }
        if (params.data.master_id > 0) {
            action.show(params.data);
        }
    };

    new agGrid.Grid(gridDiv, options);

    // 读取数据
    options.remoteData({page: 1});

    // 绑定自定义事件
    var $gridDiv = $(gridDiv);
    $gridDiv.on('click', '[data-toggle="event"]', function () {
        var data = $(this).data();
        if (data.master_id > 0) {
            action[data.action](data);
        }
    });
    config.grid = options;

})(jQuery);
</script>

@include('footers')