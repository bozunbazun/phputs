<?php
    /*
        if (!defined('SITE'))
        die('<h1>Restricted access!</h1>');
    */
        
    $id_karyawan = 4;
    
    require_once 'database.php';
    $db = new KaryawanDB();

    if($_POST)
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
                
        /*/validasi
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
        /*/
        
        if($db->edit_karyawan($id_karyawan, $username, $password, $fullname, $gender, $agama, $alamat, $nomor_telepon, $pendidikan_terakhir, $kode_jabatan, $kode_cabang, $kode_departemen, $gaji_pokok, $tanggal_diangkat, $tanggal_keluar, $nama_bank, $nomor_rekening, $kode_admin))
        {
            echo "<script>alert('Success!');</script>";
        }
        else
        {
            echo "<script>alert('Failed!');</script>";
        }
    }

    $post = $db->select_karyawan($id_karyawan);
    $post = $post[0];
?>

<form action="admin.php?page=edit_karyawan&id_karyawan=<?php echo id_karyawan; ?>" method="post">
    
            Username <font color='red'>*</font>
            <input type="text" name="username" value="<?php echo $post['username']; ?>">
            <br>
            Password <font color='red'>*</font>
            <input type="password" name="password" value="<?php echo $post['password']; ?>">
            <br>
            Full Name <font color='red'>*</font>
            <input type="text" name="fullname" value="<?php echo $post['fullname']; ?>">
            <br>
            Gender
            <input type="text" name="gender" value="<?php echo $post['gender']; ?>">
            <br>
            Agama
            <input type="text" name="agama" value="<?php echo $post['agama']; ?>">
            <br>
            Alamat
            <input type="text" name="alamat" value="<?php echo $post['alamat']; ?>">
            <br>
            Nomor HP/Telp
            <input type="text" name="nomor_telepon" value="<?php echo $post['nomor_telepon']; ?>">
            <br>
            Pendidikan Terakhir
            <input type="text" name="pendidikan_terakhir" value="<?php echo $post['pendidikan_terakhir']; ?>">
            <br>
            Kode Jabatan <font color='red'>*</font>
            <input type="text" name="kode_jabatan" value="<?php echo $post['kode_jabatan']; ?>">
            <br>
            Kode Cabang
            <input type="text" name="kode_cabang" value="<?php echo $post['kode_cabang']; ?>">
            <br>
            Kode Department
            <input type="text" name="kode_departemen" value="<?php echo $post['kode_departemen']; ?>">
            <br>
            Gaji Pokok
            <input type="text" name="gaji_pokok" value="<?php echo $post['gaji_pokok']; ?>">
            <br>
            Tanggal Dianggkat
            <input type="text" name="tanggal_diangkat" value="<?php echo $post['tanggal_diangkat']; ?>">
            <br>
            Tanggal Keluar
            <input type="text" name="tanggal_keluar" value="<?php echo $post['tanggal_keluar']; ?>">
            <br>
            Nama Bank
            <input type="text" name="nama_bank" value="<?php echo $post['nama_bank']; ?>">
            <br>
            Nomor Rekening
            <input type="text" name="nomor_rekening" value="<?php echo $post['nomor_rekening']; ?>">
            <br>
            Kode Admin <font color='red'>*</font>
            <input type="text" name="kode_admin" value="<?php echo $post['kode_admin']; ?>">
            <br>
    <input type="submit" name="submit" value="Save">
</form>