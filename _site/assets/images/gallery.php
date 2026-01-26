<?
include ("authentication.php");
include ("menuadmin.php");
include ("class/pagination.class.php");
include ("class/tableform.class.php");
include ("class/upload.class.php");

?>
<script type="text/javascript" src="js/hidediv.js"></script>
<?
//Setting
$table 	 = 'gallery';
$tableid = 'g_id';
// Menciptakan objek paging
$items = 8;
$page = 1;
if(isset($_GET['page']) and is_numeric($_GET['page']) and $page = $_GET['page'])
{ $limit = " LIMIT ".(($page-1)*$items).",$items";}
		else
{$limit = " LIMIT $items";}

// Menciptakan query
$sql 	= "SELECT * FROM $table ORDER BY g_product_id, g_sort ASC";
$numpage = "SELECT count(*) as total FROM $table";
$paging = mysql_fetch_assoc(mysql_query($numpage));
$res 	= mysql_query($sql.$limit);
$numFld = mysql_num_fields($res);
$count 	= mysql_num_rows($res);

// Menciptakan objek paging

$p = new pagination;
$p->Items($paging['total']);
$p->limit($items);
$p->target($_SERVER['PHP_SELF']);
$p->currentPage($page);
$p->calculate();

?>
<div id="add"><a href="#" onclick="showlayer('showhide')">Add</a></div><br /><br /><br />
<div id="showhide" style="display:none; margin:0px; padding:0px;">
<?
$add = new GeneratorFormTable;
$frm = $add->open_form();
$frm.= "<tr bgColor='#FFFFCC'>";
// Menciptakan objek th
$fieldname = array( 'product', 'title', 'image(best 500 x 500px)','thumb(best 90 x 90px)','insert');
foreach ($fieldname as $key) {
$frm.= '<th>'.$key.'</th>';
}
$frm.= '<th>&nbsp;</th></tr>';

$res3 = mysql_query("SELECT * FROM product");
$frm.= $add->select_open("g_product_id");
	while ($row3 = mysql_fetch_array($res3)){
$frm.= $add->select_option("$row3[p_id]","$row3[p_title]");
	}
$frm.= $add->text_field("g_title");
$frm.= $add->file_field("file");
$frm.= $add->file_field("thumb");

$frm.= $add->button("insert","insert");
$frm.= "</tr>";
$frm.= $add->close_form();
echo $frm;
?>
</div><br />



<?
// Menciptakan objek GeneratorTabel
$gtf = new GeneratorFormTable;

$get = $gtf->open_form();
$get.= '<tr>';
$get.= '<th>Edit</th>';
// Menciptakan objek th
$fieldname = array( 'product', 'title', 'image(best 500 x 500px)', 'thumb (90 x 90px)','sort');
foreach ($fieldname as $key) {
$get.= '<th>'.$key.'</th>';
}
$get.= '<th>&nbsp;</th></tr>';


$num = 1;
while ($row = mysql_fetch_array($res)){
//Menciptakan color seling
if (($num % 2) != 0)  $bgR="#FFFFCC"; else $bgR="#ffffff"; 
$num++;
$get.= "<tr bgcolor=".$bgR.">";

//Menciptakan form
$get.= $gtf->hidden_field("g_id[]","$row[g_id]");
$get.= $gtf->checkbox("checkbox[]","$row[0]");

$get.= $gtf->select_open("g_product_id[]");
$res2 = mysql_query("SELECT * FROM product WHERE p_id = '$row[g_product_id]'");
while($row2 = mysql_fetch_array($res2)){
$get.= $gtf->select_option("$row2[p_id]","$row2[p_title]");
}

$res3 = mysql_query("SELECT * FROM product");
while ($row3 = mysql_fetch_array($res3)){
$get.= $gtf->select_option("$row3[p_id]","$row3[p_title]");
}

$get.= $gtf->text_field("g_title[]","$row[g_title]");
//Menciptakan Picture
if (!$row[g_image]){
	$get.= "<td>&nbsp;";}
	else{
	$get.= $gtf->img("../assets/$row[g_image]","90");
	}
$get.= $gtf->hidden_field("g_image[]","$row[g_image]");
$get.= $gtf->file_field2("file[]");
if (!$row[g_thumb]){
	$get.= "<td>&nbsp;";}
	else{
	$get.= $gtf->img("../assets/thumb/$row[g_thumb]","90");
	}
$get.= $gtf->hidden_field("thumb2[]","$row[g_thumb]");
$get.= $gtf->file_field2("thumb[]");
$get.= $gtf->text_field("g_sort[]","$row[g_sort]");
	
//endrow
}
//endwhile
$get.= "</tr>";
$get.= $gtf->buttondelete("5");
$get.= $gtf->close_form();
echo $get;
$p->show();
?>
<?
if(isset($_POST[delete])){
	for($i=0;$i<$count;$i++){
		$del_id = $_POST[checkbox][$i];
		$sql_delete = "DELETE FROM $table WHERE $tableid = '$del_id'";
		$res_delete = mysql_query ($sql_delete) or die ("could not delete");
	}
	echo '<script>alert("Successfully delete");location="'.$_SERVER['PHP_SELF'].'";</script>';
}
		
if(isset($_POST[edit])){
	for($i=0;$i<$count;$i++){
	
	$g_id			= $_POST['g_id'][$i];
	$g_product_id	= $_POST['g_product_id'][$i];
	$g_title		= $_POST['g_title'][$i];
	$g_sort			= $_POST['g_sort'][$i];
	
	if($_FILES['file']['name'][$i]){	
			$g_image = $_FILES['file']['name'][$i];
			
			$MV = new moveupload;
			$MV->filename($_FILES['file']['name'][$i]);
			$MV->tmpname($_FILES['file']['tmp_name'][$i]);
			$MV->path('../assets/');
			$MV->startupload();
			} 
			else 
			{ $g_image = $_POST['g_image'][$i];};
	
	if($_FILES['thumb']['name'][$i]){	
			$thumb = $_FILES['thumb']['name'][$i];
			
			$TB = new moveupload;
			$TB->filename($_FILES['thumb']['name'][$i]);
			$TB->tmpname($_FILES['thumb']['tmp_name'][$i]);
			$TB->path('../assets/thumb/');
			$TB->startupload();
			} 
			else 
			{ $thumb = $_POST['thumb2'][$i];};
		 	
		$sql_edit = "UPDATE $table SET 
					
					g_product_id 	= '$g_product_id',
					g_title 		= '$g_title',
					g_image			= '$g_image',
					g_thumb			= '$thumb',
					g_sort			= '$g_sort'
					WHERE $tableid 	= '$g_id'"; 
		$res_edit = mysql_query ($sql_edit) or die ("could not edit");
	}
	echo '<script>alert("Successfully Edit"); location="'.$_SERVER['PHP_SELF'].'";</script>';
}

if(isset($_POST[insert])){
	
	$g_product_id	= $_POST['g_product_id'];
	$g_title		= $_POST['g_title'];


	if($_FILES['file']['name']){
			$g_image = $_FILES['file']['name'];
			
			$MV = new moveupload;
			$MV->filename($_FILES['file']['name']);
			$MV->tmpname($_FILES['file']['tmp_name']);
			$MV->path('../assets/');
			$MV->startupload();
			} 
	if($_FILES['thumb']['name']){	
	
			$thumb = $_FILES['thumb']['name'];
			
			$TB = new moveupload;
			$TB->filename($_FILES['thumb']['name']);
			$TB->tmpname($_FILES['thumb']['tmp_name']);
			$TB->path('../assets/thumb/');
			$TB->startupload();
			}		
		 	
			$sql_add = "INSERT INTO $table 
						(g_product_id, g_image,g_thumb, g_title) 
						VALUES
						('$g_product_id', '$g_image','$thumb','$g_title')"; 
		  	$res_add = mysql_query ($sql_add) or die ("could not insert");
	echo '<script>alert("Successfully Add"); location="'.$_SERVER['PHP_SELF'].'";</script>';
}
?>