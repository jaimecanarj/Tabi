<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import { Study, Kanji } from "@/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import HomeStudyCard from "@/Components/Home/HomeStudyCard.vue";
import HomeLastStudy from "@/Components/Home/HomeLastStudy.vue";
import HomeLastWrong from "@/Components/Home/HomeLastWrong.vue";
import HomeProgress from "@/Components/Home/HomeProgress.vue";
import HomeNextReview from "@/Components/Home/HomeNextReview.vue";

const page = usePage();

defineProps<{
    data: {
        studys: Study[];
        kanjisToReview: number;
        kanjisStudiedNumber: number;
        userStudySessions: number;
        userCorrectAnswers: number;
        lastWrongKanjis: (Study & { kanji: Kanji })[];
        lastReviewedKanjis: (Study & { kanji: Kanji })[];
        studiedToday: number;
        reviewedToday: number;
    };
}>();
</script>

<template>
    <Head title="Home" />
    <MainLayout />
    <main class="container my-12">
        <!--Vista invitado-->
        <div v-if="!page.props.auth.user" class="flex flex-col items-center">
            <div class="flex flex-col">
                <div
                    class="w-[300px] rounded-lg bg-card p-3 text-xl sm:ml-36 sm:w-[400px] sm:text-2xl md:w-[500px] md:text-3xl"
                >
                    Inicia sesión o registrate<br />
                    para ver tus estudios y progreso.
                </div>
                <div
                    class="ml-[104px] inline-block h-0 w-0 border-b-0 border-l-[24px] border-r-[24px] border-t-[40px] border-solid border-b-transparent border-l-transparent border-r-transparent border-t-card sm:ml-[168px]"
                ></div>
                <img
                    src="/assets/Viajero.webp"
                    alt="Viajero"
                    class="mt-2 w-64 sm:w-96"
                />
            </div>
        </div>
        <!--Vista usuario registrado-->
        <div v-else class="grid lg:grid-cols-3">
            <div class="lg:col-span-2 lg:mx-5">
                <section
                    class="flex flex-col justify-between gap-5 xl:flex-row"
                >
                    <HomeStudyCard
                        type="estudio"
                        :kanjisStudied="data.studiedToday"
                    />
                    <HomeStudyCard
                        type="repaso"
                        :kanjisStudied="data.reviewedToday"
                        :studies="data.kanjisToReview"
                    />
                </section>
                <HomeLastStudy :data="data.lastReviewedKanjis" />
                <HomeProgress
                    :kanjisStudied="data.kanjisStudiedNumber"
                    :studySessions="data.userStudySessions"
                    :correctAnswers="data.userCorrectAnswers"
                />
                <HomeLastWrong :data="data.lastWrongKanjis" />
            </div>
            <div class="lg:col-span-1">
                <HomeNextReview :studies="data.studys" />
            </div>
        </div>
    </main>
</template>
