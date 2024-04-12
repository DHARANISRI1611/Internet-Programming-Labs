<%@ page import="java.util.ArrayList" %>
<%@ page import="newpackage.Customer" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Information</title>
    <style>
        body{
            margin-left: 500px;
        }
    </style>
</head>
<body>
    <h1>Customer Information</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <% 
            ArrayList<Customer> al = new ArrayList<Customer>();
             al.add(new Customer("John Doe", "john.doe@example.com", "(123) 456-7890", "123 Main St."));
             al.add(new Customer("Jane Smith", "jane.smith@example.com", "(234) 567-8901", "456 Oak Ave."));
            pageContext.setAttribute("cust", al);
    %>      

            
            
            <c:forEach var="cust" items="${pageScope.cust}" varStatus="status">
                <tr>
                    <td>${cust.getName()}</td>
                    <td>${cust.getEmail()}</td>
                    <td>${cust.getPhone()}</td>
                    <td>${cust.getAddress()}</td>
                </tr>
            </c:forEach>
        </tbody>
    </table>

</body>
</html>
