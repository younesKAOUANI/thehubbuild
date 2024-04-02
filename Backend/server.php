<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");

$response = array(
  'email' => 'example@example.com',
  'name' => 'John Doe',
  'error'=> 'false'
);
// Respond to the preflight request
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
  // Set additional CORS headers for preflight requests
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Max-Age: 3600"); // Cache preflight response for 1 hour
  exit;
}
//Database Connection
$host = 'localhost'; // e.g., 'localhost'
$dbname = 'thehubd2_inscriptions';
$username = 'thehub';
$password = 'TheHub08@';

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
function inscriptionDatabase($data, $pdo, $response)
{
  try {
    $stmt = $pdo->prepare("INSERT INTO Inscriptions (`firstName`, `lastName`, `email`, `phone`, `address`, `wilaya`, `function`, `course`, `timeRegistered`, `isPaid`)
     VALUES (:firstName, :lastName, :email, :phone, :address, :wilaya, :profession, :course, NOW(), 0)");

    $stmt->bindParam(':firstName', $data['firstName']);
    $stmt->bindParam(':lastName', $data['lastName']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':address', $data['address']);
    $stmt->bindParam(':wilaya', $data['wilaya']);
    $stmt->bindParam(':profession', $data['function']);
    $stmt->bindParam(':course', $data['course']);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->errorCode() !== '00000') {
      throw new Exception("Error executing SQL: " . implode(", ", $stmt->errorInfo()));
    }
    echo "success";
    // Return an array with success status and last inserted ID
    return ['firstName' => $response['firstName'], 'email' => $response['email']];
  } catch (Exception $e) {
    
    return [$response['error'] = true];
  }
}

function newsletterDatabase($data, $pdo, $response)
{
  try {
    $stmt = $pdo->prepare("INSERT INTO Newsletter (`email`)
     VALUES (:email)");
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->errorCode() !== '00000') {
      throw new Exception("Error executing SQL: " . implode(", ", $stmt->errorInfo()));
    }

    $response['email'] =  $data['email'];
    $response['firstName'] =  $data['firstName'];
    return $response;
  } catch (Exception $e) {
    $response['error'] = true;
    return $response;
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
    $mail->Host = 'mail.thehubdz.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'contact@thehubdz.com'; // SMTP username
    $mail->Password = 'TheHub08@'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 465; // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Contact Form Response';
    $mail->setFrom('contact@thehubdz.com', 'The Hub');
    $mail->isHTML(true);
    // Sender and recipient details
    $mail->addAddress('contact@thehubdz.com', 'The Hub');
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
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  print_r($data);
  $formNature = $data['formNature'];
  switch ($formNature) {
    case 'inscriptions':
      // Code to handle formNature = 'inscription'
      inscriptionDatabase($data, $pdo, $response);
      echo ($response);
      break;
    case 'test':
      // Code to handle formNature = 'test'
      break;
    case 'contact':
      // Code to handle formNature = 'contact'
      break;
    case 'newsletter':
      // Code to handle formNature = 'newsletter'
      newsletterDatabase($data, $pdo, $response);
      echo ($response);
      break;
    default:
      echo "No case matched";
      break;
  }
} else {
  echo "Form not submitted!";
}
