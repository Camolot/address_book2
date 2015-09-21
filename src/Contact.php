<?php
    class Contact
    {
        private $firstName;
        private $lastName;
        private $address;

        function __construct($first_name, $last_name, $address)
        {
          $this->firstName = $first_name;
          $this->lastName = $last_name;
          $this->address = $address;
        }

        function setFirst ($first_name)
        {
          $this->firstName = $first_name;
        }

        function setLast ($last_name)
        {
          $this->lastName = $last_name;
        }

        function setAddress ($address)
        {
          $this->address = $address;
        }

        function getFirst ()
        {
          return $this->first;
        }

        function getLast ()
        {
          return $this->last;
        }

        function getAddress ()
        {
          return $this->address;
        }

        function getContact ()
        {
          return $this->contact;
        }
    }
?>
