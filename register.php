<!--"register.php"-->
<?php
    $errors = array();
    if ($_POST)
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $fullname = $_POST["fullname"];
        $kode_jabatan = $_POST["kode_jabatan"];
        $gender = $_POST["gender"];
        $agama = $_POST["agama"];
        $alamat = $_POST["alamat"];
        $nomor_telepon = $_POST["nomor_telepon"];
        $pendidikan_terakhir = $_POST["pendidikan_terakhir"];
        $kode_jabatan = $_POST["kode_jabatan"];
        $kode_cabang = $_POST["kode_cabang"];
        $kode_departemen = $_POST["kode_departemen"];
        $gaji_pokok = $_POST["gaji_pokok"];
        $tanggal_diangkat = $_POST["tanggal_diangkat"];
        $tanggal_keluar = $_POST["tanggal_keluar"];
        $nama_bank = $_POST["nama_bank"];
        $nomor_rekening = $_POST["nomor_rekening"];
        $kode_admin = $_POST["kode_admin"];
        
        //validasi
        if (strlen(trim($username)) < 3)
            array_push($errors, "Username must be at least 3 Characters");
        if (strlen(trim($password)) < 6)
            array_push($errors, "Password must be at least 6 Characters");
        if (strlen(trim($fullname)) == 0)
            array_push($errors, "Full Name must be filled");
        if (strlen(trim($kode_jabatan)) == 0)
            array_push($errors, "Kode Jabatan must be filled");
        if (strlen(trim($kode_admin)) == 0)
            array_push($errors, "Kode Admin must be filled");
        
        //register jika tidak ada error
        if (count($errors) == 0)
        {            
            //echo "<script>alert('Success!');</script>";
            //cara include "..." include("...")
            //required "..." required("...")
            //required_once "..."
            require_once "database.php";
            $db = new KaryawanDB();
            if ($db->insert($username, $password, $fullname, $gender, $agama, $alamat, $nomor_telepon, $pendidikan_terakhir, $kode_jabatan, $kode_cabang, $kode_departemen, $gaji_pokok, $tanggal_diangkat, $tanggal_keluar, $nama_bank, $nomor_rekening, $kode_admin))
            {
                echo "<script>alert('Success!');</script>";
                //katanya tidak boleh ada apa2 di atas header klo ndak error, jdi pke javascript
                //header("Location: login.php");
                //exit();
            }
            else
            {
                echo "<script>alert('Gagal!');</script>";
            }
        }
    }
?>

<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <h1>Register</h1>
        <?php
            if (count($errors) > 0)
            {
                echo "<font color='red'>";
                foreach ($errors as $e)
                {
                    echo "<li>$e</li>";
                }
                echo "</ul></font>";
            }
        ?>
        
        <form method="post" action="register.php">
            Username <font color='red'>*</font>
            <input type="text" name="username">
            <br>
            Password <font color='red'>*</font>
            <input type="password" name="password">
            <br>
            Full Name <font color='red'>*</font>
            <input type="text" name="fullname">
            <br>
            Gender
            <input type="text" name="gender">
            <br>
            Agama
            <input type="text" name="agama">
            <br>
            Alamat
            <input type="text" name="alamat">
            <br>
            Nomor HP/Telp
            <input type="text" name="nomor_telepon">
            <br>
            Pendidikan Terakhir
            <input type="text" name="pendidikan_terakhir">
            <br>
            Kode Jabatan <font color='red'>*</font>
            <input type="text" name="kode_jabatan">
            <br>
            Kode Cabang
            <input type="text" name="kode_cabang">
            <br>
            Kode Department
            <input type="text" name="kode_departemen">
            <br>
            Gaji Pokok
            <input type="text" name="gaji_pokok">
            <br>
            Tanggal Dianggkat
            <input type="text" name="tanggal_diangkat">
            <br>
            Tanggal Keluar
            <input type="text" name="tanggal_keluar">
            <br>
            Nama Bank
            <input type="text" name="nama_bank">
            <br>
            Nomor Rekening
            <input type="text" name="nomor_rekening">
            <br>
            Kode Admin <font color='red'>*</font>
            <input type="text" name="kode_admin">
            <br>
            <input type="submit" name="submit" value="Register">
        </form>
    </body>
</html>