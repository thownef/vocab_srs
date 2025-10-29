# 📚 Vocab SRS - Smart Vocabulary Learning

A vocabulary learning application with a customized **Spaced Repetition System (SRS)** to help you remember words longer and learn more effectively.

## ✨ Features

- 🎯 **Custom SRS Algorithm**: Optimized review schedule (1h → 8h → 1 day → 3 days → 14 days → 30 days → 60 days)
- 📝 **Vocabulary Management**: Add, edit, delete words with meaning, pronunciation, examples, images, and audio
- 🔄 **Recovery Mode**: Automatic adjustment when you forget words
- 📊 **Detailed Statistics**: Track your learning progress
- 🎨 **Modern UI**: Beautiful interface with Ant Design
- ⚡ **High Performance**: Next.js 15 + React Query + Supabase
- 🎵 **Cambridge Audio Integration**: Automatic audio URL handling from Cambridge Dictionary

## 🚀 Quick Start

### Prerequisites

- Node.js 18+
- npm/yarn/pnpm
- Supabase account (free tier available)

### Installation

1. **Clone the repository**

```bash
git clone <your-repo-url>
cd vocab-srs
```

2. **Install dependencies**

```bash
npm install
```

3. **Setup Supabase**

- Create a new project at [supabase.com](https://supabase.com)
- Copy your project URL and anon key from **Settings** → **API**
- Run the database migration (SQL provided in project documentation)

4. **Configure environment variables**

Create `.env.local`:

```env
NEXT_PUBLIC_SUPABASE_URL=https://your-project.supabase.co
NEXT_PUBLIC_SUPABASE_ANON_KEY=your-anon-key
```

5. **Start development server**

```bash
npm run dev
```

Open [http://localhost:3000](http://localhost:3000) in your browser.

## 📖 How to Use

### Adding New Words

1. Click "Add New Word" from the dashboard
2. Fill in word information (word, meaning, pronunciation, example, image, audio)
3. The system automatically schedules the first review after 1 hour

### Reviewing Words

1. Click "Start Review" when words are due
2. View the word → Click "Show Answer"
3. Rate yourself as "Remember" or "Forgot"
4. The system automatically calculates the next review time

### SRS Review Schedule

- **Level 1**: Review after 1 hour
- **Level 2**: Review after 8 hours
- **Level 3**: Review after 1 day
- **Level 4**: Review after 1 day (Round 2)
- **Level 5**: Review after 3 days
- **Level 6**: Review after 14 days
- **Level 7**: Review after 30 days
- **Level 8**: Review after 60 days
- **Completed**: No more reviews needed

**Recovery Mode**: When you forget a word at high levels, the system schedules 1-hour reviews until you remember, then returns you to Level 4.

## 🧪 Testing

```bash
# Run tests
npm test

# Test with UI
npm run test:ui

# Test coverage
npm run test:coverage
```

## 🎨 Code Quality

```bash
# Lint code
npm run lint

# Format code
npm run format

# Type check
npm run type-check
```

## 📦 Build & Deploy

### Production Build

```bash
npm run build
npm start
```

### Deploy to Vercel

[![Deploy with Vercel](https://vercel.com/button)](https://vercel.com/new)

1. Push code to GitHub
2. Import to Vercel
3. Add environment variables
4. Deploy!

## 🌟 Key Features Explained

### Custom SRS Algorithm

The application uses a scientifically-proven spaced repetition algorithm optimized for vocabulary learning. Words progress through 8 levels with increasing intervals.

### Recovery Mode

Forgot a word? Don't worry! The system automatically puts it in recovery mode, giving you frequent practice (every hour) until you remember it, then smoothly transitions back to the optimal schedule.

### Cambridge Dictionary Integration

Simply paste the audio path from Cambridge Dictionary (e.g., `/media/english/us_pron/...`), and the app automatically adds the domain for seamless audio playback.

### Single-User Focused

Designed for personal use without the complexity of multi-user authentication. Perfect for individual learners.

## 📝 Scripts

```bash
npm run dev          # Start development server
npm run build        # Build for production
npm start            # Start production server
npm run lint         # Lint code
npm run format       # Format code
npm test             # Run tests
npm run type-check   # TypeScript type checking
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

MIT

---

Made with ❤️ for language learners