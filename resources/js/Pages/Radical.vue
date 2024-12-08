<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { Kanji, Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";
import { Button } from "@/Components/ui/button";
import { ScrollArea } from "@/Components/ui/scroll-area";
import { Badge } from "@/Components/ui/badge";
import {
    HoverCard,
    HoverCardContent,
    HoverCardTrigger,
} from "@/Components/ui/hover-card";

defineProps<{
    radical: Radical;
    kanjis: Kanji[];
}>();
</script>

<template>
    <Head :title="radical.literal" />
    <MainLayout />
    <main class="container mt-6">
        <ItemDetailsCard
            :literal="radical.literal"
            tipo="radicales"
            :titulo="radical.significado"
        >
            <!-- Trazos -->
            <div class="mb-3">
                <h3 class="mr-1 inline text-lg">Trazos:</h3>
                <span class="text-lg font-semibold">{{ radical.trazos }}</span>
            </div>
            <!-- Kanjis donde aparece -->
            <div class="mb-3">
                <h3 class="mb-1 text-lg font-semibold tracking-tight">
                    Kanjis donde aparece
                    <Badge variant="secondary" class="ml-1 text-base">{{
                        kanjis.length
                    }}</Badge>
                </h3>
                <ScrollArea
                    class="flex flex-wrap"
                    height-class="md:max-h-72"
                    type="auto"
                >
                    <template v-for="kanji of kanjis">
                        <Link :href="`/kanjis/${kanji.id}`">
                            <HoverCard>
                                <HoverCardTrigger asChild>
                                    <Button
                                        variant="secondaryGradient"
                                        size="gradient"
                                        class="m-1"
                                    >
                                        {{ kanji.literal }}
                                    </Button>
                                </HoverCardTrigger>
                                <HoverCardContent class="w-fit max-w-48">
                                    <p class="capitalize">
                                        {{ kanji.significado }}
                                    </p>
                                </HoverCardContent>
                            </HoverCard>
                        </Link>
                    </template>
                </ScrollArea>
            </div>
        </ItemDetailsCard>
    </main>
</template>
