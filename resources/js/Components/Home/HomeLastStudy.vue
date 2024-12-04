<script setup lang="ts">
import { BookType } from "lucide-vue-next";
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";
import HomeKanjiGrid from "@/Components/Home/HomeKanjiGrid.vue";

const props = defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();

let lastStudies = props.estudios.slice(0, 24).map((estudio) => {
    let level = kanjiLevels.find(
        (level) => estudio.tiempo / 24 < level.threshold,
    )!;
    return { ...estudio, level };
});
</script>

<template>
    <HomeKanjiGrid :studys="lastStudies" type="last">
        <template #title><BookType :size="32" />Últimos repasados</template>
    </HomeKanjiGrid>
</template>
