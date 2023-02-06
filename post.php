<?php
$conn = mysqli_connect("localhost","root","","testing");
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v16.0/100565822961391?fields=posts%7Bfull_picture%2Cmessage%2Ccreated_time%7D%2Cname%2Cpicture&access_token=EAANY8n5ASkIBAORiIRZCNpUcvMJqDkl0mjWgyXUb4QUmkWInXCsP5EZAlFSTcbEZCfZA9cuth1UpH1iskeqxSgLwTkTRVZAqZCuPvYLskF21KxKqKT3AM6pCm7r3nrZB3jDTTDzwek5mfGNZBxI2Pr4Nk3SSVGFbrhfT8NhFUyNmSCY5dhO3bUEjREtNgRA5T2aCtFty2PFVXUZCtYnSeDxXiBc9xRZBioLr7v1jRhN6s6MwZDZD');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$result = json_decode($result);
$sql = mysqli_query($conn, "delete from facebook_page_post");
foreach($result->posts->data as $list){
    $message = '';
    $full_picture = '';

    if(isset($list->message)){
        $message = $list->message;
    }
    if(isset($list->full_picture)){
        $full_picture = $list->full_picture;
    }
    $created_time = $list->created_time;
    $page_name = $result->name;
    $page_picture = $result->picture->data->url;
    $sql = mysqli_query($conn,"insert into facebook_page_post(message, full_picture, created_time, page_name, page_picture) values('$message','$full_picture','$created_time','$page_name','$page_picture')");
echo "<pre>";
print_r($list->full_picture);
}
?>