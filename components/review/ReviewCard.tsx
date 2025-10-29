'use client';

import { Card, Button, Space, Typography, Tag, Divider } from 'antd';
import { EyeOutlined, CheckOutlined, CloseOutlined, SoundOutlined } from '@ant-design/icons';
import type { ReviewItem } from '@/lib/types';
import { playAudio } from '@/lib/utils/audio';

const { Title, Text, Paragraph } = Typography;

interface ReviewCardProps {
  vocabulary: ReviewItem;
  showAnswer: boolean;
  onShowAnswer: () => void;
  onAnswer: (remembered: boolean) => void;
  isSubmitting: boolean;
}

export default function ReviewCard({
  vocabulary,
  showAnswer,
  onShowAnswer,
  onAnswer,
  isSubmitting,
}: ReviewCardProps) {
  const state = Array.isArray(vocabulary.learning_state)
    ? vocabulary.learning_state[0]
    : vocabulary.learning_state;

  const levelLabels: Record<number, string> = {
    1: 'Mới học (1h)',
    2: 'Mới học (8h)',
    3: 'Mới học (1 ngày)',
    4: 'Lần 2 (1 ngày)',
    5: 'Lần 3 (3 ngày)',
    6: 'Lần 4 (14 ngày)',
    7: 'Lần 5 (30 ngày)',
    8: 'Lần 6 (60 ngày)',
  };

  // ✅ Sử dụng helper function
  const handlePlayAudio = () => {
    playAudio(vocabulary.audio_url);
  };

  return (
    <Card
      style={{
        minHeight: 400,
        display: 'flex',
        flexDirection: 'column',
      }}
      bodyStyle={{ flex: 1, display: 'flex', flexDirection: 'column' }}
    >
      {/* Level Badge */}
      {state && (
        <div style={{ marginBottom: 16 }}>
          <Tag color={state.in_recovery ? 'red' : 'blue'}>
            {state.in_recovery ? 'Recovery Mode' : levelLabels[state.level] || `Level ${state.level}`}
          </Tag>
        </div>
      )}

      {/* Question - Always show word */}
      <div style={{ flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center' }}>
        <div style={{ textAlign: 'center', marginBottom: 24 }}>
          <Title level={1} style={{ fontSize: 48, marginBottom: 8 }}>
            {vocabulary.word}
          </Title>

          {vocabulary.pronunciation && (
            <Text type="secondary" style={{ fontSize: 18 }}>
              {vocabulary.pronunciation}
            </Text>
          )}

          {vocabulary.audio_url && (
            <div style={{ marginTop: 16 }}>
              <Button icon={<SoundOutlined />} onClick={handlePlayAudio}>
                Phát âm
              </Button>
            </div>
          )}
        </div>

        {/* Image */}
        {vocabulary.image_url && !showAnswer && (
          <div style={{ textAlign: 'center', marginBottom: 24 }}>
            <img
              src={vocabulary.image_url}
              alt={vocabulary.word}
              style={{ maxWidth: '100%', maxHeight: 200, borderRadius: 8 }}
            />
          </div>
        )}

        <Divider />

        {/* Answer section */}
        {showAnswer ? (
          <div style={{ marginTop: 24 }}>
            <div style={{ backgroundColor: '#f0f2f5', padding: 20, borderRadius: 8, marginBottom: 24 }}>
              <Title level={3} style={{ marginTop: 0 }}>
                {vocabulary.meaning}
              </Title>

              {vocabulary.example_sentence && (
                <Paragraph style={{ marginBottom: 0, fontSize: 16 }}>
                  <Text italic>"{vocabulary.example_sentence}"</Text>
                </Paragraph>
              )}

              {vocabulary.image_url && (
                <div style={{ marginTop: 16 }}>
                  <img
                    src={vocabulary.image_url}
                    alt={vocabulary.word}
                    style={{ maxWidth: '100%', maxHeight: 200, borderRadius: 8 }}
                  />
                </div>
              )}
            </div>

            <div style={{ textAlign: 'center' }}>
              <Text strong style={{ fontSize: 16, display: 'block', marginBottom: 16 }}>
                Bạn có nhớ từ này không?
              </Text>
              <Space size="large">
                <Button
                  size="large"
                  danger
                  icon={<CloseOutlined />}
                  onClick={() => onAnswer(false)}
                  loading={isSubmitting}
                  style={{ minWidth: 120 }}
                >
                  Quên
                </Button>
                <Button
                  size="large"
                  type="primary"
                  icon={<CheckOutlined />}
                  onClick={() => onAnswer(true)}
                  loading={isSubmitting}
                  style={{ minWidth: 120 }}
                >
                  Nhớ
                </Button>
              </Space>
            </div>
          </div>
        ) : (
          <div style={{ textAlign: 'center', marginTop: 24 }}>
            <Button
              size="large"
              type="primary"
              icon={<EyeOutlined />}
              onClick={onShowAnswer}
              style={{ minWidth: 150 }}
            >
              Hiện đáp án
            </Button>
          </div>
        )}
      </div>
    </Card>
  );
}