# Smart Repeat - English Learning System with Spaced Repetition

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

## 📖 Introduction

Smart Repeat is a web application designed to help users learn English effectively using the **Spaced Repetition** method. Built with Laravel framework, it features a beautiful and user-friendly interface for managing vocabulary learning.

## 🎯 Key Features

### 📝 Vocabulary Management
- **Add New Words**: Input vocabulary, meanings, examples, parts of speech, and pronunciation
- **Edit Words**: Modify existing vocabulary entries with full editing capabilities
- **Delete Words**: Remove words from your vocabulary list
- **Search Words**: Find words by keyword, meaning, or examples
- **Filter Words**: Filter by part of speech (noun, verb, adjective, etc.)
- **View All Words**: Complete list of learned words with detailed information
- **Progress Tracking**: Display review count and next review dates

### 🧠 Smart Review System
- **Automatic Scheduling**: Automatically schedules reviews using Spaced Repetition algorithm
- **Today's Reviews**: Shows words that need to be reviewed today
- **Completion Tracking**: Records completed reviews and schedules next sessions

### 🎨 Enhanced Word Information
- **Part of Speech**: Categorize words (noun, verb, adjective, etc.)
- **Pronunciation**: Add IPA pronunciation guides
- **Multiple Examples**: Both short examples and full sentences
- **Rich Display**: Beautiful presentation of all word information

### 🔍 Search & Filter Features
- **Smart Search**: Search across word, meaning, examples, and sentences
- **Part of Speech Filter**: Filter words by grammatical category
- **Real-time Results**: Instant search results with clear indicators
- **Easy Reset**: Quick way to clear filters and return to full list

### 🧠 Spaced Repetition Algorithm
The application uses a scientifically-proven review schedule:
- **Day 1**: Learn new word
- **Day 1 (evening)**: First review
- **Day 2**: Second review
- **Day 4**: Third review
- **Day 8**: Fourth review
- **Day 15**: Fifth review
- **Day 30**: Sixth review

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

## 🎯 How to Use

1. **Add New Words**: Visit the home page and enter new vocabulary with all details
2. **Search Words**: Use the search bar to find specific words or meanings
3. **Filter Words**: Use the dropdown to filter by part of speech
4. **Edit Words**: Click "Edit" on any word in the word list to modify information
5. **Delete Words**: Use the delete button in the edit page when needed
6. **Daily Reviews**: Go to "Today's Reviews" to see words that need review
7. **Mark Completion**: Click "Remembered" after completing a review
8. **Track Progress**: View "All Words" page to monitor your learning progress

## 🔧 Technologies Used

- **Backend**: Laravel 12.x
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **Frontend**: Blade Templates + Tailwind CSS
- **Icons**: Font Awesome
- **PHP**: 8.2+

## 📊 Database Schema

### `vocabulary_words` Table
- `id`: Primary key
- `word`: Vocabulary word
- `part_of_speech`: Part of speech (noun, verb, etc.)
- `pronunciation`: IPA pronunciation
- `meaning`: Word definition
- `example`: Example sentence or phrase
- `review_count`: Number of completed reviews
- `next_review_date`: Next review date
- `created_date`: Word creation date

### `review_schedules` Table
- `id`: Primary key
- `vocabulary_word_id`: Foreign key to vocabulary word
- `review_date`: Review date
- `review_round`: Review round number
- `is_completed`: Completion status

## 🆕 Recent Updates

### Version 2.1 - Search & Filter Features
- ✅ Added comprehensive search functionality
- ✅ Added part of speech filtering
- ✅ Enhanced user interface with search bar
- ✅ Real-time search results display
- ✅ Easy filter reset functionality

### Version 2.0 - Enhanced Word Management
- ✅ Added part of speech categorization
- ✅ Added pronunciation field (IPA)
- ✅ Added full example sentences
- ✅ Added word editing functionality
- ✅ Added word deletion capability
- ✅ Improved user interface with better spacing
- ✅ Enhanced word display in all views

## 🤝 Contributing

We welcome contributions! Please:

1. Fork the project
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the `LICENSE` file for details.

## Acknowledgments

- [Laravel](https://laravel.com) - Amazing framework
- [Tailwind CSS](https://tailwindcss.com) - CSS framework
- [Font Awesome](https://fontawesome.com) - Icons

---

**Smart Repeat** - Learn English intelligently with Spaced Repetition! 🧠📚
