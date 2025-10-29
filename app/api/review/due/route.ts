import { createClient } from "@/lib/supabase/server";
import { NextResponse } from "next/server";

export async function GET() {
  const supabase = await createClient();

  const { data, error } = await supabase
    .from("learning_state")
    .select(
      `
      *,
      vocabulary (*)
    `
    )
    .lte("next_review_at", new Date().toISOString())
    .eq("is_completed", false)
    .order("next_review_at", { ascending: true });

  if (error) {
    console.error("Error fetching due words:", error);
    return NextResponse.json({ error: error.message }, { status: 500 });
  }

  const transformed = data?.map((item) => {
    const vocab = Array.isArray(item.vocabulary) ? item.vocabulary[0] : item.vocabulary;
    return {
      ...vocab,
      learning_state: {
        id: item.id,
        vocabulary_id: item.vocabulary_id,
        level: item.level,
        next_review_at: item.next_review_at,
        in_recovery: item.in_recovery,
        is_completed: item.is_completed,
        created_at: item.created_at,
        updated_at: item.updated_at,
      },
    };
  });

  return NextResponse.json(transformed || []);
}
