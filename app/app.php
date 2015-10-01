<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();

    if (empty($_SESSION['list_of_contacts'])) {
      $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();
    $app['debug'] = true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/",function() {
        $output = "";
        if (!empty(Contact::getAll())) {
            $output .= "
                <h1>List of Contacts</h1>
                <p>Here are all of your contacts:</p>
                <hr>
                <form action='/delete_contact' method='post'>
                  <button type='submit' class='btn-failure'>Delete Contacts</button>
                </form>
                <hr>
            ";
            foreach (Contact::getAll() as $contact) {
                $output = $output . "
                    <h3>First Name: " . $contact->getFirstName() . "</h3>
                    <h3>Last Name: " . $contact->getLastName() . "</h3>
                    <h3>Address: " . $contact->getAddress() . "</h3><hr>
                ";
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

    $app->get("/new_contact", function() use ($app) {
      return $app['twig']->render('contact.html.twig', array('contact' => Contact::getAll()));
    });

    // var_dump($contact); can't print outside of get/post functions

    $app->get("/contact", function() {
      $my_contact = new Contact($_GET['firstName'], $_GET['lastName'], $_GET['address']);
      $my_contact->save();

      // var_dump($contact);

      $output = "";
      foreach (Contact::getAll() as $contact) {
        $output = $output . "
            <h3>First Name: " . $contact->getFirstName() . "</h3>
          <h3>Last Name: " . $contact->getLastName() . "</h3>
          <h3>Address: " . $contact->getAddress() . "</h3><hr>
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
              <hr>
              <form action='/delete_contact' method='post'>
                <button type='submit' class='btn-failure'>Delete Contacts</button>
              </form>
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
