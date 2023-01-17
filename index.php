
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Person-Detection-and-Face-Mask-Detection</title>
  </head>
  <body>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->


<div class ="container overflow-hidden">
<div class="row px-4 ms-1 px-2 g-2 g-lg-3 bg-dark text-white">
<div class="col px-4 ms-1 px-2 p-3">
<p class = h1 text-center>Person-Detection-and-Face-Mask-Detection</p>
</div>
</div>


<div class="row px-4 ms-1 px-2 g-2 g-lg-3 bg-light">
<div class="col-md-auto p-3">

<form action="up.php" method="post" enctype="multipart/form-data">
  <div class = "mb-3">
  <label for="formFile" class="form-label">กรุณาเลือกภาพเพื่อใช้งาน</label>
  <input type="file" name="fileToUpload" id="fileToUpload" class="form-control ">
  <br>
  <input type="submit" value="อัปโหลด" name="submit" class="btn btn-danger">
</form>
</div>
</div>
</div>

<div class="row px-4 ms-1 px-2 g-2 g-lg-3 bg-light">
<div class="col-md-auto p-3">
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
echo'<p class = "h1">ผลลัพท์การตรวจจับบุคคล</p>';
if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
  $arr = json_decode($response); // convert string to array
    foreach($arr as $x => $val) {
        if( $x == "human_img")
            //echo "$x : $val<br>";
            echo '
            <img src="' . $val . '" alt="T Person" class ="img-fluid max-width:20px">
            ';
    }
}
echo'</div>';
echo'</div>';

echo '<div class="row px-4 ms-1 px-2 g-2 g-lg-3 bg-light">';
echo '<div class="col-md-auto p-3">';
echo"<br>\n";
echo'<p class = "h1">ผลลัพท์การตรวจจับ MASK</p>';
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
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('' . $imgName . '')),
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
echo'</div>';
echo'</div>';
?>
</div>
</body>
</html>