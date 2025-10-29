"use client";

import { Card, Row, Col, Statistic, Typography, List, Empty } from "antd";
import { CheckCircleOutlined, TrophyOutlined } from "@ant-design/icons";
import { useQuery } from "@tanstack/react-query";
import type { DashboardStats } from "@/lib/types";

const { Title } = Typography;

async function fetchStats(): Promise<DashboardStats> {
  const res = await fetch("/api/stats");
  if (!res.ok) throw new Error("Failed to fetch");
  return res.json();
}

export default function StatisticsPage() {
  const { data: stats } = useQuery({
    queryKey: ["stats"],
    queryFn: fetchStats,
  });

  const levelLabels: Record<number, string> = {
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
      <Title level={2}>Thống kê</Title>

      {/* Overview Stats */}
      <Row gutter={16} style={{ marginBottom: 24 }}>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic title="Tổng số từ" value={stats?.total_words || 0} valueStyle={{ color: "#1677ff" }} />
          </Card>
        </Col>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic title="Cần ôn hôm nay" value={stats?.words_due_today || 0} valueStyle={{ color: "#ff4d4f" }} />
          </Card>
        </Col>
        <Col xs={24} sm={12} md={6}>
          <Card>
            <Statistic
              title="Đã hoàn thành"
              value={stats?.words_completed || 0}
              prefix={<TrophyOutlined />}
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
              valueStyle={{ color: "#faad14" }}
            />
          </Card>
        </Col>
      </Row>

      {/* Level Distribution */}
      <Card title="Phân bố theo cấp độ" style={{ marginBottom: 24 }}>
        {stats?.level_distribution && stats.level_distribution.length > 0 ? (
          <Row gutter={[16, 16]}>
            {stats.level_distribution
              .sort((a, b) => a.level - b.level)
              .map((item) => (
                <Col xs={24} sm={12} md={8} lg={6} key={item.level}>
                  <Card size="small" hoverable>
                    <Statistic title={levelLabels[item.level] || `Level ${item.level}`} value={item.count} valueStyle={{ fontSize: 24 }} />
                  </Card>
                </Col>
              ))}
          </Row>
        ) : (
          <Empty description="Chưa có dữ liệu" />
        )}
      </Card>

      {/* Tips */}
      <Card
        title={
          <span>
            <TrophyOutlined /> Mẹo học tập
          </span>
        }
      >
        <List
          dataSource={[
            "Ôn tập đều đặn mỗi ngày để duy trì tiến độ",
            "Nếu quên một từ, đừng lo lắng - hệ thống sẽ cho bạn ôn lại sau 1 giờ",
            "Khi đạt Level 8 và nhớ, từ đó sẽ được đánh dấu hoàn thành",
            "Tập trung vào nghĩa và cách dùng từ trong ngữ cảnh",
          ]}
          renderItem={(item) => (
            <List.Item>
              <CheckCircleOutlined style={{ color: "#52c41a", marginRight: 8 }} />
              {item}
            </List.Item>
          )}
        />
      </Card>
    </div>
  );
}
