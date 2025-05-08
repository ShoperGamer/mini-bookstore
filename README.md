# mini-bookstore


## English

This is my very first mini-project developed using PHP and XAMPP. I've also incorporated the Bootstrap 5 framework to enhance the user interface and make the website more visually appealing and user-friendly.

This project serves as a learning experience for backend development with PHP and database management with phpMyAdmin via XAMPP.

### Features

* **Add Books:** Users can add new books to the website, including details like title, author, etc.
* **View All Books:** Browse through a collection of all books currently available on the website.
* **Review Books:** Users can provide feedback on books by:
    * Giving a star rating.
    * Leaving written comments.

### Technologies Used

* **PHP:** Server-side scripting language.
* **XAMPP:** Local development environment (Apache, MySQL, PHP, Perl).
* **Bootstrap 5:** Front-end framework for styling and responsiveness.
* **MySQL/phpMyAdmin:** Database management.

### Setup and Installation

To run this project locally, follow these steps:

1.  **Ensure XAMPP is installed and running.** Make sure Apache and MySQL services are active.
2.  **Download or clone the project files.**
3.  **Extract the project files.**
4.  **Locate the `Database` folder** within the extracted project files.
5.  **Import the SQL file:**
    * Open phpMyAdmin (usually accessible via `http://localhost/phpmyadmin`).
    * Create a new database (you can name it whatever you like, e.g., `book_review_db`).
    * Select the newly created database.
    * Go to the "Import" tab.
    * Click on "Choose File" and select the `.sql` file located in the `Database` folder of this project.
    * Click "Go" to import the database structure and any initial data.
6.  **Place the project folder into your XAMPP `htdocs` directory.** (Usually found at `C:\xampp\htdocs\` on Windows or `/Applications/XAMPP/htdocs/` on macOS).
7.  **Update database connection (if necessary):** Open the PHP files that handle database connections (e.g., `config.php`, `db_connect.php`) and ensure the database name, username (usually "root" by default for XAMPP), and password (usually empty by default for XAMPP) match your XAMPP MySQL setup and the database name you created in step 5.
8.  **Access the project:** Open your web browser and navigate to `http://localhost/your_project_folder_name/`.

### How to Use

Once the project is set up:

* Navigate through the website to view existing books.
* Use the "Add Book" feature to contribute new books to the collection.
* Select a book to view its details and add your star rating and comments.

---

## ภาษาไทย (Thai)


นี่เป็นมินิโปรเจกต์แรกของผมที่ได้ลองใช้ภาษา PHP และ XAMPP  ในการพัฒนา โดยได้นำเฟรมเวิร์ก Bootstrap 5 เข้ามาช่วยในการออกแบบหน้าเว็บให้สวยงามและน่าใช้งานมากยิ่งขึ้น

โปรเจกต์นี้เป็นส่วนหนึ่งของการเรียนรู้การพัฒนาเว็บแอปพลิเคชันฝั่งเซิร์ฟเวอร์ด้วย PHP และการจัดการฐานข้อมูลด้วย phpMyAdmin ผ่าน XAMPP

### ฟีเจอร์หลัก

* **เพิ่มหนังสือ:** ผู้ใช้สามารถเพิ่มหนังสือเล่มใหม่เข้าสู่เว็บไซต์ได้ พร้อมระบุรายละเอียดต่างๆ เช่น ชื่อหนังสือ ผู้แต่ง เป็นต้น
* **ดูหนังสือทั้งหมด:** เรียกดูรายการหนังสือทั้งหมดที่มีอยู่ในระบบ
* **รีวิวหนังสือ:** ผู้ใช้สามารถแสดงความคิดเห็นต่อหนังสือแต่ละเล่มได้โดย:
    * การให้คะแนนเป็นดาว
    * การเขียนคอมเมนต์

### เทคโนโลยีที่ใช้

* **PHP:** ภาษาโปรแกรมฝั่งเซิร์ฟเวอร์
* **XAMPP:** โปรแกรมสำหรับจำลองเว็บเซิร์ฟเวอร์ (Apache, MySQL, PHP, Perl)
* **Bootstrap 5:** เฟรมเวิร์กสำหรับการพัฒนาส่วนติดต่อผู้ใช้ (Front-end)
* **MySQL/phpMyAdmin:** ระบบจัดการฐานข้อมูล

### การติดตั้งและตั้งค่า

หากต้องการรันโปรเจกต์นี้บนเครื่องของคุณ ให้ทำตามขั้นตอนต่อไปนี้:

1.  **ตรวจสอบว่าได้ติดตั้ง XAMPP และเปิดใช้งานแล้ว** (Apache และ MySQL service ต้องทำงานอยู่)
2.  **ดาวน์โหลดหรือ clone ไฟล์โปรเจกต์**
3.  **แตกไฟล์โปรเจกต์ที่ดาวน์โหลดมา**
4.  **ค้นหาโฟลเดอร์ `Database`** ที่อยู่ในไฟล์โปรเจกต์ที่แตกออกมา
5.  **นำเข้าไฟล์ SQL:**
    * เปิด phpMyAdmin (โดยทั่วไปเข้าผ่าน `http://localhost/phpmyadmin`)
    * สร้างฐานข้อมูลใหม่ (สามารถตั้งชื่อตามต้องการ เช่น `book_review_db`)
    * เลือกฐานข้อมูลที่เพิ่งสร้าง
    * ไปที่แท็บ "Import" (นำเข้า)
    * คลิก "Choose File" (เลือกไฟล์) และเลือกไฟล์ `.sql` ที่อยู่ในโฟลเดอร์ `Database` ของโปรเจกต์นี้
    * คลิก "Go" (ลงมือ) เพื่อนำเข้าโครงสร้างฐานข้อมูลและข้อมูลเริ่มต้น (ถ้ามี)
6.  **นำโฟลเดอร์โปรเจกต์ไปวางไว้ในไดเรกทอรี `htdocs` ของ XAMPP** (โดยทั่วไปจะอยู่ที่ `C:\xampp\htdocs\` สำหรับ Windows หรือ `/Applications/XAMPP/htdocs/` สำหรับ macOS)
7.  **อัปเดตการเชื่อมต่อฐานข้อมูล (หากจำเป็น):** เปิดไฟล์ PHP ที่จัดการการเชื่อมต่อฐานข้อมูล (เช่น `config.php`, `db_connect.php`) และตรวจสอบว่าชื่อฐานข้อมูล, ชื่อผู้ใช้ (ปกติคือ "root" สำหรับ XAMPP), และรหัสผ่าน (ปกติจะว่างเปล่าสำหรับ XAMPP) ตรงกับการตั้งค่า MySQL ของ XAMPP และชื่อฐานข้อมูลที่คุณสร้างในขั้นตอนที่ 5
8.  **เข้าถึงโปรเจกต์:** เปิดเว็บเบราว์เซอร์แล้วไปที่ `http://localhost/your_project_folder_name/` (แทน `your_project_folder_name` ด้วยชื่อโฟลเดอร์โปรเจกต์ของคุณ)

### วิธีการใช้งาน

เมื่อตั้งค่าโปรเจกต์เรียบร้อยแล้ว:

* เข้าชมเว็บไซต์เพื่อดูรายการหนังสือที่มีอยู่
* ใช้ฟีเจอร์ "เพิ่มหนังสือ" เพื่อเพิ่มหนังสือเล่มใหม่เข้าระบบ
* เลือกหนังสือที่ต้องการเพื่อดูรายละเอียดและเพิ่มคะแนนดาวพร้อมคอมเมนต์ของคุณ