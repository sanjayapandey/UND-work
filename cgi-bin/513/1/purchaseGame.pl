#!/usr/bin/perl
use CGI;
$query  = new CGI;
$userid = $query->param('userId');
  # Print HTML.
  print ( "Content-type: text/html\n\n" );;
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom PurchaseGame ";
$cmd .= "$userid ";

my @asins = $query->param( 'asins' );
  foreach my $asin (@asins) { $gameIds .="'". $asin . "',"; }
$cmd   .= "'$gameIds' ";

my @quantities = $query->param( 'quantities' );
  foreach my $quantity (@quantities) { $qty .= $quantity . ","; }
$cmd   .= "'$qty' ";

#print( $cmd );
system($cmd);
