/**
 * Custom SRS Scheduler
 * Recovery: Quên → ôn 1h cho đến khi nhớ → quay về Lần 2 (Level 4)
 */

export interface ReviewResult {
  nextReviewAt: Date;
  newLevel: number;
  inRecovery: boolean;
  isCompleted: boolean;
}

export interface LearningState {
  level: number;
  inRecovery: boolean;
}

export function calculateNextReview(currentState: LearningState, remembered: boolean, currentTime: Date = new Date()): ReviewResult {
  const { level, inRecovery } = currentState;

  // ============ ĐANG RECOVERY ============
  if (inRecovery) {
    if (remembered) {
      // Nhớ → về Level 4 (Lần 2: ôn sau 1 ngày)
      return {
        nextReviewAt: addDays(currentTime, 1),
        newLevel: 4,
        inRecovery: false,
        isCompleted: false,
      };
    } else {
      // Vẫn quên → tiếp tục recovery, ôn sau 1h
      return {
        nextReviewAt: addHours(currentTime, 1),
        newLevel: level,
        inRecovery: true,
        isCompleted: false,
      };
    }
  }

  // ============ KHÔNG RECOVERY ============

  if (!remembered) {
    if (level === 1) {
      // Quên ở Level 1 → giữ Level 1, ôn sau 1h
      return {
        nextReviewAt: addHours(currentTime, 1),
        newLevel: 1,
        inRecovery: false,
        isCompleted: false,
      };
    } else {
      // Quên ở Level cao → vào recovery mode
      return {
        nextReviewAt: addHours(currentTime, 1),
        newLevel: level,
        inRecovery: true,
        isCompleted: false,
      };
    }
  }

  // NHỚ → Tăng level
  switch (level) {
    case 1:
      // Lần 1: 1h → nhớ → 8h
      return {
        nextReviewAt: addHours(currentTime, 8),
        newLevel: 2,
        inRecovery: false,
        isCompleted: false,
      };

    case 2:
      // Lần 1: 8h → nhớ → 1 ngày (vẫn trong Lần 1)
      return {
        nextReviewAt: addDays(currentTime, 1),
        newLevel: 3,
        inRecovery: false,
        isCompleted: false,
      };

    case 3:
      // Lần 1: 1 ngày → nhớ → Lần 2 (1 ngày)
      return {
        nextReviewAt: addDays(currentTime, 1),
        newLevel: 4,
        inRecovery: false,
        isCompleted: false,
      };

    case 4:
      // Lần 2: 1 ngày → nhớ → Lần 3 (3 ngày)
      return {
        nextReviewAt: addDays(currentTime, 3),
        newLevel: 5,
        inRecovery: false,
        isCompleted: false,
      };

    case 5:
      // Lần 3: 3 ngày → nhớ → Lần 4 (14 ngày) ✅ SỬA TỪ 7 THÀNH 14
      return {
        nextReviewAt: addDays(currentTime, 14),
        newLevel: 6,
        inRecovery: false,
        isCompleted: false,
      };

    case 6:
      // Lần 4: 14 ngày → nhớ → Lần 5 (30 ngày)
      return {
        nextReviewAt: addDays(currentTime, 30),
        newLevel: 7,
        inRecovery: false,
        isCompleted: false,
      };

    case 7:
      // Lần 5: 30 ngày → nhớ → Lần 6 (60 ngày)
      return {
        nextReviewAt: addDays(currentTime, 60),
        newLevel: 8,
        inRecovery: false,
        isCompleted: false,
      };

    case 8:
      // Lần 6: 60 ngày → nhớ → Hoàn thành
      return {
        nextReviewAt: addYears(currentTime, 10),
        newLevel: 8,
        inRecovery: false,
        isCompleted: true,
      };

    default:
      throw new Error(`Invalid level: ${level}`);
  }
}

export function getInitialReview(currentTime: Date = new Date()): ReviewResult {
  return {
    nextReviewAt: addHours(currentTime, 1),
    newLevel: 1,
    inRecovery: false,
    isCompleted: false,
  };
}

// Helper functions
function addHours(date: Date, hours: number): Date {
  const result = new Date(date);
  result.setHours(result.getHours() + hours);
  return result;
}

function addDays(date: Date, days: number): Date {
  const result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

function addYears(date: Date, years: number): Date {
  const result = new Date(date);
  result.setFullYear(result.getFullYear() + years);
  return result;
}
