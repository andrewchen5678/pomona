package cs435;

import java.sql.*;
import java.util.Scanner;
import java.text.*;
/**
 *
 * @author angelchen
 */
public class Functions {
    Connection con;
    public Functions(Connection thecon){
        con=thecon;
    }

    public void displaySchedule(String startLocationName, String destinationName, Date date) throws Exception{
        PreparedStatement prepStmt=con.prepareStatement("select t.TripNumber,Date,ScheduledStartTime,ScheduledArrivalTime from Trip as t,TripOffering as tf where t.TripNumber=tf.TripNumber and StartLocationName=? and DestinationName=? and Date=?");
        prepStmt.setString(1, startLocationName);
        prepStmt.setString(2, destinationName);
        prepStmt.setDate(3, date);
        ResultSet rs=prepStmt.executeQuery();
        printTable(rs,20);
        rs.close();
    }

    public void displayStop(int tripNumber) throws Exception{
        PreparedStatement prepStmt=con.prepareStatement("SELECT t.TripNumber,StartLocationName,DestinationName,ts.StopNumber,s.StopAddress,SequenceNumber,DrivingTime FROM TripStopInfo as ts,Stop as s, Trip as t where ts.StopNumber=s.StopNumber and ts.TripNumber=t.TripNumber and t.TripNumber=?");
        prepStmt.setInt(1, tripNumber);
        ResultSet rs=prepStmt.executeQuery();
        printTable(rs,20);
        rs.close();
    }
    
    public void recordActualData(int tripNumber, Date date, Time startTime, int stopNumber, Time arrivalTime,
            Time actualStartTime, Time actualArrivalTime, int passengerIn, int passengerOut) throws SQLException{
        System.err.printf("%s %s %s %s %s %s %s %s %s",tripNumber, date, startTime, stopNumber, arrivalTime, actualStartTime, actualArrivalTime, passengerIn, passengerOut);
        PreparedStatement prepStmt=con.prepareStatement("INSERT INTO ActualTripStopInfo (TripNumber, Date, ScheduledStartTime, StopNumber, ScheduledArrivalTime, ActualStartTime, ActualArrivalTime, NumberOfPassengerIn, NumberOfPassengerOut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        prepStmt.setInt(1, tripNumber);
        prepStmt.setDate(2, date);
        prepStmt.setTime(3, startTime);
        prepStmt.setInt(4, stopNumber);
        prepStmt.setTime(5, arrivalTime);
        prepStmt.setTime(6, actualStartTime);
        prepStmt.setTime(7, actualArrivalTime);
        prepStmt.setInt(8, passengerIn);
        prepStmt.setInt(9, passengerOut);
        prepStmt.execute();
    }

    public void deleteOffering() throws SQLException, ParseException{
        Statement stmt=con.createStatement();
        String query="SELECT * from TripOffering";
        ResultSet rs=stmt.executeQuery(query);
        //ResultSet rs=stmt.executeQuery("select * from Bus");
        printTableWithNum(rs,20);
        rs.close();
        Scanner kb=new Scanner(System.in);
        System.out.println("which one to delete?");
        int choice=kb.nextInt();kb.nextLine();
        ResultSet rs2=stmt.executeQuery(query);
        rs2.absolute(choice);
        int tripNumber=rs2.getInt(1);
        Date date=rs2.getDate(2);
        Time scheduledStartTime=rs2.getTime(3);
        rs2.close();
        deleteTripOffering(tripNumber, date, scheduledStartTime);
    }

    public void deleteBus() throws SQLException, ParseException{
        Statement stmt=con.createStatement();
        String query="SELECT * from Bus";
        ResultSet rs=stmt.executeQuery(query);
        //ResultSet rs=stmt.executeQuery("select * from Bus");
        printTable(rs,20);
        rs.close();
        Scanner kb=new Scanner(System.in);
        System.out.println("which one to delete?");
        int choice=kb.nextInt();kb.nextLine();
        deleteBus(choice);
    }

    private void deleteBus(int choice) throws SQLException{
        String query="delete from Bus where BusID="+choice;
        Statement stmt=con.createStatement();
        stmt.executeUpdate(query);
        String query2="delete from TripOffering where BusID="+choice;
        stmt.executeUpdate(query2);
        /*        ResultSet rs2=stmt.executeQuery("select * from TripOffering where BusID="+);
        if(rs2.next()){
            int busID=rs2.getInt(1);
            deleteTripOffering(tripNumber, date, scheduledStartTime);
            rs2.close();
        }*/
    }

    public void tripRecordActual() throws SQLException, ParseException{
        Statement stmt=con.createStatement();
        String query="SELECT ts.TripNumber,tf.Date,ScheduledStartTime,ts.StopNumber,ScheduledArrivalTime  FROM TripStopInfo as ts,Stop as s,TripOffering as tf where ts.StopNumber=s.StopNumber and tf.TripNumber=ts.TripNumber";
        ResultSet rs=stmt.executeQuery(query);
        //ResultSet rs=stmt.executeQuery("select * from Bus");
        printTableWithNum(rs,20);
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
        DateFormat df = new SimpleDateFormat("H:m:s");
        System.out.println("enter actualStartTime: H:m:s");Time actualStartTime=new Time(df.parse(kb.nextLine()).getTime());
        System.out.println("enter actualArrivalTime: H:m:s");Time actualArrivalTime=new Time(df.parse(kb.nextLine()).getTime());
        System.out.println("enter passenger in");int passengerIn=kb.nextInt();kb.nextLine();
        System.out.println("enter passenger out");int passengerOut=kb.nextInt();kb.nextLine();
        recordActualData(tripNumber, date, startTime, stopNumber, arrivalTime, actualStartTime, actualArrivalTime, passengerIn, passengerOut);
    }

    public void deleteTripOffering(int tripNumber, Date date, Time scheduledStartTime) throws SQLException{
        PreparedStatement prepStmt=con.prepareStatement("delete from TripOffering where tripNumber=? and date=? and scheduledStartTime=?");
        prepStmt.setInt(1, tripNumber);
        prepStmt.setDate(2, date);
        prepStmt.setTime(3, scheduledStartTime);
        prepStmt.execute();
        PreparedStatement prepStmt2=con.prepareStatement("delete from ActualTripStopInfo where tripNumber=? and date=? and scheduledStartTime=?");
        prepStmt2.setInt(1, tripNumber);
        prepStmt2.setDate(2, date);
        prepStmt2.setTime(3, scheduledStartTime);
        prepStmt2.execute();
    }

    private void printTable(ResultSet rs,int width) throws SQLException{
        ResultSetMetaData rsMetaData = rs.getMetaData();
        int numberOfColumns = rsMetaData.getColumnCount();
        System.out.println("resultSet MetaData column Count=" + numberOfColumns);
        for (int i = 1; i <= numberOfColumns; i++) {
          //System.out.println("column MetaData ");
          //System.out.println("column number "+i+": ");
          System.out.printf("%-"+width+"s|",rsMetaData.getColumnName(i));
        }
        System.out.println();
        while(rs.next()){
            for (int i = 1; i <= numberOfColumns; i++) {
              System.out.printf("%-"+width+"s|",rs.getString(i));
            }
            System.out.println();
        }
    }

    private void printTableWithNum(ResultSet rs,int width) throws SQLException{
        ResultSetMetaData rsMetaData = rs.getMetaData();
        int numberOfColumns = rsMetaData.getColumnCount();
        System.out.println("resultSet MetaData column Count=" + numberOfColumns);
        System.out.printf("%-"+6+"s|","#");
        for (int i = 1; i <= numberOfColumns; i++) {
          //System.out.println("column MetaData ");
          //System.out.println("column number "+i+": ");
          System.out.printf("%-"+6+"s|",rsMetaData.getColumnName(i));
        }
        System.out.println();
        int k=1;
        while(rs.next()){
            System.out.printf("%-"+width+"d|",k);
            k++;
            for (int i = 1; i <= numberOfColumns; i++) {
              System.out.printf("%-"+width+"s|",rs.getString(i));
            }
            System.out.println();
        }
    }

    public void addDriver(String driverName,String driverPhone) throws Exception{
        if(driverName==null || driverName.length()==0) throw new Exception("driver name can't be empty");
        if(driverPhone==null || driverPhone.length()!=10) throw new Exception("invalid phone number");
        PreparedStatement prepStmt=con.prepareStatement("insert into Driver VALUES(?,?)");
        prepStmt.setString(1, driverName);
        prepStmt.setString(2, driverPhone);
        prepStmt.execute();
    }

    public void addBus(String model,int year) throws Exception{
        if(model==null || model.length()==0) throw new Exception("model name can't be empty");
        //if(driverPhone==null || driverPhone.length()!=10) throw new Exception("invalid phone number");
        PreparedStatement prepStmt=con.prepareStatement("insert into Bus (Model,Year) VALUES(?,?)");
        prepStmt.setString(1, model);
        prepStmt.setInt(2, year);
        prepStmt.execute();
    }
}
