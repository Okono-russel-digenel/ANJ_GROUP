<?php
 /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */
include('db_connect.php');

$receiving_email_address = 'anjgroup2019@gmail.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'];
$contact->from_email = $_POST['email'];
$contact->subject = "New Subscription: " . $_POST['email'];

$contact->add_message($_POST['email'], 'Email');

try {
    $stmt = $pdo->prepare("INSERT INTO letter (email) VALUES (:email)");
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    echo $contact->send();
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
