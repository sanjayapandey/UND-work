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

print( $cmd );
system($cmd);
print <<EndofHTML;
	</b>Game successfully Updated,Back to Game: <a href="http://people.aero.und.edu/~spandey/513/1/game-list.php"
							class="btn btn-primary"> Back to Game Page </a>
       </b></font>
      </td>
     </tr>
    </table>
   </body>
  </html>
EndofHTML
