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
        return `from-${level.color}/70 to-${level.color} hover:via-${level.color}/70 hover:to-${level.color}`;
    } else {
        let color = kanjiLevels[0].color;
        return `from-${color}/70 to-${color} hover:via-${color}/70 hover:to-${color}`;
    }
};

// from-zinc-500/70 to-zinc-500 hover:via-zinc-500/70 hover:to-zinc-500
// from-levels-learner/70 to-levels-learner hover:via-levels-learner/70 hover:to-levels-learner
// from-levels-educated/70 to-levels-educated hover:via-levels-educated/70 hover:to-levels-educated
// from-levels-proficient/70 to-levels-proficient hover:via-levels-proficient/70 hover:to-levels-proficient
// from-levels-expert/70 to-levels-expert hover:via-levels-expert/70 hover:to-levels-expert
// from-levels-master/70 to-levels-master hover:via-levels-master/70 hover:to-levels-master
//bg-levels-master/70
</script>

<template>
    <div class="kanji-grid mt-10 grid gap-1">
        <Link :href="`/kanjis/${kanji.id}`" v-for="kanji in kanjis">
            <div
                :class="[
                    getLevelBackground(kanji),
                    'w-12 rounded-md bg-gradient-to-br p-1 text-center text-2xl text-light dark:bg-gradient-to-tl',
                ]"
            >
                <h2 class="font-semibold">{{ kanji.literal }}</h2>
            </div>
        </Link>
    </div>
</template>
