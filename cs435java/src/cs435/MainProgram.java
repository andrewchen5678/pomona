package cs435;
import java.sql.*;
import java.util.Scanner;
import java.text.*;

public class MainProgram {
    private static Connection con;
    private static Functions f;
    public static DateFormat df = new SimpleDateFormat("y:M:d");

    public static void main(String[] args) throws Exception{
        Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
        con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pomonatransit",
                        "pomona", "pomonapass");
        int choice=1;
        Scanner kb=new Scanner(System.in);
        f=new Functions(con);

        while(choice !=0){
            System.out.println("1.Display the schedule of all trips for a given StartLocationName and Destination Name");
            System.out.println("2.Delete a trip offering specified by Trip#, Date, and ScheduledStartTime");
            System.out.println("3.Display the stops of a given trip");
            System.out.println("5. Add a drive.");
            System.out.println("6. Add a bus");
            System.out.println("7. Delete a bus");
            System.out.println("8. Record (insert) the actual data of a given trips");
            System.out.println("0. exit");
            System.out.println("Enter choice:");
            choice=kb.nextInt();
            if(choice==1){
                displaySchedule();
                //f.displaySchedule("cla", "village", java.sql.Date.valueOf("2008-12-08")); //no 1
            } else if(choice==2){ //no 2a
                
                //f.deleteBus();
            }else if(choice==3){
                f.displayStop(5); //3
            }else if(choice==5){
                f.addDriver("fdgdfg", "1234567890"); // 5
            }else if(choice==6){
                f.addBus("junkcar", 2342); //no 6
            }else if(choice==7){
                deleteBus();
            }else if(choice==8){
                tripRecordActual(); //no 8
            }
        }
    }

    private static void displaySchedule() throws Exception{
            Scanner kb=new Scanner(System.in);
            System.out.println("Enter start location:");
            String startLocation=kb.nextLine();
            System.out.println("Enter destination:");
            String destination=kb.nextLine();
            System.out.println("Enter date:");
            Date d=new Date(df.parse(kb.nextLine()).getTime());
            f.displaySchedule(startLocation, destination, d);
    }

    private static void deleteBus() throws Exception{
            Statement stmt=con.createStatement();
            String query="SELECT * from Bus";
            ResultSet rs=stmt.executeQuery(query);
            //ResultSet rs=stmt.executeQuery("select * from Bus");
            f.printTable(rs,20);
            rs.close();
            Scanner kb=new Scanner(System.in);
            System.out.println("which one to delete?");
            int choice=kb.nextInt();kb.nextLine();
            f.deleteBus(choice);
    }

    private static void tripRecordActual() throws SQLException, ParseException{
        Statement stmt=con.createStatement();
        String query="SELECT ts.TripNumber,tf.Date,ScheduledStartTime,ts.StopNumber,ScheduledArrivalTime  FROM TripStopInfo as ts,Stop as s,TripOffering as tf where ts.StopNumber=s.StopNumber and tf.TripNumber=ts.TripNumber";
        ResultSet rs=stmt.executeQuery(query);
        //ResultSet rs=stmt.executeQuery("select * from Bus");
        f.printTableWithNum(rs,20);
        rs.close();
        Scanner kb=new Scanner(System.in);
        System.out.println("which one to add record?");
        int choice=kb.nextInt();kb.nextLine();
        ResultSet rs2=stmt.executeQuery(query);
        rs2.absolute(choice);
        int tripNumber=rs2.getInt(1);
        Date date=rs2.getDate(2);
        Time startTime=rs2.getTime(3);
        int stopNumber=rs2.getInt(4);
        Time arrivalTime=rs2.getTime(5);
        rs2.close();
        System.out.println("enter actualStartTime: H:m:s");Time actualStartTime=new Time(df.parse(kb.nextLine()).getTime());
        System.out.println("enter actualArrivalTime: H:m:s");Time actualArrivalTime=new Time(df.parse(kb.nextLine()).getTime());
        System.out.println("enter passenger in");int passengerIn=kb.nextInt();kb.nextLine();
        System.out.println("enter passenger out");int passengerOut=kb.nextInt();kb.nextLine();
        f.recordActualData(tripNumber, date, startTime, stopNumber, arrivalTime, actualStartTime, actualArrivalTime, passengerIn, passengerOut);
    }
}
