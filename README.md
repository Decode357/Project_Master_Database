# Master Data Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Alpine.js-8BC34A?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/TailwindCSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/i18n-Multi--Language-4F8A10?style=for-the-badge&logo=google-translate&logoColor=white" alt="Multi-Language">
  <img src="https://img.shields.io/badge/Dark%20Mode-Enabled-22223B?style=for-the-badge&logo=darkreader&logoColor=white" alt="Dark Mode">
</p>

## 📖 About This Project

Master Data Management System เป็นระบบจัดการข้อมูลหลัก (Master Data) สำหรับองค์กร พัฒนาด้วย Laravel Framework เพื่อจัดการข้อมูลพื้นฐาน เช่น รูปทรง (Shape), สี (Color), ลูกค้า (Customer), และข้อมูลอื่นๆ ที่เกี่ยวข้อง  
**รองรับหลายภาษา (Multi-language)** และ **ธีม Dark Mode** เพื่อประสบการณ์ผู้ใช้ที่ดียิ่งขึ้น

### ✨ Key Features

- 🎨 **Modern UI/UX** - TailwindCSS + Alpine.js
- 🌗 **Dark Mode** - สลับธีมได้ทันที
- 🌐 **Multi-language** - รองรับภาษาไทย/อังกฤษ เปลี่ยนภาษาได้ทันที
- 📊 **CRUD Operations** - จัดการข้อมูลครบวงจร
- 🔍 **Advanced Search & Filter** - ค้นหาและกรองข้อมูล
- ✅ **Real-time Validation** - ตรวจสอบข้อมูลทันที
- 📱 **Responsive Design** - รองรับทุกอุปกรณ์
- 🔐 **User Authentication & Authorization** - ระบบผู้ใช้และสิทธิ์
- 📈 **Data Relationships** - จัดการข้อมูลสัมพันธ์

### 🛠️ Technology Stack

**Backend:**  
- Laravel 10.x  
- MySQL 8.0+  
- Eloquent ORM  

**Frontend:**  
- TailwindCSS  
- Alpine.js  
- Select2  
- Blade Templates  

**Additional:**  
- Laragon  
- Composer  
- NPM/Node.js  

## 🚀 Installation

### Prerequisites
- PHP 8.1.10+
- Composer
- Node.js & NPM
- MySQL 8.0+
- Laragon (แนะนำสำหรับ Windows)

### Setup Instructions

1. **Clone Repository**
    ```bash
    git clone https://github.com/Decode357/Project_Master_Database.git
    cd MasterDataDemo
    ```

2. **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3. **Environment Configuration**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database Setup**
    - ตั้งค่า DB ใน `.env`
    - รัน migration และ seed
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Build Assets**
    ```bash
    npm run dev   # สำหรับพัฒนา
    npm run build # สำหรับ production
    ```

6. **Start Development Server**
    ```bash
    php artisan serve
    ```

## 🌐 Multi-language & Dark Mode

### เปลี่ยนภาษา

- กดปุ่มเปลี่ยนภาษา (มุมขวาบน) เพื่อสลับระหว่างภาษาไทย/อังกฤษ
- ข้อความทุกส่วนในระบบจะเปลี่ยนตามภาษา
- เพิ่มไฟล์ภาษาใหม่ได้ที่ `resources/lang/{locale}/` และใช้ `__('...')` ใน Blade

### Dark Mode

- กดปุ่มสลับธีม (🌗) เพื่อเปลี่ยนระหว่างโหมดสว่าง/มืด
- ระบบจะจำค่าธีมที่เลือกไว้ (localStorage)
- สามารถปรับแต่งธีมได้ที่ `resources/css/app.css` และ Alpine.js ใน layout

## 📁 Project Structure

```
MasterDataDemo/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database Migrations
│   ├── seeders/            # Database Seeders
│   └── factories/          # Model Factories
├── resources/
│   ├── views/              # Blade Templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript Files
├── routes/
│   ├── web.php             # Web Routes
│   └── api.php             # API Routes
└── public/                 # Public Assets
```

## 🎯 Usage

### Basic Operations

- **Shape Management:** เพิ่ม/แก้ไข/ลบรูปทรง กำหนดประเภท สถานะ ผูกข้อมูลกับลูกค้าและนักออกแบบ
- **Validation:** ตรวจสอบข้อมูลแบบ Real-time แสดงข้อผิดพลาดทันที
- **Search & Filter:** ค้นหาด้วย Item Code กรองตามประเภท/สถานะ/ลูกค้า รองรับ Pagination

## 🔧 Configuration

### Environment Variables

```env
APP_NAME="Master Data Demo"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=master_data_demo
DB_USERNAME=root
DB_PASSWORD=
```

## 👥 Team

- **Developer**: [Decode357](https://github.com/Decode357)
- **Project Type**: Master Data Management System
- **Framework**: Laravel 10.x

---

> **อัปเดตล่าสุด:**  
> - รองรับ Multi-language (เปลี่ยนภาษาได้ทันที)
> - รองรับ Dark Mode (ธีมมืด/สว่าง)

