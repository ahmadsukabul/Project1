<?PHP 
$url = "https://hooks.slack.com/services/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";
$ch = curl_init( $url );
# Setup request to send json via POST.
$payload = json_encode( array( "text"=> "tes kirim pesan dari api bukakios" ) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
echo "<pre>$result</pre>";
?>