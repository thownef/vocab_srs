import { z } from "zod";
import { NextResponse } from "next/server";
import { APIError } from "@/lib/validation/exceptions";
import { HTTPStatus } from "@/core/enum/https.enum";

export async function validate<T extends z.ZodType>(
  request: Request,
  schema: T,
): Promise<{ success: true; data: z.infer<T> } | { success: false; response: NextResponse }> {
  try {
    const body = await request.json();
    const result = schema.safeParse(body);

    if (!result.success) {
      return {
        success: false,
        response: handleAPIError(new APIError("Validation failed", HTTPStatus.UNPROCESSABLE_ENTITY, formatZodErrors(result.error))),
      };
    }

    return { success: true, data: result.data };
  } catch {
    return {
      success: false,
      response: handleAPIError(new APIError("Invalid request body", HTTPStatus.BAD_REQUEST)),
    };
  }
}

export function formatZodErrors(error: z.ZodError): Record<string, string[]> {
  const flattened = z.flattenError(error);

  return flattened.fieldErrors;
}

export function handleAPIError(error: unknown): NextResponse {
  if (error instanceof APIError) {
    return NextResponse.json(
      {
        message: error.message,
        status: error.status,
        ...(error.errors && { errors: error.errors }),
      },
      { status: error.status },
    );
  }

  return NextResponse.json(
    { message: "Internal server error", status: HTTPStatus.INTERNAL_SERVER_ERROR },
    { status: HTTPStatus.INTERNAL_SERVER_ERROR },
  );
}
