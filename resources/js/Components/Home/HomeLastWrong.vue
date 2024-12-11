<script setup lang="ts">
import { BookX } from "lucide-vue-next";
import { Estudio, Kanji } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";
import HomeKanjiGrid from "@/Components/Home/HomeKanjiGrid.vue";

const props = defineProps<{ data: (Estudio & { kanji: Kanji })[] }>();

let lastWrong = props.data.map((estudio) => {
    let level = kanjiLevels.find(
        (level) => estudio.tiempo / 24 < level.threshold,
    )!;
    return { ...estudio, level };
});
</script>

<template>
    <HomeKanjiGrid :studys="lastWrong" type="wrong">
        <template #title> <BookX :size="32" /> Últimos fallos </template>
    </HomeKanjiGrid>
</template>
