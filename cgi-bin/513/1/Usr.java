// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;

class  Usr {
  public static void  main( String args[ ] ) throws SQLException {
    String user     = "spandey";//System.getenv("ORACLE_USER");
    String password = "sanjaya1";// System.getenv("ORACLE_PASS");
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
	String  query = "";
	//case:1 Role=developer
	if(args[0].equalsIgnoreCase("developer")){

		 query  = "insert into developer values(id.NEXTVAL,name_type('"+args[1].trim()+"','"+args[2].trim()+"'))";	
	}else if(args[0].equalsIgnoreCase("customer")){
	//case:2 Role=customer
     		query  = "insert into customer values(id.NEXTVAL,name_type('"+args[1].trim()+"','"+args[2].trim()+"'),'"+args[3]+"','"+args[4]+"')";
	}
     System.out.println( query + "<b>" );
    ResultSet rset = stmt.executeQuery( query );

      // Iterate through the result and print the data.
/**
      while ( rset.next( ) ) {
        System.out.print( rset.getString(1) + ", " + rset.getString(2) );
        System.out.print( ", " + rset.getString(3) );
      }
 **/
    // Close the ResultSet and Statement.
      rset.close( );
      stmt.close( );
    }
    catch ( SQLException ex ) {
      System.out.println( ex );
    }
    // Close the Connection.
    conn.close( );
  }
}
