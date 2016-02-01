<section class="main content">
	<input type="button" onclick="logz.addEntry();" value="Dodaj log" class="add-player">
	<div class="clearfix">
		<table id="table" class="logz-table">
			<thead data-role="table-head">
			<tr data-role="header-row" class="">
				<th data-role="header-col" class="entry-no-col">
					Entry No.
				</th>
				<th data-role="header-col" class="date-col">
					Date
				</th>
				<th data-role="header-col" class="log-col">
					Log
				</th>
				<th data-role="header-col" class="controls-col">
					Controls
				</th>
			</thead>
			<tbody data-role="table-body">
				<!-- Results per log -->
			</tbody>
			<tfoot data-role="table-foot">
				<!-- Sum of results -->
			</tfoot>
		</table>
	</div>
</section>
<table class="template">
	<!-- Entry row template -->
	<tr data-role="entry-row-template" data-status="" data-id="" class="template"></tr>
	<!-- Log column template -->
	<td data-role="log-col-template" class="log-col template"></td>
	<!-- Date column template -->
	<td data-role="date-col-template" class="date-col template"></td>
	<!-- Entry No. column template -->
	<td data-role="entry-no-col-template" class="entry-no-col template"></td>
	<!-- Text input template -->
	<input data-role="input-template" type="text" value="" placeholder="log text" class="template">
	<!-- Disabled input template -->
	<div data-role="disabled-input-template" class="disabled-input template"></div>
	<!-- Controls column template -->
	<td data-role="controls-col-template" class="controls-col template">
		<input type="button" value="Sačuvaj" onclick="logz.saveRow(this)" class="finish-control button">
		<input type="button" value="Izmeni" onclick="logz.editRow(this)" class="edit-control button">
	</td>
</table>
<script>
	var logz = new LogZ("table");
</script>
