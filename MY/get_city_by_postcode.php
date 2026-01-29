<?php
/**
 * Malaysia Postcode to City/State Lookup Endpoint
 * Returns city and state based on valid Malaysia postcode
 */

header('Content-Type: application/json');

// Malaysia postcodes mapped to cities and states
$postcodeMap = [
    // Kuala Lumpur
    '50000' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50100' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50200' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50300' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50400' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50500' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50600' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50700' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    '50800' => ['city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur'],
    
    // Putrajaya
    '62000' => ['city' => 'Putrajaya', 'state' => 'Wilayah Persekutuan Putrajaya'],
    '62100' => ['city' => 'Putrajaya', 'state' => 'Wilayah Persekutuan Putrajaya'],
    
    // Selangor - Shah Alam
    '40000' => ['city' => 'Shah Alam', 'state' => 'Selangor'],
    '40100' => ['city' => 'Shah Alam', 'state' => 'Selangor'],
    '40200' => ['city' => 'Shah Alam', 'state' => 'Selangor'],
    '40300' => ['city' => 'Shah Alam', 'state' => 'Selangor'],
    '40400' => ['city' => 'Shah Alam', 'state' => 'Selangor'],
    '40500' => ['city' => 'Shah Alam', 'state' => 'Selangor'],
    
    // Selangor - Klang
    '41000' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41100' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41200' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41300' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41400' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41500' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41600' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41700' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41800' => ['city' => 'Klang', 'state' => 'Selangor'],
    '41900' => ['city' => 'Klang', 'state' => 'Selangor'],
    
    // Selangor - Petaling Jaya
    '46000' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46100' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46200' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46300' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46400' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46500' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46600' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    '46700' => ['city' => 'Petaling Jaya', 'state' => 'Selangor'],
    
    // Johor - Johor Bahru
    '80000' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80100' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80200' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80300' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80400' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80500' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80600' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80700' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80800' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '80900' => ['city' => 'Johor Bahru', 'state' => 'Johor'],
    '81000' => ['city' => 'Kulai', 'state' => 'Johor'],
    '81100' => ['city' => 'Kulai', 'state' => 'Johor'],
    '81300' => ['city' => 'Skudai', 'state' => 'Johor'],
    '81400' => ['city' => 'Skudai', 'state' => 'Johor'],
    '81500' => ['city' => 'Pontian', 'state' => 'Johor'],
    '81700' => ['city' => 'Pasir Gudang', 'state' => 'Johor'],
    '81900' => ['city' => 'Kota Tinggi', 'state' => 'Johor'],
    '82000' => ['city' => 'Kota Tinggi', 'state' => 'Johor'],
    '82100' => ['city' => 'Muar', 'state' => 'Johor'],
    '82200' => ['city' => 'Muar', 'state' => 'Johor'],
    '82300' => ['city' => 'Batu Pahat', 'state' => 'Johor'],
    '82400' => ['city' => 'Batu Pahat', 'state' => 'Johor'],
    '83200' => ['city' => 'Segamat', 'state' => 'Johor'],
    '86000' => ['city' => 'Kluang', 'state' => 'Johor'],
    '86800' => ['city' => 'Mersing', 'state' => 'Johor'],
    
    // Penang - Georgetown
    '10000' => ['city' => 'Georgetown', 'state' => 'Penang'],
    '10100' => ['city' => 'Georgetown', 'state' => 'Penang'],
    '10200' => ['city' => 'Georgetown', 'state' => 'Penang'],
    '10300' => ['city' => 'Georgetown', 'state' => 'Penang'],
    '10400' => ['city' => 'Georgetown', 'state' => 'Penang'],
    '10500' => ['city' => 'Georgetown', 'state' => 'Penang'],
    '11000' => ['city' => 'Bukit Mertajam', 'state' => 'Penang'],
    '11100' => ['city' => 'Bukit Mertajam', 'state' => 'Penang'],
    '11200' => ['city' => 'Bukit Mertajam', 'state' => 'Penang'],
    '11300' => ['city' => 'Bukit Mertajam', 'state' => 'Penang'],
    '11400' => ['city' => 'Bayan Lepas', 'state' => 'Penang'],
    '11900' => ['city' => 'Bayan Lepas', 'state' => 'Penang'],
    '12000' => ['city' => 'Butterworth', 'state' => 'Penang'],
    '12100' => ['city' => 'Butterworth', 'state' => 'Penang'],
    '12200' => ['city' => 'Butterworth', 'state' => 'Penang'],
    '12400' => ['city' => 'Perai', 'state' => 'Penang'],
    
    // Kedah - Alor Setar
    '05000' => ['city' => 'Alor Setar', 'state' => 'Kedah'],
    '05100' => ['city' => 'Alor Setar', 'state' => 'Kedah'],
    '05200' => ['city' => 'Alor Setar', 'state' => 'Kedah'],
    '05300' => ['city' => 'Alor Setar', 'state' => 'Kedah'],
    '05400' => ['city' => 'Alor Setar', 'state' => 'Kedah'],
    '05500' => ['city' => 'Alor Setar', 'state' => 'Kedah'],
    '06000' => ['city' => 'Sungai Petani', 'state' => 'Kedah'],
    '06100' => ['city' => 'Sungai Petani', 'state' => 'Kedah'],
    '06200' => ['city' => 'Sungai Petani', 'state' => 'Kedah'],
    '06300' => ['city' => 'Sungai Petani', 'state' => 'Kedah'],
    '06400' => ['city' => 'Sungai Petani', 'state' => 'Kedah'],
    '06500' => ['city' => 'Sungai Petani', 'state' => 'Kedah'],
    '07000' => ['city' => 'Langkawi', 'state' => 'Kedah'],
    '07700' => ['city' => 'Langkawi', 'state' => 'Kedah'],
    
    // Perak - Ipoh
    '30000' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30100' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30200' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30300' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30400' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30500' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30600' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30700' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30800' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '30900' => ['city' => 'Ipoh', 'state' => 'Perak'],
    '31000' => ['city' => 'Batu Gajah', 'state' => 'Perak'],
    '31100' => ['city' => 'Batu Gajah', 'state' => 'Perak'],
    '32000' => ['city' => 'Sitiawan', 'state' => 'Perak'],
    '32100' => ['city' => 'Sitiawan', 'state' => 'Perak'],
    '32200' => ['city' => 'Lumut', 'state' => 'Perak'],
    '32300' => ['city' => 'Lumut', 'state' => 'Perak'],
    '32400' => ['city' => 'Parit Buntar', 'state' => 'Perak'],
    '32500' => ['city' => 'Parit Buntar', 'state' => 'Perak'],
    '32700' => ['city' => 'Kuala Kangsar', 'state' => 'Perak'],
    '32800' => ['city' => 'Kuala Kangsar', 'state' => 'Perak'],
    '33000' => ['city' => 'Taiping', 'state' => 'Perak'],
    '33100' => ['city' => 'Taiping', 'state' => 'Perak'],
    
    // Kelantan
    '15000' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15100' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15200' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15300' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15400' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15500' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15600' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15700' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15800' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '15900' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    '16000' => ['city' => 'Kota Bharu', 'state' => 'Kelantan'],
    
    // Terengganu
    '20000' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20100' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20200' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20300' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20400' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20500' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20600' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20700' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20800' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    '20900' => ['city' => 'Kuala Terengganu', 'state' => 'Terengganu'],
    
    // Pahang
    '25000' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25100' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25200' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25300' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25400' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25500' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25600' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25700' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25800' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '25900' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    '26000' => ['city' => 'Kuantan', 'state' => 'Pahang'],
    
    // Sabah
    '88000' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '88100' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '88200' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '88300' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '88400' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '88500' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '88600' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '89000' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '89100' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '89200' => ['city' => 'Kota Kinabalu', 'state' => 'Sabah'],
    '90000' => ['city' => 'Sandakan', 'state' => 'Sabah'],
    '90100' => ['city' => 'Sandakan', 'state' => 'Sabah'],
    '90200' => ['city' => 'Sandakan', 'state' => 'Sabah'],
    '90300' => ['city' => 'Sandakan', 'state' => 'Sabah'],
    '91000' => ['city' => 'Tawau', 'state' => 'Sabah'],
    '91100' => ['city' => 'Tawau', 'state' => 'Sabah'],
    '91200' => ['city' => 'Tawau', 'state' => 'Sabah'],
    '91300' => ['city' => 'Tawau', 'state' => 'Sabah'],
    '95000' => ['city' => 'Lahad Datu', 'state' => 'Sabah'],
    '95100' => ['city' => 'Lahad Datu', 'state' => 'Sabah'],
    '96000' => ['city' => 'Semporna', 'state' => 'Sabah'],
    '96100' => ['city' => 'Semporna', 'state' => 'Sabah'],
    
    // Sarawak
    '93000' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93100' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93200' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93300' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93400' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93500' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93600' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93700' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93800' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '93900' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94000' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94100' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94200' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94300' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94400' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94500' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94600' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94700' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94800' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '94900' => ['city' => 'Kuching', 'state' => 'Sarawak'],
    '95000' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95100' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95200' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95300' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95400' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95500' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95600' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95700' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95800' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '95900' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96000' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96100' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96200' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96300' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96400' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96500' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96600' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96700' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96800' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '96900' => ['city' => 'Samarahan', 'state' => 'Sarawak'],
    '97000' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97100' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97200' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97300' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97400' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97500' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97600' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97700' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97800' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '97900' => ['city' => 'Bintulu', 'state' => 'Sarawak'],
    '98000' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98100' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98200' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98300' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98400' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98500' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98600' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98700' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98800' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '98900' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '99000' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '99100' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '99200' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '99300' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '99400' => ['city' => 'Miri', 'state' => 'Sarawak'],
    '99500' => ['city' => 'Miri', 'state' => 'Sarawak'],
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

// Clean postcode (remove spaces)
$postcode = preg_replace('/[^0-9]/', '', $postcode);

// Lookup city and state in the map
if (isset($postcodeMap[$postcode])) {
    echo json_encode([
        'success' => true,
        'postcode' => $postcode,
        'city' => $postcodeMap[$postcode]['city'],
        'state' => $postcodeMap[$postcode]['state']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'City not found in our record, you need to add it manually'
    ]);
}

