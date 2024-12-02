<script setup lang="ts">
//TODO: Cambiar diseño kanjis a vista más detallada debajo
import { Head, Link } from "@inertiajs/vue3";
import { Kanji, Radical } from "@/lib/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import ItemDetailsCard from "@/Components/ItemDetailsCard.vue";
import { Button } from "@/Components/ui/button";
import { ScrollArea } from "@/Components/ui/scroll-area";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/Components/ui/tooltip";

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
                </h3>
                <ScrollArea
                    class="flex flex-wrap"
                    height-class="md:max-h-72"
                    type="auto"
                >
                    <template v-for="kanji of kanjis">
                        <Link :href="`/kanjis/${kanji.id}`">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <Button class="m-1 text-2xl">
                                            {{ kanji.literal }}
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p class="capitalize">
                                            {{ kanji.significado }}
                                        </p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </Link>
                    </template>
                </ScrollArea>
            </div>
        </ItemDetailsCard>
    </main>
</template>
