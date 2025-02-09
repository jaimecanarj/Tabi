<script setup lang="ts">
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import moment from "moment/moment";
import * as ebisu from "ebisu-js";
import { Kanji, Study, Answer, Radical } from "@/types";
import EstudioLayout from "@/Layouts/StudyLayout.vue";
import ReviewAnswer from "@/Components/Review/ReviewAnswer.vue";
import ReviewResume from "@/Components/Review/ReviewResume.vue";

const props = defineProps<{
    kanjis: (Kanji & { radicals: Radical[]; study?: Study })[];
}>();

let kanjisToAnswer: (Kanji & { radicals: Radical[]; study?: Study })[] = [];

//Obtener kanjis a repasar
if (props.kanjis[0].study) {
    //Ordenar por posibilidad de olvidarse
    kanjisToAnswer = props.kanjis
        .toSorted((kanjiA, kanjiB) => {
            let kanjiAModel = ebisu.defaultModel(
                kanjiA.study!.time,
                kanjiA.study!.betaA,
                kanjiA.study!.betaB,
            );
            let kanjiATime = moment().diff(
                moment(kanjiA.study!.date, "YYYY-MM-DD HH:mm:ss"),
                "hours",
            );
            let kanjiBModel = ebisu.defaultModel(
                kanjiB.study!.time,
                kanjiB.study!.betaA,
                kanjiB.study!.betaB,
            );
            let kanjiBTime = moment().diff(
                moment(kanjiB.study!.date, "YYYY-MM-DD HH:mm:ss"),
                "hours",
            );
            return (
                ebisu.predictRecall(kanjiAModel, kanjiATime) -
                ebisu.predictRecall(kanjiBModel, kanjiBTime)
            );
        })
        .slice(0, 10);
} else {
    kanjisToAnswer = props.kanjis.toSorted(() => Math.random() - 0.5);
}

let kanjisAnswered: number = 1; //Contador
let kanji = ref(kanjisToAnswer[0]); //Kanji a repasar
let showData = ref(false);
let answers: (Answer & { kanji: Kanji; study?: Study })[] = [];

const handleRound = (answer: Answer) => {
    if (answer.answered) {
        if (kanji.value.study || answer.answerResult) {
            answers.push({
                ...answer,
                kanji: kanji.value,
                study: kanji.value.study,
            });
        }
        kanji.value = kanjisToAnswer[0]; //Actualizar kanji
        if (kanjisToAnswer.length + kanjisAnswered === 10) kanjisAnswered++; //Actualizar contador
        showData.value = false;
    } else {
        if (!answer.answerResult && !kanji.value.study) {
            //En caso de estudio y fallo
            kanjisToAnswer.sort(() => Math.random() - 0.5); //Mezclar lista de kanjis
        } else {
            kanjisToAnswer.shift(); //Eliminar kanji de la lista
        }
        showData.value = true;
    }
};
</script>

<template>
    <Head title="Estudio" />
    <ReviewResume v-if="kanjisAnswered > 10" :answers="answers" />
    <EstudioLayout v-else :kanji="kanji" :showData="showData">
        <template #meaning>
            <ReviewAnswer :kanji="kanji" @answer="handleRound" />
        </template>
        <template #footer>
            <footer
                class="sticky top-[100vh] mb-6 mt-10 flex justify-center text-xl"
            >
                {{ kanjisAnswered }} de 10
            </footer>
        </template>
    </EstudioLayout>
</template>
