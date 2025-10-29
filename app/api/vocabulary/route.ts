import { createClient } from "@/lib/supabase/server";
import { NextResponse } from "next/server";
import { getInitialReview } from "@/lib/srs/scheduler";

// GET /api/vocabulary - Lấy tất cả từ vựng
export async function GET() {
  const supabase = await createClient();

  const { data: vocabularies, error } = await supabase
    .from("vocabulary")
    .select(
      `
      *,
      learning_state (*)
    `
    )
    .order("created_at", { ascending: false });

  if (error) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }

  return NextResponse.json(vocabularies);
}

// POST /api/vocabulary - Thêm từ mới
export async function POST(request: Request) {
  const supabase = await createClient();
  const body = await request.json();

  const { word, meaning, pronunciation, example_sentence, image_url, audio_url } = body;

  if (!word || !meaning) {
    return NextResponse.json({ error: "Word and meaning are required" }, { status: 400 });
  }

  // 1. Tạo vocabulary
  const { data: vocabulary, error: vocabError } = await supabase
    .from("vocabulary")
    .insert({ word, meaning, pronunciation, example_sentence, image_url, audio_url })
    .select()
    .single();

  if (vocabError) {
    return NextResponse.json({ error: vocabError.message }, { status: 500 });
  }

  // 2. Tạo learning_state ban đầu
  const initialReview = getInitialReview();
  const { error: stateError } = await supabase.from("learning_state").insert({
    vocabulary_id: vocabulary.id,
    level: initialReview.newLevel,
    next_review_at: initialReview.nextReviewAt.toISOString(),
    in_recovery: initialReview.inRecovery,
    is_completed: initialReview.isCompleted,
  });

  if (stateError) {
    return NextResponse.json({ error: stateError.message }, { status: 500 });
  }

  return NextResponse.json(vocabulary, { status: 201 });
}
