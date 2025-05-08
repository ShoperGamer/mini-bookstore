<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากแบบฟอร์ม
    $book_id = intval($_POST['book_id']);
    $reviewer_name = trim($_POST['reviewer_name']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    // เตรียม SQL เพื่อบันทึกรีวิว (ไม่ใส่ created_at เพราะมี default อยู่แล้ว)
    $sql = "INSERT INTO reviews (book_id, reviewer_name, rating, comment)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("เตรียมคำสั่ง SQL ผิดพลาด: " . $conn->error);
    }

    $stmt->bind_param("isis", $book_id, $reviewer_name, $rating, $comment);

    if ($stmt->execute()) {
        header("Location: book_detail.php?book_id=" . $book_id);
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกรีวิว: " . $stmt->error;
    }
}

// ส่วนของ GET สำหรับแสดงหนังสือ
if (!isset($_GET['book_id'])) {
    header("Location: book_list.php");
    exit();
}

$book_id = intval($_GET['book_id']);

$sql = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    header("Location: book_list.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รีวิวหนังสือ: <?php echo htmlspecialchars($book['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">รีวิวหนังสือ</h1>
                
                <div class="card mb-4">
                    <div class="card-body">
                      <?php if (!empty($book['image'])): ?>
                       <img src="uploads/<?php echo htmlspecialchars($book['image']); ?>" 
                         alt="ภาพปกหนังสือ" 
                          class="img-fluid rounded mb-3" 
                          style="max-height: 600px; object-fit: contain;">
                         <?php endif; ?>

                        <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                        <p class="card-text">โดย <?php echo htmlspecialchars($book['author']); ?></p>
                    </div>
                </div>
                
                <form action="review_book.php" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                    
                    <div class="mb-3">
                        <label for="reviewer_name" class="form-label">ชื่อผู้รีวิว</label>
                        <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">คะแนนรีวิว</label>
                        <div class="rating">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" id="star<?php echo $i; ?>" name="rating" 
                                value="<?php echo $i; ?>" required>
                                <label for="star<?php echo $i; ?>" 
                                class="rating-label"><i class="bi bi-star-fill"></i></label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="comment" class="form-label">ความคิดเห็น</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">ส่งรีวิว</button>
                    <a href="book_detail.php?book_id=
                    <?php echo $book_id; ?>" class="btn btn-secondary">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .rating input {
            display: none;
        }
        .rating-label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            margin-right: 5px;
        }
        .rating input:checked ~ .rating-label {
            color: #ffc107;
        }
    </style>
</body>
</html>

<?php
$conn->close();
?>

