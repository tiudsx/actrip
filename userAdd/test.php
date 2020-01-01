<?php
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    $plaintext = "2019-03-20|3155304633908";

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                 $plaintext, MCRYPT_MODE_CBC, $iv);

    $ciphertext = $iv . $ciphertext;
    $ciphertext_base64 = base64_encode($ciphertext);

    echo  urlencode($ciphertext_base64) . "<br>";
    echo  $ciphertext_base64 . "<br>";


	

    # --- DECRYPTION ---
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    $ciphertext_dec = base64_decode(urldecode(urlencode($ciphertext_base64)));
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    
    echo  $plaintext_dec . "<br>";
	echo "<a href='test2.php?MainNumber=".urlencode($ciphertext_base64)."' target='_blank'>move</a>";
?> 