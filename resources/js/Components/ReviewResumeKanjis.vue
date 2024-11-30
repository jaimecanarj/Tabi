<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Clock, ChevronsRight } from "lucide-vue-next";
import { Kanji, KanjiLevel } from "@/lib/types";

defineProps<{
    kanjis: (Kanji & {
        oldLevel?: KanjiLevel;
        newLevel: KanjiLevel;
        date: string;
        answer: boolean;
    })[];
}>();
</script>

<template>
    <div class="mt-12 flex flex-wrap justify-center gap-4">
        <div v-for="kanji of kanjis" class="rounded-md bg-card shadow-md">
            <div class="flex w-60 flex-col">
                <Link :href="`/kanjis/${kanji.id}`">
                    <h2
                        :class="[
                            {
                                'bg-gradient-to-br from-emerald-200 to-emerald-500':
                                    kanji.answer,
                                'bg-gradient-to-br from-rose-200 to-rose-500':
                                    !kanji.answer,
                            },
                            'text-dark w-full rounded-t-md p-5 text-center text-8xl',
                        ]"
                    >
                        {{ kanji.literal }}
                    </h2>
                </Link>
                <div class="flex w-full flex-col gap-2 px-5 py-2">
                    <h3 class="text-3xl font-semibold capitalize">
                        {{ kanji.significado }}
                    </h3>
                    <div class="flex">
                        <template
                            v-if="
                                kanji.oldLevel &&
                                kanji.oldLevel != kanji.newLevel
                            "
                        >
                            <div
                                :class="[
                                    'text-light flex w-24 items-center justify-center gap-1 rounded-sm p-1 text-sm font-semibold',
                                    kanji.oldLevel.color,
                                ]"
                            >
                                <component
                                    :is="kanji.oldLevel.icon"
                                    :size="16"
                                />
                                {{ kanji.oldLevel.name }}
                            </div>
                            <ChevronsRight class="mx-0.5 my-auto" />
                        </template>
                        <div
                            :class="[
                                'text-light flex w-24 items-center justify-center gap-1 rounded-sm p-1 text-sm font-semibold',
                                kanji.newLevel.color,
                            ]"
                        >
                            <component :is="kanji.newLevel.icon" :size="16" />
                            {{ kanji.newLevel.name }}
                        </div>
                    </div>
                    <div class="flex items-center gap-1 text-sm">
                        <Clock />
                        <p>
                            Repaso
                            <span class="font-semibold">
                                {{ kanji.date }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
