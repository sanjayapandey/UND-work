// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;

class  Customers{
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
    	/**	select value(p).id,value(p).name.fname,value(p).name.lname from developer p;

	**/
	if(args[0].equalsIgnoreCase("list")){
    	      String  query  = "select value(p).id,value(p).name.fname,value(p).name.lname from customer p";

	     ResultSet rset = stmt.executeQuery( query );
		// Iterate through the result and save the data.
		 // Iterate through the result and save the data.
	      String  outp = "[";
	      while ( rset.next( ) ) {
		if ( outp != "[" ) outp += ",";
	      	 outp += "{\"id\":\""   + rset.getString(1) + "\",";
		outp += "\"name\":\"" + rset.getString(2) +" "+ rset.getString(3)+ "\"}";
	      }
	      outp += "]" ;
		// Print the JSON object outp.
      System.out.println( outp );
		rset.close( );

	}else if(args[0].equalsIgnoreCase("view")){
		 String  query  = "select value(p).id,value(p).name.fname,value(p).name.lname from customer p where id="+args[1];

	     ResultSet rset = stmt.executeQuery( query );
		// Iterate through the result and save the data.
		 // Iterate through the result and save the data.
	      String  outp = "[";
	      while ( rset.next( ) ) {
		if ( outp != "[" ) outp += ",";
	      	 outp += "{\"id\":\""   + rset.getString(1) + "\",";
		outp += "\"fname\":\"" + rset.getString(2)+ "\",";
		outp += "\"lname\":\""+ rset.getString(3)+ "\"}";
	      }
	      outp += "]" ;
		// Print the JSON object outp.
    	  System.out.println( outp );
		rset.close( );
	}
      
    // Close the ResultSet and Statement.
      
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
