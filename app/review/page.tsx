"use client";

import { useState } from "react";
import { Card, Button, Typography, Empty, Space, Progress, Result } from "antd";
import { ReadOutlined, HomeOutlined } from "@ant-design/icons";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import ReviewCard from "@/components/review/ReviewCard";
import type { ReviewItem } from "@/lib/types";

const { Title, Text } = Typography;

async function fetchDueWords(): Promise<ReviewItem[]> {
  const res = await fetch("/api/review/due");
  if (!res.ok) throw new Error("Failed to fetch");
  return res.json();
}

async function submitReview(data: { vocabulary_id: string; remembered: boolean }) {
  const res = await fetch("/api/review/submit", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error("Failed to submit");
  return res.json();
}

export default function ReviewPage() {
  const queryClient = useQueryClient();
  const [currentIndex, setCurrentIndex] = useState(0);
  const [showAnswer, setShowAnswer] = useState(false);
  const [sessionStats, setSessionStats] = useState({ correct: 0, wrong: 0 });

  const { data: dueWords, isLoading } = useQuery({
    queryKey: ["due-words"],
    queryFn: fetchDueWords,
  });

  const submitMutation = useMutation({
    mutationFn: submitReview,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["due-words"] });
      queryClient.invalidateQueries({ queryKey: ["stats"] });
    },
  });

  if (isLoading) {
    return (
      <div style={{ textAlign: "center", padding: "100px 0" }}>
        <ReadOutlined style={{ fontSize: 48, color: "#1677ff" }} />
        <Title level={3}>Đang tải...</Title>
      </div>
    );
  }

  if (!dueWords || dueWords.length === 0) {
    return (
      <Result
        icon={<ReadOutlined style={{ color: "#52c41a" }} />}
        title="Tuyệt vời!"
        subTitle="Bạn đã hoàn thành hết bài ôn tập hôm nay!"
        extra={
          <Link href="/">
            <Button type="primary" icon={<HomeOutlined />}>
              Về trang chủ
            </Button>
          </Link>
        }
      />
    );
  }

  const currentWord = dueWords[currentIndex];
  const totalWords = dueWords.length;
  const progress = ((currentIndex + 1) / totalWords) * 100;

  const handleAnswer = async (remembered: boolean) => {
    // Update stats
    setSessionStats((prev) => ({
      correct: remembered ? prev.correct + 1 : prev.correct,
      wrong: remembered ? prev.wrong : prev.wrong + 1,
    }));

    // Submit to API
    await submitMutation.mutateAsync({
      vocabulary_id: currentWord.id,
      remembered,
    });

    // Move to next word or finish
    if (currentIndex < totalWords - 1) {
      setCurrentIndex((prev) => prev + 1);
      setShowAnswer(false);
    } else {
      // Session completed
      setCurrentIndex(totalWords); // Trigger completion state
    }
  };

  // Session completed
  if (currentIndex >= totalWords) {
    return (
      <Result
        status="success"
        title="Hoàn thành session ôn tập!"
        subTitle={
          <div>
            <p>Bạn đã ôn xong {totalWords} từ</p>
            <Space size="large" style={{ marginTop: 16 }}>
              <Text strong style={{ color: "#52c41a", fontSize: 18 }}>
                ✓ Nhớ: {sessionStats.correct}
              </Text>
              <Text strong style={{ color: "#ff4d4f", fontSize: 18 }}>
                ✗ Quên: {sessionStats.wrong}
              </Text>
            </Space>
          </div>
        }
        extra={[
          <Link href="/" key="home">
            <Button type="primary" icon={<HomeOutlined />}>
              Về trang chủ
            </Button>
          </Link>,
        ]}
      />
    );
  }

  return (
    <div style={{ maxWidth: 800, margin: "0 auto" }}>
      {/* Header */}
      <div style={{ marginBottom: 24 }}>
        <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: 16 }}>
          <Title level={2} style={{ margin: 0 }}>
            Ôn tập
          </Title>
          <Space>
            <Text strong style={{ color: "#52c41a" }}>
              ✓ {sessionStats.correct}
            </Text>
            <Text strong style={{ color: "#ff4d4f" }}>
              ✗ {sessionStats.wrong}
            </Text>
          </Space>
        </div>

        <div>
          <Text type="secondary">
            Từ {currentIndex + 1} / {totalWords}
          </Text>
          <Progress percent={Math.round(progress)} strokeColor="#1677ff" showInfo={false} style={{ marginTop: 8 }} />
        </div>
      </div>

      {/* Review Card */}
      <ReviewCard
        vocabulary={currentWord}
        showAnswer={showAnswer}
        onShowAnswer={() => setShowAnswer(true)}
        onAnswer={handleAnswer}
        isSubmitting={submitMutation.isPending}
      />
    </div>
  );
}
