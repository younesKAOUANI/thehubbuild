<?php

//Database Connection
$host = 'localhost'; // e.g., 'localhost'
$dbname = 'u421767106_ids';
$username = 'u421767106_qualia_club';
$password = 'Youfadihamma@2023';
//   $dbname = 'ids';
//   $username = 'root';
//  $password = '';

// Create a PDO instance
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Dependencies
include("firebaseRDB.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Firebase declarations
// $databaseURL = "https://tsvabas-default-rtdb.firebaseio.com/";
// $db = new firebaseRDB($databaseURL);

// 2 - Save data from POST to Database Functions
function visitorDatabase($data, $pdo)
{
  try {
    $stmt = $pdo->prepare("INSERT INTO Visitors (`name`, `phone`, `email`, `profession`, `company`, `wilaya`, `field`)
     VALUES (:name, :phone, :email, :profession, :company, :wilaya, :field)");

    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':profession', $data['profession']);
    $stmt->bindParam(':company', $data['company']);
    $stmt->bindParam(':wilaya', $data['wilaya']);
    $stmt->bindParam(':field', $data['field']);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->errorCode() !== '00000') {
      throw new Exception("Error executing SQL: " . implode(", ", $stmt->errorInfo()));
    }
    echo "sucess";
    // Return an array with success status and last inserted ID
    return ['name' => $data['name'], 'email' => $data['email']];
  } catch (Exception $e) {
    // Handle exceptions (display or log the error)
    echo ('fail database');
    return array('status' => 'error', 'message' => $e->getMessage());
  }
}
function newsletterDatabase($data, $pdo)
{
  try {
    $stmt = $pdo->prepare("INSERT INTO newsletter (`email`)
     VALUES (:email)");
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->errorCode() !== '00000') {
      throw new Exception("Error executing SQL: " . implode(", ", $stmt->errorInfo()));
    }
    echo "success";
    // Return an array with success status and last inserted ID
    return ['email' => $data['email']];
  } catch (Exception $e) {
    // Handle exceptions (display or log the error)
    echo ('fail database');
    return array('status' => 'error', 'message' => $e->getMessage());
  }
}
function exhibitDatabase($data, $pdo)
{
  try {
    $stmt = $pdo->prepare("INSERT INTO exhibitors (`company`, `sector`, `adresse`,
     `city`, `wilaya`, `space`, `email`, `phone`,`fax`, `website`, `nrc`, `nif`, `nart`)
     VALUES (:company, :sector, :adresse, :city, :wilaya, :space, :email,
      :phone, :fax, :website, :nrc, :nif, :nart)");

    $stmt->bindParam(':company', $data['companyName']);
    $stmt->bindParam(':sector', $data['companySector']);
    $stmt->bindParam(':adresse', $data['companyAdresse']);
    $stmt->bindParam(':city', $data['companyCity']);
    $stmt->bindParam(':wilaya', $data['companyWilaya']);
    $stmt->bindParam(':space', $data['companySpace']);
    $stmt->bindParam(':email', $data['companyEmail']);
    $stmt->bindParam(':phone', $data['companyPhone']);
    $stmt->bindParam(':fax', $data['companyFax']);
    $stmt->bindParam(':website', $data['companyWebsite']);
    $stmt->bindParam(':nrc', $data['companyNrc']);
    $stmt->bindParam(':nif', $data['companyNif']);
    $stmt->bindParam(':nart', $data['companyArticle']);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->errorCode() !== '00000') {
      throw new Exception("Error executing SQL: " . implode(", ", $stmt->errorInfo()));
    }

    // Return an array with success status and last inserted ID
    return ['name' => $data['companyName'], 'email' => $data['companyEmail']];
  } catch (Exception $e) {
    // Handle exceptions (display or log the error)
    echo ('fail database');
    return
      array('status' => 'error', 'message' => $e->getMessage());
  }
}

function sendEmailCompany($data)
{
  // Retrieve form data from the array
  $name = $data['name'];
  $email = $data['email'];

  // Specify the paths for attachments
  // $filePaths = array(
  //   '../dossiers/Dossier de participation The Startup Valley Algeria.pdf',
  //   '../dossiers/Dossier Sponsoring The Startup Valley Algeria.pdf'
  // );

  require '../vendor/autoload.php';

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->SMTPDebug = 0; // 0 - Disable Debugging, 2 - Responses received from the server
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.titan.email'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'no-reply@industrialdigitalsummit.com'; // SMTP username
    $mail->Password = 'AlphaY@770'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Votre exposition a Industrial Digital Summit';
    $mail->setFrom('no-reply@industrialdigitalsummit.com', 'Industrial Digital Summit');
    $mail->isHTML(true);
    // Sender and recipient details
    $mail->addAddress($email, $name);

    // Email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Votre Exposition a Industrial Digital Summit';
    $mail->Body = "<!DOCTYPE html>
    <html lang=\"en\">
    <head>
      <meta charset=\"UTF-8\">
      <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
      <title>Email</title>
      <link href=\"https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap\" rel=\"stylesheet\">
    </head>
    <body style=\"margin: 0; padding: 0; background-color: white; font-family: 'Poppins', sans-serif\">
    <div style=\"max-width: 600px; margin: 20px auto;\">
    
      <!-- Banner Section -->
      <div id=\"banner\" style=\"background-image: linear-gradient(to left, #F8AB00, #EF0029); padding: 30px 20px; border-radius: 10px;\">
        <img style=\"width: 150px;\" src=\"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/e3fd6c13-f84c-4f65-9527-6a575cc4ec72/dgwo2fm-84fe1afe-2c3e-465c-86b3-61f68ade15af.png/v1/fit/w_828,h_334/ids_white_colored_by_nyctophilixic_dgwo2fm-414w-2x.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NTE3IiwicGF0aCI6IlwvZlwvZTNmZDZjMTMtZjg0Yy00ZjY1LTk1MjctNmE1NzVjYzRlYzcyXC9kZ3dvMmZtLTg0ZmUxYWZlLTJjM2UtNDY1Yy04NmIzLTYxZjY4YWRlMTVhZi5wbmciLCJ3aWR0aCI6Ijw9MTI4MCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.qg_F1yDCQQ2QTwhWf34ReeeXLQsUlgqTTaiSwiZnwsw\"
          alt=\"Banner Image\">
      </div>
    
      <div id=\"email-content\" style=\"
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: black;
        background-color: white;
        filter: drop-shadow(2px 2px 6px rgba(0, 0, 0, 0.538));
        border-radius: 10px;
        \">
        <p>Bonjour,  $name ,</p>
        <p>Nous vous remercions d'avoir rempli le formulaire d'exposition pour Industrial Digital Summit. Nous apprécions vivement votre intérêt à participer et sommes ravis de confirmer la réception de votre soumission.</p>
        <p>Notre équipe est actuellement en train de traiter les informations fournies, et nous prendrons contact avec vous sous peu pour discuter des détails supplémentaires concernant votre participation à l'événement.</p>
        <!-- <p>Afin d'assurer un processus fluide, nous avons attaché le dossier de participation à cet e-mail. Vous trouverez tous les documents pertinents ci-joints. Ce dossier contient des informations essentielles concernant votre participation, y compris les directives, les réglementations et d'autres détails sur l'exposition.</p> -->
        <p>Si vous avez des questions immédiates ou avez besoin d'une assistance supplémentaire, n'hésitez pas à nous contacter à <a href=\"mailto:contact@industrialdigitalsummit.com\">contact@industrialdigitalsummit.com</a>.</p>
        <p>Nous apprécions sincèrement votre participation et sommes impatients de collaborer avec vous lors de Industrial Digital Summit. Ensemble, faisons de cet événement un succès retentissant!</p>
        <p>Cordialement.</p>
      </div>
      <div style=\"
      text-align: center;
      font-family: 'Poppins', sans-serif;
      line-height: 15px;
      margin-bottom: 10px
      \">
            <h4 style=\"color: #ef0028c4;\">Industrial Digital Summit</h4>
            <p>Salle Zénith Ahmed Bey, Constantine</p>
            <p>Le 12, 13, 14 15 September 2024</p><br>
            <p>Contactez Nous à:</p>
            <a href=\"mailto:contact@industrialdigitalsummit.com\">contact@industrialdigitalsummit.com</a>
            </div>
          
            <!-- Second Banner Section -->
            <div id=\"banner2\" style=\"background-image: linear-gradient(to left, #F8AB00, #EF0029);   padding: 30px 20px; border-radius: 10px; text-align: center;\">
              <img style=\"width: 200px;\" src=\"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/e3fd6c13-f84c-4f65-9527-6a575cc4ec72/dgivzac-a6c4d133-3fb4-4d90-99c9-846b896fafa3.png/v1/fit/w_828,h_108/submarkpng_by_nyctophilixic_dgivzac-414w-2x.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9MTY2IiwicGF0aCI6IlwvZlwvZTNmZDZjMTMtZjg0Yy00ZjY1LTk1MjctNmE1NzVjYzRlYzcyXC9kZ2l2emFjLWE2YzRkMTMzLTNmYjQtNGQ5MC05OWM5LTg0NmI4OTZmYWZhMy5wbmciLCJ3aWR0aCI6Ijw9MTI4MCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.wibd0CeZ3RerIW3VRfQm23lifHsZnda1sh28PTPbepk\" alt=\"Second Banner Image\">
            </div>
            
          </div>
          </body>
          </html>";
    // Send the email
    // foreach ($filePaths as $filePath) {
    //   $mail->addAttachment($filePath);
    // }
    $mail->send();
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
function contact($data)
{
  // Retrieve form data from the array
  $name = $data['name'];
  $email = $data['email'];
  $phone = $data['phone'];
  $address = $data['address'];
  $comments = $data['comment'];

  // Specify the paths for attachments
  // $filePaths = array(
  //   '../dossiers/Dossier de participation The Startup Valley Algeria.pdf',
  //   '../dossiers/Dossier Sponsoring The Startup Valley Algeria.pdf'
  // );

  require '../vendor/autoload.php';

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->SMTPDebug = 0; // 0 - Disable Debugging, 2 - Responses received from the server
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.titan.email'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'no-reply@industrialdigitalsummit.com'; // SMTP username
    $mail->Password = 'AlphaY@770'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Contact Form Response';
    $mail->setFrom('no-reply@industrialdigitalsummit.com', 'Industrial Digital Summit');
    $mail->isHTML(true);
    // Sender and recipient details
    $mail->addAddress('contact@industrialdigitalsummit.com', 'Industrial Digital Summit');
    // Email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Body = "

   <p> Name: . $name .</p>
   <p> Email: . $email . </p>
   <p> Phone: . $phone . </p>
   <p> Address: . $address . </p>
   <p> Comment: . $comments . </p>

    ";
    // Send the email
    // foreach ($filePaths as $filePath) {
    //   $mail->addAttachment($filePath);
    // }
    $mail->send();
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

function sendEmailVisitor($data)
{
  require '../vendor/autoload.php';
  // Retrieve form data from the array
  $name = $data['name'];
  $email = $data['email'];

  // Specify the paths for attachments
  $filePaths = array(
    '../dossiers/Dossier de participation The Startup Valley Algeria.pdf',
    '../dossiers/Dossier Sponsoring The Startup Valley Algeria.pdf'
  );

  require '../vendor/autoload.php';

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->SMTPDebug = 0; // 0 - Disable Debugging, 2 - Responses received from the server
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.titan.email'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'no-reply@industrialdigitalsummit.com'; // SMTP username
    $mail->Password = 'AlphaY@770'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    // Sender and recipient details
    $mail->Subject = 'Votre inscription a Industrial Digital Summit';
    $mail->setFrom('no-reply@industrialdigitalsummit.com', 'Industrial Digital Summit');
    $mail->isHTML(true);
    $mail->addAddress($email, $name);
    $mail->Body = "<!DOCTYPE html>
    <html lang=\"en\">
    <head>
      <meta charset=\"UTF-8\">
      <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
      <title>Email</title>
      <link href=\"https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap\" rel=\"stylesheet\">
    </head>
    <body style=\"margin: 0; padding: 0; background-color: rgba(128, 128, 128, 0.178); font-family: 'Poppins', sans-serif\">
    <div style=\"max-width: 600px; margin: 20px auto;\">
    
      <!-- Banner Section -->
      <div id=\"banner\" style=\"background-image: linear-gradient(to left, #F8AB00, #EF0029); padding: 30px 20px; border-radius: 10px;\">
        <img style=\"width: 150px;\" src=\"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/e3fd6c13-f84c-4f65-9527-6a575cc4ec72/dgwo2fm-84fe1afe-2c3e-465c-86b3-61f68ade15af.png/v1/fit/w_828,h_334/ids_white_colored_by_nyctophilixic_dgwo2fm-414w-2x.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NTE3IiwicGF0aCI6IlwvZlwvZTNmZDZjMTMtZjg0Yy00ZjY1LTk1MjctNmE1NzVjYzRlYzcyXC9kZ3dvMmZtLTg0ZmUxYWZlLTJjM2UtNDY1Yy04NmIzLTYxZjY4YWRlMTVhZi5wbmciLCJ3aWR0aCI6Ijw9MTI4MCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.qg_F1yDCQQ2QTwhWf34ReeeXLQsUlgqTTaiSwiZnwsw\"
          alt=\"Banner Image\">
      </div>
    
      <div id=\"email-content\" style=\"
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: black;
        background-color: white;
        filter: drop-shadow(2px 2px 6px rgba(0, 0, 0, 0.538));
        border-radius: 10px;
        \">
        <p>Bonjour, " . $name . ",</p>
        <p>Nous sommes ravis de vous informer que votre inscription à Industrial Digital Summit a été confirmée avec succès.</p> 
        <p>En tant que participant enregistré, vous recevrez régulièrement des mises à jour concernant l'horaire de l'événement, tout changement éventuel, ainsi que des informations supplémentaires directement dans votre boîte de réception. Restez informé(e) de toutes les dernières actualités concernant notre événement.</p> 
        <p>Si vous avez des questions immédiates ou avez besoin d'une assistance supplémentaire, n'hésitez pas à nous contacter à <a href=\"mailto:contact@industrialdigitalsummit.com\">contact@industrialdigitalsummit.com</a>.</p> 
        <p>Nous attendons avec impatience de vous accueillir à l'événement et de partager cette expérience avec vous.</p>
        <p>Cordialement.</p>
      </div>
      <div style=\"
      text-align: center;
      font-family: 'Poppins', sans-serif;
      line-height: 15px;
      margin-bottom: 10px
      \">
            <h4 style=\"color: #ef0028c4;\">Industrial Digital Summit</h4>
            <p>Salle Zénith Ahmed Bey, Constantine</p>
            <p>Le 12, 13, 14 15 September 2024</p><br>
            <p>Contactez Nous à:</p>
            <a href=\"mailto:contact@industrialdigitalsummit.com\">contact@industrialdigitalsummit.com</a>
            </div>
          
            <!-- Second Banner Section -->
            <div id=\"banner2\" style=\"background-image: linear-gradient(to left, #F8AB00, #EF0029);   padding: 30px 20px; border-radius: 10px; text-align: center;\">
              <img style=\"width: 200px;\" src=\"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/e3fd6c13-f84c-4f65-9527-6a575cc4ec72/dgivzac-a6c4d133-3fb4-4d90-99c9-846b896fafa3.png/v1/fit/w_828,h_108/submarkpng_by_nyctophilixic_dgivzac-414w-2x.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9MTY2IiwicGF0aCI6IlwvZlwvZTNmZDZjMTMtZjg0Yy00ZjY1LTk1MjctNmE1NzVjYzRlYzcyXC9kZ2l2emFjLWE2YzRkMTMzLTNmYjQtNGQ5MC05OWM5LTg0NmI4OTZmYWZhMy5wbmciLCJ3aWR0aCI6Ijw9MTI4MCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.wibd0CeZ3RerIW3VRfQm23lifHsZnda1sh28PTPbepk\" alt=\"Second Banner Image\">
            </div>
            
          </div>
          </body>
          </html>";
    // Add the modified PDF as an attachment
    //$mail->addAttachment($outputFilename, $fullName . '.pdf');

    // Send the email
    $mail->send();
    //unlink($outputFilename);
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

// 1 - Verify the POST Variable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  print_r($_POST);
//   $formNature = $_POST['formNature'];
//   switch ($formNature) {
//     case 'inscription':
//       // Code to handle formNature = 'visitor'
//       break;
//     case 'test':
//       // Code to handle formNature = 'test'
//       break;

//     case 'contact':
//       // Code to handle formNature= 'contact'
//       break;
//     case 'newsletter':
//       // Code to handle formNature= 'newsletter'
//       break;
//     default:
//       print("No case matched");
//       break;
//   }
  // Call the appropiate functions in each case
} else {
  echo "Form not submitted!";
}
?>
