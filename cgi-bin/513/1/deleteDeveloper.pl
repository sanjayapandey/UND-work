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
print($cmd);
system( $cmd );
print <<EndofHTML;
	</b>Delete Success! ,Back to Game: <a href="http://people.aero.und.edu/~spandey/513/1/developer.php"
							class="btn btn-primary"> Back to Developer page </a>
       </b></font>
      </td>
     </tr>
    </table>
   </body>
  </html>
EndofHTML
