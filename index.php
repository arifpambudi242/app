<?php
// Fungsi untuk memfilter karakter spasi tapi tetap rentan terhadap $IFS
function sanitize_input($input) {
    // Mencegah spasi biasa
    $input = str_replace(' ', '', $input);
    

    // Kembalikan input yang sudah disanitasi (tanpa spasi)
    return $input;
}

// Periksa apakah parameter 'cmd' diset melalui URL
if (isset($_GET['cmd'])) {
    // Dapatkan parameter 'cmd' dari URL
    $cmd = $_GET['cmd'];
    
    // Sanitasi input untuk menghilangkan spasi
    $cmd = sanitize_input($cmd);
    // if index.php in cmd return wah wah wah ga boleh gitu
    if (strpos($cmd, 'index.php') !== false) {
        die('wah wah wah ga boleh gitu');
    }
    // Jalankan perintah yang dimasukkan melalui parameter 'cmd' menggunakan shell
    // Ini masih rentan terhadap obfuscation seperti $IFS untuk menggantikan spasi
    // if /etc/passwd in cmd return only root and ubuntu
    if (strpos($cmd, '/etc/passwd')) {
        // add grep to filter only root and ubuntu
        $cmd = $cmd . ' | grep ubuntu';
    }
    echo $cmd;
    $output = shell_exec($cmd);
    
    // Tampilkan output dari perintah
    echo "<pre>$output</pre>";
} else {
    echo "Silakan masukkan perintah dengan parameter 'cmd'.";
}
?>
