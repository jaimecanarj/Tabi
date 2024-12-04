<script setup lang="ts">
import moment from "moment/moment";
import { BookX } from "lucide-vue-next";
import { Estudio, Kanji, KanjiLevel } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";
import HomeKanjiGrid from "@/Components/Home/HomeKanjiGrid.vue";

const props = defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();

const oneMonthAgo = moment().subtract(1, "months");
const wrongAnswers: (Estudio & { kanji: Kanji; level: KanjiLevel })[] = [];

//Obtener los últimos 10 kanjis fallados
props.estudios.map((estudio) => {
    //Compruebo que es respuesta errónea,
    if (
        !estudio.respuesta &&
        //Compruebo que fue en el último mes
        moment(estudio.fecha).isSameOrAfter(oneMonthAgo) &&
        //Compruebo que todavía no hay 10 resultados
        wrongAnswers.length < 24
    ) {
        let level = kanjiLevels.find(
            (level) => estudio.tiempo / 24 < level.threshold,
        )!;
        wrongAnswers.push({ ...estudio, level });
    }
});
</script>

<template>
    <HomeKanjiGrid :studys="wrongAnswers" type="wrong">
        <template #title> <BookX :size="32" /> Últimos fallos </template>
    </HomeKanjiGrid>
</template>
