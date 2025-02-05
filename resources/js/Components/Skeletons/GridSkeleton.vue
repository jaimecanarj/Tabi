<script setup lang="ts">
import { Skeleton } from "@/Components/ui/skeleton";
</script>

<template>
    <div
        class="grid grid-cols-1 justify-items-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6"
    >
        <div
            class="flex h-60 w-56 flex-col rounded-md border bg-card shadow-md hover:shadow-lg xl:w-48"
            v-for="i in 12"
        >
            <Skeleton
                class="bg-gradient-primary flex h-64 justify-center rounded-b-none rounded-t-md p-4 group-hover:via-primary-light group-hover:to-primary"
            />
            <div class="flex h-full flex-col justify-between px-4 py-2">
                <Skeleton class="mt-2 h-6 w-3/4" />
                <Skeleton class="mt-2 h-6 w-full" />
            </div>
        </div>
    </div>
</template>
