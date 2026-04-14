<?php namespace App\Services\Hardware;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;


class MqttService {

    private function connect(): MqttClient {
        $server = config('services.mqtt.host');
        $port   = config('services.mqtt.port');
        $clientId = 'laravel-backend-' . uniqid();

        try {
            /*      Laravel временно подключился к MQTT серверу (broker)       */
            /*      MQTT broker — это просто “почтовый ящик сообщений”       */
            $client = new MqttClient($server, $port, $clientId);
            $settings = (new ConnectionSettings)
                ->setKeepAliveInterval(60)
                ->setLastWillTopic('backend/status')
                ->setLastWillMessage('offline')
                ->setLastWillQualityOfService(1);
            $client->connect($settings, true);
            return $client;
        } catch (\Throwable $e) {
            logger()->error('MQTT connect failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }


    public function publish(string $topic, array $payload, int $qos = 1): void {
        $client = $this->connect();

        try {
            /*      Laravel отправляет сообщение       */
            $client->publish(
                $topic,
                json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                $qos
            );
        } catch (\Throwable $e) {
            logger()->error('MQTT publish failed', [
                'error' => $e->getMessage(),
                'topic' => $topic,
                'payload' => $payload,
            ]);
        } finally {
            /*      Laravel отключается       */
            $client->disconnect();
        }
    }
}


    /*

    Общая схема
    Laravel (Service) → MQTT Broker (Mosquitto) → ESP32

    И обратно:
    ESP32 → MQTT → Laravel (optional ack / status)

*/