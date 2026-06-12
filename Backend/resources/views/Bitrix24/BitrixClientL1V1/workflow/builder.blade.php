@extends('Bitrix24.BitrixClientL1V1.layouts.app')

@section('content')
    <div class="workflow-layout">
        <section id="drawflow" class="workflow-canvas"></section>
    </div>
@endsection

@push('scripts')
    <script>
        // здесь можно что-то доконфигурировать после загрузки всех модулей
        console.log('Workflow builder ready');
    </script>
@endpush