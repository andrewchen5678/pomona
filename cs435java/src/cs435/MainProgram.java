package cs435;
import java.sql.*;

public class MainProgram {
    public static void main(String[] args) throws Exception{
        Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
        Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pomonatransit",
                        "pomona", "pomonapass");
        Functions f=new Functions(con);
        f.displaySchedule("cla", "village", java.sql.Date.valueOf("2008-12-08")); //no 1
        f.deleteBus(); //no 2a
        f.displayStop(5); //3
        f.tripRecordActual(); //no 8
        f.addDriver("fdgdfg", "1234567890"); // 5
        f.addBus("junkcar", 2342);
    }
}
