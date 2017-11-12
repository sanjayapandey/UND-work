// Import the following packages to use JDBC.
import  java.sql.*;
import  java.io.*;
import  oracle.jdbc.*;
import  oracle.jdbc.pool.OracleDataSource;
import java.sql.CallableStatement;


class  PurchaseGame{
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
	String[] ASINs = args[1].split(",");
	String[] quantities = args[2].split(",");
	for(int i=0;i<ASINs.length;i++){
		CallableStatement cs = conn.prepareCall("{call purchaseGame("+args[0]+",string_table('"+ASINs[i]+"'),"+quantities[i]+")}");
		cs.execute();
		System.out.println("success");
		cs.close();
		//rset.close( );
}
    }
    catch (Exception ex ) {
      System.out.println( ex );
    }finally{
    // Close the Connection.
    conn.close( );
}
  }
}
