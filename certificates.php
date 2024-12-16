<?php
session_start();
require_once './config/conn.php'; 

// Check if employee_id is passed via POST
if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

   
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data is fetched
    if ($result->num_rows > 0) {
        // Fetch the employee data
        $row = $result->fetch_assoc();

        // Assign the employee data to variables
        $firstname = $row['first_name'];
        $middle = $row['middle_name'];
        $surname = $row['last_name'];
        $ex = $row['extension_name'];
    } else {
        echo "No employee found with the given ID.";
    }

   
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates</title>
    <!-- Admin LTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
</head>
<style>

      
        .certificate {
            
            padding: 40px;
            max-width: 800px;
            margin: auto;
            font-family: Arial, sans-serif;
            text-align: center;
            color: #000;
            
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
        }
        .sub-heading {
            font-size: 18px;
            margin: 20px 0;
        }
        .recipient-name {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            border-bottom: 1px solid #000;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .details {
            font-size: 16px;
            line-height: 1.6;
            margin: 20px 0;
        }
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            font-size: 16px;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 20px;
            padding-top: 5px;
        }
        
        .certificate1 {
            max-width: 800px;
            margin: auto;
            padding: 40px;
            border: 1px solid #000;
            font-family: Arial, sans-serif;
            text-align: center;
            color: #000;
        }
        .header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header1 img {
            width: 80px;
        }
        
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            text-decoration: underline;
        }
        .sub-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }
        .content {
            font-size: 16px;
            text-align: left;
            line-height: 1.6;
            margin: 20px 0;
        }
        .signatory {
            margin-top: 50px;
            text-align: right;
            font-size: 16px;
        }
        .signatory .name {
            font-weight: bold;
            margin-top: 50px;
            text-decoration: underline;
        }
        
        .document {
            max-width: 800px;
            margin: auto;
            padding: 40px;
            border: 1px solid #000;
            color: #000;
        }
        .header2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header2 img {
            width: 80px;
        }
        .title1 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            text-decoration: underline;
        }
        .date {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
        }
        .recipient-info {
            font-size: 16px;
            margin-top: 30px;
        }
        .content1 {
            font-size: 16px;
            margin-top: 20px;
            line-height: 1.6;
        }
        .salary-details {
            font-size: 16px;
            margin-top: 20px;
        }
        .salary-details ul {
            list-style-type: none;
            padding: 0;
        }
        .salary-details ul li {
            margin-bottom: 10px;
        }
        .signature1 {
            margin-top: 50px;
            text-align: left;
            font-size: 16px;
        }
        .signature1 .name {
            font-weight: bold;
            margin-top: 40px;
        }
        .footer {
            font-size: 12px;
            margin-top: 20px;
        }

        .container2 {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
            color: #000;
        }
        .header3, .footer {
            text-align: center;
        }
        .header3 h2, .header p {
            margin: 0;
        }
        .content2 {
            margin-top: 20px;
        }
        .content2 p {
            text-align: justify;
        }
        .table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;

        }
        .table th, .table td {
            padding: 8px 12px;
            border: 1px solid #000;
            text-align: right;
            color: #000;
        }
        .table th {
            text-align: left;
        }
        .signature2 {
            margin-top: 40px;
            text-align: right;
        }
        .signature2 p {
            margin: 5px 0;
        }
        .leave-table {
            width: 100%;
            margin: 20px 0;
            text-align: center;
        }
        .leave-table td {
            padding: 5px;
            font-weight: bold;
        }
            
	</style>
    
    <script>
    function printDiv(divId) {
        var divContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        
        document.body.innerHTML = divContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include './util/head.php'; ?>

    <!-- Sidebar -->
    <?php include './util/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
          <!-- Page Heading -->
          <div class="row">
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
			<div class="card-footer clearfix">
                <h1 class="h3 mb-4 text-gray-800">Certificates</h1>
                <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printableArea')"><i class='fas fa-print'></i></button>
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="printableArea">
                <div class="certificate">
                    <div class="header">
                        <img src="assets/img/SAGAY.png" alt="City Logo">
                        <img src="assets/img/logo1.jpg" alt="HR Logo">
                    </div>
            
                    <h1>CERTIFICATE OF COMPLETION</h1>
                    <p class="sub-heading">This is given to</p>
            
                    <div class="recipient-name"><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></div>
            
                    <p class="details">
                        for completing four (4) training hours of <br>
                        <strong>Lecture/Orientation on RA 6713 or the Code of Conduct and Ethical Standards<br>
                        for Public Officials and Employees and Leave Laws</strong>
                        <br><br>
                        conducted by the City Government of Sagay, <br>
                        Negros Occidental on September 13, 2023.
                    </p>
            
                    <p class="details">Given this 13th day of September, 2023.</p>
            
                    <div class="signatures">
                        <div class="signature">
                            <div class="signature-line">RENA A. DY</div>
                            HRMO IV
                        </div>
                        <div class="signature">
                            <div class="signature-line">ATTY. RYAN I. BONGHANOY</div>
                            City Administrator/EEMO
                        </div>
                        <div class="signature">
                            <div class="signature-line">NARCISO L. JAVELOSA, JR.</div>
                            City Mayor
                        </div>
                    </div>
                </div>
                
                
              </div>
            </div>
              <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert1')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert1">
                    <div class="certificate1">
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                                <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                OFFICE OF THE HUMAN RESOURCE & MANAGEMENT<br>
                                Cell No. 09171194285<br>
                                Email add: <em>www.hrmosagaycity@gmail.com</em></p>
                            </div>
                            <img src="assets/img/logo1.jpg" alt="HR Logo">
                        </div>
                
                        <h2 class="title">CERTIFICATION</h2>
                
                        <div class="content">
                            <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
                            <p>This is to certify that <strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong>, is employed in this City as Medical Technologist I assigned at Alfredo E. Marañon Sr. Memorial District Hospital, this City, from the period August 22, 2022 up to the present.</p>
                            <p>This certification is issued upon the request of the above-named person for whatever legal purpose it may serve her best.</p>
                            <p>Issued this <strong>9<sup>th</sup> day of July, 2024</strong> at the City of Sagay, Province of Negros Occidental, Philippines.</p>
                        </div>
                
                        <div class="signatory">
                            <p class="name">RENA A. DY</p>
                            SUPERVISING ADMINISTRATIVE OFFICER
                            <p>(HRMO-IV)</p>
                        </div>
                    </div>
                
                </div>
                
            </div>
            <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert2')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert2">
                    <div class="document">
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                              <center> <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                <strong>OFFICE OF THE CITY MAYOR</strong></p></center> 
                            </div>
                             <img src="assets/img/logo1.jpg" alt="City Logo">
                        </div>
                
                        <h2 class="title1">NOTICE OF SALARY ADJUSTMENT</h2>
                
                        <p class="date">February 23, 2023</p>
                
                        <div class="recipient-info">
                            <p><strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong><br>
                            Midwife III<br>
                            City Health Office</p>
                            <p>Madam:</p>
                        </div>
                
                        <div class="content1">
                            <p>Pursuant to Section 6.1 of Magna Carta of Public Health Workers (R.A 7305) Revised Implementing Rules and Regulations which provides, “<em>Three (3) months before compulsory retirement, the Public Health Worker shall be granted an automatic one salary grade increase in her basic salary and her retirement benefit thereafter shall be computed on the basis of her highest salary received and paid; provided that the Public Health Worker has reached retirement age and fulfilled the service requirement under the existing law</em>.”</p>
                
                            <p>Hence, your salary adjustment effective April 22, 2023 are as follows:</p>
                        </div>
                
                        <div class="salary-details">
                            <ul>
                                <li>1. Adjustment monthly basic salary effective April 22, 2023<br>
                                    Under the new Salary Schedule: S/G 14 Step 2 &mdash; ₱34,187.00</li>
                                <li>2. Actual monthly basic salary as of April 21, 2023 S/G 13 Step 2 &mdash; ₱31,633.00</li>
                                <li>3. Monthly salary adjustment effective April 22, 2023 &mdash; ₱2,544.00</li>
                            </ul>
                        </div>
                
                        <div class="content1">
                            <p>It is understood that this salary adjustment is subject for review and post audit, and appropriate re-adjustment and refund if found not in order.</p>
                        </div>
                
                        <div class="signature1">
                            <p>Very truly yours,</p>
                            <p class="name">NARCISO L. JAVELOSA, JR.</p>
                            <p>City Mayor</p>
                        </div>
                
                        <div class="footer">
                            <p>Cc:<br>
                            Office of the City Accountant<br>
                            AEMSMDH<br>
                            Office of the Human Resource<br>
                            file</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert3')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert3">
                    <div class="container2">
                        <!-- Header Section -->
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                              <center> <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                <strong>OFFICE OF THE HUMAN RESOURCE & MANAGEMENT</strong><br>
                                Cell No. 09171194285<br>
                                Email: hrmosagaycity@gmail.com
                            </p></center> 
                            </div>
                             <img src="assets/img/logo1.jpg" alt="City Logo">
                            </div>
                            <h2 style="margin-top: 20px; text-align: center;">CERTIFICATION</h2>
                        
                
                        <!-- Content Section -->
                        <div class="content2">
                            <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
                            <p>This is to certify that <strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong> is employed in this City, as Pharmacist III assigned in the Office of the City Health since July 16, 1998 up to the present and has the following annual income, to wit:</p>
                            
                            <!-- Income Table -->
                            <table class="table">
                                <tr>
                                    <th>Salary Per Annum</th>
                                    <td>₱604,584.00</td>
                                </tr>
                                <tr>
                                    <th>RATA</th>
                                    <td>24,000.00</td>
                                </tr>
                                <tr>
                                    <th>13<sup>th</sup> Month Bonus</th>
                                    <td>50,382.00</td>
                                </tr>
                                <tr>
                                    <th>Cash Gift Bonus</th>
                                    <td>5,000.00</td>
                                </tr>
                                <tr>
                                    <th>Clothing Allowance</th>
                                    <td>7,000.00</td>
                                </tr>
                                <tr>
                                    <th>Month Bonus</th>
                                    <td>50,382.00</td>
                                </tr>
                                <tr>
                                    <th>14<sup>th</sup> Month Bonus</th>
                                    <td>75,000.00</td>
                                </tr>
                                <tr>
                                    <th>Hazard & Subsistence</th>
                                    <td>169,146.00</td>
                                </tr>
                                <tr>
                                    <th>Laundry</th>
                                    <td>1,800.00</td>
                                </tr>
                                <tr>
                                    <th><strong>Total</strong></th>
                                    <td><strong>₱987,294.00</strong></td>
                                </tr>
                            </table>
                
                            <p>This <strong>certification</strong> is issued upon the request of the above-named person for whatever legal purpose it may serve her best.</p>
                            <p><strong>Issued</strong> this 25<sup>th</sup> day of June, 2024 at the City of Sagay, Province of Negros Occidental, Philippines.</p>
                        </div>
                
                        <!-- Signature Section -->
                        <div class="signature2">
                            <p><strong>RENA A. DY</strong></p>
                            <p>SUPERVISING ADMINISTRATIVE OFFICER</p>
                            <p>(HRMO-IV)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert4')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert4">
                    <div class="container2">
                        <!-- Header Section -->
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                              <center> <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                <strong>OFFICE OF THE HUMAN RESOURCE & MANAGEMENT</strong><br>
                                Cell No. 09171194285<br>
                                Email: hrmosagaycity@gmail.com
                            </p></center> 
                            </div>
                             <img src="assets/img/logo1.jpg" alt="City Logo">
                            </div>
                            <h2 style="margin-top: 20px; text-align: center;">CERTIFICATION</h2>
                        
                
                        <!-- Content Section -->
                        <div class="content2">
                            <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
        <p>This is to certify that according to the records kept on file with this office, <strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong> has not incurred any leave of absence without pay since his first day in the service as government employee dated July 2, 2018 up to his last day with the City Government of Sagay dated November 19, 2023.</p>
        <p>This Certification is issued upon the request of the above-named person for whatever legal purpose it may serve best.</p>
        <p>Issued this 5th day of January, 2024 at the City of Sagay, Province of Negros Occidental, Philippines.</p>
                        </div>
                
                        <!-- Signature Section -->
                        <div class="signature2">
                            <p><strong>RENA A. DY</strong><br>
                            SUPERVISING ADMINISTRATIVE OFFICER<br>
                            (HRMO-IV)</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert5')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert5">
                    <div class="container2">
                        <!-- Header Section -->
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                              <center> <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                <strong>OFFICE OF THE HUMAN RESOURCE & MANAGEMENT</strong></p></center> 
                            </div>
                             <img src="assets/img/logo1.jpg" alt="City Logo">
                            </div>
                            <h2 style="margin-top: 20px; text-align: center;">CERTIFICATION</h2>
                        
                
                        <!-- Content Section -->
                        <div class="content2">
                            
        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
        <p>This is to certify that as per record kept in this office, <strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong> has the following leave balance as of September, 2014 up to the present.</p>

        <table class="leave-table">
            <tr>
                <td>VACATION</td>
                <td> - </td>
                <td>101.746 days</td>
            </tr>
            <tr>
                <td>SICK</td>
                <td> - </td>
                <td>74.75 days</td>
            </tr>
            <tr>
                <td>TOTAL</td>
                <td> - </td>
                <td>176.496 days</td>
            </tr>
        </table>

        <p>This certification is issued to the above-named person for whatever legal purpose it may serve him best.</p>
        <p>Issued this 20th day of October, 2014 at Sagay City, Province of Negros Occidental, Philippines.</p>
                        </div>
                
                        <!-- Signature Section -->
                        <div class="signature2">
                            <p><strong>RENA A. DY</strong><br>
                            SUPERVISING ADMINISTRATIVE OFFICER<br>
                            (HRMO-IV)</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert6')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert6">
                    <div class="container2">
                        <!-- Header Section -->
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                                <center> <p>Republic of the Philippines<br>
                                    Province of Negros Occidental<br>
                                    <strong>City of Sagay</strong><br>
                                    <strong>OFFICE OF THE HUMAN RESOURCE & MANAGEMENT</strong><br>
                                    Cell No. 09171194285<br>
                                    Email: hrmosagaycity@gmail.com
                                </p></center> 
                            </div>
                             <img src="assets/img/logo1.jpg" alt="City Logo">
                            </div>
                            <h2 style="margin-top: 20px; text-align: center;">CERTIFICATION</h2>
                        
                
                        <!-- Content Section -->
                        <div class="content2">
                            
        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
        <p>This is to certify that <strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong>, tendered her last day of government service as Midwife I assigned at Alfredo E. Marañon Sr. Memorial District Hospital this City, on December 27, 2023.</p>
        <p>This certification is issued for whatever legal purpose it may serve best.</p>
        <p>Issued this 2nd day of July, 2024 at Sagay City, Negros Occidental, Philippines.</p>
                        </div>
                
                        <!-- Signature Section -->
                        <div class="signature2">
                            <p><strong>RENA A. DY</strong><br>
                            SUPERVISING ADMINISTRATIVE OFFICER<br>
                            (HRMO-IV)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-footer clearfix">
                    <button  style="float:right;" class='btn btn-primary' onclick="printDiv('printcert7')"><i class='fas fa-print'></i></button>
                  </div>
                <div class="card-body" id="printcert7">
                    <div class="container2">
                        <!-- Header Section -->
                        <div class="header1">
                            <img src="assets/img/SAGAY.png" alt="City Logo">
                            <div>
                                <center> <p>Republic of the Philippines<br>
                                    Province of Negros Occidental<br>
                                    <strong>City of Sagay</strong><br>
                                    <strong>OFFICE OF THE HUMAN RESOURCE & MANAGEMENT</strong><br>
                                </p></center> 
                            </div>
                             <img src="assets/img/logo1.jpg" alt="City Logo">
                            </div>
                            <p style="text-align: left"><strong>Date: August 25, 2022</strong></p>
                            <div class="title" style="text-align: center;">
                                CERTIFICATE OF EMPLOYMENT
                            </div>
                        
                
                        <!-- Content Section -->
                        <div class="content2">
                            
                            <p><strong>TO WHOM IT MAY CONCERN:</strong></p>

                            <p>This is to certify that, as appearing in the records of this office, <strong><?php echo $firstname ?> <?php echo $middle ?> <?php echo $surname ?> <?php echo $ex ?></strong>, with BP Number 07-0168918, is an employee of the City Government of Sagay, a Local Government Unit. He is holding the position of Revenue Collection Clerk II (SG 7) /8. As such, he receives an annual basic salary of P 223,593.00.</p>
                    
                            <p>Mr. Bismar has been employed since March 7, 2001. His length of service in the government is 21 years. Based on records, Mr. Bismar has premium payments for the last six (6) months.</p>
                    
                            <p>This certification is being issued upon the request of <strong>Mr. Bismar</strong> as a requirement for his application in the GSIS Scholarship Program for (AY 2022-2023).</p>
                        </div>
                
                        <!-- Signature Section -->
                        <div class="signature2">
                            <p><strong>RENA A. DY</strong><br>
                            SUPERVISING ADMINISTRATIVE OFFICER<br>
                            (HRMO-IV)</p>
                        </div>
                    </div>
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
            </div>
           
        </section>
    </div>

    <!-- Footer -->
    <?php include './util/footer.php'; ?>

</div>

<!-- JavaScript -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<script src="./assets/js/script.js"></script>
</body>
</html>
