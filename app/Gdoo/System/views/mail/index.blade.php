{{$header["js"]}}

<div class="panel no-border" id="{{$header['master_table']}}-controller">
    @include('headers')
    <div class='list-jqgrid'>
        <div id="{{$header['master_table']}}-grid" style="width:100%;" class="ag-theme-balham"></div>
    </div>
</div>
<script>
    (function ($) {
        var table = '{{$header["master_table"]}}';
        var config = gdoo.grids[table];
        var action = config.action;
        var search = config.search;

        action.dialogType = 'dialog';

        action.test = function() {
            var me = this;
            var grid = config.grid;
            var rows = grid.api.getSelectedRows();
            if (rows.length == 1) {
                formDialog({
                    title: '测试邮件',
                    url: app.url('system/mail/test', {id: rows[0].id}),
                    storeUrl: app.url('system/mail/test'),
                    id: 'mail_test',
                    dialogClass:'modal-sm',
                    success: function(res) {
                        toastrSuccess(res.data);
                        $(this).dialog("close");
                    },
                    error: function(res) {
                        toastrError(res.data);
                    }
                });
            } else {
                toastrError('只能选择一条数据。');
            }
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
                action.edit(params.data);
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