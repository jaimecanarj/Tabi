<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Kanji, Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import StoryForm from "@/Components/StoryForm.vue";
import { Button } from "@/Components/ui/button";

defineProps<{
    kanji: Kanji & { radicales: Radical[] };
    showData: boolean;
}>();
</script>

<template>
    <MainLayout />
    <main class="container mt-12">
        <!-- Tarjeta -->
        <div class="mb-10 flex flex-col shadow-xl">
            <div
                class="flex items-center justify-center rounded-t-md bg-gradient-primary text-[200px] font-bold leading-tight text-light"
            >
                <h2>{{ kanji.literal }}</h2>
            </div>
            <slot name="significado" />
        </div>
        <template v-if="showData">
            <div class="grid gap-10 lg:grid-cols-2">
                <!-- Radicales -->
                <div class="rounded-md bg-card p-5 shadow-md">
                    <h3 class="pb-2 text-4xl font-semibold">Radicales</h3>
                    <p class="text-muted-foreground">
                        Este kanji está compuesto de:
                    </p>
                    <div class="mt-3 flex flex-wrap gap-7">
                        <Link
                            v-for="radical of kanji.radicales"
                            :href="`/radicales/${radical.id}`"
                            class="flex w-20 flex-col items-center gap-1"
                        >
                            <Button
                                variant="secondaryGradient"
                                size="gradient"
                                class="w-16 px-4 text-4xl"
                            >
                                {{ radical.literal }}
                            </Button>
                            <p
                                class="text-center text-xl font-semibold first-letter:capitalize"
                            >
                                {{ radical.significado }}
                            </p>
                        </Link>
                    </div>
                </div>

                <!-- Historia -->
                <div class="rounded-md bg-card p-5 shadow-md">
                    <h3 class="pb-1 text-4xl font-semibold">Historia</h3>
                    <div>
                        <p class="mb-3 text-muted-foreground">
                            Añade una historia a este kanji.
                        </p>
                        <StoryForm :kanji_id="kanji.id" :key="kanji.id" />
                    </div>
                </div>
            </div>
        </template>
        <slot name="absolute" />
    </main>
    <slot name="footer" />
</template>
