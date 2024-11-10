<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { ChartLine, Pencil, School } from "lucide-vue-next";
import { Kanji } from "@/lib/types";
import { Badge } from "@/Components/ui/badge";

defineProps<{ kanjis: Kanji[] }>();
</script>

<template>
    <Link v-for="kanji of kanjis" :href="`/kanjis/${kanji.id}`">
        <div
            class="flex border rounded-md shadow-md bg-card hover:bg-secondary w-72 h-36"
        >
            <div class="flex items-center p-4 rounded-l-md bg-primary">
                <h2 class="text-6xl text-primary-foreground">
                    {{ kanji.literal }}
                </h2>
            </div>
            <div class="flex flex-col justify-between px-4 py-2">
                <p
                    class="w-40 text-2xl font-semibold tracking-tight capitalize hyphens-auto line-clamp-2"
                    lang="es"
                >
                    {{ kanji.significado }}
                </p>
                <div>
                    <Badge variant="secondary" class="space-x-1">
                        <p>
                            <Pencil class="inline h-5" />
                            {{ kanji.trazos }}
                        </p>
                        <p>
                            <School class="inline h-5" />
                            {{ kanji.grado }}
                        </p>
                        <p v-if="kanji.frecuencia">
                            <ChartLine class="inline h-5" />
                            {{ kanji.frecuencia }}
                        </p>
                    </Badge>
                </div>
            </div>
        </div>
    </Link>
</template>
