#!/usr/bin/perl
use CGI;
$query  = new CGI;
$username    = $query->param( 'username' );
$password    = $query->param( 'password' );


# Print HTML.
print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Login ";
$cmd   .=  "'$username' ";
$cmd   .=  "'$password' ";  
system( $cmd );
