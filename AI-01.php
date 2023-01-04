<html></html>
<body>
<form action="up.php" method="post" enctype="multipart/form-data">
Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
<!-- <img src="curr.jpg"> -->
<?php
$menu = "";
$imgName = "curr.jpg";
if(isset($_GET['imgName'])) {
	global $imgName;
    $imgName = $_GET['imgName'];
}


$curl = curl_init();
$img_file = ('img.jpg');
$data = array(
    'src_img' => new CURLFile($imgName, mime_content_type($imgName), basename($imgName)),
    'json_export' => 'true',
    'img_export' => 'true',
);
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.aiforthai.in.th/person/human_detect/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $data,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: multipart/form-data",
    "apikey: vOL3nalJfnnMF2BaNIl7a9wxOebOaNd9" // <= add your apikey
  )
));
 
$response = curl_exec($curl);
$err = curl_error($curl);
 
curl_close($curl);
 
if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
  $arr = json_decode($response); // convert string to array
    foreach($arr as $x => $val) {
        if( $x == "human_img")
            //echo "$x : $val<br>";
            echo '<img src="' . $val . '" alt="T Person" >';
    }
}
echo"<br>\n";
echo'mask detect code';
echo"<br>\n";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.aiforthai.in.th/detectfacemask',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 1,
  CURLOPT_TIMEOUT => 30,  
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('img.jpg')),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: multipart/form-data',
    'Apikey:vOL3nalJfnnMF2BaNIl7a9wxOebOaNd9 '
  )
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>
</body>
</html>