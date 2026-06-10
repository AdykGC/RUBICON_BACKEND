@extends('Bitrix24.BitrixClientL1V1.layouts.app')

@section('content')

<div class="workflow-layout">

    <aside class="workflow-sidebar">

        <h3>События</h3>

        <div class="node-item">
            Лид создан
        </div>

        <div class="node-item">
            Сделка создана
        </div>

        <div class="node-item">
            Оплата получена
        </div>

        <h3>Действия</h3>

        <div class="node-item">
            Создать задачу
        </div>

        <div class="node-item">
            Отправить уведомление
        </div>

    </aside>

    <section class="workflow-canvas">

        <div class="node start">
            Лид создан
        </div>

        <div class="node action">
            Создать задачу
        </div>

    </section>

    <aside class="workflow-properties">

        <h3>Настройки блока</h3>

        <label>
            Название
        </label>

        <input
            type="text"
            value="Создать задачу"
        >

        <label>
            Ответственный
        </label>

        <select>
            <option>Менеджер</option>
        </select>

    </aside>

</div>

@endsection