<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการหนังสือ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .card {
            height: 100%;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .rating {
            color: #ffc107;
        }
        .book-cover {
            height: 250px; 
            object-fit: cover;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        .book-cover img {
            max-height: 250px;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">รายการหนังสือ</h1>
        
        <?php if (isset($_GET['review'])): ?>
            <div class="alert alert-info">เลือกหนังสือที่ต้องการรีวิว</div>
        <?php endif; ?>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT b.*, AVG(r.rating) as avg_rating 
                    FROM books b
                    LEFT JOIN reviews r ON b.book_id = r.book_id
                    GROUP BY b.book_id
                    ORDER BY b.author ASC";
            
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($book = $result->fetch_assoc()) {
                    $avg_rating = round($book['avg_rating'] ?? 0, 1);
                    $link = isset($_GET['review']) ? "review_book.php?book_id=".$book['book_id'] : "book_detail.php?book_id=".$book['book_id'];
                    $image_path = !empty($book['image']) ? 'uploads/' . htmlspecialchars($book['image']) : '';
                    ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="book-cover">
                                <?php if (!empty($image_path) && file_exists($image_path)): ?>
                                    <img src="<?php echo $image_path; ?>" alt="ปกหนังสือ <?php echo htmlspecialchars($book['title']); ?>">
                                <?php else: ?>
                                    <i class="bi bi-book" style="font-size: 3rem;"></i>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                                <p class="card-text">โดย <?php echo htmlspecialchars($book['author']); ?></p>
                                <p class="card-text">หมวดหมู่: <?php echo htmlspecialchars($book['category']); ?></p>
                                <p class="card-text">ราคา: <?php echo number_format($book['price'], 2); ?> บาท</p>
                                
                                <div class="rating mb-3">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= floor($avg_rating)) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } elseif ($i - 0.5 <= $avg_rating) {
                                            echo '<i class="bi bi-star-half"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }
                                    }
                                    ?>
                                    <span class="text-muted">(<?php echo $avg_rating; ?>)</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?php echo $link; ?>" class="btn btn-<?php echo isset($_GET['review']) ? 'warning' : 'primary'; ?> btn-sm">
                                    <?php echo isset($_GET['review']) ? 'ให้คะแนนรีวิว' : 'ดูรายละเอียด'; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12"><div class="alert alert-info">ไม่พบข้อมูลหนังสือ</div></div>';
            }
            $conn->close();
            ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">กลับหน้าแรก</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>