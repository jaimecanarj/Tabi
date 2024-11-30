<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import HomeStudyCard from "@/Components/Home/HomeStudyCard.vue";
import HomeLastStudy from "@/Components/Home/HomeLastStudy.vue";
import HomeLastWrong from "@/Components/Home/HomeLastWrong.vue";
import HomeProgress from "@/Components/Home/HomeProgress.vue";
import HomeNextReview from "@/Components/Home/HomeNextReview.vue";
import { Estudio, Kanji } from "@/lib/types";
import { momentLocale } from "@/lib/utils";

momentLocale();

defineProps<{ estudios: (Estudio & { kanji: Kanji })[] }>();
</script>

<template>
    <Head title="Home" />
    <MainLayout />
    <main class="container my-12">
        <div class="grid lg:grid-cols-3">
            <div class="lg:col-span-2 lg:mx-5">
                <section
                    class="flex flex-col justify-between gap-5 xl:flex-row"
                >
                    <HomeStudyCard type="estudio" :estudios="estudios" />
                    <HomeStudyCard type="repaso" :estudios="estudios" />
                </section>
                <HomeLastStudy :estudios="estudios" />
                <HomeProgress :estudios="estudios" />
                <HomeLastWrong :estudios="estudios" />
            </div>
            <div class="lg:col-span-1">
                <HomeNextReview :estudios="estudios" />
            </div>
        </div>
    </main>
</template>
