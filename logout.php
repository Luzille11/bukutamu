<?php
session_start();
session_destroy();
$_SESSION['id_user'] = null;
echo "<script>
alert('Logout berhasil, silahkan login kembali!');
window.location.href='http://localhost/bukutamu';
</script>";