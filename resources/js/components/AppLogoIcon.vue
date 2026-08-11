<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
defineOptions({ inheritAttrs: false });
defineProps<{ className?: HTMLAttributes['class'] }>();
</script>
<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 64 64"
        :class="className"
        v-bind="$attrs"
    >
        <path
            fill="currentColor"
            d="M10 9h44a6 6 0 0 1 6 6v28a6 6 0 0 1-6 6H37L25 58v-9H10a6 6 0 0 1-6-6V15a6 6 0 0 1 6-6Z"
        />
        <path
            fill="#fff"
            d="M17 20h12l3 5 3-5h12l-4 7a15 15 0 1 1-22 0l-4-7Zm8 8a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm14 0a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm-7 9-4 5h8l-4-5Z"
        />
    </svg>
</template>
