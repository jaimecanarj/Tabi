<script setup lang="ts">
import { ref } from "vue";
import axios from "axios";
import { Pencil, Search } from "lucide-vue-next";
import { VisuallyHidden } from "radix-vue";
import { Kanji, Radical } from "@/lib/types";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Badge } from "@/Components/ui/badge";
import { ScrollArea } from "@/Components/ui/scroll-area";
import { Link } from "@inertiajs/vue3";

const query = ref("");
const fetched = ref(false);
const results = ref<{ kanjis: Kanji[]; radicales: Radical[] }>({
    kanjis: [],
    radicales: [],
});

const submit = () => {
    axios.get(`/search/${query.value}`).then((res) => {
        results.value = res.data;
        fetched.value = true;
    });
};
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="ghost" size="icon">
                <Search />
            </Button>
        </DialogTrigger>
        <DialogContent
            noClose
            class="top-0 -translate-y-0 border-0 bg-transparent shadow-none sm:max-w-[425px]"
        >
            <VisuallyHidden asChild>
                <DialogTitle>Buscador</DialogTitle>
            </VisuallyHidden>
            <VisuallyHidden asChild>
                <DialogDescription>
                    Buscador de kanjis y radicales
                </DialogDescription>
            </VisuallyHidden>
            <form @submit.prevent="submit">
                <Input
                    v-model="query"
                    placeholder="Buscar..."
                    class="border-none focus-visible:ring-0 focus-visible:ring-offset-0"
                />
            </form>
            <div
                v-if="results.kanjis.length || results.radicales.length"
                class="-mt-[20px] flex flex-col rounded-b-sm bg-background"
            >
                <div v-if="results.kanjis.length" class="mt-2">
                    <div class="bg-card px-4 py-2">
                        <h2 class="font-semibold">Kanjis</h2>
                    </div>
                    <ScrollArea height-class="max-h-36" type="auto">
                        <Link
                            :href="`/kanjis/${kanji.id}`"
                            v-for="kanji of results.kanjis"
                            class="flex items-center justify-between px-4 py-2 hover:bg-accent"
                        >
                            <div class="flex items-end gap-2">
                                <h3 class="text-2xl font-semibold">
                                    {{ kanji.literal }}
                                </h3>
                                <p class="capitalize">
                                    {{ kanji.significado }}
                                </p>
                            </div>
                            <div>
                                <Badge variant="secondary">
                                    <Pencil class="inline" />
                                    {{ kanji.trazos }}
                                </Badge>
                            </div>
                        </Link>
                    </ScrollArea>
                </div>
                <div v-if="results.radicales.length">
                    <div class="mt-2 bg-card px-4 py-2">
                        <h2 class="font-semibold">Radicales</h2>
                    </div>
                    <ScrollArea
                        height-class="max-h-36"
                        class="mb-2"
                        type="auto"
                    >
                        <Link
                            :href="`/radicales/${radical.id}`"
                            v-for="radical of results.radicales"
                            class="flex items-center justify-between px-4 py-2 hover:bg-accent"
                        >
                            <div class="flex items-end gap-2">
                                <h3 class="text-2xl font-semibold">
                                    {{ radical.literal }}
                                </h3>
                                <p class="capitalize">
                                    {{ radical.significado }}
                                </p>
                            </div>
                            <div>
                                <Badge variant="secondary">
                                    <Pencil class="inline" />
                                    {{ radical.trazos }}
                                </Badge>
                            </div>
                        </Link>
                    </ScrollArea>
                </div>
            </div>
            <div
                v-else-if="fetched"
                class="-mt-[20px] rounded-b-sm bg-background px-4 py-2"
            >
                <h2 class="font-semibold">No hay resultados</h2>
            </div>
        </DialogContent>
    </Dialog>
</template>
