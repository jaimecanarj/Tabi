<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { MoreHorizontal, Eye, Pencil, Trash2 } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

const props = defineProps<{
    id: number;
    route: string;
}>();

const destroy = () => {
    axios.delete(`/admin/${props.route}/destroy/${props.id}`);
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Acciones</DropdownMenuLabel>
            <Link :href="`/${route}/${id}`">
                <DropdownMenuItem class="cursor-pointer">
                    <Eye :size="18" class="mr-2" />Ver
                </DropdownMenuItem>
            </Link>
            <Link :href="`/admin/${route}/${id}`">
                <DropdownMenuItem class="cursor-pointer">
                    <Pencil :size="18" class="mr-2" />Editar
                </DropdownMenuItem>
            </Link>
            <DropdownMenuItem class="cursor-pointer" @click="destroy">
                <Trash2 :size="18" class="mr-2" />Borrar
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
