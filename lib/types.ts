export interface Vocabulary {
  id: string;
  word: string;
  meaning: string;
  pronunciation?: string;
  example_sentence?: string;
  image_url?: string;
  audio_url?: string;
  created_at: string;
  updated_at: string;
}

export interface LearningState {
  id: string;
  vocabulary_id: string;
  level: number;
  next_review_at: string;
  in_recovery: boolean;
  is_completed: boolean;
  created_at: string;
  updated_at: string;
}

export interface ReviewHistory {
  id: string;
  vocabulary_id: string;
  level: number;
  remembered: boolean;
  reviewed_at: string;
}

export interface VocabularyWithState extends Vocabulary {
  learning_state?: LearningState;
}

export interface ReviewItem extends VocabularyWithState {
  learning_state: LearningState;
}

export interface DashboardStats {
  total_words: number;
  words_due_today: number;
  words_completed: number;
  level_distribution: { level: number; count: number }[];
}
