#!/usr/bin/perl
use CGI;
$query  = new CGI;
$action    = $query->param( 'action' );
$ISBN    = $query->param( 'ISBN' );


# Print HTML.
print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Game ";
$cmd   .=  "'$action' ";
$cmd   .=  "'$ISBN' ";  
#print($cmd);
system( $cmd );
