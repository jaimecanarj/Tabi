<script setup lang="ts">
import { Radical } from "@/lib/types";
import { Link } from "@inertiajs/vue3";
import { Hash, PencilLine } from "lucide-vue-next";
import { Badge } from "@/Components/ui/badge";

defineProps<{ radicales: (Radical & { kanjis_count: number })[] }>();
</script>

<template>
    <Link v-for="radical of radicales" :href="`/radicales/${radical.id}`">
        <div
            class="group flex h-60 w-56 flex-col rounded-md border bg-card shadow-md hover:shadow-lg xl:w-48"
        >
            <div
                class="bg-gradient-primary flex justify-center rounded-t-md p-4 group-hover:via-primary-light group-hover:to-primary"
            >
                <h2 class="text-8xl text-primary-foreground">
                    {{ radical.literal }}
                </h2>
            </div>
            <div class="flex h-full flex-col justify-between px-4 py-2">
                <p
                    class="line-clamp-2 text-2xl font-semibold tracking-tight first-letter:capitalize"
                >
                    {{ radical.significado }}
                </p>
                <Badge
                    variant="secondary"
                    class="flex w-full justify-evenly gap-1"
                >
                    <p>
                        <PencilLine class="inline h-5" />
                        {{ radical.trazos }}
                    </p>
                    <p>
                        <Hash class="inline h-5" />
                        {{ radical.kanjis_count }}
                    </p>
                </Badge>
            </div>
        </div>
    </Link>
</template>
