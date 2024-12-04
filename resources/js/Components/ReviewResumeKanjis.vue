<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { CalendarClock, ChevronsRight } from "lucide-vue-next";
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
        <div
            v-for="kanji of kanjis"
            class="group flex h-[300px] w-60 flex-col rounded-md bg-card shadow-md hover:shadow-lg"
        >
            <Link :href="`/kanjis/${kanji.id}`">
                <h2
                    :class="[
                        {
                            'bg-gradient-to-br from-emerald-300 to-emerald-500 group-hover:via-emerald-300 group-hover:to-emerald-500':
                                kanji.answer,
                            'bg-gradient-to-br from-rose-300 to-rose-500 group-hover:via-rose-300 group-hover:to-rose-500':
                                !kanji.answer,
                        },
                        'w-full rounded-t-md p-5 text-center text-8xl text-dark',
                    ]"
                >
                    {{ kanji.literal }}
                </h2>
            </Link>
            <div
                class="flex h-full w-full flex-col justify-between gap-2 px-5 py-2"
            >
                <h3 class="text-3xl font-semibold first-letter:capitalize">
                    {{ kanji.significado }}
                </h3>
                <div class="flex flex-col gap-2">
                    <div class="flex">
                        <template
                            v-if="
                                kanji.oldLevel &&
                                kanji.oldLevel != kanji.newLevel
                            "
                        >
                            <div
                                :class="[
                                    'flex items-center justify-center gap-1 rounded-sm p-2 text-sm font-semibold text-light',
                                    kanji.oldLevel.bgColor,
                                ]"
                            >
                                <component
                                    :is="kanji.oldLevel.icon"
                                    :size="20"
                                />
                            </div>
                            <ChevronsRight class="mx-0.5 my-auto" />
                        </template>
                        <div
                            :class="[
                                'flex items-center justify-center gap-1 rounded-sm p-2 text-sm font-semibold text-light',
                                kanji.newLevel.bgColor,
                            ]"
                        >
                            <component :is="kanji.newLevel.icon" :size="20" />
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <CalendarClock />
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
