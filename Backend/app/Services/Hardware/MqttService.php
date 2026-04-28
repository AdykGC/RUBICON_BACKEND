<?php namespace App\Services\Hardware;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\Transaction;
use App\Models\DeviceCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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



    // Cоздаём команду
    public function create_command($machine, $pulses, $amount){
        DB::beginTransaction();
        try{
            // 1. Запись пополнения
            $topUp = Transaction::create([
                'machine_id'     => $machine->id,
                'amount'         => $amount,
                'status'         => 'completed',
                'transaction_id' => 'KASPI_' . Str::uuid(),
            ]);
            // 2. Увеличиваем баланс автомата
            $machine->increment('balance', $amount);
            // 3 (опционально) записать продажу
            // Sale::create([...]);
            // 4. Формируем MQTT команду
            $command = DeviceCommand::create([
                'mac_address'  => $machine->mac_address,
                'command_id' => Str::uuid(),
                'action'     => 'water',
                'pulses'     => $pulses,
                'status'     => 'pending',
            ]);
            // 5. Отправляем через MQTT
            $macNoColons = str_replace(':', '', $machine->mac_address,);
            $topic = "device/{$macNoColons}";
            $this->publish($topic, [ 'command_id' => $command->command_id, 'action' => 'water', 'pulses' => $pulses, ]);
            // 6. отмечаем как sent
            $command->update(['status' => 'sent']);
            DB::commit();

            return response()->json([
                'status' => 'sent',
                'command_id' => $command->command_id,
                'pulses' => $pulses,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ошибка: ' . $e->getMessage()], 500);
        }
    }
}


    /*

    Общая схема
    Laravel (Service) → MQTT Broker (Mosquitto) → ESP32

    И обратно:
    ESP32 → MQTT → Laravel (optional ack / status)

*/