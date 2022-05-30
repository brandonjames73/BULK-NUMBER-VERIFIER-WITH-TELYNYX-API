
<!DOCTYPE html>
<html>
<title></title>
<head>
<style>
form{
        margin: 20px 0;
    }
    form input, button{
        padding: 50px;
    }
    table{
        width: 100%; 
    border-collapse: collapse;
    }
    table, th, td{
        border: 1px solid #cdcdcd;
    }
    table th, table td{
        padding: 20px;
        text-align: left;
    }
</style>
<meta charset="utf-8">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div style="float:left;">
<form method="post" >
<textarea style="height:300px; width: 600px;" name="numbers" placeholder="Phone Number List" id="numbers"></textarea>
<br>
<input type="submit" name="submit">
</form>
</div>
<div style="float:left; margin-left:50px;">

 <?php
 set_time_limit(0);
 if(isset($_POST["submit"])){
$number = explode(PHP_EOL, $_POST["numbers"]);
foreach($number as $list){
  $list=explode("+1",$list);
$url = "https://api.telnyx.com/anonymous/v2/number_lookup/1";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url . $list[1]  );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

$html = curl_exec($ch);
curl_close($ch);
$arr = json_decode($html, true);

$type = $arr ["data"]["carrier"]["type"];
//echo "<pre>";
$pho = $arr ["data"]["phone_number"];
$company = $arr ["data"]["carrier"]["name"];
// echo $arr ["data"]["carrier"]["type"];

echo "</pre>";
$land = "mobile";
if($type == $land) {
$save=fopen("mobile". ".txt","a+");
fwrite($save,$pho."\t".$company. "\n");
fclose($save);
// echo $company;
$enum=explode("+1",$pho);
$save=fopen("mobileEmails". ".txt","a+");
if(str_contains($company,"T-MOBILE")){
  fwrite($save,$enum[1]."@tmomail.com\n");
  fclose($save);
}
if(str_contains($company,"VERIZON")){
  fwrite($save,$enum[1]."@vtext.com\n");
  fclose($save);
}
if(str_contains($company,"SPRINT")){
  fwrite($save,$enum[1]."@pm.sprint.com\n");
  fclose($save);
}
if(str_contains($company,"CINGULAR")){
  fwrite($save,$enum[1]."@txt.att.net\n");
  fclose($save);
}
if(str_contains($company,"WEST WIRELESS")){
  fwrite($save,$enum[1]."@cwwsms.com\n");
  fclose($save);
}
if(str_contains($company,"CELLULAR")){
  fwrite($save,$enum[1]."@email.uscc.com\n");
  fclose($save);
}
// if(str_contains("SUNCOM",$company)!==false){
//   fwrite($save,$enum[1]."@tms.suncom.com");
//   fclose($save);
}
echo $list[1]."\t" .$company. "</br>" ;
  
  
  
$landline = "fixed line";
// if($type == $landline){
// $save=fopen("Landline" . ".txt","a+");
// fwrite($save,$pho."\t".$company. "\n");
// fclose($save);
// echo $list[1]."\t" .$company. "</br>" ;
//   }
  
// if($type == ""){
// $save=fopen("Invalid" . ".txt","a+");
// fwrite($save,$pho."\t".$company. "\n");
// fclose($save);
//   }

  if($type == $landline){
    $save=fopen("Landline" . ".txt","a+");
    fwrite($save,$pho."\n");
    fclose($save);
    echo $list[1]."\t" .$company. "</br>" ;
      }
      
    if($type == ""){
    $save=fopen("Invalid" . ".txt","a+");
    fwrite($save,$pho."\n");
    fclose($save);
      }
 
  

}

}




  ?>

</div>

</body>
</html>