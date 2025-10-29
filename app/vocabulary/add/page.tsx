"use client";

import { Form, Input, Button, Card, message, Typography } from "antd";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { useRouter } from "next/navigation";

const { Title } = Typography;
const { TextArea } = Input;

async function createVocabulary(data: any) {
  const res = await fetch("/api/vocabulary", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error("Failed to create");
  return res.json();
}

export default function AddVocabularyPage() {
  const [form] = Form.useForm();
  const router = useRouter();
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: createVocabulary,
    onSuccess: () => {
      message.success("Đã thêm từ vựng mới!");
      queryClient.invalidateQueries({ queryKey: ["vocabularies"] });
      queryClient.invalidateQueries({ queryKey: ["stats"] });
      router.push("/vocabulary");
    },
    onError: () => {
      message.error("Không thể thêm từ vựng");
    },
  });

  const onFinish = (values: any) => {
    mutation.mutate(values);
  };

  return (
    <div style={{ maxWidth: 800, margin: "0 auto" }}>
      <Title level={2}>Thêm từ vựng mới</Title>
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
              Thêm từ vựng
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
