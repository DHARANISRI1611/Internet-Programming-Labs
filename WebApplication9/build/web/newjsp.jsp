
<%@page import="java.sql.*"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
    </head>
    <body>
        <% Connection c=DriverManager.getConnection("jdbc:derby://localhost:1527/ritz");
            Statement st=c.createStatement();
            ResultSet rs=st.executeQuery("select * from orders");
            
        %>
        <table border="2" style="border-collapse: collapse">
            <tr><th>ORDER_ID</th><th>CUSTOMER_NAME</th><th>PRODUCT_NAME</th><th>Quantity</th><th>UNIT_PRICE</th></tr>
            <% while(rs.next()){ %>
                <tr><td> <% out.println(rs.getInt(1));%></td>
                    <td> <% out.println(rs.getString(2));%></td>
                    <td> <% out.println(rs.getString(3));%></td>
                    <td> <% out.println(rs.getInt(4));%></td>
                    <td> <% out.println(rs.getDouble(5));%></td>

                </tr>
            <% }
            %>
        </table><br><br>
            <% 
                ResultSet res=st.executeQuery("select * from orders");
                int totalorder=0;
            while (res.next()) {
            totalorder++;
        }   
            ResultSet resu=st.executeQuery("select * from orders");
            int totalRevenue=0;
            while (resu.next()) {
            int quantity = resu.getInt("Quantity");
            double unitPrice = resu.getDouble("UNIT_PRICE");
            totalRevenue += quantity * unitPrice;
        }
            ResultSet r=st.executeQuery("select * from orders");
            int totalOrders=0,averageOrderValue=0;
            
            while (r.next()) {
            int quantity = r.getInt("Quantity");
            double unitPrice = r.getDouble("UNIT_PRICE");
            totalRevenue += quantity * unitPrice;
            totalOrders++;
        }
        if (totalOrders > 0) {
            averageOrderValue = totalRevenue / totalOrders;
        }
            %>
        <table border="2" style="border-collapse: collapse">
            <tr><th>ORDER_ID</th><th>Total Revenue</th><th>Average Revenue</th></tr>
              <tr><td> <%= totalorder %></td><td><%= totalRevenue %></td><td><%= averageOrderValue %></td></tr>
        </table>
        
    </body>
</html>