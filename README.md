# Smart Repeat - English Learning System with Spaced Repetition

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## 📖 Introduction

Smart Repeat is a web application designed to help users learn English effectively using the **Spaced Repetition** method. Built with Laravel framework, it features a beautiful and user-friendly interface for managing vocabulary learning.

## 🎯 Key Features
## �� Key Features

### 📝 Vocabulary Management
- **Add New Words**: Input vocabulary with meanings, pronunciation, and examples
- **Edit & Delete**: Modify or remove existing vocabulary entries
- **Search & Filter**: Find words by keyword or filter by part of speech
- **Progress Tracking**: Monitor review count and next review dates

### 🧠 Smart Review System
- **Automatic Scheduling**: Uses spaced repetition algorithm for optimal learning
- **Daily Reviews**: Shows words that need to be reviewed today
- **Remember/Forgot**: Mark words as remembered or forgotten to adjust learning cycle
- **Group Actions**: Mark multiple words at once for efficient review

### 🎨 Enhanced Learning Experience
- **Part of Speech**: Categorize words (noun, verb, adjective, etc.)
- **Pronunciation Guide**: Add IPA pronunciation for better learning
- **Rich Examples**: Include example sentences for context
- **Beautiful Interface**: Clean, modern design with intuitive navigation

### 🧠 Spaced Repetition Algorithm
The application uses a scientifically-proven review schedule:

**When learning a new word (Day 0) → you will review according to the following cycle:**

- **Review 1**: Same day (morning learn – evening review) - **Day 0**
- **Review 2**: After 1 day - **Day +1**
- **Review 3**: After 3 days - **Day +3**
- **Review 4**: After 7 days - **Day +7**
- **Review 5**: After 14 days - **Day +14**
- **Review 6**: After 30 days - **Day +30**
- **Review 7**: After 90 days - **Day +90**

**Forget Mechanism**: If you forget a word during any review, the system will reset the review cycle back to the current day, allowing you to start the learning process again from the beginning.

## 🚀 Installation & Setup

### System Requirements
- PHP >= 8.2
- Composer
- SQLite (or MySQL/PostgreSQL)

### Step 1: Clone the project
```bash
git clone <repository-url>
cd smart_repeat
```

### Step 2: Install dependencies
```bash
composer install
```

### Step 3: Environment configuration
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Create database and run migrations
```bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations
php artisan migrate
```

### Step 5: Start the server
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## 🔧 Technologies Used

- **Backend**: Laravel 12.x
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **Frontend**: Blade Templates + Tailwind CSS
- **Icons**: Font Awesome
- **PHP**: 8.2+

## 🤝 Contributing

We welcome contributions! Please:

1. Fork the project
2. Create a feature branch (`git checkout -b feat/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feat/AmazingFeature`)
5. Open a Pull Request

## Acknowledgments

- [Laravel](https://laravel.com) - Amazing framework
- [Tailwind CSS](https://tailwindcss.com) - CSS framework
- [Font Awesome](https://fontawesome.com) - Icons

---

**Smart Repeat** - Learn English intelligently with Spaced Repetition! 🧠📚
