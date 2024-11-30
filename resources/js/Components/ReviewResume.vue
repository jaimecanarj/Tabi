<script setup lang="ts">
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import * as ebisu from "ebisu-js";
import moment from "moment/moment";
import "moment/locale/es";
import axios from "axios";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Answer, Estudio, Kanji, KanjiLevel } from "@/lib/types";
import ReviewResumeKanjis from "@/Components/ReviewResumeKanjis.vue";
import ReviewResumeCongratulation from "@/Components/ReviewResumeCongratulation.vue";
import { kanjiLevels } from "@/lib/utils";

const page = usePage();

const props = defineProps<{
    answers: (Answer & { kanji: Kanji; estudio?: Estudio })[];
}>();

const answersCorrect = computed(() => {
    return props.answers.reduce((acc, answer) => {
        answer.answerResult ? acc++ : acc;
        return acc;
    }, 0);
});

const createNewModel = (answer: Answer & { estudio?: Estudio }) => {
    let model = ebisu.defaultModel(48, 3, 3);

    if (answer.estudio) {
        model = ebisu.defaultModel(
            answer.estudio.tiempo,
            answer.estudio.betaA,
            answer.estudio.betaB,
        );
        let newTime = moment().diff(
            moment(answer.estudio.fecha, "YYYY-MM-DD HH:mm:ss"),
            "hours",
        );
        model = ebisu.updateRecall(
            model,
            answer.answerResult ? 1 : 0,
            1,
            newTime,
        );
    }
    return model;
};

const storeStudys = async () => {
    let studys: Omit<Estudio, "id" | "fecha">[] = [];
    props.answers.forEach((answer) => {
        let model = createNewModel(answer);
        let correctAnswers = 1;
        let attempts = 1;

        if (answer.estudio) {
            attempts += answer.estudio.intentos;
            if (answer.answerResult) {
                correctAnswers += answer.estudio.aciertos;
            } else {
                correctAnswers = answer.estudio.aciertos;
            }
        }
        studys.push({
            kanji_id: answer.kanji.id,
            user_id: page.props.auth.user.id,
            tiempo: model[2],
            betaA: model[0],
            betaB: model[1],
            respuesta: answer.answerResult ? 1 : 0,
            aciertos: correctAnswers,
            intentos: attempts,
        });
    });
    await axios.post("/repasar", {
        studys: studys,
    });
};

storeStudys();

const kanjis = ref<
    (Kanji & {
        oldLevel?: KanjiLevel;
        newLevel: KanjiLevel;
        date: string;
        answer: boolean;
    })[]
>([]);

props.answers.forEach((answer) => {
    //Calcular fecha de repaso
    let newTime = 48;
    if (answer.estudio) {
        newTime = createNewModel(answer)[2];
    }
    let date = moment().add(newTime, "hours").from(moment());
    //Calcular niveles
    let oldLevel: KanjiLevel | undefined = undefined;
    if (answer.estudio) {
        oldLevel = kanjiLevels.find(
            (level) => answer.estudio!.tiempo / 24 < level.threshold,
        )!;
    }
    let newLevel = kanjiLevels.find((level) => newTime / 24 < level.threshold)!;
    kanjis.value.push({
        ...answer.kanji,
        oldLevel,
        newLevel,
        date,
        answer: answer.answerResult!,
    });
});
</script>

<template>
    <MainLayout />
    <main class="container my-12">
        <ReviewResumeCongratulation :answersCorrect="answersCorrect" />
        <ReviewResumeKanjis :kanjis="kanjis" />
    </main>
</template>
