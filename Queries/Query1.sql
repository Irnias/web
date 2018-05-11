Select Tickets.mnTicketNumber, 
Tickets.gdOpenDate, 
Tickets.szActivitySubCategory, 
Tickets.szDescription, 
Tickets.szRequestor, 
Tickets.szActivityCategory, 
Tickets.szTeam, 
Subcategories.mnEstimateWD
FROM ((Tickets 
INNER JOIN Subcategories 
ON Tickets.szTeam = Subcategories.szTeam)
INNER JOIN Subcategories
ON Tickets.szActivityCategory = Subcategories.szActivity)
Inner JOIN Subcateogories
ON Tickets.szActivitySubCategory = Subcategories.szSubActivity;


