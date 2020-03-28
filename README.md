# tagthiswall
<p>Basic PHP script for visitors to "tag" your wall.</p>

<p>This project is designed for basic PHP learning. There are 2 main files:<br />
\setup\createtable.php will create the mysql table to be used by the main index.php file.<br />
\index.php is used to display the "wall" and to allow anyone to "tag" the wall.</p>

<p><b>Setup Instructions:</b></p>
Create a mysql database for this app and leave it empty, or use an existing database. If you create a new database, create a user with CREATE, INSERT, and SELECT privileges to the database.<br />
The table for the application will be created by the createtable.php file.<br />
(If you are using Azure MySQL In App, you will not be able to create a database. You will have to use the default database and user that is created for you.)<br />
Take note of the mysql hostname, database name, username and username password. Modify the createtable.php and index.php file to use that information.<br />
Copy the folders and files to a directory under the web root or to the web root itself.<br />
Run http://website/setup/createtable.php to create the database table. It will indicate if it is successful.<br />
(For security, delete the entire setup/ folder after successfully creating the table.)<br />
Open http://website/index.php and look at the page. This is the only page that the user's will access.</p>

<p>Invite others to "tag" your wall.</p>

<p>This project was originally created to be used with Microsoft Azure MySql In App. The files have a section for the Azure In App database connections. You can uncomment them to be used on an Azure website, and comment out the non-Azure database connections.</p>

<p>The createtable.php generates a table named graffiti_tbl with 5 columns:<br />
PIMARY KEY: Auto Increment field.<br />
tagger: Holds the "tagger's" name.<br />
message: Holds the "tag" written.<br />
location: IP Address of the tagger.<br />
date: The date of the "tag."</p>

<p>The location field is not displayed by default, but it is there if you would like to share the IP Adress of those who visit and "tag" your wall. Displaying this information to the public may be a cause of concern to some. You can eliminate the lines of code that add it to the database if you feel better about that.</p>

<p>You can see the wall at <a href="http://harold.azurewebsites.net/">Tag This Wall!</a></p>
