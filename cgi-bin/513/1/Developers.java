// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;
import java.sql.CallableStatement;

class  Developers{
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
    	      String  query  = "select value(p).id,value(p).name.fname,value(p).name.lname from developer p";

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
		 String  query  = "select value(p).id,value(p).name.fname,value(p).name.lname from developer p where id="+args[1];

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
	}else if(args[0].equalsIgnoreCase("deleteDeveloper")){
		String developerIds = args[1];
		//remove last ' from string
		if (developerIds != null && developerIds.length() > 0) {
			developerIds = developerIds.substring(0, developerIds.length() - 1);
		}
		//delete from developer table
		// String  query  = "delete from developer where id in ("+developerIds+")";
		//ResultSet rset = stmt.executeQuery( query );
	    	//stmt.executeQuery( query );
		//delete from game table: 
		//We need to loop outer to select all asin number and run this query inside loop.
		//query = "delete TABLE(select g.developers from game g where g.ASIN='ASIN-1234') d where d.id=1;";
		String plsql="DECLARE"+
		"  a  game.asin%type;"+
		"  CURSOR  GameCursor  IS SELECT  asin  FROM  game;"+
		"BEGIN"+
		"  delete from developer where id in("+developerIds+");"+
		"  OPEN  GameCursor;"+
		"  LOOP"+
		"    FETCH  GameCursor  INTO  a;"+
		"    EXIT WHEN  GameCursor%NOTFOUND;"+
		"   delete TABLE(select g.developers from game g where g.ASIN=a) d where d.id in ("+developerIds+");"+
		" END LOOP;"+
		"  CLOSE  GameCursor;"+
		"END;";
		System.out.println(plsql);
		 CallableStatement cs = conn.prepareCall(plsql);
		cs.execute();
		System.out.println("success");
		cs.close();
		//rset.close( );
	}
      
    // Close the ResultSet and Statement.
      
      stmt.close( );
    }
    catch ( Exception ex ) {
      System.out.println( ex );
    }finally{
    // Close the Connection.
	 conn.close( );
   }
  }
}
