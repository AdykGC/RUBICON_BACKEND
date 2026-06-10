<template>
    <div class="workflow-layout">
        <WorkflowSidebar />
        <WorkflowCanvas />
        <WorkflowProperties />
    </div>
</template>


<script setup>
    import WorkflowSidebar from "./WorkflowSidebar.vue";
    import WorkflowCanvas from "./WorkflowCanvas.vue";
    import WorkflowProperties from "./WorkflowProperties.vue";
</script>
