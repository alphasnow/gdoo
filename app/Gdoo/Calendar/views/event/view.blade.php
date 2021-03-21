<table class="table table-form">
	<tr>
		<td width="15%" align="right">主题</td>
		<td align="left">
			{{$options['title']}}
		</td>
	</tr>

	<tr>
		<td align="right">地点</td>
			<td align="left">
			{{$options['location']}}
		</td>
	</tr>

	<tr>
		<td align="right">共享对象</td>
		<td>
			 {{$share['receive_name']}}
		</td>
	</tr>

	<tr>
		<td align="right">日历</td>
		<td align="left">
           	{{$calendar['displayname']}}
		</td>
	</tr>

	<tr>
		<td align="right">访问规则</td>
		<td>
			 @if($options['access_class_options']) @foreach($options['access_class_options'] as $key => $value)
				 @if($key==$options['accessclass']) {{$value}} @endif
			 @endforeach @endif
			 @if($options['allday']=='true') 全天事件 @endif
		</td>
	</tr>

	<tr>
		<td align="right">开始时间</td>
			<td align="left">
			<span id="time">
				{{$options['startdate']}}
				{{$options['starttime']}}
			</span>
		</td>
	</tr>

	<tr>
		<td align="right">结束时间</td>
		<td align="left">
			{{$options['enddate']}}
			{{$options['endtime']}}
		</td>
	</tr>

	<tr>
		<td align="right">附件管理</td>
		<td>
			@include('attachment/show')
		</td>
	</tr>

	<tr>
		<td align="right">描述</td>
		<td align="left">
			{{$options['description']}}
		</td>
	</tr>

</table>
