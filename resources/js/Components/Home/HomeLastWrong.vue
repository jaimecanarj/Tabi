<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import moment from "moment/moment";
import { BookX } from "lucide-vue-next";
import { Estudio, Kanji, KanjiLevel } from "@/lib/types";
import { kanjiLevels } from "@/lib/utils";

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
    <section class="mt-10 rounded-xl bg-card p-6 shadow-md">
        <h2 class="flex items-center gap-2 text-3xl font-semibold">
            <BookX :size="32" />Últimos fallos
        </h2>
        <div
            class="home-grid mt-4 grid max-h-40 gap-2 overflow-hidden sm:max-h-28"
        >
            <div v-for="study in wrongAnswers">
                <Link :href="`/kanjis/${study.kanji_id}`">
                    <div
                        class="w-14 rounded bg-secondary p-2 text-center text-2xl font-semibold"
                    >
                        {{ study.kanji.literal }}
                    </div>
                </Link>
            </div>
        </div>
    </section>
</template>
