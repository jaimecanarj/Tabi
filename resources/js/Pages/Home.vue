<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import HomeStudyCard from "@/Components/Home/HomeStudyCard.vue";
import HomeLastStudy from "@/Components/Home/HomeLastStudy.vue";
import HomeLastWrong from "@/Components/Home/HomeLastWrong.vue";
import HomeHeatMap from "@/Components/Home/HomeHeatMap.vue";
import HomeNextReview from "@/Components/Home/HomeNextReview.vue";
import { Estudio, Kanji } from "@/lib/types";

defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();
</script>

<template>
    <Head title="Home" />
    <MainLayout />
    <main class="container mt-12">
        <div class="grid md:grid-cols-3">
            <div class="col-span-2 md:mx-5">
                <section
                    class="flex flex-col justify-between gap-5 xl:flex-row"
                >
                    <HomeStudyCard type="estudio" :estudios="estudios" />
                    <HomeStudyCard type="repaso" :estudios="estudios" />
                </section>
                <HomeLastStudy :estudios="estudios" />
                <HomeHeatMap />
                <HomeLastWrong :estudios="estudios" />
            </div>
            <div class="col-span-1">
                <HomeNextReview :estudios="estudios" />
            </div>
        </div>
    </main>
</template>
