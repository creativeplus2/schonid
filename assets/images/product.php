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
$table = 'product';
$tableid = 'p_id';
// Menciptakan objek paging

// Menciptakan query
$sql 	= "SELECT * FROM $table ORDER BY p_sort ASC";
$numpage = "SELECT count(*) as total FROM $table";
$paging = mysql_fetch_assoc(mysql_query($numpage));
$res 	= mysql_query($sql);
$numFld = mysql_num_fields($res);
$count 	= mysql_num_rows($res);

// Menciptakan objek paging
?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>
<div id="add"><a href="#" onclick="showlayer('showhide')">Add Product</a></div><br /><br /><br />
<div id="showhide" style="display:none; margin:0px; padding:0px;">
<?
$add = new GeneratorFormTable;
$frm = $add->open_form();
$frm.= "<tr bgColor='#FFFFCC'>";
// Menciptakan objek th
$fieldname = array( 'category', 'title', 'content', 'banner image (600x170px)','thumb image (90x220px)','pdf','insert');
foreach ($fieldname as $key) {
$frm.= '<th>'.$key.'</th>';
}
$frm.= '<th>&nbsp;</th></tr>';

$res3 = mysql_query("SELECT * FROM category");
$frm.= $add->select_open("p_cat_id");
	while ($row3 = mysql_fetch_array($res3)){
$frm.= $add->select_option("$row3[cat_id]","$row3[cat_label]");
	}
$frm.= $add->select_close();
$frm.= $add->text_field("p_title");
$frm.= $add->text_area("p_content","","50");
$frm.= $add->file_field("file");
$frm.= $add->file_field("thumb");
$frm.= $add->file_field("pdf");
$frm.= $add->button("insert","insert");
$frm.= "</tr>";
$frm.= $add->close_form();
echo $frm;
?>
</div><br />



<?
$gtf = new GeneratorFormTable;

$get = $gtf->open_form();
$get.= '<tr>';
$get.= '<th>Edit</th>';
// Menciptakan objek th
$fieldname = array( 'category', 'title', 'content', 'banner image (600x170px)','thumb image (90x220px)','pdf','sort');
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
$get.= $gtf->hidden_field("p_id[]","$row[p_id]");
$get.= $gtf->checkbox("checkbox[]","$row[p_id]");

//Menciptakan form option category
$get.= $gtf->select_open("p_cat_id[]");
$res2 = mysql_query("SELECT * FROM category WHERE cat_id = '$row[p_cat_id]'");
while($row2 = mysql_fetch_array($res2)){
$get.= $gtf->select_option("$row2[cat_id]","$row2[cat_label]");
}

$res3 = mysql_query("SELECT * FROM category");
while ($row3 = mysql_fetch_array($res3)){
$get.= $gtf->select_option("$row3[cat_id]","$row3[cat_label]");
}

$get.= $gtf->select_close();

//Menciptakan form
$get.= $gtf->text_field("p_title[]","$row[p_title]","10");
$get.= $gtf->text_area("p_content[]","$row[p_content]","35");
	
//Menciptakan Picture
if (!$row[p_image]){
	$get.= "<td>&nbsp;";}
	else{
	$get.= $gtf->img("../assets/$row[p_image]","200");
	}
$get.= $gtf->hidden_field("p_image[]","$row[p_image]");
$get.= $gtf->file_field2("file[]");

if (!$row[p_thumb]){
	$get.= "<td>&nbsp;";}
	else{
	$get.= $gtf->img("../assets/$row[p_thumb]","90");
	}
$get.= $gtf->hidden_field("t_image[]","$row[p_thumb]");
$get.= $gtf->file_field2("thumb[]");
$get.= $gtf->text_field2("pdf_text[]","$row[p_pdf]");
$get.= $gtf->file_field2("pdf[]");
$get.= $gtf->text_field("p_sort[]","$row[p_sort]","6");	
//endrow
}
//endwhile
$get.= "</tr>";
$get.= $gtf->buttondelete("9");
$get.= $gtf->close_form();
echo $get;
?>
<?
if(isset($_POST[delete])){
	for($i=1;$i<$count;$i++){
		$del_id = $_POST[checkbox][$i];
		$sql_delete = "DELETE FROM $table WHERE $tableid = '$del_id'";
		$res_delete = mysql_query ($sql_delete) or die ("could not delete");
	}
	echo '<script>alert("Successfully delete");location="'.$_SERVER['PHP_SELF'].'";</script>';
}
		
if(isset($_POST[edit])){
	for($i=1;$i<$count;$i++){
	
	$p_id		= $_POST['p_id'][$i];
	$p_cat_id	= $_POST['p_cat_id'][$i];
	$p_title	= $_POST['p_title'][$i];
	$p_content	= $_POST['p_content'][$i];
	$p_sort		= $_POST['p_sort'][$i];

	if($_FILES['file']['name'][$i]){	
			$file = $_FILES['file']['name'][$i];
			
			$MV = new moveupload;
			$MV->filename($_FILES['file']['name'][$i]);
			$MV->tmpname($_FILES['file']['tmp_name'][$i]);
			$MV->path('../assets/');
			$MV->startupload();
			} 
			else 
			{ $file = $_POST['p_image'][$i];};
			
	if($_FILES['thumb']['name'][$i]){	
			$thumb = $_FILES['thumb']['name'][$i];
			
			$TB = new moveupload;
			$TB->filename($_FILES['thumb']['name'][$i]);
			$TB->tmpname($_FILES['thumb']['tmp_name'][$i]);
			$TB->path('../assets/');
			$TB->startupload();
			} 
			else 
			{ $thumb = $_POST['t_image'][$i];};
			
	
		if($_FILES['pdf']['name'][$i]){	
			$pdf = $_FILES['pdf']['name'][$i];
			
			$TB = new moveupload;
			$TB->filename($_FILES['pdf']['name'][$i]);
			$TB->tmpname($_FILES['pdf']['tmp_name'][$i]);
			$TB->path('../assets/pdf/');
			$TB->startupload();
			} 
			else 
			{ $pdf = $_POST['pdf_text'][$i];};

		 	
		$sql_edit = "UPDATE $table SET 
					p_cat_id 	= '$p_cat_id', 
					p_title 	= '$p_title', 
					p_content 	= '$p_content', 
					p_image 	= '$file',
					p_thumb 	= '$thumb',
					p_pdf		= '$pdf',
					p_sort 		= '$p_sort'
					WHERE $tableid ='$p_id'"; 
		$res_edit = mysql_query ($sql_edit) or die ("could not edit");
	}
	echo '<script>alert("Successfully Edit"); location="'.$_SERVER['PHP_SELF'].'";</script>';
}

if(isset($_POST[insert])){

	$p_cat_id	= $_POST['p_cat_id'];
	$p_title	= $_POST['p_title'];
	$p_content	= $_POST['p_content'];
	$p_sort		= $_POST['p_sort'];
	
	if($_FILES['file']['name']){	
	
			$file = $_FILES['file']['name'];
			
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
			$TB->path('../assets/');
			$TB->startupload();
			}
	
	if($_FILES['pdf']['name']){	
	
			$pdf = $_FILES['pdf']['name'];
			
			$TB = new moveupload;
			$TB->filename($_FILES['pdf']['name']);
			$TB->tmpname($_FILES['pdf']['tmp_name']);
			$TB->path('../assets/pdf/');
			$TB->startupload();
			}
		 	
			$sql_add = "INSERT INTO $table 
						(p_cat_id, p_title, p_content, p_image, p_thumb, p_pdf ) VALUES
						('$p_cat_id', '$p_title', '$p_content', '$file' , '$thumb', '$pdf')"; 
		  	$res_add = mysql_query ($sql_add) or die ("could not insert");
	echo '<script>alert("Successfully Add"); location="'.$_SERVER['PHP_SELF'].'";</script>';
}
?>