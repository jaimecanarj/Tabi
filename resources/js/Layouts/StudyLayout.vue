<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Kanji, Radical } from "@/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import StoryForm from "@/Components/StoryForm.vue";
import { Button } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";

defineProps<{
    kanji: Kanji & { radicals: Radical[] };
    showData: boolean;
}>();
</script>

<template>
    <MainLayout />
    <main class="container mt-12">
        <!-- Tarjeta -->
        <div class="mb-10 flex flex-col shadow-xl">
            <div
                class="flex items-center justify-center rounded-t-md bg-gradient-primary-to-alt text-[200px] font-bold leading-tight text-light"
            >
                <h2>{{ kanji.literal }}</h2>
            </div>
            <slot name="meaning" />
        </div>
        <template v-if="showData">
            <div class="grid gap-3 lg:grid-cols-[1fr_auto_1fr] lg:gap-10">
                <!-- Radicales -->
                <div class="m-5">
                    <h3 class="pb-2 text-4xl font-semibold">Radicales</h3>
                    <p class="text-muted-foreground">
                        Este kanji está compuesto de:
                    </p>
                    <div class="mt-3 flex flex-wrap gap-7">
                        <Link
                            v-for="radical of kanji.radicals"
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
                                class="hyphens-auto text-center text-xl font-semibold first-letter:capitalize"
                                lang="es"
                            >
                                {{ radical.meaning }}
                            </p>
                        </Link>
                    </div>
                </div>
                <Separator orientation="vertical" />
                <!-- Historia -->
                <div class="m-5">
                    <h3 class="pb-1 text-4xl font-semibold">Historia</h3>
                    <div>
                        <p class="mb-3 text-muted-foreground">
                            Añade una historia a este kanji.
                        </p>
                        <StoryForm :kanjiId="kanji.id" :key="kanji.id" />
                    </div>
                </div>
            </div>
        </template>
        <slot name="absolute" />
    </main>
    <slot name="footer" />
</template>
