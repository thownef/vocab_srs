export interface VocabularyWord {
  id: string
  word: string
  pronunciation: string
  meaning: string
  example: string
  status: 'Mastered' | 'Familiar' | 'Learning'
  createdAt: string
  mastery: number
}

export interface UserStats {
  streak: number
  totalWords: number
  accuracy: number
  dailyGoal: number
  dailyProgress: number
}
