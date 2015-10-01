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
        } else {
            $output .= "
                <p>Sorry, no contacts found.</p>
            ";
        }
    $output .= "
        <a href='/new_contact'>Add new contacts</a>
    ";

    return $output;
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
              <form action='/contact'>
                <div class='form-group'>
                  <label for='firstName'>Enter First Name</label>
                  <input id='firstName' name='firstName' class='form-control' type='text'>

                  <label for='lastName'>Enter Last name</label>
                  <input id='lastName' name='lastName' class='form-control' type='text'>

                  <label for='address'>Enter Address</label>
                  <input id='address' name='address' class='form-control' type='text'>
                </div>
                <button type='submit' class='btn-success'>Create Contact</button>
              </form>
              <hr>
              <form action='/delete_contact' method='post'>
                <button type='submit' class='btn-failure'>Delete Contacts</button>
              </form>
              <br>
              <a href='/'>Return to Contacts List</a>

            </div>
          </body>
        </html>
        ";
    });

    // var_dump($contact); can't print outside of get/post functions

    $app->get("/contact", function() {
      $my_contact = new Contact($_GET['firstName'], $_GET['lastName'], $_GET['address']);
      $my_contact->save();

      // var_dump($contact);

      $output = "";
      foreach (Contact::getAll() as $contact) {
        $output = $output . "
            <h1>" . $contact->getFirstName() . "</h1>
          <h2>" . $contact->getLastName() . "</h2>
          <h3>" . $contact->getAddress() . "</h3>
        ";
      }
      return "
      <!DOCTYPE html>
        <html>
          <head>
            <title>Your Contacts</title>
          </head>
          <body>
            <hr>
            " . $output . "
            <hr>
            <a href='/new_contact'>Make a New Contact</a>
            <a href='/'>Return to Contacts List</a>
          </body>
        </html>";
    });

    $app->post("/delete_contact", function() {
      Contact::deleteAll();

      return "
          <h1>Contacts Cleared!</h1>
          <p><a href='/new_contact'>Home</a></p>
      ";
    });

    return $app;
?>
