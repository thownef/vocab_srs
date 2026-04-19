import type { VocabularyWord, UserStats } from './types'

export const MOCK_WORDS: VocabularyWord[] = [
  {
    id: '1',
    word: 'Ephemeral',
    pronunciation: '/əˈfem(ə)rəl/',
    meaning: 'Lasting for a very short time.',
    example: 'The beauty of the sunset was ephemeral, fading into the night within minutes.',
    status: 'Mastered',
    createdAt: '2024-03-01T10:00:00Z',
    mastery: 92,
  },
  {
    id: '2',
    word: 'Serendipity',
    pronunciation: '/ˌserənˈdipədē/',
    meaning: 'The occurrence and development of events by chance in a happy or beneficial way.',
    example: 'Finding my favorite book at the thrift store was a moment of pure serendipity.',
    status: 'Learning',
    createdAt: '2024-03-15T14:30:00Z',
    mastery: 45,
  },
  {
    id: '3',
    word: 'Luminous',
    pronunciation: '/ˈlo͞omənəs/',
    meaning: 'Full of or shedding light; bright or shining, especially in the dark.',
    example: 'The moon cast a luminous glow over the calm lake.',
    status: 'Familiar',
    createdAt: '2024-03-10T09:15:00Z',
    mastery: 78,
  },
  {
    id: '4',
    word: 'Resilient',
    pronunciation: '/rəˈzilyənt/',
    meaning: 'Able to withstand or recover quickly from difficult conditions.',
    example: 'The community was resilient, rebuilding their homes after the storm.',
    status: 'Learning',
    createdAt: '2024-03-20T11:45:00Z',
    mastery: 30,
  },
  {
    id: '5',
    word: 'Eloquent',
    pronunciation: '/ˈeləkwənt/',
    meaning: 'Fluent or persuasive in speaking or writing.',
    example: 'The speaker delivered an eloquent address that inspired the entire audience.',
    status: 'Mastered',
    createdAt: '2024-02-28T16:20:00Z',
    mastery: 95,
  },
]

export const MOCK_STATS: UserStats = {
  streak: 12,
  totalWords: 156,
  accuracy: 88,
  dailyGoal: 10,
  dailyProgress: 6,
}
