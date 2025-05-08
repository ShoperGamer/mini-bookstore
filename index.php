<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบันทึกและรีวิวหนังสือ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">ระบบบันทึกและรีวิวหนังสือ</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">เมนูหลัก</h5>
                        <div class="d-grid gap-3">
                            <a href="add_book.php" class="btn btn-primary btn-lg">บันทึกข้อมูลหนังสือ</a>
                            <a href="book_list.php" class="btn btn-success btn-lg">แสดงรายการหนังสือ</a>
                            <a href="book_list.php?review=1" class="btn btn-warning btn-lg">ให้คะแนนรีวิวหนังสือ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>