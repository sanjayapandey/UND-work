// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;
import java.sql.CallableStatement;


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
	if(args[0].equalsIgnoreCase("view")){
		//  select g.ASIN, g.title, g.price , d.id, value(d).name.fname from game g, TABLE(select g.developers from game g where g.ASIN='ASIN-9877') d
		String tempQuery = "select d.id, value(d).name.fname, value(d).name.lname from TABLE(select g.developers from game g where g.ASIN='"+ args[1] +"') d";
		Statement stmt1 = conn.createStatement( );
		ResultSet rset1 = stmt1.executeQuery( tempQuery );
		String developers = "";
		int index = 1;
		while ( rset1.next( ) ) {
			developers = developers +index + ": "+rset1.getString(2) + " " + rset1.getString(3)+"<br>";
			index ++;
		}
		rset1.close( );

		query="select asin,title,price from game where asin='"+args[1]+"'";
		rset = stmt.executeQuery( query );
		
	    	 // Iterate through the result and save the data.
	       String  outp = "[";
	       while ( rset.next( ) ) {
		 if ( outp != "[" ) outp += ",";
		 outp += "{\"ASIN\":\""   + rset.getString(1) + "\",";
		outp += "\"title\":\""   + rset.getString(2) + "\",";
		 outp += "\"price\":\"" + rset.getString(3) + "\",";
		
		 outp += "\"developer\":\"" + developers+ "\"}";
	       }
	       outp += "]" ;
	       // Print the JSON object outp.
	       System.out.println( outp );
	       // Close the ResultSet and Statement.
	       rset.close( );
	}else if(args[0].equalsIgnoreCase("add")){
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
		 outp += "\"price\":\"" + rset.getString(3) + "\",";
		//  select g.ASIN, g.title, g.price , d.id, value(d).name.fname from game g, TABLE(select g.developers from game g where g.ASIN='ASIN-9877') d
		String tempQuery = "select d.id, value(d).name.fname, value(d).name.lname from TABLE(select g.developers from game g where g.ASIN='"+ rset.getString(1)+"') d";
		Statement stmt1 = conn.createStatement( );
		ResultSet rset1 = stmt1.executeQuery( tempQuery );
		String developers = "";
		int index = 1;
		while ( rset1.next( ) ) {
			developers = developers + index+ ": "+ rset1.getString(2) + " " + rset1.getString(3)+"<br>";
			index++;
		}
		 outp += "\"developer\":\"" + developers+ "\"}";
		rset1.close( );
	       }
	       outp += "]" ;
	       // Print the JSON object outp.
	       System.out.println( outp );
	       // Close the ResultSet and Statement.
	       rset.close( );
	}else if(args[0].equalsIgnoreCase("addDeveloper")){
		String asin = args[1];
		System.out.println("asin is: >>>>"+asin);
		String developerIds = args[2];
                //remove last ' from string
                if (developerIds != null && developerIds.length() > 0) {
                        developerIds = developerIds.substring(0, developerIds.length() - 1);
                }

		// Check if that user exists on game or not. 
		//String[] array = developerIds.split(",");
		//Step:1 Get all developer id of this specific game
		/*
			select id from TABLE(select g.developers from game g where g.ASIN=**);
		*/
		//for(int i=0;i<array.length;i++){
			//try to insert into game, and check for exception. If the exception is constraint voilation exception then simply continue it Otherwise update game table.
			
			//Step-1a: Get developer's name 
		/*	String tempQuery = "select value(p).name.fname, value(p).name.lname from developer p where id ="+array[i];
			rset = stmt.executeQuery( tempQuery );
			String subQuery="";
			while ( rset.next( ) ) {
				subQuery = array[i]+",name_type('"+rset.getString(1)+"','"+rset.getString(2)+"')";
			}
			rset.close( );
			/*
			insert into TABLE(select g.developers from game g where g.ASIN='ASIN-1234') values (1,name_type('sanjaya','pandey'))			
			*/
		/*	query ="insert into TABLE(select g.developers from game g where g.ASIN='"+asin+"') values ("+subQuery+")";
			ResultSet newRset = stmt.executeQuery( query );
			newRset.close( );
		}
		*/
		String plsql = "DECLARE"+
				" a  developer.id%type;"+
				" b  developer.name%type;"+
				" counter integer;"+
				" CURSOR  DeveloperCursor  IS SELECT id,name  FROM  developer p where id in ("+developerIds+");"+
				"BEGIN"+
				"  OPEN  DeveloperCursor;"+
				"  LOOP"+
				"    FETCH  DeveloperCursor  INTO  a,b;"+
				"    EXIT WHEN  DeveloperCursor%NOTFOUND;"+
				"    SELECT  count(*) into counter from TABLE(select g.developers from game g where g.ASIN='"+asin+"') d where id=a;"+
				"    if counter=0 then"+
				"        insert into TABLE(select g.developers from game g where g.ASIN='"+asin+"') values (a,b);"+
				"    end if;"+
				"END LOOP;"+
				"  CLOSE  DeveloperCursor;"+		
				"END;";
		System.out.println(plsql);
		CallableStatement cs = conn.prepareCall(plsql);
		cs.execute();
		System.out.println("success");
		cs.close();
		//rset.close( );
		
	}else if (args[0].equalsIgnoreCase("updatePrice")){
		String[] ASINs = args[1].split(",");
		String[] prices = args[2].split(",");

	      /*Adding elements to HashMap*/
		for(int i=0;i<ASINs.length;i++){
			System.out.println("ASIN is: "+ASINs[i] +" and price is: "+prices[i]);	
			query = "update game set price="+prices[i]+" where ASIN='"+ASINs[i]+"'";
			Statement stmt1 = conn.createStatement( );
			stmt1.executeQuery( query );
			stmt1.close();	
		}
	}
     
     
      //stmt.close( );
    }
    catch (Exception ex ) {
      System.out.println( ex );
    }finally{
    // Close the Connection.
    conn.close( );
}
  }
}
