# tagthiswall
Basic PHP script for visitors to "tag" your wall.

This project is designed for basic PHP learning. There are 2 main files:<br />
\setup\createtable.php will create the mysql table to be used by the main index.php file.<br />
\index.php is used to display the "wall" and to allow anyone to "tag" the wall.<p>

Setup Instructions:<br />
Create a mysql database for this app and leave it empty. The table will be built from the createtable.php file.<br />
Take note of the mysql hostname, database name, username and username password.<br />
Copy the folders and files to a directory under the web root or to the web root itself.<br />
Run \setup\createtable.php<br />
Open \index.php and look at the page.<p>

Invite others to "tag" your wall.<p>

This project was originally created to be used with Microsoft Azure MySql In App. The files have a section for the Azure In App database connections. You can uncomment them to be used on an Azure website, and comment out the non-Azure database connections.<p>

