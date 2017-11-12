#!/usr/bin/perl
use CGI;
$query  = new CGI;
$action    = $query->param( 'action' );


# Print HTML.
print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Developers ";
$cmd   .=  "'$action' ";
my @developers = $query->param( 'developerIds' );
  foreach my $developer (@developers) { $developerIds .= $developer . ","; }
$cmd   .=  "'$developerIds' ";  
system( $cmd );
