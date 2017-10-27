// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;

class  Login {
  public static void  main( String args[ ] ) throws SQLException {
    String user     ="spandey";// System.getenv("ORACLE_USER");
    String password ="sanjaya1";// System.getenv("ORACLE_PASS");
    String database = "oracle1.aero.und.edu:1521/cs513.aero.und.edu";
 
    // Open an OracleDataSource and get a connection.
    OracleDataSource ods = new OracleDataSource( );
    ods.setURL     ( "jdbc:oracle:thin:@" + database );
    ods.setUser    ( user );
    ods.setPassword( password );
    Connection conn = ods.getConnection( );

    try {
      // Create, compose, and execute a statement.
      Statement stmt = conn.createStatement( );
     String  query  = "select ID from customer where username='"+args[0].trim()+"' and password='"+args[1].trim()+"'";
     ResultSet rset = stmt.executeQuery( query );
	boolean loggedIn = false;
	int userId = 0;
	// Iterate through the result and save the data.
      while ( rset.next( ) ) {
        loggedIn = true;
	userId = Integer.valueOf(rset.getString(1));
      }
	String  outp = "[";
	outp += "{\"loggedIn\":\""+ loggedIn+ "\",";
	outp += "\"userName\":\""+ args[0].trim()+ "\",";
        outp += "\"userId\":\"" + userId + "\"}";
	outp += "]" ;
	
	System.out.println(outp);

    // Close the ResultSet and Statement.
      rset.close( );
      stmt.close( );
    }
    catch ( SQLException ex ) {
      System.out.println( ex );
    }finally{
    // Close the Connection.
    conn.close( );
	}
  }
}
