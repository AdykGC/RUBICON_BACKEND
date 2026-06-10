@extends('Bitrix24.BitrixClientL1V1.layouts.app')

@section('content')

<div class="workflow-layout">

    <section
        id="drawflow"
        class="workflow-canvas">
    </section>

</div>

@endsection

@push('scripts')

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    const editor = new Drawflow(
        document.getElementById('drawflow')
    );

    editor.start();

    window.workflow.forEach(node => {

        editor.addNode(
            node.type,      // имя
            1,              // inputs
            1,              // outputs
            node.x,
            node.y,
            node.type,      // css class
            {
                id: node.id,
                name: node.name
            },
            `
                <div style="padding:10px;">
                    <strong>${node.name}</strong>
                </div>
            `
        );

    });

});

</script>

@endpush
