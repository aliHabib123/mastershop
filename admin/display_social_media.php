<?php
function main()
{
	$contentType = 'social-media';
	$contentMySqlExtDAO = new ContentMySqlExtDAO();
	$orderBy = "desc";
	$fieldName = "id";
	$condition = " type = '$contentType' order by $fieldName $orderBy";

	// paging
	$limit = 10000;
	$offset = 0;

	$condition .= " limit $limit offset $offset ";
	$records = $contentMySqlExtDAO->select($condition);
	?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				SOCIAL MEDIA MANAGEMENT
			</div>
			<div class="actions">
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Title"; ?></th>
						<th><?php echo "Link"; ?></th>
						<th><?php echo "Display Order"; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($rc = 0; $rc < count($records); $rc++) {
						$row = $records[$rc];
					?>
						<tr id="<?php echo $row->id; ?>">
							<!-- primary key -->
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->title?></td>
							<td><?php echo $row->customUrl?></td>
							<td><?php echo $row->displayOrder;?></td>

							<td>
								<a class="btn btn-xs yellow" href="edit_social_media.php?id=<?php echo $row->id;?>">
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
<?php  }
include "template.php"; ?>