<script setup lang="ts">
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

const props = defineProps<{ kanjis: (Kanji & { estudios: Estudio[] })[] }>();

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
    if (kanji.estudios.length) {
        let result = levels.find(
            (level) => kanji.estudios[0].tiempo / 24 < level.threshold,
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
        class="text-light grid grid-cols-2 shadow-lg sm:grid-cols-3 lg:grid-cols-6"
    >
        <div
            v-for="level in levels"
            :key="level.name"
            :class="[
                level.color,
                'flex h-40 min-w-40 grow flex-col items-center justify-center',
            ]"
        >
            <p class="text-5xl font-bold">{{ level.kanjis }}</p>
            <p>{{ level.name }}</p>
        </div>
    </div>
</template>
