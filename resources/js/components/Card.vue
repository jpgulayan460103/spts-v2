<template>
    <div class="card">
        <div class="card-header" v-if="header">{{ header }}</div>

        <div class="card-body">
            <slot></slot>
        </div>
    </div> 
</template>

<script>
    export default {
        props: ["header"],
    }
</script>