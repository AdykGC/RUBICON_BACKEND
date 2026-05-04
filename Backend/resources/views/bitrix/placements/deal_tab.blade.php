{{-- Backend/resources/views/bitrix/deal_tab.blade.php --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Автоматы клиента</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; }
        th { background: #f5f5f5; text-align: left; }
        .muted { color: #777; }
    </style>
</head>
<body>
    <h3>Автоматы клиента</h3>

    <p class="muted">
        Сделка #{{ $deal['ID'] ?? '' }},
        контакт: {{ $contact['NAME'] ?? '' }} {{ $contact['LAST_NAME'] ?? '' }}
        ({{ $contact['EMAIL'][0]['VALUE'] ?? 'e-mail не указан' }})
    </p>

    @if ($machines->isEmpty())
        <p>Автоматы для этого клиента в системе не найдены.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Название</th>
                <th>Адрес</th>
                <th>Баланс</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($machines as $machine)
                <tr>
                    <td>{{ $machine->name }}</td>
                    <td>{{ $machine->location }}</td>
                    <td>{{ number_format($machine->balance, 2, '.', ' ') }}</td>
                    <td>{{ $machine->is_active ? 'Активен' : 'Выключен' }}</td>
                    <td>
                        <a href="{{ config('app.url') }}/machines/{{ $machine->id }}" target="_blank">
                            Открыть
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>