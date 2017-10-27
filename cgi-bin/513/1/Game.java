// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;

class  Game{
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
	ResultSet rset;
	//case:1 add new game
	if(args[0].equalsIgnoreCase("add")){
		/**
			insert into game values('ISBN123',
						'Civil war ',
						developer_tab(
								developer_type(1, name_type('sanjaya','pandey')),
								developer_type(1, name_type('subik','pokharel'))
					        ),23.45);
		**/
		String developerIds = args[3];
		//remove last ' from string
		if (developerIds != null && developerIds.length() > 0) {
			developerIds = developerIds.substring(0, developerIds.length() - 1);
		}
		
		String subQuery = "developer_tab(";
		String tempQuery = "select value(p).id, value(p).name.fname, value(p).name.lname from developer p where id in ("+developerIds+")";
		rset = stmt.executeQuery( tempQuery );
		while ( rset.next( ) ) {
			if ( !subQuery.equalsIgnoreCase("developer_tab(")) subQuery = subQuery+ ",";
			subQuery = subQuery+ "developer_type("+rset.getString(1)+", name_type('"+rset.getString(2)+"','"+rset.getString(3)+"'))";
		}
		rset.close( );
		subQuery = subQuery + ")";
		query  = "insert into game values('"+args[1]+"','"+args[2]+"',"+subQuery+","+args[4]+")";
		System.out.println( query + "<b>" );
		rset = stmt.executeQuery( query );

	    // Close the ResultSet and Statement.
	      rset.close( );	
	}else if(args[0].equalsIgnoreCase("list")){
		query="select asin, title, price from game";
		rset = stmt.executeQuery( query );
		
	    	 // Iterate through the result and save the data.
	       String  outp = "[";
	       while ( rset.next( ) ) {
		 if ( outp != "[" ) outp += ",";
		 outp += "{\"ASIN\":\""   + rset.getString(1) + "\",";
		outp += "\"title\":\""   + rset.getString(2) + "\",";
		 outp += "\"price\":\"" + rset.getString(3) + "\"}";
	       }
	       outp += "]" ;
	       // Print the JSON object outp.
	       System.out.println( outp );
	       // Close the ResultSet and Statement.
	       rset.close( );
	}
     
     
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
