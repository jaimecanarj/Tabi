<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import moment from "moment";
import { Clock } from "lucide-vue-next";
import { Estudio, Kanji, KanjiLevel } from "@/lib/types";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";

defineProps<{ studys: (Estudio & { kanji: Kanji; level: KanjiLevel })[] }>();
</script>

<template>
    <section class="mt-10 rounded-xl bg-card p-6 shadow-md">
        <h2
            class="flex items-center gap-2 border-b-4 border-secondary pb-2 text-3xl font-semibold"
        >
            <slot name="title" />
        </h2>
        <div
            class="home-grid mt-4 grid max-h-40 gap-2 overflow-hidden sm:max-h-28"
        >
            <HoverCard
                v-for="study in studys"
                :open-delay="500"
                :close-delay="200"
            >
                <HoverCardTrigger asChild>
                    <Link :href="`/kanjis/${study.kanji_id}`">
                        <div
                            class="w-14 rounded bg-gradient-to-br from-secondary p-2 text-center text-2xl font-semibold shadow-sm hover:via-secondary hover:shadow-md"
                        >
                            {{ study.kanji.literal }}
                        </div>
                    </Link>
                </HoverCardTrigger>
                <HoverCardContent class="w-fit">
                    <div class="flex items-center justify-between gap-1">
                        <div class="text-xl font-semibold capitalize">
                            {{ study.kanji.significado }}
                        </div>
                        <div
                            :class="[
                                'w-fit rounded-sm p-1 font-semibold text-light',
                                study.level.color,
                            ]"
                        >
                            <component :is="study.level.icon" :size="20" />
                        </div>
                    </div>
                    <div class="mt-2 flex items-center gap-1">
                        <Clock :size="20" />
                        {{ moment(study.fecha).format("DD [de] MMM, YYYY") }}
                    </div>
                </HoverCardContent>
            </HoverCard>
        </div>
    </section>
</template>
