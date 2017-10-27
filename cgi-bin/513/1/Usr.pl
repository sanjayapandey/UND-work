#!/usr/bin/perl
use CGI;
$query  = new CGI;
$fname    = $query->param( 'firstName' );
$lname    = $query->param( 'lastName' );
$username    = $query->param( 'userName' );
$password    = $query->param( 'password' );
$role = $query->param('role');


  # Print HTML.
  print ( "Content-type: text/html\n\n" );
print($fname );
# Use "here-doc" syntax.
# Compose a Java command.
$cmd    =  "/usr/bin/java -Djava.security.egd=file:/dev/./urandom Usr ";
$cmd   .=  "'$role' ";
$cmd   .=  "'$fname' ";
$cmd   .=  "'$lname' ";
$cmd   .=  "'$username' ";
$cmd   .=  "'$password' ";
print( $cmd );   
system( $cmd );
print <<EndofHTML;
	</b>Your account is successfully created, you can login to application
						by clicking following button.      <a href="http://people.aero.und.edu/~spandey/513/1/login.php"
							class="btn btn-primary"> Login </a>
       </b></font>
      </td>
     </tr>
    </table>
   </body>
  </html>
EndofHTML
