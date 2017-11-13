#!/usr/bin/perl
use CGI;
$query  = new CGI;
$action = $query->param('action');


  # Print HTML.
  print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Game ";
$cmd   .=  "'$action' ";

my @games = $query->param( 'keys' );
  foreach my $game (@games) { $gameASIN .= $game . ","; }
$cmd   .= "'$gameASIN' ";

my @prices = $query->param( 'prices' );
  foreach my $price (@prices) { $newPrice .= $price . ","; }
$cmd   .= "'$newPrice' ";

system($cmd);
