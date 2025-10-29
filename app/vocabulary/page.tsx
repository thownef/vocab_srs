"use client";

import { Table, Button, Space, Typography, Popconfirm, message, Tag, Input } from "antd";
import { PlusOutlined, EditOutlined, DeleteOutlined } from "@ant-design/icons";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import { useState } from "react";
import type { VocabularyWithState } from "@/lib/types";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/vi";

dayjs.extend(relativeTime);
dayjs.locale("vi");

const { Title } = Typography;
const { Search } = Input;

async function fetchVocabularies(): Promise<VocabularyWithState[]> {
  const res = await fetch("/api/vocabulary");
  if (!res.ok) throw new Error("Failed to fetch vocabularies");
  return res.json();
}

async function deleteVocabulary(id: string) {
  const res = await fetch(`/api/vocabulary/${id}`, { method: "DELETE" });
  if (!res.ok) throw new Error("Failed to delete");
  return res.json();
}

export default function VocabularyPage() {
  const queryClient = useQueryClient();
  const [searchText, setSearchText] = useState("");

  const { data: vocabularies, isLoading } = useQuery({
    queryKey: ["vocabularies"],
    queryFn: fetchVocabularies,
  });

  const deleteMutation = useMutation({
    mutationFn: deleteVocabulary,
    onSuccess: () => {
      message.success("Đã xóa từ vựng");
      queryClient.invalidateQueries({ queryKey: ["vocabularies"] });
    },
    onError: () => {
      message.error("Không thể xóa từ vựng");
    },
  });

  const getLevelTag = (level: number, isCompleted: boolean) => {
    if (isCompleted) return <Tag color="green">Hoàn thành</Tag>;
    const colors = ["blue", "cyan", "geekblue", "purple", "magenta", "red", "volcano", "orange"];
    return <Tag color={colors[level - 1] || "default"}>Level {level}</Tag>;
  };

  const filteredData = vocabularies?.filter(
    (item) => item.word.toLowerCase().includes(searchText.toLowerCase()) || item.meaning.toLowerCase().includes(searchText.toLowerCase())
  );

  const columns = [
    {
      title: "Từ vựng",
      dataIndex: "word",
      key: "word",
      width: 200,
      render: (text: string, record: VocabularyWithState) => (
        <div>
          <div style={{ fontWeight: "bold", fontSize: "16px" }}>{text}</div>
          {record.pronunciation && <div style={{ color: "#666", fontSize: "12px" }}>{record.pronunciation}</div>}
        </div>
      ),
    },
    {
      title: "Nghĩa",
      dataIndex: "meaning",
      key: "meaning",
    },
    {
      title: "Ví dụ",
      dataIndex: "example_sentence",
      key: "example_sentence",
      ellipsis: true,
    },
    {
      title: "Cấp độ",
      key: "level",
      width: 130,
      render: (_: any, record: VocabularyWithState) => {
        const state = Array.isArray(record.learning_state) ? record.learning_state[0] : record.learning_state;
        return state ? getLevelTag(state.level, state.is_completed) : "-";
      },
    },
    {
      title: "Ôn tiếp theo",
      key: "next_review",
      width: 150,
      render: (_: any, record: VocabularyWithState) => {
        const state = Array.isArray(record.learning_state) ? record.learning_state[0] : record.learning_state;
        if (!state || state.is_completed) return "-";
        return dayjs(state.next_review_at).fromNow();
      },
    },
    {
      title: "Thao tác",
      key: "actions",
      width: 150,
      render: (_: any, record: VocabularyWithState) => (
        <Space>
          <Button type="link" icon={<EditOutlined />} href={`/vocabulary/${record.id}/edit`} size="small">
            Sửa
          </Button>
          <Popconfirm
            title="Xóa từ vựng?"
            description="Bạn có chắc muốn xóa từ này?"
            onConfirm={() => deleteMutation.mutate(record.id)}
            okText="Xóa"
            cancelText="Hủy"
          >
            <Button type="link" danger icon={<DeleteOutlined />} size="small">
              Xóa
            </Button>
          </Popconfirm>
        </Space>
      ),
    },
  ];

  return (
    <div>
      <div style={{ marginBottom: 16, display: "flex", justifyContent: "space-between" }}>
        <Title level={2}>Quản lý từ vựng</Title>
        <Link href="/vocabulary/add">
          <Button type="primary" icon={<PlusOutlined />}>
            Thêm từ mới
          </Button>
        </Link>
      </div>

      <Search
        placeholder="Tìm kiếm từ vựng..."
        allowClear
        size="large"
        style={{ marginBottom: 16 }}
        onChange={(e) => setSearchText(e.target.value)}
      />

      <Table columns={columns} dataSource={filteredData} rowKey="id" loading={isLoading} pagination={{ pageSize: 10 }} />
    </div>
  );
}
