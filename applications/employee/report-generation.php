<?php
include '../function/function.php';
// Import the FPDF library
require('fpdf185/fpdf.php');

// Set up a new FPDF object
$pdf = new FPDF();

$user = $_SESSION['user'];

// Connect to the database
$mysqli = connect();

// Prepare a statement to fetch data from the database
$stmt = $mysqli->prepare('SELECT employeeid,name,department,jobrole FROM employee WHERE username = ?');

// Bind the user ID parameter to the statement
$stmt->bind_param('s', $user);

// Execute the statement
$stmt->execute();

// Bind the result columns to variables
$stmt->bind_result($employeeid,$name,$department,$jobrole);

// Fetch the results
$stmt->fetch();

// Close the statement
$stmt->close();

// Close the database connection
$mysqli->close();

// Define the PDF content
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(7, 29, 112);
$current_date = date('F');
$pdf->Cell(0, 10, "Performance Result Report - Month $current_date", 1, 1, 'C', true); // Add cell with heading text

$pdf->Ln(10);

$pdf->SetFillColor(7, 29, 112); // Set fill color for the table

// Create the table
$pdf->SetTextColor(255, 255, 255); // Set text color for the table
$pdf->Cell(50, 10, 'Employee ID', 1, 0, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(50, 10, 'E0001', 1, 1, 'L', false);

$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, 10, 'Name', 1, 0, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(50, 10, 'Ethan', 1, 1, 'L', false);

$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, 10, 'Department', 1, 0, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(50, 10, 'Marketing', 1, 1, 'L', false);

$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, 10, 'Job Role', 1, 0, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(50, 10, 'Project Manager', 1, 1, 'L', false);

$pdf->SetFillColor(255, 255, 255); // Reset fill color
$pdf->SetTextColor(0, 0, 0); // Reset text color


// Set the content-type header to PDF
header('Content-Type: application/pdf');

// Set the content-disposition header to force a download
header('Content-Disposition: attachment;filename="example.pdf"');

// Output the PDF to the browser
$pdf->Output('Performance Result Report - ' . $current_date . '.pdf', 'D');
