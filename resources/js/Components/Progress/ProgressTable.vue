<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

defineProps<{ kanjis: (Kanji & { estudios: Estudio[] })[] }>();

const getLevelBackground = (kanji: Kanji & { estudios: Estudio[] }) => {
    if (kanji.estudios.length) {
        let level = kanjiLevels.find(
            (level) => kanji.estudios[0].tiempo / 24 < level.threshold,
        )!;
        return `bg-gradient-${level.color}`;
    } else {
        let color = kanjiLevels[0].color;
        return "bg-gradient-levels-new";
    }
};
</script>

<template>
    <div class="kanji-grid mt-10 grid gap-1">
        <Link :href="`/kanjis/${kanji.id}`" v-for="kanji in kanjis">
            <div
                :class="[
                    getLevelBackground(kanji),
                    'w-12 rounded-md p-1 text-center text-2xl text-light',
                ]"
            >
                <h2 class="font-semibold">{{ kanji.literal }}</h2>
            </div>
        </Link>
    </div>
</template>
