<?php
// Konfigurasi koneksi database
$servername = "localhost"; // atau IP server database
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$dbname = "techdeveloper";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memproses form jika data dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $details = $_POST['details'];

    // Mengupload file referensi desain jika ada
    $file_name = "";
    if (!empty($_FILES['fileToUpload']['name'])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $file_name;

        // Validasi ekstensi file
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (in_array($fileType, ["doc", "docx", "pdf"])) {
            // Upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars($file_name) . " berhasil diupload.";
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file.";
            }
        } else {
            echo "Hanya file DOC, DOCX, dan PDF yang diperbolehkan.";
            exit;
        }
    }

    // Menyimpan data ke tabel user
    $sql = "INSERT INTO user_order (name, phone, email, status, details, file_name) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $phone, $email, $status, $details, $file_name);

    if ($stmt->execute()) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IT Company Website</title>
    <link rel="stylesheet" href="./css/careers.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="icon" href="./images/image.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
      integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous"
    />
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
    <script src="./js/main.js"></script>
  </head>
  <body>
    <header class="header">
      <a href="#" class="logo"><img src="./images/image.png" alt="" /></a>
      <div class="fas fa-bars"></div>
      <nav class="navbar">
        <ul>
          <li><a href="index.html#home">home</a></li>
          <li><a href="index.html#about">about</a></li>
          <li><a href="index.html#service">services</a></li>
          <li><a href="index.html#portfolio">portfolio</a></li>
          <li><a href="index.html#team">team</a></li>
          <li><a href="#">Order</a></li>
          <li><a href="index.html#contact">contact</a></li>
        </ul>
      </nav>
    </header>

    <section id="home" class="home"></section>

    <section id="career-heading" class="career-heading">
      <h1 class="heading">Order Now</h1>
      <p>Lengkapi formulir yang kami sediakan</p>
    </section>
    <div class="career">
      <div class="career-form">
        <form
          action="./careers.php"
          method="POST"
          enctype="multipart/form-data"
        >
          <input
            type="text"
            name="name"
            placeholder="Name"
            class="career-form-txt"
            required
          />
          <input
            type="tel"
            id="phone"
            name="phone"
            pattern="[0-9]{10}"
            required
            placeholder="Contact number"
            maxlength="10"
            class="career-form-phone"
          />
          <input
            type="email"
            name="email"
            placeholder="Email"
            class="career-form-email"
            required
          />
          <div class="radio-class">
            <h2 class="name">Kategori order</h2>
            <label class="radio">
              <input
                class="radio-one"
                type="radio"
                checked="checked"
                name="status"
                value="Web Designer"
              />
              <span class="checkmark"></span>
              Web Designer
            </label>
            <label class="radio">
              <input
                class="radio-two"
                type="radio"
                name="status"
                value="Web Developer"
              />
              <span class="checkmark"></span>
              Web Developer
            </label>
            <label class="radio">
              <input
                class="radio-three"
                type="radio"
                name="status"
                value="Mobile App Designer"
              />
              <span class="checkmark"></span>
              Mobile App Designer
            </label>
            <label class="radio">
              <input
                class="radio-four"
                type="radio"
                name="status"
                value="Mobile App Developer"
              />
              <span class="checkmark"></span>
              Mobile App Developer
            </label>
          </div>
          <textarea
            placeholder="Other Details"
            name="details"
            class="career-form-txtarea"
            required
          ></textarea>
          <div class="file">
            <h2 class="name">Referensi desain</h2>
            <input
              class="upload"
              type="file"
              name="fileToUpload"
              accept=".doc,.docx,.pdf"
            /><br /><br /><br />
          </div>
          <input
            type="submit"
            value="Submit"
            name="submit"
            class="career-form-btn"
          />
        </form>
      </div>
    </div>

    <div class="footer">
      <div class="footer-top">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 footer-links">
              <h4>About Us</h4>
              <ul>
                <li>
                  <i class="ion-ios-arrow-forward"></i> <a href="#">Home</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="#about">About us</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="#service">Our services</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="#">Terms & condition</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="#">Privacy policy</a>
                </li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Useful Links</h4>
              <ul>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="#portfolio">Portfolio</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i> <a href="#team">Team</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="careers.html">Career</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i>
                  <a href="#contact">Contact</a>
                </li>
                <li>
                  <i class="ion-ios-arrow-forward"></i> <a href="#faq">FAQ</a>
                </li>
              </ul>
            </div>

            <div
              class="col-lg-3 col-md-6 footer-contact"
              style="font-size: 1.5rem"
            >
              <h4>Contact Us</h4>
              <p>
                30154 Alang Alang Lebar<br />
                Palembang, Sumatera Selatan<br />
                Indonesia <br />
                <strong>Phone:</strong> +628 993401674<br />
                <strong>Email:</strong> techdedveloper@gmail.com<br />
              </p>

              <div class="social-links">
                <a href="https://www.facebook.com/"
                  ><i class="ion-logo-facebook"></i
                ></a>
                <a href="https://twitter.com/login?lang=en"
                  ><i class="ion-logo-twitter"></i
                ></a>
                <a href="https://www.linkedin.com/"
                  ><i class="ion-logo-linkedin"></i
                ></a>
                <a href="https://www.instagram.com/"
                  ><i class="ion-logo-instagram"></i
                ></a>
                <a
                  href="https://accounts.google.com/servicelogin/signinchooser?flowName=GlifWebSignIn&flowEntry=ServiceLogin"
                  ><i class="ion-logo-googleplus"></i
                ></a>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 footer-newsletter">
              <h4>TechDeveloper</h4>
              <p>
                Dengan Keahlian Kami Yang Disatukan, Anda Mendapatkan Sebuah
                Ansambel Yang Mampu Melakukan Apa Pun Dan Segala Yang Dibutuhkan
                Merek Anda. Berlangganan Di Sini Untuk Mendapatkan Pembaruan
                Terbaru Kami.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row align-items-center">
          <div
            class="col-md-6 copyright"
            style="color: #fff; font-size: 1.3rem"
          >
            Copyright &copy; 2024 TechDeveloper. All Rights Reserved.
          </div>
        </div>
      </div>
    </div>

    <a href="#" class="back-to-top"><i class="ion-ios-arrow-up"></i></a>
  </body>
</html>

