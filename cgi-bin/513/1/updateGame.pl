#!/usr/bin/perl
use CGI;
$query  = new CGI;
$ISBN    = $query->param('ISBN');
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

my @developers = $query->param( 'developers' );
  foreach my $developer (@developers) { $developerIds .= $developer . ","; }
$cmd   .= "'$developerIds' ";
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
