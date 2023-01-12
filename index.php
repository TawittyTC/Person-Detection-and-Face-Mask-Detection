
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
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Objective</a></li>

          <li><a href="#" class="nav-link px-2 text-white">About</a></li>
        </ul>

      </div>
    </div>
  </header>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

<div class ="container px-4">
<div class="row px-4 ms-1 px-2">
<div class="col px-4 ms-1 px-2">
<h1>Person-Detection-and-Face-Mask-Detection</h1>
</div>

<div class="row px-4 ms-1 px-2">
<div class="col-xl-2 col-lg-2 col-md-4 col-6 px-4 ms-1 px-2">

<form action="up.php" method="post" enctype="multipart/form-data">
Select image to upload:
<div class="row px-4 ms-1 px-2">
<div class="col px-4 ms-1 px-2">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
<!-- <img src="curr.jpg"> -->
</div>
</div>
</div>

<div class="row px-4 ms-1 px-2">
<div class="col px-4 ms-1 px-2">
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
            echo '
            <div class="row px-4 ms-1 px-2">
            <div class="col px-4 ms-1 px-2">
            <img src="' . $val . '" alt="T Person" class="rounded float-start ">
            </div>
            </div>';
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
?>
</div>
</body>
</html>