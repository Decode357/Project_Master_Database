# Master Data Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Alpine.js-8BC34A?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/TailwindCSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
</p>

## 📖 About This Project

Master Data Management System เป็นระบบจัดการข้อมูลหลัก (Master Data) สำหรับองค์กร ที่พัฒนาด้วย Laravel Framework โดยมีจุดประสงค์เพื่อจัดการข้อมูลพื้นฐานต่างๆ เช่น ข้อมูลรูปทรง (Shape), สี (Color), ลูกค้า (Customer), และข้อมูลอื่นๆ ที่เกี่ยวข้อง

### ✨ Key Features

- 🎨 **Modern UI/UX** - ใช้ TailwindCSS และ Alpine.js สำหรับ Interactive UI
- 📊 **CRUD Operations** - ระบบจัดการข้อมูลแบบครบครัน (Create, Read, Update, Delete)
- 🔍 **Advanced Search & Filter** - ค้นหาและกรองข้อมูลได้อย่างรวดเร็ว
- ✅ **Real-time Validation** - ตรวจสอบข้อมูลแบบ Real-time ด้วย AJAX
- 📱 **Responsive Design** - รองรับการใช้งานบนทุกอุปกรณ์
- 🔐 **User Authentication & Authorization** - ระบบจัดการผู้ใช้และสิทธิ์การเข้าถึง
- 📈 **Data Relationships** - จัดการความสัมพันธ์ของข้อมูลแบบซับซ้อน

### 🛠️ Technology Stack

**Backend:**
- Laravel 11.x (PHP Framework)
- MySQL 8.0+ (Database)
- Eloquent ORM (Database Relationships)

**Frontend:**
- TailwindCSS (CSS Framework)
- Alpine.js (JavaScript Framework)
- Select2 (Enhanced Select Dropdowns)
- Blade Templates (Laravel Templating Engine)

**Additional Tools:**
- Laragon (Local Development Environment)
- Composer (PHP Package Manager)
- NPM/Node.js (Frontend Package Manager)

## 📋 Data Models

ระบบจัดการข้อมูลหลักต่างๆ ดังนี้:

### Core Models
- **Shape** - ข้อมูลรูปทรงสินค้า
- **Color** - ข้อมูลสีและการเคลือบ
- **Customer** - ข้อมูลลูกค้า
- **Department** - ข้อมูลแผนก
- **Designer** - ข้อมูลนักออกแบบ
- **Pattern** - ข้อมูลลวดลาย
- **Process** - ข้อมูลกระบวนการผลิต

### Supporting Models
- **ShapeType** - ประเภทรูปทรง
- **Status** - สถานะต่างๆ
- **ItemGroup** - กลุ่มสินค้า
- **Effect** - เอฟเฟกต์พิเศษ
- **Glaze** - ข้อมูลการเคลือบ

## 🚀 Installation

### Prerequisites
- PHP 8.2 หรือสูงกว่า
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
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

3. **Environment Configuration**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Setup**
```bash
# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=master_data_demo
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

5. **Build Assets**
```bash
# Development
npm run dev

# Production
npm run build
```

6. **Start Development Server**
```bash
php artisan serve
```

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

1. **การจัดการข้อมูล Shape**
   - เพิ่ม/แก้ไข/ลบข้อมูลรูปทรง
   - กำหนดประเภท สถานะ และข้อมูลเทคนิค
   - ผูกข้อมูลกับลูกค้า นักออกแบบ และแผนก

2. **ระบบ Validation**
   - ตรวจสอบข้อมูลแบบ Real-time
   - แสดงข้อผิดพลาดที่ชัดเจน
   - Modal จะไม่ปิดเมื่อมี validation errors

3. **การค้นหาและกรอง**
   - ค้นหาด้วย Item Code
   - กรองตามประเภท สถานะ หรือลูกค้า
   - รองรับ Pagination

## 🔧 Configuration

### Environment Variables

```env
# Application
APP_NAME="Master Data Demo"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=master_data_demo
DB_USERNAME=root
DB_PASSWORD=

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
```


## 👥 Team

- **Developer**: [Decode357](https://github.com/Decode357)
- **Project Type**: Master Data Management System
- **Framework**: Laravel 11.x

