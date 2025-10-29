"use client";

import { Layout, Menu } from "antd";
import { HomeOutlined, BookOutlined, ReadOutlined, BarChartOutlined } from "@ant-design/icons";
import Link from "next/link";
import { usePathname } from "next/navigation";
import type { MenuProps } from "antd";

const { Header, Content, Footer } = Layout;

export function MainLayout({ children }: { children: React.ReactNode }) {
  const pathname = usePathname();

  const menuItems: MenuProps["items"] = [
    {
      key: "/",
      icon: <HomeOutlined />,
      label: <Link href="/">Trang chủ</Link>,
    },
    {
      key: "/vocabulary",
      icon: <BookOutlined />,
      label: <Link href="/vocabulary">Từ vựng</Link>,
    },
    {
      key: "/review",
      icon: <ReadOutlined />,
      label: <Link href="/review">Ôn tập</Link>,
    },
  ];

  return (
    <Layout style={{ minHeight: "100vh" }}>
      <Header style={{ display: "flex", alignItems: "center", padding: "0 20px" }}>
        <div
          style={{
            color: "white",
            fontSize: "20px",
            fontWeight: "bold",
            marginRight: "40px",
          }}
        >
          Vocab SRS
        </div>
        <Menu theme="dark" mode="horizontal" selectedKeys={[pathname]} items={menuItems} style={{ flex: 1, minWidth: 0 }} />
      </Header>
      <Content style={{ padding: "24px 50px", background: "#fff" }}>
        <div style={{ minHeight: 380 }}>{children}</div>
      </Content>
      <Footer style={{ textAlign: "center" }}>Vocab SRS ©{new Date().getFullYear()} - Học từ vựng hiệu quả</Footer>
    </Layout>
  );
}
