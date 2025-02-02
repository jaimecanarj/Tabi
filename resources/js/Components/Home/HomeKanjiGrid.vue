<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import moment from "moment/moment";
import { Clock } from "lucide-vue-next";
import { Study, Kanji, KanjiLevel } from "@/types";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";

const props = defineProps<{
    studies: (Study & { kanji: Kanji; level: KanjiLevel })[];
    type: string;
}>();

let message: string;

switch (props.type) {
    case "wrong":
        message = "fallado";
        break;
    case "last":
        message = "estudiado";
        break;
}
</script>

<template>
    <section class="mt-10 rounded-xl bg-card p-6 shadow-md">
        <h2
            class="flex items-center gap-2 border-b-4 pb-2 text-3xl font-semibold"
        >
            <slot name="title" />
        </h2>
        <h2 v-if="!studies.length" class="pl-3 pt-5 text-2xl">
            Aún no has {{ message }} ningún kanji.
        </h2>
        <div
            v-else
            class="mt-4 grid max-h-40 grid-cols-[repeat(auto-fill,_minmax(56px,_1fr))] gap-2 overflow-hidden sm:h-28"
        >
            <HoverCard
                v-for="study in studies"
                :open-delay="500"
                :close-delay="200"
            >
                <HoverCardTrigger asChild>
                    <Link :href="`/kanjis/${study.kanji_id}`">
                        <div
                            class="bg-gradient-secondary w-14 rounded p-2 text-center text-2xl font-semibold shadow-sm hover:shadow-md"
                        >
                            {{ study.kanji.literal }}
                        </div>
                    </Link>
                </HoverCardTrigger>
                <HoverCardContent class="w-fit">
                    <div class="flex items-center justify-between gap-1">
                        <div
                            class="text-xl font-semibold first-letter:capitalize"
                        >
                            {{ study.kanji.meaning }}
                        </div>
                        <div
                            :class="[
                                'w-fit rounded-sm p-1 font-semibold text-light',
                                study.level.bgColor,
                            ]"
                        >
                            <component :is="study.level.icon" :size="20" />
                        </div>
                    </div>
                    <div class="mt-2 flex items-center gap-1">
                        <Clock :size="20" />
                        {{ moment(study.date).format("DD [de] MMM, YYYY") }}
                    </div>
                </HoverCardContent>
            </HoverCard>
        </div>
    </section>
</template>
