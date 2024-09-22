<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel File Upload with Sample Download</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f1f1f1;
        }
        .upload-container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
        }
        .upload-container h2 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #5a5a5a;
        }
        .upload-container .btn-info {
            font-size: 1.2em;
        }
        .form-group label {
            font-weight: bold;
            color: #5a5a5a;
        }
        .alert-info {
            background-color: #e9f5ff;
            border-color: #bee5eb;
            color: #0c5460;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="upload-container text-center">
                <h2><i class="fas fa-file-excel"></i> Upload Your Excel File</h2>
                <p class="text-muted">Please upload a valid .csv file for processing.</p>

                <!-- Download Sample File -->
                <a href="<?php echo base_url('public/uploads/sample.csv'); ?>" class="btn btn-info mb-4" download>
                    <i class="fas fa-file-download"></i> Download Sample File
                </a>
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-<?= session()->getFlashdata('alert-type') ?>">
                        <?= session()->getFlashdata('message') ?>
                    </div>
                <?php endif; ?>
                <!-- File Upload Form -->
                <form action="<?php echo base_url('file_upload'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group text-left">
                        <label>Check Duplicacy For:</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="check_email" name="check_option[]" value="email">
                            <label class="form-check-label" for="check_email">Email</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="check_phone" name="check_option[]" value="phone">
                            <label class="form-check-label" for="check_phone">Phone</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="check_both" name="check_option[]" value="both">
                            <label class="form-check-label" for="check_both">Both Email and Phone</label>
                        </div>
                    </div>
                    <div class="form-group text-left">
                        <label for="excelFile">Select Excel File</label>
                        <input type="file" class="form-control-file" id="excelFile" name="excelFile" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block btn-lg"><i class="fas fa-upload"></i> Upload Excel File</button>
                </form>

                <div class="alert alert-info mt-4">
                    <strong>Note:</strong> Please make sure your file is formatted correctly before uploading.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
