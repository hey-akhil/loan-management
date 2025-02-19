<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan EMI Calculator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/slider.css">
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
     <style>
        .dark-mode .table th{
            color: none;
        }
     </style>
</head>

<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php';
    include('day-night-toggler.php');
    ?>

<div id="content" class="content closed">
        <h2 class="">Loan EMI Calculator</h2>

    
            <div class="col-lg-6 col-md-8 col-sm-12">
                <form id="emiForm" class="p-4 shadow-sm bg-none rounded">
                    <div class="mb-3">
                        <label class="form-label">Loan Amount (₹)</label>
                        <input type="number" class="form-control" id="loanAmount" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Annual Interest Rate (%)</label>
                        <input type="number" class="form-control" id="interestRate" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loan Tenure (Years)</label>
                        <input type="number" class="form-control" id="loanTenure" required>
                    </div>

                    <!-- Buttons with proper spacing -->
                    <div class="d-grid gap-2 d-sm-flex">
                        <button type="button" class="btn btn-primary" onclick="calculateEMI()">Calculate EMI</button>
                        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </form>

                <!-- EMI Result Display -->
                <div class="result mt-4 p-3 bg-none shadow-sm rounded d-none" id="emiResultContainer">
                    <h5 class="text-center">EMI Breakdown</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Monthly EMI</th>
                                <td id="monthlyEMI"></td>
                            </tr>
                            <tr>
                                <th>Total Payable</th>
                                <td id="totalPayable"></td>
                            </tr>
                            <tr>
                                <th>Total Interest</th>
                                <td id="totalInterest"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        function calculateEMI() {
            let P = parseFloat(document.getElementById("loanAmount").value);
            let annualRate = parseFloat(document.getElementById("interestRate").value);
            let N = parseInt(document.getElementById("loanTenure").value) * 12;

            if (!P || !annualRate || !N) {
                alert("Please enter valid values.");
                return;
            }

            let R = (annualRate / 12) / 100;
            let emi = (P * R * Math.pow((1 + R), N)) / (Math.pow((1 + R), N) - 1);
            let totalPayable = emi * N;
            let totalInterest = totalPayable - P;

            document.getElementById("monthlyEMI").textContent = "₹" + emi.toFixed(2);
            document.getElementById("totalPayable").textContent = "₹" + totalPayable.toFixed(2);
            document.getElementById("totalInterest").textContent = "₹" + totalInterest.toFixed(2);

            document.getElementById("emiResultContainer").classList.remove("d-none");
        }
    </script>

</body>

</html>
