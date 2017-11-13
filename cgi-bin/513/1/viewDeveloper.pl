#!/usr/bin/perl
use CGI;
$query  = new CGI;
$action    = $query->param( 'action' );
$id    = $query->param( 'id' );


# Print HTML.
print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Developers ";
$cmd   .=  "'$action' ";
$cmd   .=  "'$id' ";  
#print($cmd);
system( $cmd );
