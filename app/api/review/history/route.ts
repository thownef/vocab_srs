import { createClient } from "@/lib/supabase/server";
import { NextResponse } from "next/server";

// GET /api/review/history
export async function GET(request: Request) {
  const supabase = await createClient();
  const { searchParams } = new URL(request.url);
  const limit = parseInt(searchParams.get("limit") || "50");

  const { data, error } = await supabase
    .from("review_history")
    .select(
      `
      *,
      vocabulary (word, meaning)
    `
    )
    .order("reviewed_at", { ascending: false })
    .limit(limit);

  if (error) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }

  return NextResponse.json(data);
}
