<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="input-field">
                <input name="name" type="text" class="form-control" placeholder="Name" required>
              </div>
              <div class="input-field">
                <input name="number" type="number" class="form-control" placeholder="Phone Number" required>
              </div>
              <div class="input-field">
                <input name="email" type="email" class="form-control" placeholder="Email ID" required>
              </div>
              <div class="input-field">
                <input readonly class="form-control" placeholder="Upload Resume" value="">
                <input type="file" name="userfile" class="form-control" placeholder="Upload Resume" required accept=".doc,.docx,.pdf,.rtf,.txt,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,text/rtf,text/plain">
                <img class="upload-icon" src="career-assets/images/upload-icon.svg" alt="icon">
                <img class="close-icon" src="career-assets/images/close-icon.svg" alt="icon">
              </div>
            </div>
            <p><i>Upload either DOC, DOCX, PDF, RTF or TXT file types (2 MB max)</i></p>
            <button type="submit" name="submit" class="btn bg-gradient w-100">SUBMIT</button>
          </form>
<?php
    use PHPMailer\PHPMailer\PHPMailer;

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';

    if(isset($_POST['submit'])) {
    
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPDebug  = 4; 

      $mail->SMTPAuth  = true; 
      $mail->Port       = 25;

      // $mail->Host       = "10.41.171.37";
      // $mail->Username   = "karvycomfal";
      // $mail->Password   = "Alsk##1357@@";
      $mail->Host       = "smtp.gmail.com";
      $mail->Username   = "chandra.a@webileapps.com";
      $mail->Password   = "gqwepxbwqjxedvrr";
      
      $mail->IsHTML(true);    
      // $mail->AddAddress("careers@kfintech.com", "Kfintech - Careers");
      // $mail->SetFrom("careers@kfintech.com", "KFintech Careers");
      $mail->AddAddress("chandra.a@webileapps.com", "Kfintech - Careers");
      $mail->SetFrom("chandra.a@webileapps.com", "KFintech Careers");

      $mail->AddReplyTo("{$_POST['email']}", "{$_POST['name']}");
      $mail->Subject = "Resume from Careers site";
      $mail->Body = "
      Email: {$_POST['email']} <br/>
      Name: {$_POST['name']}<br/>
      Number: {$_POST['number']}
      ";

      $msg = '';
      if (array_key_exists('userfile', $_FILES)) {
        $ext = PHPMailer::mb_pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name'])) . '.' . $ext;
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
          if (!$mail->addAttachment($uploadfile, $_FILES['userfile']['name'])) {
            $msg .= 'Failed to attach file ' . $_FILES['userfile']['name'];
          }
          // if (!$mail->send()) {
          //   $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
          // } else {
          //   $msg .= 'Message sent!';
          // }
        } else {
          $msg .= 'Failed to move file to ' . $uploadfile;
        }
      }

      if(!$mail->Send()) {
        echo "<script>alert('Resume could not be sent.')</script>";
      } else {
        echo "<script>alert('Resume sent successfully')</script>";
      }
    }
  ?>
  </body>

</html>
