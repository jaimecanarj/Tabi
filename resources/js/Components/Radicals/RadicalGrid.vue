<script setup lang="ts">
import { Radical } from "@/lib/types";
import { Link } from "@inertiajs/vue3";
import { Pencil } from "lucide-vue-next";
import { Badge } from "@/Components/ui/badge";

defineProps<{ radicales: Radical[] }>();
</script>

<template>
    <Link v-for="radical of radicales" :href="`/radicales/${radical.id}`">
        <div
            class="flex border rounded-md shadow-md bg-card hover:bg-secondary w-72 h-36"
        >
            <div
                class="flex items-center justify-center w-1/3 p-4 rounded-l-md bg-primary"
            >
                <h2 class="text-6xl text-primary-foreground">
                    {{ radical.literal }}
                </h2>
            </div>
            <div class="flex flex-col justify-between px-4 py-2">
                <p
                    class="w-40 text-2xl font-semibold tracking-tight capitalize hyphens-auto line-clamp-2"
                    lang="es"
                >
                    {{ radical.significado }}
                </p>
                <div>
                    <Badge variant="secondary">
                        <Pencil class="inline" />
                        {{ radical.trazos }}
                    </Badge>
                </div>
            </div>
        </div>
    </Link>
</template>
