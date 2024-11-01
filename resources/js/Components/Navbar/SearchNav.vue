<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Input } from "@/Components/ui/input";
import { Search } from "lucide-vue-next";
import { VisuallyHidden } from "radix-vue";
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
            <Input id="name" placeholder="Buscar..." />
        </DialogContent>
    </Dialog>
</template>
