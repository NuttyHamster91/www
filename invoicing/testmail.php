<?php



        $from = "info@simonh.online";



        $to = "shammond1991@gmail.com";



        $subject = "Hello Sendmail.";



        $message = "This is an test email to test Sendmail.";



        $headers = [ "From: $from" ];



        mail( $to, $subject, $message, implode( '\r\n', $headers ) ); 

        ?>