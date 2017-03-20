<?php
    class Database
    {
        private $conn;
        
        function __construct()
        {
            $this->conn = mysqli_connect("localhost", "root", "", "phputs");
            if (!$this->conn)
            {
                //die("Koneksi database gagal!");
                die(mysqli_connect_error());
            }
        }
        
        function query($query)
        {
            return $this->conn->query($query) or die($this->conn->error . " " . $query);
        }
        
        function getdatetime()
        {
            return date('Y-m-d H:i:s');
        }
        
        function fetch($query)
        {
            $result = $this->conn->query($query);
            $retval = array();
            while ($row = mysqli_fetch_array($result))
            {
                array_push($retval, $row);
            }
            return $retval;
        }
        
        function secure_input($input)
        {
            return $this->conn->real_escape_string(strip_tags($input));
        }
        
        function prepare($query)
        {
            return $this->conn->prepare($query);
        }
    }

    class KaryawanDB extends Database
    {
        function insert($username, $password, $fullname, $gender, $agama, $alamat, $nomor_telepon, $pendidikan_terakhir, $kode_jabatan, $kode_cabang, $kode_departemen, $gaji_pokok, $tanggal_diangkat, $tanggal_keluar, $nama_bank, $nomor_rekening, $kode_admin)
        {
            //FK mesti sama pada tabel Admin dan Jabatan
            //Perlu di ADD FILTER
            //PERLU CONFIRM PASSWORD
            $username = $this->secure_input($username);
            $fullname = $this->secure_input($fullname);
            $kode_jabatan = $this->secure_input($kode_jabatan);
            $kode_admin = $this->secure_input($kode_admin);

            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO karyawan(username, password, fullname, kode_jabatan, kode_admin)" .
                " VALUES ('$username', '$password', '$fullname', '$kode_jabatan', '$kode_admin')";
            return $this->query($query);
        }
        function check_login($username, $password)
        {
            $query = "SELECT id_karyawan, password FROM karyawan WHERE username = '$username'";
            $result = $this->fetch($query);
            $result = $result[0];            
            return (password_verify($password, $result['password']) ? $result['id_karyawan'] : -1);
            //return (($result['password'] == $password) ? $result['id'] : -1);
        } 
        
        function view_karyawan($id)
        {
            $id = $this->secure_input($id);
            $query = "SELECT username, fullname, gender, agama, alamat, nomor_telepon, pendidikan_terakhir, kode_jabatan, kode_cabang, kode_departemen, gaji_pokok, tanggal_diangkat, tanggal_keluar, nama_bank, nomor_rekening, kode_admin WHERE id_karyawan = ?";
            $stmt = $this->prepare($query);
            $stmt->bind_param("i", $id); //("si", $string, $integer) string, integer
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_array();
        }
        
        function edit_karyawan($id_karyawan, $username, $password, $fullname, $gender, $agama, $alamat, $nomor_telepon, $pendidikan_terakhir, $kode_jabatan, $kode_cabang, $kode_departemen, $gaji_pokok, $tanggal_diangkat, $tanggal_keluar, $nama_bank, $nomor_rekening, $kode_admin)
        {
            $id_karyawan = intval($this->secure_input($id_karyawan));
            $username = $this->secure_input($username);
            $fullname = $this->secure_input($fullname);
            $gender = $this->secure_input($gender);
            $agama = $this->secure_input($agama);
            $alamat = $this->secure_input($alamat);
            $nomor_telepon = intval($this->secure_input($nomor_telepon));
            $pendidikan_terakhir = $this->secure_input($pendidikan_terakhir);
            $kode_jabatan = $this->secure_input($kode_jabatan);
            $kode_cabang = $this->secure_input($kode_cabang);
            $kode_departemen = $this->secure_input($kode_departemen);
            $gaji_pokok = intval($this->secure_input($gaji_pokok));
            $tanggal_diangkat = $this->secure_input($tanggal_diangkat);
            $tanggal_keluar = $this->secure_input($tanggal_keluar);
            $nama_bank = $this->secure_input($nama_bank);
            $nomor_rekening = $this->secure_input($nomor_rekening);
            
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "UPDATE karyawan SET username = ?, password = ?, fullname = ?, gender = ?, agama = ?, alamat = ?, nomor_telepon = ?, pendidikan_terakhir = ?, kode_jabatan = ?, kode_cabang = ?, kode_departemen = ?, gaji_pokok = ?, tanggal_diangkat = ?, tanggal_keluar = ?, nama_bank = ?, nomor_rekening = ?, kode_admin = ? WHERE id_karyawan = ?";
            $stmt = $this->prepare($query);
            //K login -> absen -> liat 
            //A login -> edit -> regis K
            $stmt->bind_param("ssssssissssisssisi",  $username, $password, $fullname, $gender, $agama, $alamat, $nomor_telepon, $pendidikan_terakhir, $kode_jabatan, $kode_cabang, $kode_departemen, $gaji_pokok, $tanggal_diangkat, $tanggal_keluar, $nama_bank, $nomor_rekening, $kode_admin, $id_karyawan);
            return $stmt->execute();
        }
        
        function select_karyawan($id_karyawan)
        {
            $id_karyawan = intval($this->secure_input($id_karyawan));
            $query = "SELECT * FROM karyawan WHERE id_karyawan = $id_karyawan";
            return $this->fetch($query);
        }
    }

class AbsensiDB extends Database{
        function insert($id_karyawan,$bool_cuti){
            $todayDate = date("Y-m-d");
            $bool_hadir = 1;
            $todayIn = date("H:i");
            $todayOut = date("H:i");
            
            $query = "INSERT INTO absensi (date,id_karyawan,kehadiran,jam_masuk,jam_keluar,cuti) values ('$todayDate','$id_karyawan','$bool_hadir','$todayIn','$todayOut','$bool_cuti')";
            
            return $this->query($query);
        }
        
        function selectAll($id_karyawan){
            $query = "SELECT * FROM absensi where id_karyawan = '$id_karyawan'";
            
            return $this->fetch($query);
            
        }
        function updateKeluar($id_karyawan){
            $todayOut = date("H:i");
            $query = "UPDATE absensi SET jam_keluar = $todayOut where id_karyawan = $id_karyawan";
            
            return $this->fetch($query);
        }
           function get_Admin($id){
            $id = intval($this->secure_input($id));
            $query = "SELECT fullname from admin where kode_admin = $id";
            
            return $this->fetch($query);
        }

    }

class ADMINDB extends DATABASE {
		function INSERT ($username,$password,$fullname){
			//$kode_admin = intval($this -> secure_input($kode_admin));
			$username = $this -> secure_input($username);
			$password = $this -> secure_input($password);
			$fullname = $this -> secure_input($fullname);

			$password = password_hash($password,PASSWORD_DEFAULT);

			$query = "INSERT INTO admin(username,password,fullname) VALUES ('$username','$password','$fullname')";
			return $this -> query($query);
		}

		function UPDATE ($kode_admin,$username,$password,$fullname){
			$kode_admin = intval($this -> secure_input($kode_admin));
			$username = $this -> secure_input($username);
			$password = $this -> secure_input($password);
			$fullname = $this -> secure_input($fullname);

			$password = password_hash($password,PASSWORD_DEFAULT);
			
			$query = "UPDATE admin SET username = ? , password = ? , fullname = ? WHERE kode_admin = ? ";

			$stmt = $this-> prepare($query);
			$stmt -> bind_param("sssi",$username,$password,$fullname,$kode_admin);
			return $stmt->execute();

	}

		function DELETE ($kode_admin){
			$kode_admin = intval($this -> secure_input($kode_admin));

			$query = "DELETE FROM admin WHERE kode_admin = ?";

			$stmt = $this-> prepare($query);
			$stmt -> bind_param("i",$kode_admin);
			return $stmt -> execute();

		}

		function SELECT(){
			$query = "SELECT * FROM admin ORDER BY kode_admin ASC";
			return $this-> fetch(query);
		}



}

class JABATANDB extends DATABASE {

		function INSERT ($kode_jabatan,$nama_jabatab,$level_jabatan){
			$kode_jabatan = $this -> secure_input($kode_jabatan);
			$nama_jabatan = $this -> secure_input($nama_jabatan);
			$level_jabatan = intval($this -> secure_input($nama_jabatan));
		
			$query = "INSERT INTO jabatan(kode_jabatan,nama_jabatan,level_jabatan) VALUES ('$kode_jabatan','$nama_jabatan','level_jabatan')";
			return $this -> query($query); 	
		}

		function UPDATE ($kode_jabatan,$nama_jabatan,$level_jabatan){
			$kode_jabatan = $this -> secure_input($kode_jabatan);
			$nama_jabatan = $this -> secure_input($nama_jabatan);
			$level_jabatan = intval($this -> secure_input($nama_jabatan));
		
			$query = "UPDATE jabatan SET nama_jabatan = ? , level_jabatan = ? WHERE kode_jabatan = ?";

			$stmt = $this->prepare($query);
			$stmt = bind_param("sis",$nama_jabatan,$level_jabatan,$kode_jabatan);
			return $stmt -> execute();
		}

		function DELETE ($kode_jabatan){
			$kode_jabatan = $this -> secure_input($kode_jabatan);

			$query = "DELETE FROM jabatan WHERE kode_jabatan = ?";

			$stmt = $this-> prepare($query);
			$stmt = bind_param("s",$kode_jabatan);
			return $stmt-> execute();
		}

		function SELECT (){
			$query = "SELECT * FROM jabatan ORDER BY kode_jabatan ASC";
			return $this->fetch($query);
		}

	}

?>