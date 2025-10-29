"use client";

import { Card, Col, Row, Statistic, Button, Typography, Spin, Alert } from "antd";
import { BookOutlined, ReadOutlined, CheckCircleOutlined, TrophyOutlined } from "@ant-design/icons";
import { useQuery } from "@tanstack/react-query";
import Link from "next/link";
import { DashboardStats } from "@/lib/types";

const { Title } = Typography;

async function fetchStats(): Promise<DashboardStats> {
  const res = await fetch("/api/stats");
  if (!res.ok) throw new Error("Failed to fetch stats");
  return res.json();
}

async function fetchDueWords() {
  const res = await fetch("/api/review/due");
  if (!res.ok) throw new Error("Failed to fetch due words");
  return res.json();
}

export default function HomePage() {
  const {
    data: stats,
    isLoading: statsLoading,
    error: statsError,
  } = useQuery({
    queryKey: ["stats"],
    queryFn: fetchStats,
  });

  const { data: dueWords, isLoading: dueLoading } = useQuery({
    queryKey: ["due-words"],
    queryFn: fetchDueWords,
  });

  if (statsLoading || dueLoading) {
    return (
      <div style={{ textAlign: "center", padding: "100px 0" }}>
        <Spin size="large" />
      </div>
    );
  }

  if (statsError) {
    return <Alert message="Lỗi" description="Không thể tải dữ liệu" type="error" />;
  }

  const levelNames: Record<number, string> = {
    1: "Mới học (1h)",
    2: "Mới học (8h)",
    3: "Mới học (1 ngày)",
    4: "Lần 2 (1 ngày)",
    5: "Lần 3 (3 ngày)",
    6: "Lần 4 (14 ngày)",
    7: "Lần 5 (30 ngày)",
    8: "Lần 6 (60 ngày)",
  };

  return (
    <div>
      <Title level={2}>Trang chủ</Title>

      {/* Stats Cards */}
      <Row gutter={16} style={{ marginBottom: 24 }}>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic title="Tổng số từ" value={stats?.total_words || 0} prefix={<BookOutlined />} valueStyle={{ color: "#1677ff" }} />
          </Card>
        </Col>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic
              title="Cần ôn hôm nay"
              value={stats?.words_due_today || 0}
              prefix={<ReadOutlined />}
              valueStyle={{ color: "#ff4d4f" }}
            />
          </Card>
        </Col>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic
              title="Đã hoàn thành"
              value={stats?.words_completed || 0}
              prefix={<CheckCircleOutlined />}
              valueStyle={{ color: "#52c41a" }}
            />
          </Card>
        </Col>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic
              title="Tiến độ"
              value={stats?.total_words ? Math.round(((stats.words_completed || 0) / stats.total_words) * 100) : 0}
              suffix="%"
              prefix={<TrophyOutlined />}
              valueStyle={{ color: "#faad14" }}
            />
          </Card>
        </Col>
      </Row>

      {/* Quick Actions */}
      <Card title="Hành động nhanh" style={{ marginBottom: 24 }}>
        <Row gutter={16}>
          <Col>
            <Link href="/review">
              <Button type="primary" size="large" icon={<ReadOutlined />}>
                Bắt đầu ôn tập ({dueWords?.length || 0} từ)
              </Button>
            </Link>
          </Col>
          <Col>
            <Link href="/vocabulary/add">
              <Button size="large" icon={<BookOutlined />}>
                Thêm từ mới
              </Button>
            </Link>
          </Col>
        </Row>
      </Card>

      {/* Level Distribution */}
      <Card title="Phân bố theo cấp độ">
        <Row gutter={[16, 16]}>
          {stats?.level_distribution?.map((item) => (
            <Col xs={24} sm={12} md={8} lg={6} key={item.level}>
              <Card size="small">
                <Statistic title={levelNames[item.level] || `Level ${item.level}`} value={item.count} valueStyle={{ fontSize: "20px" }} />
              </Card>
            </Col>
          ))}
        </Row>
      </Card>
    </div>
  );
}
