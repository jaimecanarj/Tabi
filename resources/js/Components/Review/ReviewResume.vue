<script setup lang="ts">
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import * as ebisu from "ebisu-js";
import moment from "moment/moment";
import "moment/locale/es";
import axios from "axios";
import { Answer, Study, Kanji, KanjiLevel } from "@/types";
import { kanjiLevels } from "@/lib/utils";
import MainLayout from "@/Layouts/MainLayout.vue";
import ReviewResumeKanjis from "@/Components/Review/ReviewResumeKanjis.vue";
import ReviewResumeCongratulation from "@/Components/Review/ReviewResumeCongratulation.vue";

const page = usePage();

const props = defineProps<{
    answers: (Answer & { kanji: Kanji; study?: Study })[];
}>();

const answersCorrect = computed(() => {
    return props.answers.reduce((acc, answer) => {
        answer.answerResult ? acc++ : acc;
        return acc;
    }, 0);
});

const createNewModel = (answer: Answer & { study?: Study }) => {
    let model = ebisu.defaultModel(48, 3, 3);

    if (answer.study) {
        model = ebisu.defaultModel(
            answer.study.time,
            answer.study.betaA,
            answer.study.betaB,
        );
        let newTime = moment().diff(
            moment(answer.study.date, "YYYY-MM-DD HH:mm:ss"),
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
    let studys: Omit<Study, "id" | "date">[] = [];
    props.answers.forEach((answer) => {
        let model = createNewModel(answer);
        let correctAnswers = 1;
        let attempts = 1;

        if (answer.study) {
            attempts += answer.study.attempts;
            if (answer.answerResult) {
                correctAnswers += answer.study.successes;
            } else {
                correctAnswers = answer.study.successes;
            }
        }
        studys.push({
            kanji_id: answer.kanji.id,
            user_id: page.props.auth.user.id,
            time: model[2],
            betaA: model[0],
            betaB: model[1],
            answer: answer.answerResult ? 1 : 0,
            successes: correctAnswers,
            attempts: attempts,
        });
    });
    await axios.post("/review", {
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
    if (answer.study) {
        newTime = createNewModel(answer)[2];
    }
    let date = moment().add(newTime, "hours").from(moment());
    //Calcular niveles
    let oldLevel: KanjiLevel | undefined = undefined;
    if (answer.study) {
        oldLevel = kanjiLevels.find(
            (level) => answer.study!.time / 24 < level.threshold,
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
