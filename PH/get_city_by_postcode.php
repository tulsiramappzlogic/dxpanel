<?php
/**
 * Philippines Postcode to City/Municipality and Barangay Lookup Endpoint
 * Returns city/municipality and barangay based on valid Philippines postcode
 */

header('Content-Type: application/json');

// Philippines postcodes mapped to cities/municipalities and common barangays
// Postcode format: 4 digits
$postcodeMap = [
    // Metro Manila - Manila
    '1000' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1001' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1002' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1003' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1004' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1005' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1006' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1007' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1008' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1010' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1011' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1012' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1013' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1014' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1015' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1016' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1017' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1018' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1019' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1020' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1021' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1022' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1023' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1024' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1025' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1026' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1027' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1028' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1029' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1030' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1031' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1032' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1033' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1034' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1035' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1036' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1037' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1038' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1039' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1040' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1041' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1042' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1043' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1044' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1045' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    '1046' => ['city' => 'Manila', 'barangay' => 'Santa Cruz'],
    
    // Quezon City
    '1100' => ['city' => 'Quezon City', 'barangay' => 'Project 1'],
    '1101' => ['city' => 'Quezon City', 'barangay' => 'Project 2'],
    '1102' => ['city' => 'Quezon City', 'barangay' => 'Project 3'],
    '1103' => ['city' => 'Quezon City', 'barangay' => 'Project 4'],
    '1104' => ['city' => 'Quezon City', 'barangay' => 'Project 5'],
    '1105' => ['city' => 'Quezon City', 'barangay' => 'Project 6'],
    '1106' => ['city' => 'Quezon City', 'barangay' => 'Project 7'],
    '1107' => ['city' => 'Quezon City', 'barangay' => 'Project 8'],
    '1108' => ['city' => 'Quezon City', 'barangay' => 'Holy Spirit'],
    '1109' => ['city' => 'Quezon City', 'barangay' => 'Bayanihan'],
    '1110' => ['city' => 'Quezon City', 'barangay' => 'Tandang Sora'],
    '1111' => ['city' => 'Quezon City', 'barangay' => 'Bagong Silang'],
    '1112' => ['city' => 'Quezon City', 'barangay' => 'Commonwealth'],
    '1113' => ['city' => 'Quezon City', 'barangay' => 'Fairview'],
    '1114' => ['city' => 'Quezon City', 'barangay' => 'Laguna'],
    '1115' => ['city' => 'Quezon City', 'barangay' => 'Novaliches'],
    '1116' => ['city' => 'Quezon City', 'barangay' => 'San Bartolome'],
    '1117' => ['city' => 'Quezon City', 'barangay' => 'Pasong Tamo'],
    '1118' => ['city' => 'Quezon City', 'barangay' => 'Project 1'],
    '1119' => ['city' => 'Quezon City', 'barangay' => 'Project 2'],
    '1120' => ['city' => 'Quezon City', 'barangay' => 'Project 3'],
    '1121' => ['city' => 'Quezon City', 'barangay' => 'Project 4'],
    '1122' => ['city' => 'Quezon City', 'barangay' => 'Project 5'],
    '1123' => ['city' => 'Quezon City', 'barangay' => 'Project 6'],
    '1124' => ['city' => 'Quezon City', 'barangay' => 'Project 7'],
    '1125' => ['city' => 'Quezon City', 'barangay' => 'Project 8'],
    '1126' => ['city' => 'Quezon City', 'barangay' => 'Cubao'],
    '1127' => ['city' => 'Quezon City', 'barangay' => 'Cubao'],
    '1128' => ['city' => 'Quezon City', 'barangay' => 'Cubao'],
    '1129' => ['city' => 'Quezon City', 'barangay' => 'Kamuning'],
    '1130' => ['city' => 'Quezon City', 'barangay' => 'Kamuning'],
    '1131' => ['city' => 'Quezon City', 'barangay' => 'Kamuning'],
    '1132' => ['city' => 'Quezon City', 'barangay' => 'Krus na Liwas'],
    '1133' => ['city' => 'Quezon City', 'barangay' => 'Krus na Liwas'],
    '1134' => ['city' => 'Quezon City', 'barangay' => 'Krus na Liwas'],
    '1135' => ['city' => 'Quezon City', 'barangay' => 'Bayanihan'],
    '1136' => ['city' => 'Quezon City', 'barangay' => 'Bayanihan'],
    '1137' => ['city' => 'Quezon City', 'barangay' => 'Bayanihan'],
    '1138' => ['city' => 'Quezon City', 'barangay' => 'Bayanihan'],
    
    // Makati City
    '1200' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1201' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1202' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1203' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1204' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1205' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1206' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1207' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1208' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1209' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1210' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1211' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1212' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1213' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1214' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    '1215' => ['city' => 'Makati City', 'barangay' => 'Poblacion'],
    
    // Pasig City
    '1600' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1601' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1602' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1603' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1604' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1605' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1606' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1607' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    '1608' => ['city' => 'Pasig City', 'barangay' => 'Poblacion'],
    
    // Taguig City
    '1630' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1631' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1632' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1633' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1634' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1635' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1636' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1637' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    '1638' => ['city' => 'Taguig City', 'barangay' => 'Fort Bonifacio'],
    
    // Parañaque City
    '1700' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1701' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1702' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1703' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1704' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1705' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1706' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1707' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1708' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1709' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1710' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1711' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    '1712' => ['city' => 'Parañaque City', 'barangay' => 'Poblacion'],
    
    // Las Piñas City
    '1740' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1741' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1742' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1743' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1744' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1745' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1746' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1747' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    '1748' => ['city' => 'Las Piñas City', 'barangay' => 'Poblacion'],
    
    // Valenzuela City
    '1440' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1441' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1442' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1443' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1444' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1445' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1446' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1447' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    '1448' => ['city' => 'Valenzuela City', 'barangay' => 'Poblacion'],
    
    // Caloocan City
    '1400' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1401' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1402' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1403' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1404' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1405' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1406' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1407' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1408' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    '1409' => ['city' => 'Caloocan City', 'barangay' => 'Poblacion'],
    
    // Malabon City
    '1470' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1471' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1472' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1473' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1474' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1475' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1476' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1477' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1478' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    '1479' => ['city' => 'Malabon City', 'barangay' => 'Poblacion'],
    
    // Navotas City
    '1485' => ['city' => 'Navotas City', 'barangay' => 'Poblacion'],
    '1486' => ['city' => 'Navotas City', 'barangay' => 'Poblacion'],
    '1487' => ['city' => 'Navotas City', 'barangay' => 'Poblacion'],
    '1488' => ['city' => 'Navotas City', 'barangay' => 'Poblacion'],
    '1489' => ['city' => 'Navotas City', 'barangay' => 'Poblacion'],
    
    // Mandaluyong City
    '1550' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1551' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1552' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1553' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1554' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1555' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1556' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    '1557' => ['city' => 'Mandaluyong City', 'barangay' => 'Poblacion'],
    
    // San Juan City
    '1500' => ['city' => 'San Juan City', 'barangay' => 'Poblacion'],
    '1502' => ['city' => 'San Juan City', 'barangay' => 'Poblacion'],
    '1503' => ['city' => 'San Juan City', 'barangay' => 'Poblacion'],
    '1504' => ['city' => 'San Juan City', 'barangay' => 'Poblacion'],
    
    // Pateros
    '1620' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1621' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1622' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1623' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1624' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1625' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1626' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    '1627' => ['city' => 'Pateros', 'barangay' => 'Poblacion'],
    
    // Cebu City
    '6000' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6001' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6002' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6003' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6004' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6005' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6006' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6007' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    '6008' => ['city' => 'Cebu City', 'barangay' => 'Poblacion'],
    
    // Davao City
    '8000' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8001' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8002' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8003' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8004' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8005' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8006' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8007' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    '8008' => ['city' => 'Davao City', 'barangay' => 'Poblacion'],
    
    // Laguna
    '4000' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4001' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4002' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4003' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4004' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4005' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4006' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4007' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4008' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4009' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4010' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4011' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4012' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4013' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4014' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4015' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4016' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4017' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    '4018' => ['city' => 'Calamba City', 'barangay' => 'Poblacion'],
    
    // Cavite
    '4100' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4101' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4102' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4103' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4104' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4105' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4106' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4107' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4108' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4109' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4110' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4111' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4112' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4113' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4114' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4115' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4116' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4117' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    '4118' => ['city' => 'Cavite City', 'barangay' => 'Poblacion'],
    
    // Batangas
    '4200' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4201' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4202' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4203' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4204' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4205' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4206' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4207' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4208' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    '4209' => ['city' => 'Batangas City', 'barangay' => 'Poblacion'],
    
    // Pampanga
    '2000' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2001' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2002' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2003' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2004' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2005' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2006' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2007' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2008' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2009' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    
    // Bulacan
    '3000' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3001' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3002' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3003' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3004' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3005' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3006' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3007' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    '3008' => ['city' => 'Malolos City', 'barangay' => 'Poblacion'],
    
    // Rizal
    '1850' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    '1851' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    '1852' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    '1853' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    '1854' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    '1855' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    '1856' => ['city' => 'Antipolo City', 'barangay' => 'Poblacion'],
    
    // Ilocos
    '2700' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2701' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2702' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2703' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2704' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2705' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2706' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    '2707' => ['city' => 'San Fernando City', 'barangay' => 'Poblacion'],
    
    // Pangasinan
    '2400' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    '2401' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    '2402' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    '2403' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    '2404' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    '2405' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    '2406' => ['city' => 'Dagupan City', 'barangay' => 'Poblacion'],
    
    // Iloilo
    '5000' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5001' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5002' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5003' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5004' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5005' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5006' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5007' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    '5008' => ['city' => 'Iloilo City', 'barangay' => 'Poblacion'],
    
    // Bacolod
    '6100' => ['city' => 'Bacolod City', 'barangay' => 'Poblacion'],
    '6101' => ['city' => 'Bacolod City', 'barangay' => 'Poblacion'],
    '6102' => ['city' => 'Bacolod City', 'barangay' => 'Poblacion'],
    '6103' => ['city' => 'Bacolod City', 'barangay' => 'Poblacion'],
    '6104' => ['city' => 'Bacolod City', 'barangay' => 'Poblacion'],
    '6105' => ['city' => 'Bacolod City', 'barangay' => 'Poblacion'],
    
    // Tacloban
    '6500' => ['city' => 'Tacloban City', 'barangay' => 'Poblacion'],
    '6501' => ['city' => 'Tacloban City', 'barangay' => 'Poblacion'],
    '6502' => ['city' => 'Tacloban City', 'barangay' => 'Poblacion'],
    '6503' => ['city' => 'Tacloban City', 'barangay' => 'Poblacion'],
    '6504' => ['city' => 'Tacloban City', 'barangay' => 'Poblacion'],
    
    // General Santos
    '9500' => ['city' => 'General Santos City', 'barangay' => 'Poblacion'],
    '9501' => ['city' => 'General Santos City', 'barangay' => 'Poblacion'],
    '9502' => ['city' => 'General Santos City', 'barangay' => 'Poblacion'],
    '9503' => ['city' => 'General Santos City', 'barangay' => 'Poblacion'],
    '9504' => ['city' => 'General Santos City', 'barangay' => 'Poblacion'],
    '9505' => ['city' => 'General Santos City', 'barangay' => 'Poblacion'],
    
    // Zamboanga
    '7000' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7001' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7002' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7003' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7004' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7005' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7006' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7007' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    '7008' => ['city' => 'Zamboanga City', 'barangay' => 'Poblacion'],
    
    // Baguio
    '2600' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2601' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2602' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2603' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2604' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2605' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2606' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2607' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2608' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    '2609' => ['city' => 'Baguio City', 'barangay' => 'Poblacion'],
    
    // Angeles
    '2009' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2010' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2011' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2012' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2013' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2014' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2015' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2016' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    '2017' => ['city' => 'Angeles City', 'barangay' => 'Poblacion'],
    
    // Olongapo
    '2200' => ['city' => 'Olongapo City', 'barangay' => 'Poblacion'],
    '2201' => ['city' => 'Olongapo City', 'barangay' => 'Poblacion'],
    '2202' => ['city' => 'Olongapo City', 'barangay' => 'Poblacion'],
    '2203' => ['city' => 'Olongapo City', 'barangay' => 'Poblacion'],
    '2204' => ['city' => 'Olongapo City', 'barangay' => 'Poblacion'],
    
    // Lucena
    '4300' => ['city' => 'Lucena City', 'barangay' => 'Poblacion'],
    '4301' => ['city' => 'Lucena City', 'barangay' => 'Poblacion'],
    '4302' => ['city' => 'Lucena City', 'barangay' => 'Poblacion'],
    '4303' => ['city' => 'Lucena City', 'barangay' => 'Poblacion'],
    '4304' => ['city' => 'Lucena City', 'barangay' => 'Poblacion'],
    '4305' => ['city' => 'Lucena City', 'barangay' => 'Poblacion'],
    
    // Naga
    '4400' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4401' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4402' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4403' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4404' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4405' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4406' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    '4407' => ['city' => 'Naga City', 'barangay' => 'Poblacion'],
    
    // Tuguegarao
    '3500' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3501' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3502' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3503' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3504' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3505' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3506' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3507' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    '3508' => ['city' => 'Tuguegarao City', 'barangay' => 'Poblacion'],
    
    // Butuan
    '8600' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8601' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8602' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8603' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8604' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8605' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8606' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    '8607' => ['city' => 'Butuan City', 'barangay' => 'Poblacion'],
    
    // Cotabato
    '9600' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9601' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9602' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9603' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9604' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9605' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9606' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    '9607' => ['city' => 'Cotabato City', 'barangay' => 'Poblacion'],
    
    // Puerto Princesa
    '5300' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5301' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5302' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5303' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5304' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5305' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5306' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5307' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
    '5308' => ['city' => 'Puerto Princesa City', 'barangay' => 'Poblacion'],
];

// Get postcode from request
$postcode = isset($_GET['postcode']) ? trim($_GET['postcode']) : '';

if (empty($postcode)) {
    echo json_encode([
        'success' => false,
        'message' => 'Postcode is required'
    ]);
    exit;
}

// Clean postcode (remove spaces, convert to uppercase)
$postcode = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $postcode));

// Lookup city and barangay in the map
if (isset($postcodeMap[$postcode])) {
    echo json_encode([
        'success' => true,
        'postcode' => $postcode,
        'city' => $postcodeMap[$postcode]['city'],
        'barangay' => $postcodeMap[$postcode]['barangay']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'City not found in our record, you need to add it manually'
    ]);
}

