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
    	      String  query  = "select id, c.customer.name.fname, c.customer.name.lname from customer c";

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
		String tempQuery = "select g.asin, g.title, p.quantity from game g, TABLE(select customer.purchases from customer where customer.id="+args[1]+") p where g.asin in p.asin";
		Statement stmt1 = conn.createStatement( );
		ResultSet rset1 = stmt1.executeQuery( tempQuery );
	
		int index = 1;
		
		String  gameStr = "[";
		while ( rset1.next( ) ) {
			if ( gameStr != "[" ) gameStr += ",";
			gameStr += "{\"ASIN\":\""   + rset1.getString(1) + "\",";			
			gameStr += "\"Title\":\""   + rset1.getString(2) + "\",";		
			gameStr += "\"Quantity\":\"" +rset1.getString(3) + "\"}";
	       }
	       gameStr += "]" ;
		rset1.close( );


		 String  query  = "select id, c.customer.name.fname, c.customer.name.lname, c.amount from customer c where id="+args[1];

	     ResultSet rset = stmt.executeQuery( query );
		// Iterate through the result and save the data.
		 // Iterate through the result and save the data.
	      String  outp = "[";
	      while ( rset.next( ) ) {
		if ( outp != "[" ) outp += ",";
	      	 outp += "{\"id\":\""   + rset.getString(1) + "\",";
		outp += "\"fname\":\"" + rset.getString(2)+ "\",";
		outp += "\"lname\":\""+ rset.getString(3)+ "\",";
		outp += "\"amount\":\""+ rset.getString(4)+ "\",";
		outp += "\"games\":" + gameStr+ "}";
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
