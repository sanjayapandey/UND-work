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
		String tempQuery = "SELECT g.asin, g.title from game g, TABLE(g.developers) d where d.id="+args[1];
		Statement stmt1 = conn.createStatement( );
		ResultSet rset1 = stmt1.executeQuery( tempQuery );
		String games = "";
		int index = 1;
		
		String  gameStr = "[";
		while ( rset1.next( ) ) {
			if ( gameStr != "[" ) gameStr += ",";
			gameStr += "{\"ASIN\":\""   + rset1.getString(1) + "\",";		
			gameStr += "\"Title\":\"" +rset1.getString(2) + "\"}";
	       }
	       gameStr += "]" ;
		rset1.close( );


		String  query  = "select value(p).id,value(p).name.fname,value(p).name.lname from developer p where id="+args[1];
	     ResultSet rset = stmt.executeQuery( query );
		// Iterate through the result and save the data.
		 // Iterate through the result and save the data.
	      String  outp = "[";
	      while ( rset.next( ) ) {
		if ( outp != "[" ) outp += ",";
	      	 outp += "{\"id\":\""   + rset.getString(1) + "\",";
		outp += "\"fname\":\"" + rset.getString(2)+ "\",";
		outp += "\"lname\":\""+ rset.getString(3)+ "\",";
		outp += "\"games\":" + gameStr+ "}";
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
	
		/*String plsql="DECLARE"+
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
		*/
		 CallableStatement cs = conn.prepareCall("{call deleteDeveloper(string_table("+developerIds+"))}");
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
