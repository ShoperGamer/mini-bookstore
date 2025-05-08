<?php 
include 'config.php';

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

// ดึงรีวิว
$reviews_sql = "SELECT * FROM reviews WHERE book_id = ? ORDER BY created_at DESC";
$reviews_stmt = $conn->prepare($reviews_sql);
$reviews_stmt->bind_param("i", $book_id);
$reviews_stmt->execute();
$reviews_result = $reviews_stmt->get_result();

// คำนวณคะแนนเฉลี่ย
$avg_rating = 0;
$rating_sql = "SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id = ?";
$rating_stmt = $conn->prepare($rating_sql);
$rating_stmt->bind_param("i", $book_id);
$rating_stmt->execute();
$rating_result = $rating_stmt->get_result();

if ($rating_row = $rating_result->fetch_assoc()) {
    $avg_rating = round($rating_row['avg_rating'], 1);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดหนังสือ: <?php echo htmlspecialchars($book['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .rating-label:hover, .rating-label:hover ~ .rating-label {
            color: #ffc107 !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                    <?php if (!empty($book['image'])): ?>
    <img src="uploads/<?php echo htmlspecialchars($book['image']); ?>" 
         alt="ภาพปกหนังสือ" 
         class="img-fluid rounded mb-3" 
         style="max-height: 600px; object-fit: contain;">
<?php else: ?>
    <div class="text-muted mb-3">ไม่มีภาพปก</div>
<?php endif; ?>

                        <h2 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h2>
                        <p class="card-text"><strong>ผู้แต่ง:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                        <p class="card-text"><strong>หมวดหมู่:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
                        <p class="card-text"><strong>ราคา:</strong> <?php echo number_format($book['price'], 2); ?> บาท</p>
                        
                        <div class="mb-3">
                            <span class="text-warning">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $avg_rating) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } elseif ($i - 0.5 <= $avg_rating) {
                                        echo '<i class="bi bi-star-half"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                            </span>
                            <span> (<?php echo $avg_rating; ?> จาก 5 ดาว)</span>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="review_book.php?book_id=<?php echo $book_id; ?>" class="btn btn-warning">ให้คะแนนรีวิว</a>
                            <a href="book_list.php" class="btn btn-secondary">กลับสู่รายการหนังสือ</a>
                        </div>
                    </div>
                </div>
                
                <h3 class="mb-3">รีวิวหนังสือ</h3>
                
                <?php if ($reviews_result->num_rows > 0): ?>
                    <?php while($review = $reviews_result->fetch_assoc()): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title"><?php echo htmlspecialchars($review['reviewer_name']); ?></h5>
                                    <div class="text-warning">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $review['rating'] ? 
                                            '<i class="bi bi-star-fill"></i>' : 
                                            '<i class="bi bi-star"></i>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                                <p class="card-text text-muted"><small>โพสต์เมื่อ: <?php echo $review['created_at']; ?></small></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info">ยังไม่มีรีวิวสำหรับหนังสือเล่มนี้</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>