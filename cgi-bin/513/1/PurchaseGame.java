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
	String  plsql = "";
	ResultSet rset;

	String[] ASINs = args[1].split(",");
	String[] quantities = args[2].split(",");
	for(int i=0;i<ASINs.length;i++){
	plsql = "DECLARE"+
"  /* Output variables to hold the result of the query: */"+
"  a GAME.ASIN%type;"+
"  b GAME.PRICE%type;"+
"  counter integer;"+
"  quantity integer;"+
"  customerId integer := "+args[0]+";"+
"  /* Cursor declaration: */"+
"  CURSOR  GameCursor  IS select asin, price from game where asin in ('"+ASINs[i]+"');"+
"BEGIN"+
"  OPEN  GameCursor;"+
"  LOOP"+
"    /* Retrieve each row of the result of the above query into PL/SQL variables: */"+
"    FETCH  GameCursor  INTO  a, b;"+
"    /* If there are no more rows to fetch, exit the loop: */"+
"    EXIT WHEN  GameCursor%NOTFOUND;"+
"    /* check if that book already purchased or not */"+
"    BEGIN"+
"    SELECT count(*) into counter from TABLE(select customer.purchases from customer where customer.id = customerId) p where p.asin = a;"+
"    EXCEPTION"+
"      WHEN NO_DATA_FOUND THEN"+
"        counter := 0;"+
"    END;"+
"    BEGIN"+
"    SELECT p.quantity into quantity from TABLE(select customer.purchases from customer where customer.id = customerId) p where p.asin = a;"+
"    EXCEPTION"+
"      WHEN NO_DATA_FOUND THEN"+
"        quantity := 0;"+
"    END;"+
"    if counter=0 then"+
"        insert into TABLE(select customer.purchases from customer where customer.id = customerId) values (purchase_type(a, "+quantities[i]+"));"+
"    else"+
"        update TABLE(select customer.purchases from customer where customer.id = customerId) set quantity = quantity + "+quantities[i]+" where asin =a;"+
"    end if;"+
"    update customer set customer.amount = customer.amount + "+quantities[i]+"*b where id = customerId;"+
"  END LOOP;"+
"  /* Free cursor used by the query. */"+
"  CLOSE  GameCursor;"+
"END;";
		System.out.println(plsql);
		 CallableStatement cs = conn.prepareCall(plsql);
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
