#!/usr/bin/perl
use CGI;
$query  = new CGI;

  # Print HTML.
  print ( "Content-type: text/html\n\n" );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Reset ";
system( $cmd );
print <<EndofHTML;
	</b>System is successfully reset. Go to dashboard:    <a href="http://people.aero.und.edu/~spandey/513/1/dashboard.php"
							class="btn btn-primary"> Dashboard	 </a>
       </b></font>
      </td>
     </tr>
    </table>
   </body>
  </html>
EndofHTML
