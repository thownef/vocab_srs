export class APIError extends Error {
  constructor(
    public message: string,
    public status: number,
    public errors?: Record<string, string[]>,
  ) {
    super(message);
    this.name = "APIError";
  }
}
