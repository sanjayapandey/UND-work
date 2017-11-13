// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;
import java.sql.CallableStatement;


class  Reset{
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
	ResultSet rset;
	CallableStatement cs = conn.prepareCall("begin resetSystem; end;");
	cs.execute();
	cs.close();
	//rset.close( );
	String  outp = "[";
	outp += "{\"success\":\""+ true+ "\"}";
	outp += "]" ;
	System.out.println(outp);
    }
    catch (Exception ex ) {
      System.out.println( ex );
    }finally{
    // Close the Connection.
    conn.close( );
}
  }
}
