<?php

//----------------------------------------- start edit here ---------------------------------------------//
//$script_location = "http://localhost/smf-base/"; // location of the script
$script_location = "http://forum.sys-admin.kz/"; // location of the script
$maxlimit = 5242880; // maxim image limit
$folderforever = "ups/images"; // folder where to save images
$foldertmp = "ups/imagestmp"; // folder where to save images

// requirements
$minwidth = 10; // minim width
$minheight = 10; // minim height
$maxwidth = 5000; // maxim width
$maxheight = 5000; // maxim height

//thumbnails - 1 or 0 to allow or disallow
$thumb = 0; // allow to create thumb n.1
$thumb2 = 0; // allow to create thumb n.2
$thumb3 = 0; // allow to create thumb n.3
$thumb4 = 0; // allow to create thumb n.4

// allowed extensions
$extensions = array('.png', '.gif', '.jpg', '.jpeg','.PNG', '.GIF', '.JPG', '.JPEG');
//----------------------------------------- end edit here ---------------------------------------------//

if(isset($_POST['submit'])){
if(!empty($_POST['check_list'])) {
// Counting number of checked checkboxes.
$checked_count = count($_POST['check_list']);
echo "You have selected following ".$checked_count." option(s): <br/>";
// Loop to store and display values of individual checked checkbox.
foreach($_POST['check_list'] as $selected) {
echo "<p>".$selected ."</p>";
}
echo "<br/><b>Note :</b> <span>Similarily, You Can Also Perform CRUD Operations using These Selected Values.</span>";
}
else{
echo "<b>Please Select Atleast One Option.</b>";
}
}


	// check that we have a file
	if((!empty($_FILES["uploadfile"])) && ($_FILES['uploadfile']['error'] == 0)) {

	// check extension
	$extension = strrchr($_FILES['uploadfile']['name'], '.');
	if (!in_array($extension, $extensions))	{
		echo 'неправильный формат, разреены только .png , .gif, .jpg, .jpeg
		<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';
	} else {

// get file size
$filesize = $_FILES['uploadfile']['size'];

	// check filesize
	if($filesize > $maxlimit){ 
		echo "Файл слишком тяжелый.";
	} else if($filesize < 1){ 
		echo "Пустой файл.";
	} else {

// temporary file
$uploadedfile = $_FILES['uploadfile']['tmp_name'];

// capture the original size of the uploaded image
list($width,$height) = getimagesize($uploadedfile);

	// check if image size is lower
	if($width < $minwidth || $height < $minheight){ 
		echo 'Изображение слишком маленькое. Минимум - '.$minwidth.'x'.$minheight.'
		<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';
	} else if($width > $maxwidth || $height > $maxheight){ 
		echo 'Изображение слишком большое. Максимум - '.$maxwidth.'x'.$maxheight.'
		<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';
	} else {

// all characters lowercase
$filename = strtolower($_FILES['uploadfile']['name']);

// replace all spaces with _
$filename = preg_replace('/\s/', '_', $filename);

// extract filename and extension
$pos = strrpos($filename, '.'); 
$basename = substr($filename, 0, $pos); 
$ext = substr($filename, $pos+1);

// get random number
$rand = time();

// image name
$image = $basename .'-'. $rand . "." . $ext;

// checking folder type
if (isset($_POST['tempimage'])) {
    $folder = $foldertmp;
    $ch = "1";
    
} else {
    $folder = $folderforever;
   $ch = "2";
}


// check if file exists
$check = $folder . '/' . $image;
	if (file_exists($check)) {
		echo 'Image already exists';
	} else {

// check if it's animate gif
$frames = exec("identify -format '%n' ". $uploadedfile ."");
	if ($frames > 1) {
		// yes it's animate image
		// copy original image
		copy($_FILES['uploadfile']['tmp_name'], $folder . '/' . $image);

		// orignal image location
		$write_image = $folder . '/' . $image;
		//ennable form
		echo '<img src="' . $write_image . '" alt="'. $image .'" alt="'. $image .'" width="500" /><br />
<input type="text" name="location" value="'.$script_location.''.$write_image.'" class="location corners" /><br />        
<input type="text" name="location-bb" value="[IMG]'.$script_location.''.$write_image.'[/IMG]" class="location corners" />
<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';

	} else {

// create an image from it so we can do the resize
 switch($ext){
  case "gif":
	$src = imagecreatefromgif($uploadedfile);
  break;
  case "jpg":
	$src = imagecreatefromjpeg($uploadedfile);
  break;
  case "jpeg":
	$src = imagecreatefromjpeg($uploadedfile);
  break;
  case "png":
	$src = imagecreatefrompng($uploadedfile);
  break;
 }

// copy original image
copy($_FILES['uploadfile']['tmp_name'], $folder . '/' . $image);

// orignal image location
$write_image = $folder . '/' . $image;

if ($thumb == 1){
// create first thumbnail image - resize original to 80 width x 80 height pixels 
$newheight = ($height/$width)*80;
$newwidth = 80;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagealphablending($tmp, false);
imagesavealpha($tmp,true);
$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// write thumbnail to disk
$write_thumbimage = $folder .'/thumb-'. $image;
 switch($ext){
  case "gif":
	imagegif($tmp,$write_thumbimage);
  break;
  case "jpg":
	imagejpeg($tmp,$write_thumbimage,100);
  break;
  case "jpeg":
	imagejpeg($tmp,$write_thumbimage,100);
  break;
  case "png":
	imagepng($tmp,$write_thumbimage);
  break;
 }
}

if ($thumb2 == 1){
// create second thumbnail image - resize original to 125 width x 125 height pixels 
$newheight = ($height/$width)*125;
$newwidth = 125;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagealphablending($tmp, false);
imagesavealpha($tmp,true);
$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// write thumbnail to disk
$write_thumb2image = $folder .'/thumb2-'. $image;
 switch($ext){
  case "gif":
	imagegif($tmp,$write_thumb2image);
  break;
  case "jpg":
	imagejpeg($tmp,$write_thumb2image,100);
  break;
  case "jpeg":
	imagejpeg($tmp,$write_thumb2image,100);
  break;
  case "png":
	imagepng($tmp,$write_thumb2image);
  break;
 }
}

if ($thumb3 == 1){
// create third thumbnail image - resize original to 125 width x 125 height pixels 
$newheight = ($height/$width)*250;
$newwidth = 250;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagealphablending($tmp, false);
imagesavealpha($tmp,true);
$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// write thumbnail to disk
$write_thumb3image = $folder .'/thumb3-'. $image;
 switch($ext){
  case "gif":
	imagegif($tmp,$write_thumb3image);
  break;
  case "jpg":
	imagejpeg($tmp,$write_thumb3image,100);
  break;
  case "jpeg":
	imagejpeg($tmp,$write_thumb3image,100);
  break;
  case "png":
	imagepng($tmp,$write_thumb3image);
  break;
 }
}

if ($thumb4 == 1){
// create third thumbnail image - resize original to 125 width x 125 height pixels 
$newheight = ($height/$width)*350;
$newwidth = 350;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagealphablending($tmp, false);
imagesavealpha($tmp,true);
$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// write thumbnail to disk
$write_thumb4image = $folder .'/thumb4-'. $image;
 switch($ext){
  case "gif":
    imagegif($tmp,$write_thumb4image);
  break;
  case "jpg":
    imagejpeg($tmp,$write_thumb4image,100);
  break;
  case "jpeg":
    imagejpeg($tmp,$write_thumb4image,100);
  break;
  case "png":
    imagepng($tmp,$write_thumb4image);
  break;
 }
}

// all is done. clean temporary files
imagedestroy($src);
imagedestroy($tmp);

// image preview
// image preview
if ($thumb == 1){
echo "<img src='" . $write_thumbimage . "' alt='". $image ."' /><br />
<input type='text' name='location' value='[IMG]".$script_location."". $write_thumbimage ."[/IMG]' class='location corners' /><br />
<br />";
}
if ($thumb2 == 1){
echo "<img src='" . $write_thumb2image . "' alt='". $image ."' /><br />
<input type='text' name='location' value='[IMG]".$script_location."". $write_thumb2image ."[/IMG]' class='location corners' /><br />
<br />";
}
if ($thumb3 == 1){
echo "<img src='" . $write_thumb3image . "' alt='". $image ."' /><br />
<input type='text' name='location' value='[IMG]".$script_location."". $write_thumb3image ."[/IMG]' class='location corners' /><br />
<br />";
}

if ($thumb4 == 1){
echo "<img src='" . $write_thumb4image . "' alt='". $image ."' /><br />
<input type='text' name='location' value='[IMG]".$script_location."". $write_thumb4image ."[/IMG]' class='location corners' /><br />
<br />";
}

echo "<img src='" . $write_image . "' alt='". $image ."' alt='". $image ."' width='500' /><br />
<input type='text' name='location' value='".$script_location."".$write_image."' class='location corners' id='location' onclick='select()' /><br /> 
<input type='text' name='location-bb' value='[IMG]".$script_location."".$write_image."[/IMG]' class='location corners' id='location-bb' onclick='select()' /><br />
<script language='javascript' type='text/javascript'>window.top.window.formEnable();</script>
<div class='clear'></div>";
	  }
	}
  }
}
	
	  }
		// error all fileds must be filled
	} else {
		echo '<div class="wrong">Что то пошло не так... Попробуйте вновь.</div>'; }
?>
