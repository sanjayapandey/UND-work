#!/usr/bin/perl
use CGI;
$query  = new CGI;
$ISBN    = $query->param('ISBN');
$title    = $query->param( 'title' );
$price    = $query->param( 'price' );
$developers    = $query->param( 'developers' );
$action = $query->param('action');


  # Print HTML.
  print ( "Content-type: text/html\n\n" );
print($fname );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Game ";
$cmd   .=  "'$action' ";
$cmd   .=  "'$ISBN' ";
$cmd   .=  "'$title' ";

my @developers = $query->param( 'developers' );
  foreach my $developer (@developers) { $developerIds .= $developer . ","; }
$cmd   .= "'$developerIds' ";
$cmd   .=  "'$price' ";
print( $cmd );
system($cmd);
print <<EndofHTML;
	</b>Game successfully created,Back to Game: <a href="http://people.aero.und.edu/~spandey/513/1/game.php"
							class="btn btn-primary"> Back to Game Page </a>
       </b></font>
      </td>
     </tr>
    </table>
   </body>
  </html>
EndofHTML
