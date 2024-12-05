<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Library, PencilLine, TrendingUp } from "lucide-vue-next";
import { Kanji } from "@/lib/types";
import { Badge } from "@/Components/ui/badge";

defineProps<{ kanjis: Kanji[] }>();
</script>

<template>
    <Link v-for="kanji of kanjis" :href="`/kanjis/${kanji.id}`">
        <div
            class="group flex h-60 w-56 flex-col rounded-md border bg-card shadow-md hover:shadow-lg xl:w-48"
        >
            <div
                class="bg-gradient-primary flex justify-center rounded-t-md p-4 group-hover:via-primary-light group-hover:to-primary"
            >
                <h2 class="text-8xl text-primary-foreground">
                    {{ kanji.literal }}
                </h2>
            </div>
            <div class="flex h-full flex-col justify-between px-4 py-2">
                <p
                    class="line-clamp-2 text-2xl font-semibold tracking-tight first-letter:capitalize"
                >
                    {{ kanji.significado }}
                </p>
                <Badge
                    variant="secondary"
                    class="flex w-full justify-evenly gap-1"
                >
                    <p>
                        <PencilLine class="inline h-5" />
                        {{ kanji.trazos }}
                    </p>
                    <p>
                        <Library class="inline h-5" />
                        {{ kanji.grado }}
                    </p>
                    <p v-if="kanji.frecuencia">
                        <TrendingUp class="inline h-5" />
                        {{ kanji.frecuencia }}
                    </p>
                </Badge>
            </div>
        </div>
    </Link>
</template>
