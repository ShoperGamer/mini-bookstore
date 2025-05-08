<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกหนังสือใหม่</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-image {
            max-width: 300px;
            max-height: 300px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">บันทึกหนังสือใหม่</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="add_book.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="image" class="form-label">ภาพปกหนังสือ</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewFile()">
                        <img id="imagePreview" class="preview-image img-thumbnail" alt="ภาพตัวอย่าง">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">ชื่อหนังสือ</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">ผู้แต่ง</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">หมวดหมู่</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">ราคา</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <a href="index.php" class="btn btn-secondary">กลับหน้าแรก</a>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // ตรวจสอบข้อมูลพื้นฐาน
                    $title = $_POST['title'] ?? '';
                    $author = $_POST['author'] ?? '';
                    $category = $_POST['category'] ?? '';
                    $price = $_POST['price'] ?? 0;
                    
                    if (empty($title) || empty($author) || empty($category) || empty($price)) {
                        echo "<div class='alert alert-danger mt-3'>กรุณากรอกข้อมูลให้ครบทุกช่อง</div>";
                        exit;
                    }
                    
                    // อัปโหลดไฟล์ภาพ
                    $imageName = null;
                    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                        $targetDir = "uploads/";
                        if (!is_dir($targetDir)) {
                            mkdir($targetDir, 0755, true);
                        }
                        
                        // ตรวจสอบประเภทไฟล์
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        $fileType = mime_content_type($_FILES['image']['tmp_name']);
                        
                        if (!in_array($fileType, $allowedTypes)) {
                            echo "<div class='alert alert-danger mt-3'>อนุญาตเฉพาะไฟล์ภาพ JPEG, PNG และ GIF เท่านั้น</div>";
                            exit;
                        }
                        
                        // สร้างชื่อไฟล์ใหม่
                        $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $imageName = uniqid() . '.' . strtolower($fileExt);
                        $targetFile = $targetDir . $imageName;
                        
                        // ย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย
                        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                            echo "<div class='alert alert-danger mt-3'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์</div>";
                            exit;
                        }
                    } else {
                        echo "<div class='alert alert-danger mt-3'>กรุณาเลือกไฟล์ภาพปกหนังสือ</div>";
                        exit;
                    }
                    
                    // บันทึกข้อมูลลงฐานข้อมูล
                    $stmt = $conn->prepare("INSERT INTO books (title, author, category, price, image) VALUES (?, ?, ?, ?, ?)");
                    
                    if (!$stmt) {
                        echo "<div class='alert alert-danger mt-3'>เตรียมคำสั่ง SQL ผิดพลาด: " . $conn->error . "</div>";
                        exit;
                    }
                    
                    $stmt->bind_param("ssdss", $title, $author, $category, $price, $imageName);
                    
                    if ($stmt->execute()) {
                        // แสดงภาพที่อัปโหลดพร้อมข้อมูลหนังสือ
                        echo "<div class='alert alert-success mt-3'>
                                <h4>✅ เพิ่มหนังสือเรียบร้อยแล้ว</h4>
                                <div class='row mt-3'>
                                    <div class='col-md-4'>
                                        <img src='uploads/$imageName' class='img-fluid rounded' alt='ภาพปกหนังสือ'>
                                    </div>
                                    <div class='col-md-8'>
                                        <p><strong>ชื่อหนังสือ:</strong> " . htmlspecialchars($title) . "</p>
                                        <p><strong>ผู้แต่ง:</strong> " . htmlspecialchars($author) . "</p>
                                        <p><strong>หมวดหมู่:</strong> " . htmlspecialchars($category) . "</p>
                                        <p><strong>ราคา:</strong> " . number_format($price, 2) . " บาท</p>
                                        <a href='book_list.php' class='btn btn-primary mt-2'>ดูรายการหนังสือ</a>
                                    </div>
                                </div>
                              </div>";
                    } else {
                        // ลบไฟล์ภาพถ้าบันทึกไม่สำเร็จ
                        if (file_exists($targetFile)) {
                            unlink($targetFile);
                        }
                        echo "<div class='alert alert-danger mt-3'>❌ เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
                    }
                    
                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ฟังก์ชันแสดงตัวอย่างภาพก่อนอัปโหลด
        function previewFile() {
            const preview = document.getElementById('imagePreview');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>