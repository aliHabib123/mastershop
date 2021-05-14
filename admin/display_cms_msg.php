<?php
include "class/Cms_msg.php";
function main()
{
    $orderBy = "desc";
    $fieldName = "Msg_ID";
    if (isset($_REQUEST["orderBy"])) {
        $orderBy = $_REQUEST["orderBy"];
        $fieldName = $_REQUEST["fieldName"];
    }

    $keywords = trim($_REQUEST["keywords"]);

    if ($keywords != "") {
        $condition.=" Msg_Description like '%$keywords%' and ";
    }

    $condition.=" 1 order by $fieldName $orderBy ";

    // paging
    $limit=1125;
    $offset = 0;
    $page=$_REQUEST["page"];
    $recordsCount = Cms_msg::count($condition);
    $numberOfPages = ceil($recordsCount/$limit);
    if ($page !="") {
        $page=$_REQUEST["page"];
        $offset = ($page - 1) * $limit ;
    }


    $condition.=" limit $limit offset $offset ";
    $records = Cms_msg::select($condition); ?><div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
				<i class="fa fa-globe"></i>CMS MSG MANAGEMENT
				<!--
				<form name="myform223" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						Search by Msg Description: 
						<input type="text" value="<?php echo $keywords ?>" name="keywords" id="keywords" style="width:300px; height:20px;"> &nbsp; 
						<input type="submit" style="" value="   Search   " />
					</div>
				</form>
				-->
		</div>
		<div class="actions">
			<div class="btn-group">
				<a class="btn default" href="#" data-toggle="dropdown">
				Columns
				<i class="fa fa-angle-down"></i>
				</a>
				<div id="sample_2_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
<label><input type="checkbox" checked data-column="0">ID</label><label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Msg Description"; ?></label>
				</div>
			</div>
			<div class="btn-group" >
				<a id="sample_editable_1_new" class="btn green" href="new_cms_msg.php">
				Add New <i class="fa fa-plus"></i>
				</a>
			</div>						
		</div>
	</div>
	<div class="portlet-body">
		<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
			<thead>
				<tr>
<th>ID</th>
<th><?php echo "Msg Description"; ?></th>
<th></th>
<th></th>

				</tr>
			</thead>
			<tbody>
			
	<?php
        for ($rc=0;$rc<count($records);$rc++) {
            $cms_msg = $records[$rc]; ?>
				<tr  id="<?php echo $cms_msg->Msg_ID; ?>">
					<!-- primary key -->
					<td><?php echo $cms_msg->Msg_ID; ?></td>
					<td><?php echo substr($cms_msg->Msg_Description, 0, 100);
            if (strlen($cms_msg->Msg_Description) > 100) {
                echo "...";
            } ?></td>

					<td>
						<a class="btn btn-xs yellow" href="edit_cms_msg.php?id=<?php echo $cms_msg->Msg_ID?>">
						Edit
						<i class="fa fa-edit"></i>
						</a>			
					</td>
					<td>
						<a class="btn btn-xs red" href="javascript:deleteAjax('cms_msg', '<?php echo $cms_msg->Msg_ID; ?>')">
							<i class="fa fa-times"></i>
							Delete
						</a>
					</td>
				</tr>
	<?php
          $c++;
            $i++;
        } ?>
			</tbody>
		</table>
	</div>
</div>
<?php
}include "template.php";?>					
