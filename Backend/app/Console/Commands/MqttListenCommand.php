<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\DeviceCommand;

class MqttListenCommand extends Command
{
    protected $signature = 'mqtt:listen';

    public function handle()
    {
        $client = new MqttClient( config('services.mqtt.host'), config('services.mqtt.port'), 'laravel-listener');

        $client->connect();

        $client->subscribe('device/+/ack', function ($topic, $message) {

            $data = json_decode($message, true);

            $this->handleAck($data);

        }, 0);

        $client->loop(true);
    }

    private function handleAck($data)
    {
        if (!isset($data['command_id'])) return;

        DeviceCommand::where('command_id', $data['command_id'])
            ->update([
                'status' => $data['status'] ?? 'done'
            ]);

        logger()->info('ACK received', $data);
    }
}