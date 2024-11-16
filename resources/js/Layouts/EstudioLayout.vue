<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Kanji } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import StoryForm from "@/Components/StoryForm.vue";
import { Button } from "@/Components/ui/button";

defineProps<{ kanji: Kanji; showData: boolean }>();
</script>

<template>
    <MainLayout />
    <main class="container relative mt-12">
        <!-- Tarjeta -->
        <div class="flex flex-col mb-10 shadow-xl">
            <div
                class="flex justify-center items-center rounded-t-md text-[200px] font-bold bg-gradient-primary text-primary-foreground leading-tight"
            >
                <h2>{{ kanji.literal }}</h2>
            </div>
            <slot name="significado" />
        </div>
        <div v-if="showData" class="grid gap-10 lg:grid-cols-2">
            <!-- Radicales -->
            <div class="p-5 rounded-md shadow-md bg-card">
                <h3 class="pb-2 text-4xl font-semibold">Radicales</h3>
                <p class="text-muted-foreground">
                    Este kanji está compuesto de:
                </p>
                <div class="flex flex-wrap mt-3 gap-7">
                    <Link
                        v-for="radical of kanji.radicales"
                        :href="`/radicales/${radical.id}`"
                    >
                        <Button class="text-2xl">
                            {{ radical.literal }}
                        </Button>
                        <span class="ml-2 text-xl capitalize">
                            {{ radical.significado }}
                        </span>
                    </Link>
                </div>
            </div>

            <!-- Historia -->
            <div class="p-5 rounded-md shadow-md bg-card">
                <h3 class="pb-1 text-4xl font-semibold">Historia</h3>
                <div>
                    <p class="mb-3 text-muted-foreground">
                        Añade una historia a este kanji.
                    </p>
                    <StoryForm :kanji_id="kanji.id" :key="kanji.id" />
                </div>
            </div>
        </div>
        <slot name="absolute" />
    </main>
    <slot name="footer" />
</template>
