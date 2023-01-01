<template>
    <div class="mb-3">
        <label class="form-label">{{ label }}</label>
            <slot></slot>
        <div class="form-text" v-if="help">{{ help }}</div>
    </div> 
</template>

<script>
    export default {
        props: [
            'label',
            'help',
            'helpType'
        ],
    }
</script>