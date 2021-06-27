<?php
function main()
{
	$optionMySqlExtDAO = new OptionsMySqlExtDAO();
	$records = $optionMySqlExtDAO->queryAll();
?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				Options Management
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th><?php echo "Option Name"; ?></th>
						<th><?php echo "Option Value"; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($rc = 0; $rc < count($records); $rc++) {
						$row = $records[$rc];
					?>
						<tr id="<?php echo $row->id; ?>">
							<td><?php echo $row->name; ?></td>
							<td><?php echo ($row->type == 1) ? $row->value : $row->valueText; ?></td>
							<td>
								<a class="btn btn-xs yellow" href="option.php?action=edit&id=<?php echo $row->id; ?>">
									Edit
									<i class="fa fa-edit"></i>
								</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<style>
		.dataTables_info,
		.dataTables_paginate,
		.dataTables_length,
		.dataTables_filter {
			display: none;
		}
	</style>
<?php  }
include "template.php"; ?>