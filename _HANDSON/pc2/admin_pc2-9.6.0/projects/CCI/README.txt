PC^2 Countdown Timer v1.2

Overview:
        This zip contains a webpage control to allow the start/stop of a
        countdown clock for PC^2 v9.3. This also contains a webpage countdown timer
        and admin.

This zip file contains:
        CCI.jar         -- main program
        pc2v9.ini       -- sample pc2v9.ini
        PHP             -- this folder contains the web pages/images
        README.txt      -- this file

Requirements:
        PC^2 Server configured and running
        Web Server w/support PHP 4.3
        Java 1.7
        An unused PC^2 Admin account with permission to start/stop the clock
        Port TCP/50006

Installation:
        1 -- Copy contents of PHP folder to your webserver's document folder
                (eg /var/www/cci, where document root is /var/www)

        2 -- Copy CCI.jar & pc2v9.ini into another folder on your server
                (eg ~/cci)

        3 -- Modify the pc2v9.ini updating the client section with the follow info:
                server=localhost:50002 <- replace localhost with your Contest Server IP/name
                username=administrator2 <- replace with PC2 Admin account you created for the CCI
                password=administrator2 <- replace with PC2 Admin password you created for the CCI

        4 -- Start CCI using the command line:

                java -jar CCI.jar

        5 -- To control countdown clock open a browser and goto:
                http://webserver/cci/admin.php

        6 -- To view countdown clock open a browser and goto:
                http://webserver/cci


Usage:

        1 -- Using the admin.php page, set the desired Contest Start Time in the Select a Time section

        2 -- Click the "Set Start Time" button to update the Start Time TextBox(es)

        3 -- To start the COUNT DOWN clock click the "Start Countdown" button

        4 -- To stop the COUNT DOWN clock click the "Stop Countdown" button

NOTES:

        -- Running multiple admin.php pages is not currently supported and may cause undesirable results
        
        -- The Conest Start Time can be set directly by using the Epoch textbox 
        

More information about this feature is on the PC^2 wiki at:
http://pc2.ecs.csus.edu/wiki/Countdown_Clock_Project

If you have any questions or concerns, email pc2@ecs.csus.edu