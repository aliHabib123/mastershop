<?php
include "class/Cms_general.php";
function main()
{
    $orderBy = "desc";
    $fieldName = "general_id";
    if (isset($_REQUEST["orderBy"])) {
        $orderBy = $_REQUEST["orderBy"];
        $fieldName = $_REQUEST["fieldName"];
    }

    $keywords = trim($_REQUEST["keywords"]);

    if ($keywords != "") {
        $condition.=" site_title like '%$keywords%' and ";
    }

    $condition.=" 1 order by $fieldName $orderBy ";

    // paging
    $limit=1125;
    $offset = 0;
    $page=$_REQUEST["page"];
    $recordsCount = Cms_general::count($condition);
    $numberOfPages = ceil($recordsCount/$limit);
    if ($page !="") {
        $page=$_REQUEST["page"];
        $offset = ($page - 1) * $limit ;
    }


    $condition.=" limit $limit offset $offset ";
    $records = Cms_general::select($condition); ?><div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
				<i class="fa fa-globe"></i>CMS GENERAL MANAGEMENT
				<!--
				<form name="myform223" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						Search by site title: 
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
<label><input type="checkbox" checked data-column="0">ID</label><label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Site title"; ?></label><label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Email"; ?></label>
				</div>
			</div>
			<div class="btn-group" >
				<a id="sample_editable_1_new" class="btn green" href="new_cms_general.php">
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
<th><?php echo "Site title"; ?></th>
<th><?php echo "Email"; ?></th>
<th></th>
<th></th>

				</tr>
			</thead>
			<tbody>
			
	<?php
        for ($rc=0;$rc<count($records);$rc++) {
            $cms_general = $records[$rc]; ?>
				<tr  id="<?php echo $cms_general->general_id; ?>">
					<!-- primary key -->
					<td><?php echo $cms_general->general_id; ?></td>
					<td><?php echo substr($cms_general->site_title, 0, 100);
            if (strlen($cms_general->site_title) > 100) {
                echo "...";
            } ?></td>
<td><?php echo substr($cms_general->email, 0, 100);
            if (strlen($cms_general->email) > 100) {
                echo "...";
            } ?></td>

					<td>
						<a class="btn btn-xs yellow" href="edit_cms_general.php?id=<?php echo $cms_general->general_id?>">
						Edit
						<i class="fa fa-edit"></i>
						</a>			
					</td>
					<td>
						<a class="btn btn-xs red" href="javascript:deleteAjax('cms_general', '<?php echo $cms_general->general_id; ?>')">
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
