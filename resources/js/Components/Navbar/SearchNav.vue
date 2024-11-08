<script setup lang="ts">
import { VisuallyHidden } from "radix-vue";
import { useForm } from "@inertiajs/vue3";
import { Search } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";

const form = useForm({
    kanji: "",
});

const submit = () => {
    form.get(`/search/${form.kanji}`);
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
            class="sm:max-w-[425px] bg-transparent border-0 shadow-none top-24"
            noClose
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
                <Input v-model="form.kanji" placeholder="Buscar..." />
            </form>
        </DialogContent>
    </Dialog>
</template>
