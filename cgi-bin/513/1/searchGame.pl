#!/usr/bin/perl
use CGI;
$query  = new CGI;
$searchTitle    = $query->param( 'searchTitle' );

# Print HTML.
print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Game search ";
$cmd   .=  "'$searchTitle' ";
#print($cmd);
system( $cmd );
