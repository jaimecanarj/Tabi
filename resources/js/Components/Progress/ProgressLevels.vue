<script setup lang="ts">
import { Study, Kanji } from "@/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ kanjis: (Kanji & { studies: Study[] })[] }>();

const levels = [
    {
        ...kanjiLevels[0],
        kanjis: 0,
    },
    {
        ...kanjiLevels[1],
        kanjis: 0,
    },
    {
        ...kanjiLevels[2],
        kanjis: 0,
    },
    {
        ...kanjiLevels[3],
        kanjis: 0,
    },
    {
        ...kanjiLevels[4],
        kanjis: 0,
    },
    {
        ...kanjiLevels[5],
        kanjis: 0,
    },
];

props.kanjis.forEach((kanji) => {
    if (kanji.studies.length) {
        let result = levels.find(
            (level) => kanji.studies[0].time / 24 < level.threshold,
        );
        if (result) {
            result.kanjis++;
        }
    } else {
        levels[0].kanjis++;
    }
});
</script>

<template>
    <div
        class="grid grid-cols-2 text-light shadow-lg sm:grid-cols-3 lg:grid-cols-6"
    >
        <div
            v-for="level in levels"
            :key="level.name"
            :class="[
                level.bgColor,
                'flex h-40 min-w-36 grow flex-col items-center justify-center',
            ]"
        >
            <p class="text-4xl font-bold sm:text-5xl">{{ level.kanjis }}</p>
            <p>{{ level.name }}</p>
        </div>
    </div>
</template>
