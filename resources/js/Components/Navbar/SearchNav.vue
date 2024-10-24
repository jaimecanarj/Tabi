<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Search } from "lucide-vue-next";
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
            <Input id="name" placeholder="Buscar..." />
        </DialogContent>
    </Dialog>
</template>
