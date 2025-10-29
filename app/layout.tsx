import type { Metadata } from 'next';
import { Geist } from 'next/font/google';
import { AntdRegistry } from '@ant-design/nextjs-registry';
import { ConfigProvider } from 'antd';
import { QueryClientProvider } from '@/components/providers/QueryClientProvider';
import { MainLayout } from '@/components/layouts/MainLayout';
import './globals.css';

const defaultUrl = process.env.VERCEL_URL
  ? `https://${process.env.VERCEL_URL}`
  : 'http://localhost:3000';

export const metadata: Metadata = {
  metadataBase: new URL(defaultUrl),
  title: 'Vocab SRS - Học từ vựng hiệu quả',
  description: 'Ứng dụng học từ vựng với Spaced Repetition System',
};

const geistSans = Geist({
  variable: '--font-geist-sans',
  display: 'swap',
  subsets: ['latin'],
});

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="vi" suppressHydrationWarning>
      <body className={`${geistSans.className} antialiased`}>
        <AntdRegistry>
          <ConfigProvider
            theme={{
              token: {
                colorPrimary: '#1677ff',
                borderRadius: 6,
              },
            }}
          >
            <QueryClientProvider>
              <MainLayout>{children}</MainLayout>
            </QueryClientProvider>
          </ConfigProvider>
        </AntdRegistry>
      </body>
    </html>
  );
}