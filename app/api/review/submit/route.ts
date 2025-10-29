import { createClient } from "@/lib/supabase/server";
import { NextResponse } from "next/server";
import { calculateNextReview } from "@/lib/srs/scheduler";

// POST /api/review/submit
export async function POST(request: Request) {
  const supabase = await createClient();
  const body = await request.json();

  const { vocabulary_id, remembered } = body;

  if (!vocabulary_id || typeof remembered !== "boolean") {
    return NextResponse.json({ error: "vocabulary_id and remembered (boolean) are required" }, { status: 400 });
  }

  // 1. Lấy learning_state hiện tại
  const { data: currentState, error: fetchError } = await supabase
    .from("learning_state")
    .select("*")
    .eq("vocabulary_id", vocabulary_id)
    .single();

  if (fetchError || !currentState) {
    return NextResponse.json({ error: "Learning state not found" }, { status: 404 });
  }

  // 2. Tính toán next review
  const result = calculateNextReview(
    {
      level: currentState.level,
      inRecovery: currentState.in_recovery,
    },
    remembered
  );

  // 3. Update learning_state
  const { error: updateError } = await supabase
    .from("learning_state")
    .update({
      level: result.newLevel,
      next_review_at: result.nextReviewAt.toISOString(),
      in_recovery: result.inRecovery,
      is_completed: result.isCompleted,
    })
    .eq("vocabulary_id", vocabulary_id);

  if (updateError) {
    return NextResponse.json({ error: updateError.message }, { status: 500 });
  }

  // 4. Ghi lại history
  const { error: historyError } = await supabase.from("review_history").insert({
    vocabulary_id,
    level: currentState.level,
    remembered,
  });

  if (historyError) {
    console.error("Failed to save history:", historyError);
  }

  return NextResponse.json({ success: true, result });
}
