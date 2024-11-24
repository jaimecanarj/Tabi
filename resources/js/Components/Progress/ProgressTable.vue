<script setup lang="ts">
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

defineProps<{ kanjis: (Kanji & { estudios: Estudio[] })[] }>();

const getLevelBackground = (kanji: Kanji & { estudios: Estudio[] }) => {
    if (kanji.estudios.length) {
        let result = kanjiLevels.find(
            (level) => kanji.estudios[0].tiempo / 24 < level.threshold,
        );
        if (result) {
            return result.color;
        }
    } else {
        return kanjiLevels[0].color;
    }
};
</script>

<template>
    <div class="kanji-grid mt-10 grid gap-1">
        <div
            v-for="kanji in kanjis"
            :class="[
                getLevelBackground(kanji),
                'w-12 rounded-md p-1 text-center text-2xl text-primary-foreground',
            ]"
        >
            <h2 class="font-semibold">{{ kanji.literal }}</h2>
        </div>
    </div>
</template>
