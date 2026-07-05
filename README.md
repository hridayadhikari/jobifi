# 💼 Jobifi - Laravel Job Portal

Jobifi is a full-stack Job Portal web application developed using Laravel. It connects job seekers with recruiters through a secure, role-based platform while providing administrators with complete control over the system.

---

## 📌 Features

### 👨‍💼 Admin
- Secure admin authentication
- Dashboard with platform overview
- Manage users
- Manage recruiters
- Manage job seekers
- Manage companies
- Manage job categories
- Monitor job postings
- Monitor job applications

### 🏢 Recruiter
- Recruiter registration & login
- Company profile management
- Create, edit and delete job posts
- View applicants
- Manage job listings

### 👨‍🎓 Job Seeker
- Registration & login
- Profile management
- Upload profile photo
- Browse jobs
- Search & filter jobs
- Save jobs
- Apply for jobs
- View application history

---

## 🛠 Tech Stack

### Backend
- Laravel 12
- PHP 8.3+
- PostgreSQL
- Laravel Breeze
- Blade Template Engine

### Frontend
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- AJAX
- jQuery

### Authentication
- Laravel Breeze
- Role-Based Authentication
- Middleware Authorization

---

## 📂 Project Structure

```
app/
├── Models
├── Http
│   ├── Controllers
│   ├── Middleware
resources/
├── views
│   ├── admin
│   ├── recruiter
│   ├── seeker
│   ├── layouts
routes/
database/
storage/
```

---

## 👥 User Roles

| Role | Description |
|------|-------------|
| Admin | Manages the entire platform |
| Recruiter | Posts jobs and manages applicants |
| Seeker | Searches and applies for jobs |

---

## 🔑 Authentication

- Login
- Registration
- Password Reset
- Email Verification (Optional)
- Role-based dashboard redirection
- Protected routes using middleware

---

## 📦 Database

Main Tables

- users
- recruiter_profiles
- seeker_profiles
- companies
- categories
- skills
- jobs
- applications
- saved_jobs
- job_skill

---

## 🚀 Installation

### Clone Repository

```bash
git clone https://github.com/yourusername/jobifi.git
```

### Navigate

```bash
cd jobifi
```

### Install Dependencies

```bash
composer install

npm install
```

### Configure Environment

```bash
cp .env.example .env
```

Update database credentials in `.env`

### Generate Key

```bash
php artisan key:generate
```

### Run Migrations

```bash
php artisan migrate --seed
```

### Link Storage

```bash
php artisan storage:link
```

### Start Server

```bash
php artisan serve
```

Compile frontend assets

```bash
npm run dev
```

---

## 📸 Screens

- Login
- Registration
- Admin Dashboard
- Recruiter Dashboard
- Seeker Dashboard
- Profile Page
- Job Listing
- Job Details
- Applications

---

## 📁 Current Modules

- ✅ Authentication
- ✅ Role Management
- ✅ Dashboard
- ✅ Profile Management
- ✅ Job Management
- ✅ Company Management
- ✅ Category Management
- ✅ Skill Management
- ✅ Applications
- ✅ Saved Jobs
- 🚧 Notifications
- 🚧 Email Services

---

## 🔒 Security

- CSRF Protection
- Password Hashing
- Middleware Authorization
- Input Validation
- Eloquent ORM
- Secure File Uploads

---

## 📈 Future Improvements

- Resume Builder
- AI Resume Analysis
- AI Job Recommendations
- Email Notifications
- Interview Scheduling
- Chat System
- Company Verification
- Analytics Dashboard
- REST API
- Mobile Application

---

## 👨‍💻 Developed By

**Hriday Adhikari**

B.Tech Computer Science & Engineering

Techno College of Engineering Agartala

---

## 📄 License

This project is developed for educational and internship purposes.

---

## ⭐ Acknowledgements

- Laravel
- Laravel Breeze
- Bootstrap
- PostgreSQL
- PHP Community