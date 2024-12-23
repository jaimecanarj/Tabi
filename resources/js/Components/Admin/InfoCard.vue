<script setup lang="ts">
defineProps<{ item: number; kanjis: string; name: string; plural: string }>();
</script>

<template>
    <div
        class="bg-gradient-secondary relative flex h-36 w-full cursor-pointer justify-between rounded-md p-4 sm:h-32 md:h-auto lg:h-32"
    >
        <div
            class="flex w-full items-end gap-2 md:mt-12 md:flex-col md:items-center lg:mt-0 lg:flex-row lg:items-end"
        >
            <h2 class="text-7xl font-semibold">{{ item }}</h2>
            <p class="text-3xl first-letter:capitalize">
                {{ name }}{{ item > 1 ? plural : "" }}
            </p>
        </div>
        <h1 class="absolute right-4 text-4xl font-semibold">{{ kanjis }}</h1>
    </div>
</template>
