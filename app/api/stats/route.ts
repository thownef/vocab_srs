import { createClient } from "@/lib/supabase/server";
import { NextResponse } from "next/server";

// GET /api/stats
export async function GET() {
  const supabase = await createClient();

  // Total words
  const { count: totalWords } = await supabase.from("vocabulary").select("*", { count: "exact", head: true });

  // Words due today
  const { count: wordsDueToday } = await supabase
    .from("learning_state")
    .select("*", { count: "exact", head: true })
    .lte("next_review_at", new Date().toISOString())
    .eq("is_completed", false);

  // Words completed
  const { count: wordsCompleted } = await supabase
    .from("learning_state")
    .select("*", { count: "exact", head: true })
    .eq("is_completed", true);

  // Level distribution
  const { data: levelDist } = await supabase.from("learning_state").select("level").eq("is_completed", false);

  const levelDistribution =
    levelDist?.reduce((acc: { level: number; count: number }[], item) => {
      const existing = acc.find((x) => x.level === item.level);
      if (existing) {
        existing.count++;
      } else {
        acc.push({ level: item.level, count: 1 });
      }
      return acc;
    }, []) || [];

  return NextResponse.json({
    total_words: totalWords || 0,
    words_due_today: wordsDueToday || 0,
    words_completed: wordsCompleted || 0,
    level_distribution: levelDistribution,
  });
}
