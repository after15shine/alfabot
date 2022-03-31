<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL ^ E_DEPRECATED);
//    ====================================================
//    |                                                                                                  |
//    |   Source              : https://github.com/Kls7no11/alfagift2          |
//    |   Whatsapp Me   : https://wa.link/oi9hnz                                     |
//    |                                                                                                  |
//    ====================================================
function deviceId()
{
      return sprintf(
         '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0x0fff) | 0x4000,
         mt_rand(0, 0x3fff) | 0x8000,
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff)
      );
}
goto banner;
cp:
echo ">> Nomor HP : ";
$nomor = trim(fgets(STDIN));
$model = "Samsung Samsung GT S-".rand(1111,9999);
$nomorhp = "\"$nomor\"";
$deviceid= deviceId();
$deviceid2 = "\"$deviceid\"";
$url = "https://api.alfagift.id/v1/otp/request";
$body = '{"action":"REGISTER","mobileNumber":'.$nomorhp.',"type":0}';
$headers = headerClass($deviceid,$model);
$run = data($body,$headers,$url);
$json = json_decode($run, true);
$res = $json["status"]["code"];
if($res=="00"){
	echo ">> Berhasil Mengirim OTP\n";
	} else if($res=="01"){
		echo ">> ".$json["status"]["message"]; echo "\r\n"; sleep(2);
		goto banner;
		} else {
			echo ">> Kesalahan tidak diketahui\n"; sleep(2);
			goto banner;
			}
verifulang:
echo ">> Masukan Kode OTP: ";
$otp = trim(fgets(STDIN));
$otp = "\"$otp\"";
$url = "https://api.alfagift.id/v1/otp/verify";
$body = '{"action":"REGISTER","mobileNumber":'.$nomorhp.',"otpCode":'.$otp.',"type":0}';
$headers = headerClass($deviceid,$model);
$run = data($body,$headers,$url);
$json = json_decode($run, true);
$res = $json["status"]["code"];
if($res=="99"){
	echo ">> ".$msg = $json["verifyOtpDescription"]; echo "\r\n";
	} else if($res=="00"){
	$token = $json["token"];
    $token2 = "\"$token\"";
    echo ">> Verifikasi Berhasil\n";
    } else {
    	echo ">> Kesalahan tidak diketahui\n";
    goto verifulang;
    }
reg:
$url = "https://api.alfagift.id/v1/account/member/create";
$html = file_get_contents('https://swappery.site/data.php?qty=1');
$json = json_decode($html, true);
$fristName = $json["result"][0]["firstname"];
$lastName = $json["result"][0]["lastname"];
$random_name = "$fristName $lastName";
$random_email = "$fristName".rand(1111,9999);
$random_name = "\"$random_name\"";
$random_email = "\"$random_email@gmail.com\"";
$password = "after15shine";
$body = '{"address":"","birthDate":"1991-10-11","debug":false,"deviceId":'.$deviceid2.',"email":'.$random_email.',"firstName":"","fullName":'.$random_name.',"gender":"F","lastName":"","latitude":0,"longitude":0,"maritalStatus":"M","password":"'.$password.'","phone":'.$nomorhp.',"postCode":"","registerPonta":true,"token":'.$token2.'}';
$headers = headerClass($deviceid,$model);
$run = data($body,$headers,$url);
$json = json_decode($run, true);
$res = $json["status"]["code"];
if($res=="00"){
	$msg = $json["status"]["message"];
    $memberid = $json['memberId'];
    $token = $json["status"]["token"];
    $id_ponta = $json["member"]["ponta"]["accountCard"];
    $no_hp = $json["member"]["ponta"]["phoneNumber"];
    echo ">> Status : $msg Mendaftar\n";
    echo ">> Member : $memberid\n";
    echo ">> Ponta  : $id_ponta\n";
    file_put_contents('akunalfagift.txt', "$no_hp|$password|$token\n", FILE_APPEND);
    goto login;
} else if($res=="99"){
	$msg = $json["status"]["message"];
	echo ">> Status : $msg \n";
	goto reg;
	} else {
		var_dump("$run\n"); sleep(10);
		goto reg;
		}
		
login:
$url = "https://api.alfagift.id/v1/promotion/myVoucher";
$body = '{"limit":10,"start":0}';
$headers = headerLogin($deviceid,$model,$token,$memberid);
$run = data($body,$headers,$url);
$json = json_decode($run, true);
$res = $json["status"]["code"];
 if($res == "00"){
    $total_voucher = $json["totalVouchers"];
    if($total_voucher == null){
        echo ">> Voucher Kosong sob\n";
       }elseif($total_voucher !== null){
        echo ">> Total voucher = $total_voucher \n";
        $voucher = $json['vouchers'];
        print_r($voucher);
    }
 }
die;
banner:
system("clear");
echo "\n\n           d8b    ,d8888b                      d8,   ,d8888b        
           88P    88P'                        `8P    88P'      d8P  
          d88  d888888P                           d888888P  d888888P
 d888b8b  888    ?88'     d888b8b   d888b8b    88b  ?88'      ?88'  
d8P' ?88  ?88    88P     d8P' ?88  d8P' ?88    88P  88P       88P   
88b  ,88b  88b  d88      88b  ,88b 88b  ,88b  d88  d88        88b   
`?88P'`88b  88bd88'      `?88P'`88b`?88P'`88bd88' d88'        `?8b  
                                          )88                       
           version : 2.0                 ,88P                       
    https://github.com/Kls7no11     `?8888P                        \n\n\n";                                                           goto cp;
                                
                                     
function headerClass($deviceid,$model){
$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Accept-language: id';
$headers[] = 'Versionname: 4.0.30';
$headers[] = 'Versionnumber: 403016';
$headers[] = 'Devicemodel: '.$model;
$headers[] = 'Packagename: com.alfamart.alfagift';
$headers[] = 'Signature: 6E:41:03:61:A5:09:55:05:B6:84:84:C9:75:0B:89:56:5D:1D:41:C7';
$headers[] = 'Latitude: 0.0';
$headers[] = 'Longitude: 0.0';
$headers[] = 'Deviceid: '.$deviceid;
$headers[] = 'Content-Type: application/json';
$headers[] = 'User-agent: okhttp/3.14.4';
return $headers;
}
function data($body,$headers,$url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
return $result;
}
function headerLogin($deviceid,$model,$token,$memberid){
$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Accept-language: id';
$headers[] = 'Versionname: 4.0.30';
$headers[] = 'Versionnumber: 403016';
$headers[] = 'Devicemodel: '.$model;
$headers[] = 'Packagename: com.alfamart.alfagift';
$headers[] = 'Signature: 6E:41:03:61:A5:09:55:05:B6:84:84:C9:75:0B:89:56:5D:1D:41:C7';
$headers[] = 'Latitude: 0.0';
$headers[] = 'Longitude: 0.0';
$headers[] = 'Deviceid: '.$deviceid;
$headers[] = 'Token: '.$token;
$headers[] = 'Id: '.$memberid;
$headers[] = 'Content-Type: application/json';
$headers[] = 'User-agent: okhttp/3.14.4';
return $headers;
}