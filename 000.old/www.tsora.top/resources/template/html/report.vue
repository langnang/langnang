<p class="alert alert-success" role="report">
	说明
	<button class="btn btn-success btn-xs pull-right" type="button" for="developmentReport">开发报告</button>
	<button class="btn btn-warning btn-xs pull-right" type="button" for="bugFeedback">BUG反馈</button>
</p>
<table class="table table-striped" role="developmentReport" style="display: none;">
	<caption class="text-center h3">开发报告</caption>
	<thead>
		<tr>
			<th class="text-center">功能描述</th>
			<th class="text-center">知识技术</th>
			<th class="text-center">完成状态</th>
			<th class="text-center">存在问题</th>
		</tr>
	</thead>
	<tbody class="text-center">
		<tr>
			<td>获取文件夹中所有Echarts类别</td>
			<td>$.ajax({});PHP:Filesystem函数</td>
			<td>Success</td>
			<td>None</td>
		</tr>
		<tr>
			<td>遍历数组并获取相应文件中文件</td>
			<td>Array:forEach();$.ajax({async:false});PHP:Filesystem函数</td>
			<td>Success</td>
			<td>ajax同步渲染，若文件过多可能存在卡顿</td>
		</tr>
		<tr>
			<td>基于Vue框架的循环渲染</td>
			<td>Vue:v-for=""</td>
			<td>Success</td>
			<td>v-bind:href导致页面无法正常渲染</td>
		</tr>
		
	</tbody>
</table>
<table class="table table-striped" role="bugFeedback" style="display: none;">
	<caption class="text-center h3">BUG反馈</caption>
	<thead>
		<tr>
			<th class="text-center">功能描述</th>
			<th class="text-center">知识技术</th>
			<th class="text-center">完成状态</th>
			<th class="text-center">存在问题</th>
		</tr>
	</thead>
	<tbody class="text-center">
		<tr>
			<td>获取文件夹中所有Echarts类别</td>
			<td>$.ajax({});PHP:Filesystem函数</td>
			<td>Success</td>
			<td>None</td>
		</tr>
		<tr>
			<td>遍历数组并获取相应文件中文件</td>
			<td>Array:forEach();$.ajax({async:false});PHP:Filesystem函数</td>
			<td>Success</td>
			<td>ajax同步渲染，若文件过多可能存在卡顿</td>
		</tr>
		<tr>
			<td>基于Vue框架的循环渲染</td>
			<td>Vue:v-for=""</td>
			<td>Success</td>
			<td>v-bind:href导致页面无法正常渲染</td>
		</tr>
		
	</tbody>
</table>