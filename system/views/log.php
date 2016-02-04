<section class="main content">
	<h1><?php echo $log->name; ?></h1>
	<input type="button" onclick="logz.addEntry();" value="Dodaj zapis" class="add-player">
	<div class="clearfix">
		<table id="table" class="logz-table" data-id="<?php echo $log->id; ?>">
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
				<?php $i = 0; foreach ($log_entries as $log_entry) : $i++; ?>
					<tr data-role="entry-row" data-status="inactive" data-id="<?php echo $log_entry->id; ?>" class="">
						<td data-role="entry-no-col" class="entry-no-col"><?php echo $i; ?></td>
						<td data-role="date-col" class="date-col"><?php echo $log_entry->date_added->format('d.m.Y. H:i:s'); ?></td>
						<td data-role="log-col" class="log-col">
							<div data-role="disabled-input" class="disabled-input"><?php echo $log_entry->text; ?></div></td>
						<td data-role="controls-col" class="controls-col">
							<input type="button" value="Sačuvaj" onclick="logz.saveRow(this)" class="finish-control button">
							<input type="button" value="Izmeni" onclick="logz.editRow(this)" class="edit-control button">
							<input type="button" value="Obriši" onclick="logz.deleteRow(this)" class="delete-control button">
						</td>
					</tr>
				<?php endforeach; ?>
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
		<input type="button" value="Obriši" onclick="logz.deleteRow(this)" class="delete-control button">
	</td>
</table>
<script>
	var logz = new LogZ("table");
</script>
