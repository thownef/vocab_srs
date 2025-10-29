/**
 * Get full audio URL from path
 * If path is already a full URL (starts with http), return as is
 * Otherwise, prepend Cambridge Dictionary domain
 */
export function getAudioUrl(path: string | null | undefined): string | null {
  if (!path) return null;

  // Nếu đã là URL đầy đủ, return luôn
  if (path.startsWith("http://") || path.startsWith("https://")) {
    return path;
  }

  // Thêm / ở đầu nếu chưa có
  const cleanPath = path.startsWith("/") ? path : `/${path}`;

  return `https://dictionary.cambridge.org${cleanPath}`;
}

/**
 * Play audio from Cambridge Dictionary or full URL
 */
export function playAudio(path: string | null | undefined): void {
  const audioUrl = getAudioUrl(path);
  if (!audioUrl) return;

  const audio = new Audio(audioUrl);
  audio.play().catch((error) => {
    console.error("Failed to play audio:", error);
  });
}
