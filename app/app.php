<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();

    if (empty($_SESSION['list_of_contacts'])) {
      $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();
    $app['debug'] = true;

      $app->get("/",function() {
          $output = "";
          if (!empty(Contact::getAll())) {
              $output .= "
                  <h1>List of Contacts</h1>
                  <p>Here are all of your contacts:</p>
              ";
              foreach (Contact::getAll() as $contact) {
                  $output = $output . "<p>" . $contact->getDescription() . "</p>";
          }
      }
    });

    $app->get("/new_contact", function() {
      return "
      <!DOCTYPE html>
        <html>
          <head>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
            <title>Add a new contact!</title>
          </head>
          <body>
            <div class='container'>
              <h1>'Contact Information'</h1>
              <p>'Enter the information for the new contact.'</p>
              <form action='/create_contact'>
                <div class='form-group'>
                  <label for='firstName'>Enter First Name</label>
                  <input id='firstName' name='firstName' class='form-control' type='text'>

                  <label for='lastName'>Enter Last name</label>
                  <input id='lastName' name='lastName' class='form-control' type='text'>

                  <label for='address'>Enter Address</label>
                  <input id='address' name='address' class='form-control' type='text'>
                </div>
                <button type='submit' class='btn-success'>Create</button>
            </div>
          </body>
        </html>
        ";
        $output = $contact;
    });
    var_dump($contact);
    $app->get("/create_contact", function() {
      $my_contact = new Contact($_GET['firstName'], $_GET['lastName'], $_GET['address']);
      $contacts = array($contact);
    //   var_dump($contact);

      $output = "";
      foreach ($contacts as $contact) {
        $output = $output . "<h1>" . $contact->getFirstName() . "</h1>
          <h2>" . $contact->getLastName() . "</h2>
          <h3>" . $contact->getAddress . "</h3>
          <h4>" . $contact->getContact . "</h4>
        ";
      }
      return "
      <!DOCTYPE html>
        <html>
          <head>
            <title>Your Contacts</title>
          </head>
          <body>
            " . output . "
          </body>
        </html>";
    });

    return $app;
?>
