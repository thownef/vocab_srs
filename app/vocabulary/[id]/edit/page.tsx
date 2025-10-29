"use client";

import { Form, Input, Button, Card, message, Typography, Spin } from "antd";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { useRouter } from "next/navigation";
import { useParams } from "next/navigation";
import { useEffect } from "react";
import type { Vocabulary } from "@/lib/types";

const { Title } = Typography;
const { TextArea } = Input;

async function fetchVocabulary(id: string): Promise<Vocabulary> {
  const res = await fetch(`/api/vocabulary/${id}`);
  if (!res.ok) throw new Error("Failed to fetch");
  return res.json();
}

async function updateVocabulary({ id, data }: { id: string; data: Vocabulary }) {
  const res = await fetch(`/api/vocabulary/${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error("Failed to update");
  return res.json();
}

export default function EditVocabularyPage() {
  const [form] = Form.useForm();
  const router = useRouter();
  const params = useParams();
  const queryClient = useQueryClient();
  const id = params.id as string;

  const { data: vocabulary, isLoading } = useQuery({
    queryKey: ["vocabulary", id],
    queryFn: () => fetchVocabulary(id),
  });

  const mutation = useMutation({
    mutationFn: updateVocabulary,
    onSuccess: () => {
      message.success("Đã cập nhật từ vựng!");
      queryClient.invalidateQueries({ queryKey: ["vocabularies"] });
      queryClient.invalidateQueries({ queryKey: ["vocabulary", id] });
      router.push("/vocabulary");
    },
    onError: () => {
      message.error("Không thể cập nhật từ vựng");
    },
  });

  useEffect(() => {
    if (vocabulary) {
      form.setFieldsValue({
        word: vocabulary.word,
        meaning: vocabulary.meaning,
        pronunciation: vocabulary.pronunciation,
        example_sentence: vocabulary.example_sentence,
        image_url: vocabulary.image_url,
        audio_url: vocabulary.audio_url,
      });
    }
  }, [vocabulary, form]);

  const onFinish = (values: Vocabulary) => {
    mutation.mutate({ id, data: values });
  };

  if (isLoading) {
    return (
      <div style={{ textAlign: "center", padding: "100px 0" }}>
        <Spin size="large" />
      </div>
    );
  }

  return (
    <div style={{ maxWidth: 800, margin: "0 auto" }}>
      <Title level={2}>Chỉnh sửa từ vựng</Title>
      <Card>
        <Form form={form} layout="vertical" onFinish={onFinish}>
          <Form.Item label="Từ vựng" name="word" rules={[{ required: true, message: "Vui lòng nhập từ vựng!" }]}>
            <Input size="large" placeholder="Nhập từ vựng" />
          </Form.Item>

          <Form.Item label="Nghĩa" name="meaning" rules={[{ required: true, message: "Vui lòng nhập nghĩa!" }]}>
            <Input size="large" placeholder="Nhập nghĩa tiếng Việt" />
          </Form.Item>

          <Form.Item label="Phát âm (IPA)" name="pronunciation">
            <Input size="large" placeholder="/prəˌnʌnsiˈeɪʃn/" />
          </Form.Item>

          <Form.Item label="Câu ví dụ" name="example_sentence">
            <TextArea rows={3} placeholder="Nhập câu ví dụ" />
          </Form.Item>

          <Form.Item label="URL hình ảnh" name="image_url">
            <Input placeholder="https://example.com/image.jpg" />
          </Form.Item>

          <Form.Item label="URL âm thanh" name="audio_url">
            <Input placeholder="https://example.com/audio.mp3" />
          </Form.Item>

          <Form.Item>
            <Button type="primary" htmlType="submit" size="large" loading={mutation.isPending}>
              Cập nhật
            </Button>
            <Button style={{ marginLeft: 8 }} onClick={() => router.back()}>
              Hủy
            </Button>
          </Form.Item>
        </Form>
      </Card>
    </div>
  );
}
